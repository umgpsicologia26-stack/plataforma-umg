<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
use App\Models\CaseNotification;
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

        $criticalCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where(
                'priority',
                'Critica'
            )
            ->count();

        return view(
            'moderator.dashboard',
            compact(
                'totalCases',
                'openCases',
                'followUpCases',
                'closedCases',
                'criticalCases'
            )
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
    |
    | Permite cambiar:
    | - Estado
    | - Prioridad
    | - Agregar comentario de seguimiento
    |
    | Si existe comentario, se crea además una notificación
    | para el usuario propietario del caso.
    |
    */

    public function updateCase(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        /*
        |----------------------------------------------------------------------
        | VALIDACIÓN
        |----------------------------------------------------------------------
        */

        $request->validate([
            'status' => [
                'required',
                'in:Abierto,En seguimiento,Cerrado'
            ],

            'priority' => [
                'required',
                'in:Baja,Media,Alta,Critica'
            ],

            'comment' => [
                'nullable',
                'string',
                'max:5000'
            ],
        ]);


        $moderatorUuid = Auth::user()->uuid;


        /*
        |----------------------------------------------------------------------
        | BUSCAR CASO
        |----------------------------------------------------------------------
        |
        | El moderador solamente puede modificar casos que le pertenecen.
        |
        */

        $case = CaseFile::where(
            'id',
            $id
        )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();


        /*
        |----------------------------------------------------------------------
        | ACTUALIZAR CASO Y CREAR COMENTARIO
        |----------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid
        ) {

            /*
            |------------------------------------------------------------------
            | ACTUALIZAR ESTADO Y PRIORIDAD
            |------------------------------------------------------------------
            */

            $case->status = $request->status;
            $case->priority = $request->priority;

            $case->save();


            /*
            |------------------------------------------------------------------
            | CREAR COMENTARIO
            |------------------------------------------------------------------
            */

            if ($request->filled('comment')) {

                $comment = CaseComment::create([
                    'case_id' => $case->id,
                    'user_id' => $moderatorUuid,
                    'comment' => trim(
                        $request->comment
                    ),
                    'type' => 'SEGUIMIENTO',
                ]);


                /*
                |--------------------------------------------------------------
                | NOTIFICAR AL USUARIO
                |--------------------------------------------------------------
                */

                CaseNotification::create([
                    'user_uuid' => $case->user_uuid,
                    'case_id' => $case->id,
                    'comment_id' => $comment->id,
                    'message' =>
                        'El moderador ha respondido a tu caso ' .
                        $case->case_number . '.',
                ]);
            }
        });


        /*
        |----------------------------------------------------------------------
        | REGRESAR AL CASO
        |----------------------------------------------------------------------
        */

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
    | AGREGAR SOLAMENTE UN COMENTARIO
    |--------------------------------------------------------------------------
    |
    | Este método existe porque web.php tiene la ruta:
    |
    | moderator.case.comment
    |
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


        /*
        |----------------------------------------------------------------------
        | BUSCAR CASO
        |----------------------------------------------------------------------
        */

        $case = CaseFile::where(
            'id',
            $id
        )
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->firstOrFail();


        /*
        |----------------------------------------------------------------------
        | CREAR COMENTARIO Y NOTIFICACIÓN
        |----------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid
        ) {

            $comment = CaseComment::create([
                'case_id' => $case->id,
                'user_id' => $moderatorUuid,
                'comment' => trim(
                    $request->comment
                ),
                'type' => 'SEGUIMIENTO',
            ]);


            CaseNotification::create([
                'user_uuid' => $case->user_uuid,
                'case_id' => $case->id,
                'comment_id' => $comment->id,
                'message' =>
                    'El moderador ha respondido a tu caso ' .
                    $case->case_number . '.',
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
                'Comentario agregado correctamente.'
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


        /*
        |----------------------------------------------------------------------
        | OBTENER CONVERSACIONES
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | PREPARAR DATOS
        |----------------------------------------------------------------------
        */

        foreach ($conversations as $conversation) {

            /*
            |------------------------------------------------------------------
            | FECHAS
            |------------------------------------------------------------------
            */

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


            /*
            |------------------------------------------------------------------
            | USUARIO
            |------------------------------------------------------------------
            */

            $conversation->user = DB::table(
                'users'
            )
                ->where(
                    'uuid',
                    $conversation->user_uuid
                )
                ->first();


            /*
            |------------------------------------------------------------------
            | MENSAJES
            |------------------------------------------------------------------
            */

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


            /*
            |------------------------------------------------------------------
            | FECHAS DE MENSAJES
            |------------------------------------------------------------------
            */

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


        /*
        |----------------------------------------------------------------------
        | COMPATIBILIDAD
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | BUSCAR CONVERSACIÓN
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | FECHAS
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | USUARIO
        |----------------------------------------------------------------------
        */

        $conversation->user = DB::table(
            'users'
        )
            ->where(
                'uuid',
                $conversation->user_uuid
            )
            ->first();


        /*
        |----------------------------------------------------------------------
        | MENSAJES
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | CONVERTIR FECHAS DE MENSAJES
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | MARCAR CONVERSACIÓN COMO LEÍDA
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | ACTUALIZAR OBJETO EN MEMORIA
        |----------------------------------------------------------------------
        */

        $conversation->moderator_last_read_at = Carbon::now();

        $conversation->messages = $messages;


        /*
        |----------------------------------------------------------------------
        | VISTA
        |----------------------------------------------------------------------
        |
        | resources/views/moderator/view-chat.blade.php
        |
        */

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


        /*
        |----------------------------------------------------------------------
        | VALIDACIÓN
        |----------------------------------------------------------------------
        */

        $request->validate([
            'message' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);


        $moderatorUuid = Auth::user()->uuid;


        /*
        |----------------------------------------------------------------------
        | VERIFICAR CONVERSACIÓN
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | NO PERMITIR MENSAJES EN CONVERSACIÓN CERRADA
        |----------------------------------------------------------------------
        */

        if (
            isset($chat->status) &&
            strtoupper($chat->status) === 'CERRADO'
        ) {

            return back()->with(
                'error',
                'Esta conversación se encuentra cerrada.'
            );
        }


        /*
        |----------------------------------------------------------------------
        | GUARDAR MENSAJE
        |----------------------------------------------------------------------
        */

        DB::table(
            'chat_messages'
        )
            ->insert([
                'uuid' => (string) Str::uuid(),
                'conversation_id' => $id,
                'sender_uuid' => $moderatorUuid,
                'sender_type' => 'MODERATOR',
                'message' => trim(
                    $request->message
                ),
                'created_at' => now(),
                'updated_at' => now(),
            ]);


        /*
        |----------------------------------------------------------------------
        | ACTUALIZAR CONVERSACIÓN
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | VERIFICAR CONVERSACIÓN
        |----------------------------------------------------------------------
        */

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


        /*
        |----------------------------------------------------------------------
        | CERRAR CONVERSACIÓN
        |----------------------------------------------------------------------
        */

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