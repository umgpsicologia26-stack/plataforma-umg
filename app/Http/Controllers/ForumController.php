<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MOSTRAR FORO
    |--------------------------------------------------------------------------
    |
    | USUARIO:
    | Solo puede ver publicaciones visibles.
    |
    | MODERADOR / ADMIN:
    | Pueden ver publicaciones visibles y ocultas para poder moderarlas.
    |
    */

    public function index()
    {
        $user = Auth::user();

        $query = ForumMessage::with('user')
            ->orderBy('created_at', 'asc');

        /*
        |--------------------------------------------------------------------------
        | USUARIO NORMAL
        |--------------------------------------------------------------------------
        |
        | Los usuarios solamente pueden visualizar mensajes visibles.
        |
        */

        if (
            !$user ||
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {
            $query->where(
                'visibility_status',
                'VISIBLE'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR / MODERADOR
        |--------------------------------------------------------------------------
        |
        | No agregamos where de visibility_status.
        | De esta manera pueden ver:
        |
        | VISIBLE
        | HIDDEN
        |
        */

        $messages = $query->get();

        return view(
            'forum.index',
            compact('messages')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR MENSAJE
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $request->validate([

            'content' => [
                'required',
                'string',
                'max:5000'
            ],

            'identity_type' => [
                'required',
                'in:name,nickname'
            ]

        ]);


        $user = Auth::user();


        ForumMessage::create([

            'uuid' => (string) Str::uuid(),

            /*
             * SIEMPRE se guarda el UUID REAL
             * del usuario.
             */
            'user_uuid' => $user->uuid,

            /*
             * Se conserva GENERAL para no romper
             * una posible columna existente en BD.
             */
            'category' => 'GENERAL',

            'content' => $request->content,

            /*
             * nickname = anónimo
             * name = nombre real
             */
            'is_anonymous' =>
                $request->identity_type === 'nickname',

            'ai_flagged' => false,

            /*
             * Todo mensaje nuevo comienza visible.
             */
            'visibility_status' => 'VISIBLE'

        ]);


        return back()->with(
            'success',
            'Mensaje publicado correctamente.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | OCULTAR MENSAJE
    |--------------------------------------------------------------------------
    |
    | SOLO ADMINISTRADOR Y MODERADOR
    |
    */

    public function restrict($uuid)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PERMISOS
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR MENSAJE
        |--------------------------------------------------------------------------
        */

        $message = ForumMessage::findOrFail($uuid);


        /*
        |--------------------------------------------------------------------------
        | OCULTAR MENSAJE
        |--------------------------------------------------------------------------
        */

        $message->visibility_status = 'HIDDEN';

        $message->save();


        return back()->with(
            'success',
            'El mensaje fue restringido correctamente.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESTAURAR MENSAJE
    |--------------------------------------------------------------------------
    |
    | SOLO ADMINISTRADOR Y MODERADOR
    |
    */

    public function restore($uuid)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PERMISOS
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR MENSAJE
        |--------------------------------------------------------------------------
        */

        $message = ForumMessage::findOrFail($uuid);


        /*
        |--------------------------------------------------------------------------
        | RESTAURAR MENSAJE
        |--------------------------------------------------------------------------
        */

        $message->visibility_status = 'VISIBLE';

        $message->save();


        return back()->with(
            'success',
            'El mensaje fue restaurado.'
        );
    }
}