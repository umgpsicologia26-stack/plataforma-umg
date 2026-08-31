<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    | IMPORTANTE:
    | El detalle utiliza la MISMA vista:
    |
    | moderator.cases
    |
    | No se utiliza moderator.case
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
            ->where('id', $id)
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
    |
    | Permite modificar:
    |
    | - Estado
    | - Prioridad
    | - Comentario de seguimiento
    |
    */

    public function updateCase(
        Request $request,
        $id
    ) {
        $this->checkRole(['MODERATOR']);

        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | BUSCAR CASO
        |--------------------------------------------------------------------------
        |
        | El moderador solamente puede modificar casos
        | que estén asignados a él.
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
        |--------------------------------------------------------------------------
        | TRANSACCIÓN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $case,
            $moderatorUuid
        ) {

            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR ESTADO
            |--------------------------------------------------------------------------
            */

            $case->status = $request->status;


            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR PRIORIDAD
            |--------------------------------------------------------------------------
            */

            $case->priority = $request->priority;


            /*
            |--------------------------------------------------------------------------
            | GUARDAR CASO
            |--------------------------------------------------------------------------
            */

            $case->save();


            /*
            |--------------------------------------------------------------------------
            | GUARDAR COMENTARIO
            |--------------------------------------------------------------------------
            |
            | La tabla case_comments utiliza:
            |
            | user_id
            |
            | y acepta:
            |
            | OBSERVACION
            | CORRECCION
            | SEGUIMIENTO
            |
            */

            if ($request->filled('comment')) {

                CaseComment::create([
                    'case_id' => $case->id,
                    'user_id' => $moderatorUuid,
                    'comment' => $request->comment,
                    'type' => 'SEGUIMIENTO',
                ]);
            }
        });


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL DETALLE
        |--------------------------------------------------------------------------
        */

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
    | LISTAR CHATS
    |--------------------------------------------------------------------------
    */

    public function chats()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;


        $chats = DB::table('chats')
            ->where(
                'moderator_uuid',
                $moderatorUuid
            )
            ->orderByDesc('updated_at')
            ->get();


        return view(
            'moderator.chats',
            compact('chats')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VER CHAT
    |--------------------------------------------------------------------------
    */

    public function viewChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;


        /*
        |--------------------------------------------------------------------------
        | BUSCAR CHAT
        |--------------------------------------------------------------------------
        */

        $chat = DB::table('chats')
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
        | OBTENER MENSAJES
        |--------------------------------------------------------------------------
        */

        $messages = DB::table('chat_messages')
            ->where(
                'chat_id',
                $id
            )
            ->orderBy(
                'created_at',
                'asc'
            )
            ->get();


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
        | VALIDAR MENSAJE
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
        | VERIFICAR CHAT
        |--------------------------------------------------------------------------
        */

        $chat = DB::table('chats')
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
        | NO ENVIAR MENSAJES A CHAT CERRADO
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
            'chat_id' => $id,
            'sender_uuid' => $moderatorUuid,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR CHAT
        |--------------------------------------------------------------------------
        */

        DB::table('chats')
            ->where(
                'id',
                $id
            )
            ->update([
                'updated_at' => now(),
            ]);


        return back()->with(
            'success',
            'Mensaje enviado correctamente.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR CHAT
    |--------------------------------------------------------------------------
    */

    public function closeChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR CHAT
        |--------------------------------------------------------------------------
        */

        $chat = DB::table('chats')
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

        DB::table('chats')
            ->where(
                'id',
                $id
            )
            ->update([
                'status' => 'CERRADO',
                'updated_at' => now(),
            ]);


        return redirect()
            ->route('moderator.chats')
            ->with(
                'success',
                'La conversación fue cerrada correctamente.'
            );
    }
}