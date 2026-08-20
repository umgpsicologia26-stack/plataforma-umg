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
    */

    public function index()
    {
        $messages = ForumMessage::with('user')
            ->where('visibility_status', 'VISIBLE')
            ->orderBy('created_at', 'asc')
            ->get();

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
             * Ya no utilizamos categorías.
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

        if (
            !$user ||
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {

            abort(403);
        }


        $message = ForumMessage::findOrFail($uuid);


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

        if (
            !$user ||
            !in_array(
                $user->role,
                ['ADMIN', 'MODERATOR']
            )
        ) {

            abort(403);
        }


        $message = ForumMessage::findOrFail($uuid);


        $message->visibility_status = 'VISIBLE';

        $message->save();


        return back()->with(
            'success',
            'El mensaje fue restaurado.'
        );
    }
}