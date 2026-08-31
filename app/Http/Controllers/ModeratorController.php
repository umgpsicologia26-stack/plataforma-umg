<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\CaseComment;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends BaseController
{
    /* DASHBOARD */

    public function dashboard()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;


        /* CONVERSACIONES ASIGNADAS */

        $conversations = ChatConversation::where(
            'moderator_uuid',
            $moderatorUuid
        )->get();


        /*
        |--------------------------------------------------------------------------
        | MENSAJES NUEVOS
        |--------------------------------------------------------------------------
        |
        | Se consideran nuevos únicamente los mensajes enviados
        | por el USUARIO después de la última lectura del moderador.
        |
        */

        $newMessagesCount = 0;

        $newConversationsCount = 0;


        foreach ($conversations as $conversation) {

            $query = ChatMessage::where(
                'conversation_id',
                $conversation->id
            )
            ->where(
                'sender_type',
                'USER'
            );


            if ($conversation->moderator_last_read_at) {

                $query->where(
                    'created_at',
                    '>',
                    $conversation->moderator_last_read_at
                );

            }


            $count = $query->count();


            if ($count > 0) {

                $newMessagesCount += $count;

                $newConversationsCount++;

            }
        }


        return view(
            'moderator.dashboard',
            compact(
                'newMessagesCount',
                'newConversationsCount'
            )
        );
    }


    /* LISTAR CASOS ASIGNADOS */

    public function cases()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $cases = CaseFile::where(
            'moderator_uuid',
            $moderatorUuid
        )
        ->with([
            'user',
            'comments.user'
        ])
        ->latest()
        ->get();

        return view(
            'moderator.cases',
            compact('cases')
        );
    }


    /* VER CASO INDIVIDUAL */

    public function viewCase($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;

        $case = CaseFile::where(
            'id',
            $id
        )
        ->where(
            'moderator_uuid',
            $moderatorUuid
        )
        ->with([
            'user',
            'moderator',
            'comments.user'
        ])
        ->firstOrFail();

        return view(
            'moderator.view-case',
            compact('case')
        );
    }


    /* AGREGAR OBSERVACIÓN / CORRECCIÓN */

    public function saveComment(Request $request, $id)
{
    $this->checkRole(['MODERATOR']);

    $request->validate([
        'comment' => [
            'required',
            'string',
            'min:3',
            'max:5000'
        ]
    ]);

    $moderatorUuid = Auth::user()->uuid;

    // Verificar que el caso pertenece al moderador
    $case = CaseFile::where('id', $id)
        ->where('moderator_uuid', $moderatorUuid)
        ->firstOrFail();

    // Guardar comentario del moderador
    CaseComment::create([
        'case_id' => $case->id,
        'user_id' => $moderatorUuid,
        'type' => 'SEGUIMIENTO',
        'comment' => $request->comment,
        'color' => null
    ]);

    // Cambiar automáticamente el estado a "En seguimiento"
    if ($case->status === 'En seguimiento') {
        $case->status = 'Cerrado';
        $case->save();
    }

    return back()->with(
        'success',
        'Comentario de seguimiento guardado correctamente.'
    );
}

    /* ACTUALIZAR ESTADO */

    public function updateStatus(Request $request, $id)
{
    $this->checkRole(['MODERATOR']);

    $request->validate([
        'status' => [
            'required',
            'in:EN SEGUIMIENTO, CERRADO'
        ]
    ]);

    $moderatorUuid = Auth::user()->uuid;

    $case = CaseFile::where('id', $id)
        ->where('moderator_uuid', $moderatorUuid)
        ->firstOrFail();

    $case->update([
        'status' => $request->status
    ]);

    return back()->with(
        'success',
        'Estado del caso actualizado correctamente.'
    );
}

    /* LISTAR CONVERSACIONES DEL MODERADOR */

    public function chats()
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;


        $conversations = ChatConversation::where(
            'moderator_uuid',
            $moderatorUuid
        )
        ->with([
            'user',
            'messages' => function ($query) {

                $query->orderBy(
                    'created_at',
                    'asc'
                );

            }
        ])
        ->latest()
        ->get();


        /* CALCULAR MENSAJES NUEVOS */

        foreach ($conversations as $conversation) {

            $query = $conversation->messages
                ->where(
                    'sender_type',
                    'USER'
                );


            if ($conversation->moderator_last_read_at) {

                $query = $query->filter(function ($message) use ($conversation) {

                    return $message->created_at
                        ->gt(
                            $conversation->moderator_last_read_at
                        );

                });

            }


            $conversation->new_messages_count =
                $query->count();
        }


        return view(
            'moderator.chats',
            compact('conversations')
        );
    }


    /* VER CONVERSACIÓN INDIVIDUAL */

    public function viewChat($id)
    {
        $this->checkRole(['MODERATOR']);

        $moderatorUuid = Auth::user()->uuid;


        /* SEGURIDAD */

        $conversation = ChatConversation::where(
            'id',
            $id
        )
        ->where(
            'moderator_uuid',
            $moderatorUuid
        )
        ->firstOrFail();


        /* MARCAR COMO LEÍDA */

        $conversation->moderator_last_read_at = now();

        $conversation->save();


        /* CARGAR MENSAJES */

        $conversation->load([

            'user',

            'messages' => function ($query) {

                $query->orderBy(
                    'created_at',
                    'asc'
                );

            }

        ]);


        return view(
            'moderator.view-chat',
            compact('conversation')
        );
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
            'min:1',
            'max:2000'
        ]
    ]);

    $moderatorUuid = Auth::user()->uuid;

    /* VERIFICAR CONVERSACIÓN */

    $conversation = ChatConversation::where(
        'id',
        $id
    )
    ->where(
        'moderator_uuid',
        $moderatorUuid
    )
    ->firstOrFail();


    /* GUARDAR MENSAJE */

    ChatMessage::create([

        'conversation_id' => $conversation->id,

        'sender_uuid' => $moderatorUuid,

        'sender_type' => 'MODERATOR',

        'message' => trim(
            $request->message
        ),

    ]);


    /* ACTUALIZAR FECHA DE LA CONVERSACIÓN */

    $conversation->touch();


    /* ACTIVAR CONVERSACIÓN */

    if ($conversation->status === 'ESPERANDO') {

        $conversation->status = 'ACTIVO';

        $conversation->save();

    }


    /* ACTUALIZAR ÚLTIMA LECTURA DEL MODERADOR */

    $conversation->moderator_last_read_at = now();

    $conversation->save();


    return back()->with(
        'success',
        'Mensaje enviado correctamente.'
    );
}
    }
