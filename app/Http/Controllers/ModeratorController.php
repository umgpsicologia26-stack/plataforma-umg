<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
use App\Models\CaseNotification;
use App\Models\ChatConversation;
use App\Models\ModeratorNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ModeratorController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DEL MODERADOR
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $evaluationNotifications = ModeratorNotification::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('read', false)
            ->orderByDesc('created_at')
            ->get();

        $evaluationNotificationsCount = $evaluationNotifications->count();

        $totalCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )->count();

        $openCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where(
                'status',
                'Abierto'
            )
            ->count();

        $followUpCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where(
                'status',
                'En seguimiento'
            )
            ->count();

        $closedCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where(
                'status',
                'Cerrado'
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | MENSAJES NUEVOS DEL CHAT
        |--------------------------------------------------------------------------
        */

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
            ->count();

        return view(
            'moderator.dashboard',
            compact(
                'totalCases',
                'openCases',
                'followUpCases',
                'closedCases',
                'newConversationsCount',
                'evaluationNotifications',
                'evaluationNotificationsCount'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESULTADO DE EVALUACIÓN
    |--------------------------------------------------------------------------
    */

    public function evaluationResult($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $notification = ModeratorNotification::with([
            'evaluacion',
            'intento.usuario',
            'intento.respuestas.pregunta',
        ])
            ->where(
                'id',
                $id
            )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | VERIFICACIÓN DE SEGURIDAD
        |--------------------------------------------------------------------------
        |
        | El moderador solamente puede consultar resultados de evaluaciones
        | creadas por él y vinculadas correctamente con el intento.
        |
        */

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

        /*
        |--------------------------------------------------------------------------
        | MARCAR LA NOTIFICACIÓN COMO LEÍDA
        |--------------------------------------------------------------------------
        */

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

    /*
    |--------------------------------------------------------------------------
    | DESCARGAR RESULTADO DE EVALUACIÓN EN PDF
    |--------------------------------------------------------------------------
    */

    public function downloadEvaluationResult($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $notification = ModeratorNotification::with([
            'evaluacion',
            'intento.usuario',
            'intento.respuestas.pregunta',
        ])
            ->where(
                'id',
                $id
            )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | VERIFICACIÓN DE SEGURIDAD
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

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

        return $pdf->download(
            $nombreArchivo
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MARCAR NOTIFICACIÓN DE EVALUACIÓN COMO LEÍDA
    |--------------------------------------------------------------------------
    */

    public function markEvaluationNotificationAsRead($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $notification = ModeratorNotification::where(
            'id',
            $id
        )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();

        $notification->update([
            'read' => true,
        ]);

        return redirect()
            ->route(
                'moderator.dashboard'
            )
            ->with(
                'success',
                'Notificación marcada como leída.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAR CASOS DEL MODERADOR
    |--------------------------------------------------------------------------
    */

    public function cases()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $cases = CaseFile::with([
            'user',
            'moderator'
        ])
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->orderByDesc(
                'created_at'
            )
            ->get();

        return view(
            'moderator.cases',
            compact('cases')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VER DETALLE DE UN CASO
    |--------------------------------------------------------------------------
    */

    public function viewCase($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $case = CaseFile::with([
            'user',
            'moderator',
            'comments.user'
        ])
            ->where(
                'id',
                $id
            )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();

        return view(
            'moderator.view-case',
            compact('case')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CASO
    |--------------------------------------------------------------------------
    */

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

        $case = CaseFile::where(
            'id',
            $id
        )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid
        ) {

            $case->status = $request->status;

            $case->save();

            if ($request->filled('comment')) {

                CaseComment::create([
                    'case_id' => $case->id,
                    'user_id' => $moderatorUuid,
                    'type' => 'OBSERVACION',
                    'comment' => trim($request->comment),
                    'color' => null,
                ]);
            }
        });

        return redirect()
            ->route(
                'moderator.case',
                [
                    'id' => $case->id
                ]
            )
            ->with(
                'success',
                'Los cambios del caso fueron guardados correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AGREGAR SOLAMENTE UNA RESPUESTA AL CHAT
    |--------------------------------------------------------------------------
    */

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

        $case = CaseFile::where(
            'id',
            $id
        )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid
        ) {

            $conversation = DB::table(
                'chat_conversations'
            )
                ->where(
                    'user_uuid',
                    $case->user_uuid
                )
                ->where(
                    'moderator_uuid',
                    $moderatorUuid
                )
                ->first();

            if (!$conversation) {

                $conversationId = DB::table(
                    'chat_conversations'
                )->insertGetId([
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

                DB::table(
                    'chat_conversations'
                )
                    ->where(
                        'id',
                        $conversationId
                    )
                    ->update([
                        'status' => 'ACTIVO',
                        'updated_at' => now(),
                    ]);
            }

            DB::table(
                'chat_messages'
            )->insert([
                'uuid' => (string) Str::uuid(),
                'conversation_id' => $conversationId,
                'sender_uuid' => $moderatorUuid,
                'sender_type' => 'MODERATOR',
                'message' => trim($request->comment),
                'created_at' => now(),
                'updated_at' => now(),
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

        return redirect()
            ->route(
                'moderator.case',
                [
                    'id' => $case->id
                ]
            )
            ->with(
                'success',
                'Respuesta enviada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAR CONVERSACIONES
    |--------------------------------------------------------------------------
    */

    public function chats()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $conversations = DB::table(
            'chat_conversations'
        )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->orderByDesc(
                'updated_at'
            )
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

            $conversation->user = DB::table(
                'users'
            )
                ->where(
                    'uuid',
                    $conversation->user_uuid
                )
                ->first();

            $conversation->messages = DB::table(
                'chat_messages'
            )
                ->where(
                    'conversation_id',
                    $conversation->id
                )
                ->orderBy(
                    'created_at',
                    'asc'
                )
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
            compact(
                'conversations',
                'chats'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VER CONVERSACIÓN
    |--------------------------------------------------------------------------
    */

    public function viewChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $conversation = DB::table(
            'chat_conversations'
        )
            ->where(
                'id',
                $id
            )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
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

        $conversation->user = DB::table(
            'users'
        )
            ->where(
                'uuid',
                $conversation->user_uuid
            )
            ->first();

        $messages = DB::table(
            'chat_messages'
        )
            ->where(
                'conversation_id',
                $id
            )
            ->orderBy(
                'created_at',
                'asc'
            )
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

        DB::table(
            'chat_conversations'
        )
            ->where(
                'id',
                $id
            )
            ->update([
                'moderator_last_read_at' => now(),
            ]);

        $conversation->moderator_last_read_at = Carbon::now();

        $conversation->messages = $messages;

        return view(
            'moderator.view-chat',
            compact(
                'conversation',
                'messages'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENVIAR MENSAJE DEL MODERADOR
    |--------------------------------------------------------------------------
    */

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

        $chat = DB::table(
            'chat_conversations'
        )
            ->where(
                'id',
                $id
            )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
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

        DB::table(
            'chat_messages'
        )->insert([
            'uuid' => (string) Str::uuid(),
            'conversation_id' => $id,
            'sender_uuid' => $moderatorUuid,
            'sender_type' => 'MODERATOR',
            'message' => trim($request->message),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table(
            'chat_conversations'
        )
            ->where(
                'id',
                $id
            )
            ->update([
                'updated_at' => now(),
                'status' => 'ACTIVO',
            ]);

        return back()->with(
            'success',
            'Mensaje enviado correctamente.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CERRAR CONVERSACIÓN
    |--------------------------------------------------------------------------
    */

    public function closeChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $chat = DB::table(
            'chat_conversations'
        )
            ->where(
                'id',
                $id
            )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->first();

        if (!$chat) {
            abort(404);
        }

        DB::table(
            'chat_conversations'
        )
            ->where(
                'id',
                $id
            )
            ->update([
                'status' => 'CERRADO',
                'updated_at' => now(),
            ]);

        return redirect()
            ->route(
                'moderator.chats'
            )
            ->with(
                'success',
                'La conversación fue cerrada correctamente.'
            );
    }
}