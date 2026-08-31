<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Conversación | Moderador
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }

        .container {
            width: 95%;
            max-width: 1000px;
            margin: 30px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 25px;
        }

        .back {
            text-decoration: none;
            background: #334155;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .back:hover {
            background: #475569;
        }

        .chat-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 14px;
            overflow: hidden;
        }

        .chat-header {
            padding: 18px 20px;
            background: #263449;
            border-bottom: 1px solid #334155;
        }

        .user-name {
            font-size: 18px;
            font-weight: bold;
        }

        .user-info {
            margin-top: 5px;
            color: #94a3b8;
            font-size: 14px;
        }

        .messages {
            padding: 25px;
            min-height: 450px;
            max-height: 600px;
            overflow-y: auto;
        }

        .message-row {
            display: flex;
            margin-bottom: 15px;
        }

        .message-row.user {
            justify-content: flex-start;
        }

        .message-row.moderator {
            justify-content: flex-end;
        }

        .message-row.bot {
            justify-content: flex-start;
        }

        .message {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 16px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .message.user {
            background: #334155;
            color: #f8fafc;
            border-bottom-left-radius: 5px;
        }

        .message.moderator {
            background: #2563eb;
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message.bot {
            background: #475569;
            color: #f8fafc;
            border-bottom-left-radius: 5px;
        }

        .sender {
            display: block;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            opacity: .8;
        }

        .time {
            display: block;
            margin-top: 6px;
            font-size: 10px;
            opacity: .7;
            text-align: right;
        }

        .empty-messages {
            text-align: center;
            color: #94a3b8;
            padding: 100px 20px;
        }

        .message-form {
            padding: 18px;
            background: #263449;
            border-top: 1px solid #334155;
        }

        .form-wrapper {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        textarea {
            flex: 1;
            min-height: 50px;
            max-height: 140px;
            resize: vertical;
            padding: 13px 15px;
            border: 1px solid #475569;
            border-radius: 12px;
            background: #0f172a;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 15px;
            outline: none;
        }

        textarea:focus {
            border-color: #2563eb;
        }

        .send {
            border: none;
            background: #2563eb;
            color: white;
            padding: 13px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .send:hover {
            background: #1d4ed8;
        }

        .success {
            background: #14532d;
            color: #dcfce7;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        @media (max-width: 700px) {

            .container {
                width: 96%;
                margin: 15px auto;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .messages {
                min-height: 400px;
            }

            .message {
                max-width: 88%;
            }

            .form-wrapper {
                flex-direction: column;
            }

            textarea {
                width: 100%;
            }

            .send {
                width: 100%;
            }
        }

    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <h1>
            Conversación #{{ $conversation->id }}
        </h1>

        <a
            href="{{ route('moderator.chats') }}"
            class="back">
            ← Volver a conversaciones
        </a>

    </div>

    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="chat-card">

        {{-- INFORMACIÓN DEL USUARIO --}}

        <div class="chat-header">

            <div class="user-name">

                @if($conversation->user)

                    {{ $conversation->user->anonymous_nickname
                        ?? $conversation->user->first_name
                        ?? 'Usuario' }}

                @else

                    Usuario

                @endif

            </div>

            <div class="user-info">

                Estado:
                <strong>
                    {{ $conversation->status }}
                </strong>

                &nbsp; • &nbsp;

                Conversación iniciada:

                {{ $conversation->created_at
                    ? $conversation->created_at->format('d/m/Y H:i')
                    : '' }}

            </div>

        </div>

        {{-- MENSAJES --}}

        <div
            class="messages"
            id="messages">

            @forelse(
                $conversation->messages
                as $message
            )

                @php

                    $type = strtoupper(
                        $message->sender_type
                    );

                    if ($type === 'MODERATOR') {
                        $class = 'moderator';
                        $sender = 'Tú';
                    }

                    elseif ($type === 'BOT') {
                        $class = 'bot';
                        $sender = 'UMG Cerca';
                    }

                    else {
                        $class = 'user';
                        $sender = 'Usuario';
                    }

                @endphp


                <div
                    class="message-row {{ $class }}">

                    <div
                        class="message {{ $class }}">

                        <span class="sender">
                            {{ $sender }}
                        </span>

                        {{ $message->message }}

                        <span class="time">

                            {{ $message->created_at
                                ? $message->created_at->format('H:i')
                                : '' }}

                        </span>

                    </div>

                </div>

            @empty

                <div class="empty-messages">

                    No hay mensajes en esta conversación.

                </div>

            @endforelse

        </div>


        {{-- FORMULARIO DEL MODERADOR --}}

        <div class="message-form">

            <form
                action="{{ route(
                    'moderator.chat.message',
                    $conversation->id
                ) }}"
                method="POST">

                @csrf

                <div class="form-wrapper">

                    <textarea
                        name="message"
                        placeholder="Escribe tu respuesta..."
                        required
                        maxlength="2000"
                    ></textarea>

                    <button
                        type="submit"
                        class="send">
                        Enviar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

    const messages =
        document.getElementById('messages');

    if (messages) {

        messages.scrollTop =
            messages.scrollHeight;

    }

</script>

</body>

</html>
