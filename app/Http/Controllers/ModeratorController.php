<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
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

        $criticalCases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
            ->where('priority', 'Critica')
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
            ->orderByDesc('created_at')
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
    |
    | Se mantiene la vista moderator.cases
    |
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
            'moderator.cases',
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
            $case->priority = $request->priority;

            $case->save();

            if ($request->filled('comment')) {

                CaseComment::create([
                    'case_id' => $case->id,
                    'user_id' => $moderatorUuid,
                    'comment' => $request->comment,
                    'type' => 'SEGUIMIENTO',
                ]);
            }
        });

        return redirect()
            ->route(
                'moderator.case',
                ['id' => $case->id]
            )
            ->with(
                'success',
                'Los cambios del caso fueron guardados correctamente.'
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
        |--------------------------------------------------------------------------
        | OBTENER CONVERSACIONES
        |--------------------------------------------------------------------------
        */

        $conversations = DB::table('chat_conversations')
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->orderByDesc('updated_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PREPARAR DATOS PARA LA VISTA
        |--------------------------------------------------------------------------
        */

        foreach ($conversations as $conversation) {

            /*
            |------------------------------------------------------------------
            | CONVERTIR FECHAS A CARBON
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
            | OBTENER USUARIO
            |------------------------------------------------------------------
            */

            $conversation->user = DB::table('users')
                ->where(
                    'uuid',
                    $conversation->user_uuid
                )
                ->first();

            /*
            |------------------------------------------------------------------
            | OBTENER MENSAJES
            |------------------------------------------------------------------
            */

            $conversation->messages = DB::table('chat_messages')
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
            | CONVERTIR FECHAS DE LOS MENSAJES A CARBON
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
        |--------------------------------------------------------------------------
        | COMPATIBILIDAD
        |--------------------------------------------------------------------------
        |
        | Algunas partes de tu vista pueden utilizar $chats.
        | Se mantienen ambas variables para evitar errores.
        |
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
        |--------------------------------------------------------------------------
        | BUSCAR CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        $chat = DB::table('chat_conversations')
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
        |--------------------------------------------------------------------------
        | CONVERTIR FECHAS DE LA CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        if ($chat->created_at) {
            $chat->created_at = Carbon::parse(
                $chat->created_at
            );
        }

        if ($chat->updated_at) {
            $chat->updated_at = Carbon::parse(
                $chat->updated_at
            );
        }

        if ($chat->moderator_last_read_at) {
            $chat->moderator_last_read_at = Carbon::parse(
                $chat->moderator_last_read_at
            );
        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER USUARIO
        |--------------------------------------------------------------------------
        */

        $chat->user = DB::table('users')
            ->where(
                'uuid',
                $chat->user_uuid
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | OBTENER MENSAJES
        |--------------------------------------------------------------------------
        */

        $messages = DB::table('chat_messages')
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
        |--------------------------------------------------------------------------
        | CONVERTIR FECHAS DE LOS MENSAJES
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | MARCAR CONVERSACIÓN COMO LEÍDA
        |--------------------------------------------------------------------------
        */

        DB::table('chat_conversations')
            ->where(
                'id',
                $id
            )
            ->update([
                'moderator_last_read_at' => now(),
            ]);

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR TAMBIÉN EL OBJETO EN MEMORIA
        |--------------------------------------------------------------------------
        */

        $chat->moderator_last_read_at = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | MOSTRAR VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'moderator.chat',
            compact(
                'chat',
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
        |--------------------------------------------------------------------------
        | VALIDAR
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | VERIFICAR CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        $chat = DB::table('chat_conversations')
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
        |--------------------------------------------------------------------------
        | NO PERMITIR MENSAJES EN CONVERSACIÓN CERRADA
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | GUARDAR MENSAJE
        |--------------------------------------------------------------------------
        */

        DB::table('chat_messages')->insert([
            'uuid' => (string) Str::uuid(),
            'conversation_id' => $id,
            'sender_uuid' => $moderatorUuid,
            'sender_type' => 'MODERATOR',
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        DB::table('chat_conversations')
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
        |--------------------------------------------------------------------------
        | VERIFICAR CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        $chat = DB::table('chat_conversations')
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
        |--------------------------------------------------------------------------
        | CERRAR CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        DB::table('chat_conversations')
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