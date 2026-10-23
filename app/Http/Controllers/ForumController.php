<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumMessage;
use App\Models\AuditLog;
use App\Events\ForumPostCreated;
use App\Models\ModeratorNotification;
use App\Events\ForumNotificationCreated;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        // Marcar como leídas las notificaciones del foro
        // únicamente para el moderador que está revisando las publicaciones.
        if ($user && strtoupper($user->role) === 'MODERATOR') {
            ModeratorNotification::where('moderator_uuid', $user->uuid)
                ->where('read', false)
                ->where('message', 'Nueva publicación en el foro.')
                ->update(['read' => true]);
        }

        $query = ForumMessage::with('user')
            ->orderBy('created_at', 'asc');

        $isModeratorOrAdmin = $user && in_array(
            strtoupper($user->role),
            ['ADMIN', 'MODERATOR'],
            true
        );

        if (!$isModeratorOrAdmin) {
            $query->where('visibility_status', 'VISIBLE');
        }

        $messages = $query->get();

        return view('forum.index', compact('messages'));
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

        $message = ForumMessage::create([

            /*
            |--------------------------------------------------------------------------
            | UUID DE LA PUBLICACIÓN
            |--------------------------------------------------------------------------
            */

            'uuid' => (string) Str::uuid(),

            /*
            |--------------------------------------------------------------------------
            | UUID REAL DEL USUARIO
            |--------------------------------------------------------------------------
            */

            'user_uuid' => $user->uuid,

            /*
            |--------------------------------------------------------------------------
            | CATEGORÍA
            |--------------------------------------------------------------------------
            */

            'category' => 'GENERAL',

            /*
            |--------------------------------------------------------------------------
            | CONTENIDO
            |--------------------------------------------------------------------------
            |
            | El modelo ForumMessage aplica el cifrado configurado
            | mediante su cast de Eloquent.
            |
            */

            'content' => $request->input('content'),

            /*
            |--------------------------------------------------------------------------
            | IDENTIDAD
            |--------------------------------------------------------------------------
            |
            | nickname = publicación anónima
            | name     = nombre real
            |
            */

            'is_anonymous' =>
                $request->input('identity_type') === 'nickname',

            /*
            |--------------------------------------------------------------------------
            | IA
            |--------------------------------------------------------------------------
            */

            'ai_flagged' => false,

            /*
            |--------------------------------------------------------------------------
            | VISIBILIDAD
            |--------------------------------------------------------------------------
            |
            | Toda publicación nueva comienza visible.
            |
            */

            'visibility_status' => 'VISIBLE'
        ]);

        /*
        |--------------------------------------------------------------------------
        | EVENTO EN TIEMPO REAL
        |--------------------------------------------------------------------------
        |
        | Se emite después de guardar la publicación para que los
        | clientes suscritos al canal privado del foro puedan recibirla.
        |
        */

        broadcast(
            new ForumPostCreated($message->load('user'))
        );

/*
|--------------------------------------------------------------------------
| NOTIFICACIONES EXCLUSIVAS DEL FORO
|--------------------------------------------------------------------------
| Se guarda una notificación individual para cada moderador.
| No se modifican las notificaciones de chat ni de casos.
*/

$moderators = \App\Models\User::query()
    ->whereRaw('UPPER(role) = ?', ['MODERATOR'])
    ->get(['uuid']);

foreach ($moderators as $moderator) {
    $notification = ModeratorNotification::create([
        'moderator_uuid' => $moderator->uuid,
        'conversation_id' => null,
        'evaluacion_uuid' => null,
        'attempt_uuid' => null,
        'message' => 'Nueva publicación en el foro.',
        'read' => false,
    ]);

    broadcast(
        new ForumNotificationCreated($notification)
    );
}

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

        $oldVisibility = $message->visibility_status;

        $message->visibility_status = 'HIDDEN';

        $message->save();

        AuditLog::create([
            'action' => 'restrict_forum_message',
            'performed_by' => $user->uuid,
            'target_type' => 'ForumMessage',
            'target_id' => $message->uuid,
            'changes' => [
                'visibility_status' => [
                    'before' => $oldVisibility,
                    'after' => $message->visibility_status,
                ],
            ],
        ]);

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

        $oldVisibility = $message->visibility_status;

        $message->visibility_status = 'VISIBLE';

        $message->save();

        AuditLog::create([
            'action' => 'restore_forum_message',
            'performed_by' => $user->uuid,
            'target_type' => 'ForumMessage',
            'target_id' => $message->uuid,
            'changes' => [
                'visibility_status' => [
                    'before' => $oldVisibility,
                    'after' => $message->visibility_status,
                ],
            ],
        ]);

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
