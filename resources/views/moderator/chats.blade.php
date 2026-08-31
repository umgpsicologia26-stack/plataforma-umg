<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Conversaciones | UMG Xela</title>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #0f172a;
        color: #e2e8f0;
        min-height: 100vh;
    }

    .container {
        width: 92%;
        max-width: 1100px;
        margin: 40px auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .title-section h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #f8fafc;
    }

    .title-section p {
        margin-top: 7px;
        color: #94a3b8;
        font-size: 14px;
    }

    .back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        background: #334155;
        color: white;
        padding: 11px 18px;
        border-radius: 10px;
        font-weight: 600;
        transition: .2s;
    }

    .back:hover {
        background: #475569;
    }

    .new-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #450a0a;
        border: 1px solid #991b1b;
        color: #fecaca;
        padding: 15px 18px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .new-alert i {
        color: #ef4444;
        font-size: 18px;
    }

    .new-alert strong {
        color: #fca5a5;
    }

    .card {
        position: relative;
        background: #1e293b;
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 18px;
        border: 1px solid #334155;
        transition: .25s;
    }

    .card:hover {
        transform: translateY(-3px);
        border-color: #475569;
        box-shadow: 0 15px 35px rgba(0,0,0,.25);
    }

    .card.new-message {
        border: 1px solid #dc2626;

        box-shadow:
            0 0 0 1px rgba(220,38,38,.15),
            0 12px 35px rgba(220,38,38,.12);
    }

    .new-message-badge {
        position: absolute;
        top: -10px;
        right: 18px;

        display: inline-flex;
        align-items: center;
        gap: 7px;

        background: #dc2626;
        color: white;

        padding: 6px 12px;
        border-radius: 20px;

        font-size: 11px;
        font-weight: 800;
        letter-spacing: .3px;

        box-shadow: 0 5px 15px rgba(220,38,38,.35);

        animation: pulse 1.8s infinite;
    }

    .new-message-badge i {
        font-size: 9px;
    }

    @keyframes pulse {

        0% {
            box-shadow: 0 0 0 0 rgba(220,38,38,.5);
        }

        70% {
            box-shadow: 0 0 0 8px rgba(220,38,38,0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(220,38,38,0);
        }

    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 18px;
    }

    .conversation-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .conversation-title i {
        color: #60a5fa;
    }

    .conversation-title strong {
        font-size: 17px;
        color: #f8fafc;
    }

    .status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-esperando {
        background: #78350f;
        color: #fef3c7;
    }

    .status-activo {
        background: #14532d;
        color: #dcfce7;
    }

    .status-cerrado {
        background: #334155;
        color: #cbd5e1;
    }

    .conversation-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 18px;
    }

    .info {
        background: #263449;
        padding: 13px;
        border-radius: 9px;
    }

    .label {
        display: block;
        color: #94a3b8;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .value {
        font-weight: 600;
        color: #f1f5f9;
        font-size: 14px;
    }

    .last-message {
        background: #172033;
        border-left: 3px solid #475569;
        padding: 13px 15px;
        border-radius: 8px;
        color: #cbd5e1;
        margin-bottom: 18px;
        font-size: 14px;
        line-height: 1.6;
    }

    .last-message.new {
        border-left-color: #ef4444;
        background: #291518;
    }

    .last-message strong {
        color: #94a3b8;
    }

    .last-message.new strong {
        color: #fca5a5;
    }

    .unread-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 22px;
        height: 22px;

        padding: 0 7px;
        margin-left: 7px;

        border-radius: 20px;

        background: #ef4444;
        color: white;

        font-size: 11px;
        font-weight: 800;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        text-decoration: none;

        background: #2563eb;
        color: white;

        padding: 11px 19px;
        border-radius: 9px;

        font-size: 14px;
        font-weight: 600;

        transition: .2s;
    }

    .button:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .button.new {
        background: #dc2626;
    }

    .button.new:hover {
        background: #b91c1c;
    }

    .empty {
        background: #1e293b;
        padding: 55px 30px;
        text-align: center;
        border-radius: 16px;
        border: 1px solid #334155;
        color: #94a3b8;
    }

    .empty-icon {
        width: 70px;
        height: 70px;

        margin: 0 auto 18px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #263449;
        color: #64748b;

        font-size: 28px;
    }

    .empty h3 {
        margin: 0 0 8px;
        color: #e2e8f0;
    }

    .empty p {
        margin: 0;
        font-size: 14px;
    }

    @media (max-width: 700px) {

        .container {
            width: 92%;
            margin-top: 25px;
        }

        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
        }

        .header .back {
            width: 100%;
            justify-content: center;
        }

        .conversation-info {
            grid-template-columns: 1fr;
        }

        .card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .status {
            align-self: flex-start;
        }

        .new-message-badge {
            position: static;
            display: inline-flex;
            margin-bottom: 12px;
        }

    }

</style>

</head>

<body>

<div class="container">

    {{-- HEADER --}}

<div class="header">

    <div class="title-section">

        <h1>

            <i class="fas fa-comments"></i>

            Conversaciones

        </h1>

        <p>

            Conversaciones de usuarios asignadas para atención.

        </p>

    </div>


    <a
        href="{{ route('moderator.dashboard') }}"
        class="back">

        <i class="fas fa-arrow-left"></i>

        Volver al panel

    </a>

