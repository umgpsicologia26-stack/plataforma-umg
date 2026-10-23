<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * MOSTRAR CHAT DEL USUARIO
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | BUSCAR LA CONVERSACIÓN DEL USUARIO
        |--------------------------------------------------------------------------
        */

        $conversation = ChatConversation::where(
            'user_uuid',
            $user->uuid
        )
        ->whereIn('status', [
            'ESPERANDO',
            'ACTIVO'
        ])
        ->with([
            'messages' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'moderator'
        ])
        ->latest('updated_at')
        ->first();

        /*
        |--------------------------------------------------------------------------
        | SI NO HAY CONVERSACIÓN ACTIVA
        |--------------------------------------------------------------------------
        */

        if (!$conversation) {

            $conversation = ChatConversation::where(
                'user_uuid',
                $user->uuid
            )
            ->with([
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc');
                },
                'moderator'
            ])
            ->latest('created_at')
            ->first();
        }

        return view(
            'chat.index',
            compact('conversation')
        );
    }


    /**
     * OBTENER MENSAJES ACTUALIZADOS
     */
    public function messages()
    {
        if (!Auth::check()) {

            return response()->json([
                'success' => false,
                'message' => 'No autenticado.'
            ], 401);
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | BUSCAR CONVERSACIÓN ACTIVA
        |--------------------------------------------------------------------------
        */

        $conversation = ChatConversation::where(
            'user_uuid',
            $user->uuid
        )
        ->whereIn('status', [
            'ESPERANDO',
            'ACTIVO'
        ])
        ->latest('updated_at')
        ->first();

        /*
        |--------------------------------------------------------------------------
        | SI NO EXISTE UNA CONVERSACIÓN ACTIVA
        |--------------------------------------------------------------------------
        */

        if (!$conversation) {

            $conversation = ChatConversation::where(
                'user_uuid',
                $user->uuid
            )
            ->latest('created_at')
            ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | SI NO EXISTE NINGUNA CONVERSACIÓN
        |--------------------------------------------------------------------------
        */

        if (!$conversation) {

            return response()->json([
                'success' => true,
                'conversation_id' => null,
                'messages' => []
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER MENSAJES
        |--------------------------------------------------------------------------
        */

        $messages = ChatMessage::where(
            'conversation_id',
            $conversation->id
        )
        ->orderBy(
            'created_at',
            'asc'
        )
        ->get();

        /*
        |--------------------------------------------------------------------------
        | RESPUESTA JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'conversation_id' =>
                $conversation->id,

            'conversation_status' =>
                $conversation->status,

            'moderator_uuid' =>
                $conversation->moderator_uuid,

            'messages' =>
                $messages->map(function ($message) {

                    return [

                        'id' =>
                            $message->id,

                        'sender_type' =>
                            $message->sender_type,

                        'sender_uuid' =>
                            $message->sender_uuid,

                        'message' =>
                            $message->message,

                        'time' =>
                            $message->created_at
                                ? $message->created_at->format('H:i')
                                : '',

                    ];

                })->values(),

        ]);
    }


    /**
     * ENVIAR MENSAJE DEL USUARIO
     */
    public function sendMessage(Request $request)
    {
        if (!Auth::check()) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Debes iniciar sesión para utilizar el chat.'
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDAR
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'message' => [
                'required',
                'string',
                'min:1',
                'max:2000'
            ]
        ]);

        $user = Auth::user();

        $messageText = trim(
            $request->message
        );

        /*
        |--------------------------------------------------------------------------
        | BUSCAR CONVERSACIÓN ACTIVA
        |--------------------------------------------------------------------------
        */

        $conversation = ChatConversation::where(
            'user_uuid',
            $user->uuid
        )
        ->whereIn('status', [
            'ESPERANDO',
            'ACTIVO'
        ])
        ->latest('updated_at')
        ->first();

        /*
        |--------------------------------------------------------------------------
        | SI NO EXISTE, CREAR
        |--------------------------------------------------------------------------
        */

        if (!$conversation) {

            $conversation = ChatConversation::create([
                'user_uuid' =>
                    $user->uuid,

                'moderator_uuid' =>
                    null,

                'status' =>
                    'ESPERANDO',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | GUARDAR MENSAJE DEL USUARIO
        |--------------------------------------------------------------------------
        */

        $userMessage = ChatMessage::create([

            'conversation_id' =>
                $conversation->id,

            'sender_uuid' =>
                $user->uuid,

            'sender_type' =>
                'USER',

            'message' =>
                $messageText,

        ]);

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR CONVERSACIÓN
        |--------------------------------------------------------------------------
        |
        | Esto es importante porque permite que el usuario y el moderador
        | trabajen siempre sobre la conversación más reciente.
        |
        */

        $conversation->touch();

        /*
        |--------------------------------------------------------------------------
        | DETECTAR SOLICITUD DE ATENCIÓN HUMANA
        |--------------------------------------------------------------------------
        */

        $humanAttentionWords = [

            'hablar con alguien',
            'hablar con una persona',
            'quiero hablar con alguien',
            'quiero hablar con una persona',
            'necesito hablar con alguien',
            'necesito hablar con una persona',
            'puedo hablar con alguien',
            'puedo hablar con una persona',

            'quiero un moderador',
            'necesito un moderador',
            'hablar con moderador',
            'hablar con un moderador',

            'ayuda de una persona',
            'ayuda humana',
            'persona real',
            'atencion humana',
            'atención humana'
        ];

        $requestHuman = false;

        $lowerMessage = mb_strtolower(
            $messageText
        );

        foreach ($humanAttentionWords as $word) {

            if (
                str_contains(
                    $lowerMessage,
                    mb_strtolower($word)
                )
            ) {

                $requestHuman = true;

                break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ASIGNAR MODERADOR
        |--------------------------------------------------------------------------
        */

        if (!$conversation->moderator_uuid) {

            $conversation =
                $this->assignModerator(
                    $conversation
                );
        }

        /*
        |--------------------------------------------------------------------------
        | ¿EL MODERADOR YA TOMÓ LA CONVERSACIÓN?
        |--------------------------------------------------------------------------
        |
        | Cuando el moderador envía su primer mensaje, la conversación
        | pasa a estado ACTIVO (ver ModeratorController@sendChatMessage).
        |
        | A partir de ese momento, el bot ya NO debe responder:
        | la atención queda 100% a cargo del moderador humano,
        | hasta que él cierre la conversación (CERRADO).
        |
        */

        $moderatorHandling =
            $conversation->status === 'ACTIVO';

        $botMessage = null;

        if (!$moderatorHandling) {

            /*
            |--------------------------------------------------------------------------
            | RESPUESTA DEL BOT
            |--------------------------------------------------------------------------
            */

            if ($requestHuman) {

                if (!empty(
                    $conversation->moderator_uuid
                )) {

                    $botText =
                        "Claro. He registrado tu solicitud para hablar con una persona. "
                        . "Un moderador podrá revisar la conversación y brindarte orientación. "
                        . "Por favor, permanece en este chat.";

                } else {

                    $botText =
                        "He registrado tu solicitud para hablar con una persona. "
                        . "En este momento no hay un moderador disponible, "
                        . "pero tu conversación ha quedado en espera de atención.";
                }

            } else {

                $botText =
                    $this->generateBotResponse(
                        $messageText
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | GUARDAR RESPUESTA DEL BOT
            |--------------------------------------------------------------------------
            */

            $botMessage = ChatMessage::create([

                'conversation_id' =>
                    $conversation->id,

                'sender_uuid' =>
                    null,

                'sender_type' =>
                    'BOT',

                'message' =>
                    $botText,

            ]);

            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR CONVERSACIÓN
            |--------------------------------------------------------------------------
            */

            $conversation->touch();
        }

        /*
        |--------------------------------------------------------------------------
        | RECARGAR
        |--------------------------------------------------------------------------
        */

        $conversation->refresh();

        /*
        |--------------------------------------------------------------------------
        | RESPUESTA
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Mensaje enviado correctamente.',

            'conversation_id' =>
                $conversation->id,

            'user_message' => [

                'id' =>
                    $userMessage->id,

                'sender_type' =>
                    'USER',

                'message' =>
                    $userMessage->message,

                'time' =>
                    $userMessage
                        ->created_at
                        ->format('H:i'),

            ],

            'bot_message' =>
                $botMessage
                    ? [

                        'id' =>
                            $botMessage->id,

                        'sender_type' =>
                            'BOT',

                        'message' =>
                            $botMessage->message,

                        'time' =>
                            $botMessage
                                ->created_at
                                ->format('H:i'),

                    ]
                    : null,

            'moderator_assigned' =>
                !empty(
                    $conversation->moderator_uuid
                ),

            'moderator_handling' =>
                $moderatorHandling,

        ]);
    }


    
/**
 * ASIGNAR MODERADOR EQUITATIVAMENTE
 */
private function assignModerator(
    ChatConversation $conversation
) {
    // No cambiar el moderador de una conversación ya asignada.
    if (!empty($conversation->moderator_uuid)) {
        return $conversation;
    }


    // Obtener moderadores activos, independientemente
    // de si el estado está guardado en mayúsculas o minúsculas.
    $moderators = User::where('role', 'MODERATOR')
        ->whereRaw('UPPER(status) = ?', ['ACTIVO'])
        ->get();


    // Si no hay moderadores disponibles, dejar la conversación esperando.
    if ($moderators->isEmpty()) {
        $conversation->update([
            'moderator_uuid' => null,
            'status' => 'ESPERANDO',
        ]);

        return $conversation->fresh();
    }

    // Contar las conversaciones asignadas a cada moderador
    // durante el mes y año actuales.
    $startOfMonth = now()->startOfMonth();
    $startOfNextMonth = now()->addMonth()->startOfMonth();

    $monthlyCounts = \App\Models\ChatConversation::query()
        ->selectRaw('moderator_uuid, COUNT(*) as total')
        ->whereIn(
            'moderator_uuid',
            $moderators->pluck('uuid')
        )
        ->where('created_at', '>=', $startOfMonth)
        ->where('created_at', '<', $startOfNextMonth)
        ->groupBy('moderator_uuid')
        ->pluck('total', 'moderator_uuid');

    // Contar también las conversaciones históricas para desempatar.
    $totalCounts = \App\Models\ChatConversation::query()
        ->selectRaw('moderator_uuid, COUNT(*) as total')
        ->whereIn(
            'moderator_uuid',
            $moderators->pluck('uuid')
        )
        ->groupBy('moderator_uuid')
        ->pluck('total', 'moderator_uuid');

    // Elegir primero al que tenga menos conversaciones este mes.
    // En caso de empate, elegir al que tenga menos en total.
    $moderator = $moderators->sort(function ($a, $b) use (
        $monthlyCounts,
        $totalCounts
    ) {
        $monthlyA = (int) ($monthlyCounts[$a->uuid] ?? 0);
        $monthlyB = (int) ($monthlyCounts[$b->uuid] ?? 0);

        if ($monthlyA !== $monthlyB) {
            return $monthlyA <=> $monthlyB;
        }

        $totalA = (int) ($totalCounts[$a->uuid] ?? 0);
        $totalB = (int) ($totalCounts[$b->uuid] ?? 0);

        if ($totalA !== $totalB) {
            return $totalA <=> $totalB;
        }

        return strcmp($a->uuid, $b->uuid);
    })->first();

    // Asignar la conversación al moderador seleccionado.
    $conversation->update([
        'moderator_uuid' => $moderator->uuid,
        'status' => 'ESPERANDO',
    ]);

    return $conversation->fresh();
}

    /**
     * RESPUESTA DEL BOT
     */
    private function generateBotResponse(
        string $message
    ): string {

        $text = mb_strtolower(
            trim($message)
        );

        /*
        |--------------------------------------------------------------------------
        | SALUDOS
        |--------------------------------------------------------------------------
        */

        $greetings = [
            'hola',
            'buenas',
            'buenos dias',
            'buenos días',
            'buenas tardes',
            'buenas noches',
            'hey',
            'hola umg'
        ];

        foreach ($greetings as $greeting) {

            if (
                str_contains(
                    $text,
                    $greeting
                )
            ) {

                return
                    "Hola 👋 Soy UMG. "
                    . "Estoy aquí para escucharte y orientarte. "
                    . "Puedes contarme qué estás sintiendo o qué situación estás atravesando.";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ABUSO SEXUAL
        |--------------------------------------------------------------------------
        */

        $abuseWords = [
            'abuso sexual',
            'abusaron de mi',
            'abusaron de mí',
            'abuso',
            'acoso sexual',
            'violacion',
            'violación',
            'me tocaron',
            'me obligaron'
        ];

        foreach ($abuseWords as $word) {

            if (
                str_contains(
                    $text,
                    $word
                )
            ) {

                return
                    "Lamento que estés pasando por una situación así. "
                    . "Lo que ocurre no es tu culpa y tienes derecho a recibir ayuda. "
                    . "Si estás en peligro inmediato, busca un lugar seguro y contacta a los servicios de emergencia. "
                    . "También puedes solicitar hablar con un moderador desde este chat.";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SUICIDIO / RIESGO
        |--------------------------------------------------------------------------
        */

        $suicideWords = [
            'suicidio',
            'suicidarme',
            'matarme',
            'quitarme la vida',
            'no quiero vivir',
            'quiero morir',
            'me quiero morir',
            'hacerme daño',
            'hacerme danio'
        ];

        foreach ($suicideWords as $word) {

            if (
                str_contains(
                    $text,
                    $word
                )
            ) {

                return
                    "Siento que estés pasando por un momento tan difícil. "
                    . "Tu seguridad es importante. "
                    . "Si existe un riesgo inmediato de hacerte daño, busca a una persona de confianza, "
                    . "dirígete a un lugar seguro y contacta a los servicios de emergencia de tu localidad. "
                    . "También puedes escribir \"quiero hablar con alguien\" para solicitar atención de un moderador.";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EMOCIONES
        |--------------------------------------------------------------------------
        */

        $emotionalWords = [
            'triste',
            'tristeza',
            'ansiedad',
            'ansioso',
            'ansiosa',
            'deprimido',
            'deprimida',
            'solo',
            'sola',
            'llorar',
            'estresado',
            'estresada',
            'preocupado',
            'preocupada',
            'mal emocionalmente'
        ];

        foreach ($emotionalWords as $word) {

            if (
                str_contains(
                    $text,
                    $word
                )
            ) {

                return
                    "Gracias por compartir cómo te sientes. "
                    . "No tienes que enfrentar todo esto en silencio. "
                    . "Si quieres, puedes contarme un poco más sobre lo que está ocurriendo. "
                    . "También puedes solicitar hablar con una persona si necesitas apoyo humano.";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPUESTA GENERAL
        |--------------------------------------------------------------------------
        */

        return
            "Gracias por confiar en UMG. "
            . "Estoy aquí para escucharte. "
            . "Puedes contarme qué está sucediendo o cómo te estás sintiendo. "
            . "Si necesitas atención de una persona, puedes escribir "
            . "\"quiero hablar con alguien\".";
    }
}