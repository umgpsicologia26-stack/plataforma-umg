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
    | Puede recibir publicaciones visibles y ocultas.
    | La vista determina qué contenido puede mostrarse.
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
    | VISIBILIDAD
    |--------------------------------------------------------------------------
    |
    | USUARIO:
    | Puede recibir publicaciones visibles y ocultas.
    | La vista determina qué contenido puede mostrarse.
    |
    | MODERADOR / ADMIN:
    | Pueden ver publicaciones visibles y ocultas para poder moderarlas.
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
        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | USUARIO AUTENTICADO
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();


        if (!$user) {
            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | CREAR PUBLICACIÓN
        |--------------------------------------------------------------------------
        */

        ForumMessage::create([

            /*
            |------------------------------------------------------------------
            | UUID DE LA PUBLICACIÓN
            |------------------------------------------------------------------
            */

            'uuid' => (string) Str::uuid(),


            /*
            |------------------------------------------------------------------
            | UUID REAL DEL USUARIO
            |------------------------------------------------------------------
            */

            'user_uuid' => $user->uuid,


            /*
            |------------------------------------------------------------------
            | CATEGORÍA
            |------------------------------------------------------------------
            */

            'category' => 'GENERAL',


            /*
            |------------------------------------------------------------------
            | CONTENIDO
            |------------------------------------------------------------------
            |
            | Usamos input() para obtener correctamente el valor enviado
            | por el formulario.
            |
            */

            'content' => $request->input('content'),


            /*
            |------------------------------------------------------------------
            | IDENTIDAD
            |------------------------------------------------------------------
            |
            | nickname = publicación anónima
            | name     = nombre real
            |
            */

            'is_anonymous' =>
                $request->input('identity_type') === 'nickname',


            /*
            |------------------------------------------------------------------
            | IA
            |------------------------------------------------------------------
            */

            'ai_flagged' => false,


            /*
            |------------------------------------------------------------------
            | VISIBILIDAD
            |------------------------------------------------------------------
            |
            | Toda publicación nueva comienza visible.
            |
            */

            'visibility_status' => 'VISIBLE'
        ]);


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL FORO
        |--------------------------------------------------------------------------
        */

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
        | VERIFICAR AUTENTICACIÓN
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PERMISOS
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR PUBLICACIÓN POR UUID
        |--------------------------------------------------------------------------
        */

        $message = ForumMessage::where(
            'uuid',
            $uuid
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | OCULTAR MENSAJE
        |--------------------------------------------------------------------------
        */

        $message->visibility_status = 'HIDDEN';

        $message->save();


        /*
        |--------------------------------------------------------------------------
        | REGRESAR
        |--------------------------------------------------------------------------
        */

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
        | VERIFICAR AUTENTICACIÓN
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PERMISOS
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR PUBLICACIÓN POR UUID
        |--------------------------------------------------------------------------
        */

        $message = ForumMessage::where(
            'uuid',
            $uuid
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | RESTAURAR MENSAJE
        |--------------------------------------------------------------------------
        */

        $message->visibility_status = 'VISIBLE';

        $message->save();


        /*
        |--------------------------------------------------------------------------
        | REGRESAR
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'El mensaje fue restaurado correctamente.'
        );
    }
}