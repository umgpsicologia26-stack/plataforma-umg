<?php
namespace App\Http\Controllers;

use App\Models\CaseComment;
use App\Models\CaseFile;
use App\Models\CaseNotification;
use App\Models\ChatConversation;
use App\Models\ModeratorNotification;
use App\Models\ChatMessage;
use App\Models\AuditLog;
use App\Models\AdminNotification;
use App\Events\CaseActivityUpdated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ModeratorController extends BaseController
{
    /* DASHBOARD DEL MODERADOR */

    public function dashboard()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $evaluationNotifications = ModeratorNotification::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('read', false)
            ->where(function ($query) {
                $query->whereNotNull('evaluacion_uuid')
                    ->orWhereNotNull('attempt_uuid');
            })
            ->orderByDesc('created_at')
            ->get();

        $evaluationNotificationsCount = $evaluationNotifications->count();

        // Publicaciones nuevas del foro pendientes de revisar.
        $forumNotificationsCount = ModeratorNotification::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('read', false)
            ->where('message', 'Nueva publicación en el foro.')
            ->count();

        $totalCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )->count();

        $openCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('status', 'Abierto')
            ->count();

        $followUpCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('status', 'En seguimiento')
            ->count();

        $closedCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('status', 'Cerrado')
            ->count();

        /* CASOS NUEVOS O CON OBSERVACIONES POSTERIORES A SU LECTURA */

            $newCasesCount = $this->pendingCasesCount($moderatorUuid);

        /* MENSAJES NUEVOS DEL CHAT */

        $newConversationsCount = DB::table('chat_messages')
            ->join(
                'chat_conversations',
                'chat_messages.conversation_id',
                '=',
                'chat_conversations.id'
            )
            ->where(
                'chat_conversations.moderator_uuid',
                $moderatorUuid
            )
            ->where(
                'chat_messages.sender_type',
                'USER'
            )
            ->where(function ($query) {
                $query->whereNull(
                    'chat_conversations.moderator_last_read_at'
                )
                    ->orWhereColumn(
                        'chat_messages.created_at',
                        '>',
                        'chat_conversations.moderator_last_read_at'
                    );
            })
            ->distinct()
            ->count('chat_conversations.id');

        return view(
            'moderator.dashboard',
            compact(
                'totalCases',
                'openCases',
                'followUpCases',
                'closedCases',
                'newCasesCount',
                'newConversationsCount',
                'evaluationNotifications',
                'evaluationNotificationsCount',
                'forumNotificationsCount'
            )
        );
    }

    /* CASOS PENDIENTES (misma lógica que usaba dashboard()) */

    private function pendingCasesCount(string $moderatorUuid): int
    {
        return CaseFile::query()
            ->where('moderator_uuid', $moderatorUuid)
            ->whereIn('status', ['Abierto', 'En seguimiento'])
            ->where(function ($query) use ($moderatorUuid) {
                // Caso asignado que este moderador todavía no ha abierto.
                $query->whereNotExists(function ($subquery) use ($moderatorUuid) {
                    $subquery->select(DB::raw(1))
                        ->from('moderator_case_reads')
                        ->whereColumn(
                            'moderator_case_reads.case_id',
                            'case_files.id'
                        )
                        ->where(
                            'moderator_case_reads.moderator_uuid',
                            $moderatorUuid
                        );
                })

                // Caso leído que recibió una observación posterior de otra persona.
                ->orWhereExists(function ($subquery) use ($moderatorUuid) {
                    $subquery->select(DB::raw(1))
                        ->from('moderator_case_reads')
                        ->join(
                            'case_comments',
                            'case_comments.case_id',
                            '=',
                            'moderator_case_reads.case_id'
                        )
                        ->whereColumn(
                            'moderator_case_reads.case_id',
                            'case_files.id'
                        )
                        ->where(
                            'moderator_case_reads.moderator_uuid',
                            $moderatorUuid
                        )
                        ->whereNotNull(
                            'moderator_case_reads.last_read_at'
                        )
                        ->whereColumn(
                            'case_comments.created_at',
                            '>',
                            'moderator_case_reads.last_read_at'
                        )
                        ->where(
                            'case_comments.user_id',
                            '!=',
                            $moderatorUuid
                        );
                });
            })
            ->count();
    }

    /* CONTADORES DEL DASHBOARD (JSON, solo del moderador autenticado) */

    public function dashboardCounters()
    {
        $this->checkRole(['MODERATOR']);

        return response()->json([
            'success' => true,
            'new_cases_count' => $this->pendingCasesCount(
                Auth::user()->uuid
            ),
        ]);
    }

    /* RESULTADO DE EVALUACIÓN */

    public function evaluationResult($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $notification = ModeratorNotification::with([
            'evaluacion',
            'intento.usuario',
            'intento.respuestas.pregunta',
        ])
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->firstOrFail();

        /* VERIFICACIÓN DE SEGURIDAD */

        $evaluacion = $notification->evaluacion;
        $attempt = $notification->intento;

        if (!$evaluacion || !$attempt) {
            abort(404);
        }

        if (
            $evaluacion->created_by !== $moderatorUuid ||
            $attempt->evaluacion_uuid !== $evaluacion->uuid ||
            $attempt->status !== 'COMPLETADA'
        ) {
            abort(404);
        }

        /* MARCAR LA NOTIFICACIÓN COMO LEÍDA */

        $notification->update([
            'read' => true,
        ]);

        return view(
            'moderator.evaluation-result',
            compact(
                'notification',
                'evaluacion',
                'attempt'
            )
        );
    }

    /* DESCARGAR RESULTADO DE EVALUACIÓN EN PDF */

    public function downloadEvaluationResult($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $notification = ModeratorNotification::with([
            'evaluacion',
            'intento.usuario',
            'intento.respuestas.pregunta',
        ])
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->firstOrFail();

        /* VERIFICACIÓN DE SEGURIDAD */

        $evaluacion = $notification->evaluacion;
        $attempt = $notification->intento;

        if (!$evaluacion || !$attempt) {
            abort(404);
        }

        if (
            $evaluacion->created_by !== $moderatorUuid ||
            $attempt->evaluacion_uuid !== $evaluacion->uuid ||
            $attempt->status !== 'COMPLETADA'
        ) {
            abort(404);
        }

        /* GENERAR PDF */

        $pdf = Pdf::loadView(
            'moderator.evaluation-pdf',
            compact(
                'notification',
                'evaluacion',
                'attempt'
            )
        );

        $nombreArchivo = 'resultado-evaluacion-' .
            Str::slug($evaluacion->title) .
            '.pdf';

        return $pdf->download($nombreArchivo);
    }

    /* MARCAR NOTIFICACIÓN DE EVALUACIÓN COMO LEÍDA */

    public function markEvaluationNotificationAsRead($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $notification = ModeratorNotification::where(
            'id',
            $id
        )
            ->where('moderator_uuid', $moderatorUuid)
            ->firstOrFail();

        $notification->update([
            'read' => true,
        ]);

        return redirect()
            ->route('moderator.dashboard')
            ->with(
                'success',
                'Notificación marcada como leída.'
            );
    }

    /* LISTAR CASOS DEL MODERADOR */

    public function cases()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $cases = CaseFile::with([
            'user',
            'moderator',
            'comments.user'
        ])
            ->where('moderator_uuid', $moderatorUuid)
            ->orderByDesc('created_at')
            ->get();

        return view('moderator.cases', compact('cases'));
    }

    /* VER DETALLE DE UN CASO */

    public function viewCase($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $case = CaseFile::with([
            'user',
            'moderator',
            'comments.user'
        ])
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->firstOrFail();

        $this->authorize('view', $case);

        // Registrar la lectura del caso para este moderador.
        DB::table('moderator_case_reads')->updateOrInsert(
            [
                'case_id' => $case->id,
                'moderator_uuid' => $moderatorUuid,
            ],
            [
                'last_read_at' => now(),
                'updated_at' => now(),
            ]
        );

        return view('moderator.view-case', compact('case'));
    }

    /* ACTUALIZAR CASO */

    public function updateCase(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        $request->validate([
            'status' => [
                'required',
                'in:Abierto,En seguimiento,Cerrado'
            ],
            'comment' => [
                'nullable',
                'string',
                'max:5000'
            ],
        ]);

        $moderatorUuid = Auth::user()->uuid;

        $case = CaseFile::where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->firstOrFail();

        $this->authorize('update', $case);

        $oldStatus = $case->status;

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid,
            $oldStatus
        ) {
            $case->status = $request->status;
            $case->save();

            if ($oldStatus !== $case->status) {
                AuditLog::create([
                    'action' => 'update_case_status',
                    'performed_by' => $moderatorUuid,
                    'target_type' => 'CaseFile',
                    'target_id' => (string) $case->id,
                    'changes' => [
                        'case_number' => $case->case_number,
                        'type' => $case->type,
                        'status' => [
                            'before' => $oldStatus,
                            'after' => $case->status,
                        ],
                    ],
                ]);
            }

            if ($request->filled('comment')) {
                $comment = CaseComment::create([
                    'case_id' => $case->id,
                    'user_id' => $moderatorUuid,
                    'type' => 'OBSERVACION',
                    'comment' => trim($request->comment),
                    'color' => null,
                ]);

                CaseActivityUpdated::emit($case, $comment, 'case.comment.created');

                AuditLog::create([
                    'action' => 'moderator_add_case_comment',
                    'performed_by' => $moderatorUuid,
                    'target_type' => 'CaseFile',
                    'target_id' => (string) $case->id,
                    'changes' => [
                        'case_number' => $case->case_number,
                        'type' => $case->type,
                        'comment_id' => (string) $comment->id,
                        'comment_type' => $comment->type,
                    ],
                ]);
            }
        });

        if ($oldStatus !== $case->status) {
            try {
                $moderatorName = trim(
                    (Auth::user()->first_name ?? '') . ' ' .
                    (Auth::user()->last_name ?? '')
                );

                AdminNotification::notifyAdmins(
                    $case,
                    'El moderador ' . ($moderatorName ?: 'asignado')
                        . ' cambió el estado del caso ' . $case->case_number
                        . ': de "' . $oldStatus . '" a "' . $case->status . '".'
                );
            } catch (\Throwable $e) {
                report($e);
            }

            // Si también hubo comentario, su evento ya cubre el cambio de estado.
            if (!$request->filled('comment')) {
                CaseActivityUpdated::emit($case, null, 'case.status.updated');
            }
        }

        return redirect()
            ->route('moderator.case', ['id' => $case->id])
            ->with(
                'success',
                'Los cambios del caso fueron guardados correctamente.'
            );
    }

    /* AGREGAR SOLAMENTE UNA RESPUESTA AL CHAT */

    public function saveComment(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        $request->validate([
            'comment' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);

        $moderatorUuid = Auth::user()->uuid;

        $case = CaseFile::where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->firstOrFail();

        $this->authorize('update', $case);

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid
        ) {
            $conversation = DB::table('chat_conversations')
                ->where('user_uuid', $case->user_uuid)
                ->where('moderator_uuid', $moderatorUuid)
                ->first();

            if (!$conversation) {
                $conversationId = DB::table('chat_conversations')
                    ->insertGetId([
                        'uuid' => (string) Str::uuid(),
                        'user_uuid' => $case->user_uuid,
                        'moderator_uuid' => $moderatorUuid,
                        'status' => 'ACTIVO',
                        'moderator_last_read_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            } else {
                $conversationId = $conversation->id;

                DB::table('chat_conversations')
                    ->where('id', $conversationId)
                    ->update([
                        'status' => 'ACTIVO',
                        'updated_at' => now(),
                    ]);
            }

            ChatMessage::create([
                'conversation_id' => $conversationId,
                'sender_uuid' => $moderatorUuid,
                'sender_type' => 'MODERATOR',
                'message' => trim($request->comment),
            ]);

            CaseNotification::create([
                'user_uuid' => $case->user_uuid,
                'moderator_uuid' => $moderatorUuid,
                'case_id' => $case->id,
                'comment_id' => null,
                'message' =>
                    'El moderador ha respondido a tu caso ' .
                    $case->case_number . '.',
                'read_at' => null,
            ]);
        });

        try {
            AdminNotification::notifyAdmins(
                $case,
                'El moderador respondió en el caso ' . $case->case_number . '.',
                false
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('moderator.case', ['id' => $case->id])
            ->with(
                'success',
                'Respuesta enviada correctamente.'
            );
    }

    /* LISTAR CONVERSACIONES */

    public function chats()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $conversations = DB::table('chat_conversations')
            ->where('moderator_uuid', $moderatorUuid)
            ->orderByDesc('updated_at')
            ->get();

        foreach ($conversations as $conversation) {
            if ($conversation->created_at) {
                $conversation->created_at = Carbon::parse(
                    $conversation->created_at
                );
            }

            if ($conversation->updated_at) {
                $conversation->updated_at = Carbon::parse(
                    $conversation->updated_at
                );
            }

            if ($conversation->moderator_last_read_at) {
                $conversation->moderator_last_read_at = Carbon::parse(
                    $conversation->moderator_last_read_at
                );
            }

            $conversation->user = DB::table('users')
                ->where('uuid', $conversation->user_uuid)
                ->first();

            $conversation->messages = ChatMessage::where(
                'conversation_id',
                $conversation->id
            )
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($conversation->messages as $message) {
                if ($message->created_at) {
                    $message->created_at = Carbon::parse(
                        $message->created_at
                    );
                }

                if ($message->updated_at) {
                    $message->updated_at = Carbon::parse(
                        $message->updated_at
                    );
                }
            }
        }

        $chats = $conversations;

        return view(
            'moderator.chats',
            compact('conversations', 'chats')
        );
    }

    /* VER CONVERSACIÓN */

    public function viewChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $conversation = DB::table('chat_conversations')
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->first();

        if (!$conversation) {
            abort(404);
        }

        if ($conversation->created_at) {
            $conversation->created_at = Carbon::parse(
                $conversation->created_at
            );
        }

        if ($conversation->updated_at) {
            $conversation->updated_at = Carbon::parse(
                $conversation->updated_at
            );
        }

        if ($conversation->moderator_last_read_at) {
            $conversation->moderator_last_read_at = Carbon::parse(
                $conversation->moderator_last_read_at
            );
        }

        $conversation->user = DB::table('users')
            ->where('uuid', $conversation->user_uuid)
            ->first();

        $messages = ChatMessage::where('conversation_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($messages as $message) {
            if ($message->created_at) {
                $message->created_at = Carbon::parse(
                    $message->created_at
                );
            }

            if ($message->updated_at) {
                $message->updated_at = Carbon::parse(
                    $message->updated_at
                );
            }
        }

        DB::table('chat_conversations')
            ->where('id', $id)
            ->update([
                'moderator_last_read_at' => now(),
            ]);

        $conversation->moderator_last_read_at = Carbon::now();
        $conversation->messages = $messages;

        return view(
            'moderator.view-chat',
            compact('conversation', 'messages')
        );
    }

    /**
     * Obtener los mensajes actualizados de una conversación del moderador.
     */
    public function fetchChatMessages($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        // Verificar que la conversación esté asignada a este moderador.
        $conversation = DB::table('chat_conversations')
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->first();

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'Conversación no encontrada.'
            ], 404);
        }

        // Obtener los mensajes de la conversación.
        $messages = ChatMessage::where('conversation_id', $id)
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Marcar como leídos los mensajes nuevos del usuario mientras
        // el moderador está atendiendo esta conversación.
        $lastReadAt = $conversation->moderator_last_read_at;

        $hasUnreadUserMessages = ChatMessage::where('conversation_id', $id)
            ->where('sender_type', 'USER')
            ->when(
                $lastReadAt,
                fn ($query) => $query->where('created_at', '>', $lastReadAt)
            )
            ->exists();

        if ($hasUnreadUserMessages) {
            DB::table('chat_conversations')
                ->where('id', $id)
                ->update([
                    'moderator_last_read_at' => now()
                ]);
        }

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender_type' => $message->sender_type,
                    'message' => $message->message,
                    'time' => $message->created_at
                        ? Carbon::parse($message->created_at)->format('H:i')
                        : ''
                ];
            })->values()
        ]);
    }

    /* ENVIAR MENSAJE DEL MODERADOR */

    public function sendChatMessage(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        $request->validate([
            'message' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);

        $moderatorUuid = Auth::user()->uuid;

        $chat = DB::table('chat_conversations')
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->first();

        if (!$chat) {
            abort(404);
        }

        if (
            isset($chat->status) &&
            strtoupper($chat->status) === 'CERRADO'
        ) {
            return back()->with(
                'error',
                'Esta conversación se encuentra cerrada.'
            );
        }

        ChatMessage::create([
            'uuid' => (string) Str::uuid(),
            'conversation_id' => $id,
            'sender_uuid' => $moderatorUuid,
            'sender_type' => 'MODERATOR',
            'message' => trim($request->message),
        ]);

        DB::table('chat_conversations')
            ->where('id', $id)
            ->update([
                'updated_at' => now(),
                'status' => 'ACTIVO',
            ]);

        $activeCase = CaseFile::where('user_uuid', $chat->user_uuid)
            ->where('moderator_uuid', $moderatorUuid)
            ->whereIn('status', ['Abierto', 'En seguimiento'])
            ->latest()
            ->first();

        if ($activeCase) {
            try {
                AdminNotification::notifyAdmins(
                    $activeCase,
                    'El moderador respondió en el caso ' . $activeCase->case_number . '.',
                    false
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return back()->with(
            'success',
            'Mensaje enviado correctamente.'
        );
    }

    /* CERRAR CONVERSACIÓN */

    public function closeChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $chat = DB::table('chat_conversations')
            ->where('id', $id)
            ->where('moderator_uuid', $moderatorUuid)
            ->first();

        if (!$chat) {
            abort(404);
        }

        $oldStatus = $chat->status;

        DB::table('chat_conversations')
            ->where('id', $id)
            ->update([
                'status' => 'CERRADO',
                'updated_at' => now(),
            ]);

        if ($oldStatus !== 'CERRADO') {
            AuditLog::create([
                'action' => 'moderator_close_chat',
                'performed_by' => $moderatorUuid,
                'target_type' => 'ChatConversation',
                'target_id' => (string) $id,
                'changes' => [
                    'status' => [
                        'before' => $oldStatus,
                        'after' => 'CERRADO',
                    ],
                ],
            ]);
        }

        return redirect()
            ->route('moderator.chats')
            ->with(
                'success',
                'La conversación fue cerrada correctamente.'
            );
    }
}