</div>


    {{-- CALCULAR MENSAJES NUEVOS --}}

@php

    $totalNewMessages = 0;

    foreach ($conversations as $conversation) {

        $userMessages = $conversation->messages
            ->where('sender_type', 'USER');

        if ($conversation->moderator_last_read_at) {

            $userMessages = $userMessages->filter(
                function ($message) use ($conversation) {

                    return $message->created_at->gt(
                        $conversation->moderator_last_read_at
                    );

                }
            );

        }

        $totalNewMessages += $userMessages->count();

    }

@endphp

{{-- ALERTA GENERAL --}}

@if($totalNewMessages > 0)

    <div class="new-alert">

        <i class="fas fa-bell"></i>

        <div>

            <strong>
                Tienes mensajes nuevos.
            </strong>

            Hay

            <strong>
                {{ $totalNewMessages }}
            </strong>

            mensaje{{ $totalNewMessages != 1 ? 's' : '' }}

            pendiente{{ $totalNewMessages != 1 ? 's' : '' }}

            de revisar.

        </div>

    </div>

@endif


{{-- ============================================================
     CONVERSACIONES
     ============================================================ --}}

@if($conversations->count() > 0)


    @foreach($conversations as $conversation)


        @php

            /*
             * MENSAJES NUEVOS DE ESTA CONVERSACIÓN
             */

            $unreadMessages = $conversation->messages
                ->where('sender_type', 'USER');


            if ($conversation->moderator_last_read_at) {

                $unreadMessages = $unreadMessages->filter(
                    function ($message) use ($conversation) {

                        return $message->created_at->gt(
                            $conversation->moderator_last_read_at
                        );

                    }
                );

            }


            $unreadCount = $unreadMessages->count();


            /*
             * ÚLTIMO MENSAJE
             */

            $lastMessage = $conversation->messages
                ->sortBy('created_at')
                ->last();

        @endphp


        <div
            class="card {{ $unreadCount > 0 ? 'new-message' : '' }}"
        >


            {{-- BADGE MENSAJE NUEVO --}}

            @if($unreadCount > 0)

                <div class="new-message-badge">

                    <i class="fas fa-circle"></i>

                    MENSAJE NUEVO

                    <span>
                        {{ $unreadCount }}
                    </span>

                </div>

            @endif


            {{-- HEADER --}}

            <div class="card-header">

                <div class="conversation-title">

                    <i class="fas fa-user-circle"></i>

                    <strong>

                        Conversación #{{ $conversation->id }}

                    </strong>

                </div>


                @if($conversation->status === 'ESPERANDO')

                    <span class="status status-esperando">

                        <i class="fas fa-clock"></i>

                        ESPERANDO

                    </span>

                @elseif($conversation->status === 'ACTIVO')

                    <span class="status status-activo">

                        <i class="fas fa-circle-check"></i>

                        ACTIVO

                    </span>

                @else

                    <span class="status status-cerrado">

                        {{ $conversation->status }}

                    </span>

                @endif

            </div>


            {{-- INFORMACIÓN --}}

            <div class="conversation-info">


                <div class="info">

                    <span class="label">
                        Usuario
                    </span>

                    <span class="value">

                        @if($conversation->user)

                            {{ $conversation->user->anonymous_nickname
                                ?? $conversation->user->first_name
                                ?? 'Usuario' }}

                        @else

                            Usuario

                        @endif

                    </span>

                </div>


                <div class="info">

                    <span class="label">
                        Fecha de conversación
                    </span>

                    <span class="value">

                        {{ $conversation->created_at->format('d/m/Y H:i') }}

                    </span>

                </div>


                <div class="info">

                    <span class="label">
                        Mensajes
                    </span>

                    <span class="value">

                        {{ $conversation->messages->count() }}

                        @if($unreadCount > 0)

                            <span class="unread-count">

                                {{ $unreadCount }}

                            </span>

                        @endif

                    </span>

                </div>


            </div>


            {{-- ÚLTIMO MENSAJE --}}

            @if($lastMessage)

                <div
                    class="last-message {{ $unreadCount > 0 ? 'new' : '' }}"
                >

                    <strong>

                        @if($unreadCount > 0)

                            <i class="fas fa-bell"></i>

                            Nuevo mensaje:

                        @else

                            Último mensaje:

                        @endif

                    </strong>


                    {{ \Illuminate\Support\Str::limit(
                        $lastMessage->message,
                        180
                    ) }}

                </div>

            @endif


            {{-- BOTÓN --}}

            <a
                href="{{ route(
                    'moderator.chat',
                    $conversation->id
                ) }}"
                class="button {{ $unreadCount > 0 ? 'new' : '' }}"
            >

                @if($unreadCount > 0)

                    <i class="fas fa-envelope-open"></i>

                    Ver mensaje nuevo

                @else

                    <i class="fas fa-comments"></i>

                    Atender conversación

                @endif

                <i class="fas fa-arrow-right"></i>

            </a>


        </div>


    @endforeach


@else

    <div class="empty">

        <div class="empty-icon">

            <i class="fas fa-comments"></i>

        </div>

        <h3>
            No hay conversaciones asignadas
        </h3>

        <p>
            Actualmente no tienes conversaciones pendientes de atención.
        </p>

    </div>

@endif

</div>

</body>

</html>
