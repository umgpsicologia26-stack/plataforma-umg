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

    /*
    |--------------------------------------------------------------------------
    | GRUPO POR USUARIO
    |--------------------------------------------------------------------------
    */

    .user-group {
        background: #182235;
        border: 1px solid #334155;
        border-radius: 16px;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .user-group[open] {
        border-color: #475569;
    }

    .user-group.has-unread {
        border-color: #dc2626;
        box-shadow:
            0 0 0 1px rgba(220,38,38,.12),
            0 12px 35px rgba(220,38,38,.10);
    }

    .user-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;

        padding: 20px 22px;
        cursor: pointer;
        list-style: none;

        transition: background .2s;
    }

    .user-summary:hover {
        background: #1e293b;
    }

    .user-summary::-webkit-details-marker {
        display: none;
    }

    .user-summary-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;

        border-radius: 50%;
        background: #263449;
        color: #60a5fa;

        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .user-group.has-unread .user-avatar {
        background: #3f1d1d;
        color: #f87171;
    }

    .user-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .user-name {
        font-size: 16px;
        font-weight: 700;
        color: #f8fafc;
    }

    .user-sub {
        font-size: 12.5px;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-summary-right {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .user-unread-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        background: #dc2626;
        color: white;

        padding: 6px 12px;
        border-radius: 20px;

        font-size: 12px;
        font-weight: 800;

        animation: pulse 1.8s infinite;
    }

    .conv-count-badge {
        background: #263449;
        color: #cbd5e1;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .chevron {
        color: #64748b;
        transition: transform .2s;
    }

    .user-group[open] .chevron {
        transform: rotate(180deg);
    }

    .user-conversations {
        padding: 4px 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 16px;
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

    /*
    |--------------------------------------------------------------------------
    | TARJETA DE CONVERSACIÓN (dentro del grupo)
    |--------------------------------------------------------------------------
    */

    .card {
        position: relative;
        background: #1e293b;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #334155;
        transition: .25s;
    }

    .card:hover {
        border-color: #475569;
    }

    .card.new-message {
        border: 1px solid #dc2626;

        box-shadow:
            0 0 0 1px rgba(220,38,38,.15),
            0 10px 25px rgba(220,38,38,.12);
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

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 16px;
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
        font-size: 16px;
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
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .info {
        background: #263449;
        padding: 12px;
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
        margin-bottom: 16px;
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

        padding: 10px 18px;
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

        .user-summary {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .user-summary-right {
            width: 100%;
            justify-content: space-between;
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


    {{-- CALCULAR MENSAJES NUEVOS (TOTAL GENERAL) --}}

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
     CONVERSACIONES AGRUPADAS POR USUARIO
     ============================================================ --}}

@if($conversations->count() > 0)

    @php

        /*
         * AGRUPAR CONVERSACIONES POR USUARIO
         * (si por alguna razón no tiene user_uuid, se agrupa
         * individualmente para no perder ninguna conversación)
         */

        $groupedConversations = $conversations->groupBy(
            function ($conversation) {

                return $conversation->user_uuid
                    ?? 'sin-usuario-' . $conversation->id;

            }
        );

    @endphp


    @foreach($groupedConversations as $userKey => $userConversations)

        @php

            $firstConversation = $userConversations->first();
            $userObj = $firstConversation->user;

            $userName = $userObj
                ? ($userObj->anonymous_nickname
                    ?? $userObj->first_name
                    ?? 'Usuario')
                : 'Usuario';

            /*
             * TOTALES DEL GRUPO
             */

            $groupUnreadTotal = 0;
            $groupLastActivity = null;

            foreach ($userConversations as $conversation) {

                $unread = $conversation->messages
                    ->where('sender_type', 'USER');

                if ($conversation->moderator_last_read_at) {

                    $unread = $unread->filter(
                        function ($message) use ($conversation) {

                            return $message->created_at->gt(
                                $conversation->moderator_last_read_at
                            );

                        }
                    );

                }

                $groupUnreadTotal += $unread->count();

                if (
                    !$groupLastActivity ||
                    $conversation->updated_at->gt($groupLastActivity)
                ) {
                    $groupLastActivity = $conversation->updated_at;
                }

            }

            $conversationsCount = $userConversations->count();

        @endphp


        <details
            class="user-group {{ $groupUnreadTotal > 0 ? 'has-unread' : '' }}"
            {{ $groupUnreadTotal > 0 ? 'open' : '' }}
        >

            <summary class="user-summary">

                <div class="user-summary-left">

                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="user-meta">

                        <span class="user-name">
                            {{ $userName }}
                        </span>

                        <span class="user-sub">

                            {{ $conversationsCount }}

                            conversación{{ $conversationsCount != 1 ? 'es' : '' }}

                            @if($groupLastActivity)

                                &nbsp;•&nbsp;

                                Última actividad:

                                {{ $groupLastActivity->format('d/m/Y H:i') }}

                            @endif

                        </span>

                    </div>

                </div>


                <div class="user-summary-right">

                    <span class="conv-count-badge">
                        {{ $conversationsCount }}
                    </span>

                    @if($groupUnreadTotal > 0)

                        <span class="user-unread-badge">

                            <i class="fas fa-bell"></i>

                            {{ $groupUnreadTotal }}

                            nuevo{{ $groupUnreadTotal != 1 ? 's' : '' }}

                        </span>

                    @endif

                    <i class="fas fa-chevron-down chevron"></i>

                </div>

            </summary>


            <div class="user-conversations">

                @foreach($userConversations->sortByDesc('updated_at') as $conversation)

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

            </div>

        </details>

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