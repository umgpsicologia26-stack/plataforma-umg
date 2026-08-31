<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>UMG Xela - Orientación</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #111827
                );

            color: #e2e8f0;
        }

        .container {
            width: 92%;
            max-width: 1050px;

            margin: 30px auto;
        }

        /* =====================================================
           ENCABEZADO
        ===================================================== */

        .header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            margin-bottom: 18px;
        }

        .brand {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #2563eb;

            color: white;

            font-size: 20px;

            box-shadow:
                0 8px 20px
                rgba(37, 99, 235, .25);
        }

        h1 {
            margin: 0;

            font-size: 25px;
            font-weight: 700;

            color: #f8fafc;
        }

        .subtitle {
            margin-top: 4px;

            color: #94a3b8;

            font-size: 13px;
        }

        /* =====================================================
           CHAT
        ===================================================== */

        .chat {
            position: relative;

            background:
                rgba(30, 41, 59, .96);

            border:
                1px solid #334155;

            border-radius: 18px;

            padding: 28px;

            height: 560px;

            overflow-y: auto;

            box-shadow:
                0 20px 50px
                rgba(0, 0, 0, .25);
        }

        .chat::-webkit-scrollbar {
            width: 7px;
        }

        .chat::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat::-webkit-scrollbar-thumb {
            background: #475569;

            border-radius: 20px;
        }

        .chat::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* =====================================================
           MENSAJES
        ===================================================== */

        .message {
            display: flex;

            width: 100%;

            margin-bottom: 18px;
        }

        .message.user {
            justify-content: flex-start;
        }

        .message.bot,
        .message.moderator {
            justify-content: flex-end;
        }

        .message-wrapper {
            display: flex;

            flex-direction: column;

            width: fit-content;

            max-width: 72%;

            min-width: 0;
        }

        .message.user
        .message-wrapper {
            align-items: flex-start;
        }

        .message.bot
        .message-wrapper,

        .message.moderator
        .message-wrapper {
            align-items: flex-end;
        }

        /* =====================================================
           NOMBRE DEL REMITENTE
        ===================================================== */

        .sender {
            display: block;

            width: fit-content;

            margin-bottom: 5px;

            padding: 0 6px;

            color: #94a3b8;

            font-size: 11px;

            font-weight: 600;

            letter-spacing: .3px;
        }

        .message.moderator .sender {
            color: #60a5fa;
        }

        /* =====================================================
           BURBUJA
        ===================================================== */

        .bubble {
            display: block;

            width: fit-content;

            max-width: 100%;

            padding:
                11px 15px;

            border-radius: 16px;

            font-size: 14px;

            line-height: 1.55;

            white-space: pre-wrap;

            overflow-wrap: anywhere;

            word-break: break-word;

            box-shadow:
                0 3px 10px
                rgba(0, 0, 0, .12);

            animation:
                messageAppear
                .18s ease-out;
        }

        @keyframes messageAppear {

            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        /* USUARIO */

        .message.user .bubble {
            background: #334155;

            color: #f8fafc;

            border-bottom-left-radius: 5px;
        }

        /* BOT */

        .message.bot .bubble {
            background: #475569;

            color: #f8fafc;

            border-bottom-right-radius: 5px;
        }

        /* MODERADOR */

        .message.moderator .bubble {
            background: #2563eb;

            color: white;

            border-bottom-right-radius: 5px;

            box-shadow:
                0 5px 16px
                rgba(37, 99, 235, .20);
        }

        /* =====================================================
           HORA
        ===================================================== */

        .time {
            display: block;

            width: fit-content;

            margin-top: 4px;

            padding: 0 6px;

            color: #64748b;

            font-size: 10px;
        }

        /* =====================================================
           MENSAJE VACÍO
        ===================================================== */

        .empty {
            height: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            text-align: center;

            color: #94a3b8;

            font-size: 14px;
        }

        /* =====================================================
           ACTUALIZACIÓN
        ===================================================== */

        .status-area {
            text-align: center;

            margin:
                12px 0 18px;
        }

        .refresh-button {
            border:
                1px solid #475569;

            background: #1e293b;

            color: #cbd5e1;

            padding:
                9px 17px;

            border-radius: 9px;

            cursor: pointer;

            font-family: inherit;

            font-size: 12px;

            transition:
                .2s ease;
        }

        .refresh-button:hover {
            background: #334155;

            border-color: #64748b;

            transform: translateY(-1px);
        }

        .connection-status {
            margin-top: 7px;

            color: #64748b;

            font-size: 10px;
        }

        /* =====================================================
           RESPUESTA
        ===================================================== */

        .reply {
            background:
                rgba(30, 41, 59, .96);

            border:
                1px solid #334155;

            border-radius: 16px;

            padding: 18px;

            box-shadow:
                0 15px 35px
                rgba(0, 0, 0, .18);
        }

        .reply-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 12px;
        }

        .reply h3 {
            margin: 0;

            font-size: 15px;

            color: #f8fafc;
        }

        .reply-info {
            color: #64748b;

            font-size: 11px;
        }

        .message-form {
            display: flex;

            gap: 10px;

            align-items: flex-end;
        }

        textarea {
            display: block;

            width: 100%;

            min-height: 58px;

            max-height: 180px;

            resize: vertical;

            padding:
                12px 14px;

            border:
                1px solid #475569;

            border-radius: 10px;

            background: #0f172a;

            color: #f8fafc;

            font-family: inherit;

            font-size: 14px;

            line-height: 1.45;

            margin: 0;

            transition:
                border-color .2s,
                box-shadow .2s;
        }

        textarea:focus {
            outline: none;

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, .12);
        }

        textarea::placeholder {
            color: #64748b;
        }

        .button {
            flex-shrink: 0;

            border: none;

            background: #2563eb;

            color: white;

            padding:
                12px 22px;

            min-height: 44px;

            border-radius: 9px;

            cursor: pointer;

            font-size: 13px;

            font-weight: 600;

            transition:
                .2s ease;
        }

        .button:hover {
            background: #1d4ed8;

            transform: translateY(-1px);
        }

        .button:disabled {
            opacity: .6;

            cursor: not-allowed;

            transform: none;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 700px) {

            .container {
                width: 95%;

                margin:
                    18px auto;
            }

            .header {
                align-items: flex-start;
            }

            h1 {
                font-size: 21px;
            }

            .chat {
                height: 500px;

                padding:
                    18px 14px;
            }

            .message-wrapper {
                max-width: 86%;
            }

            .reply {
                padding: 14px;
            }

            .reply-header {
                align-items: flex-start;

                flex-direction: column;

                gap: 3px;
            }

            .message-form {
                flex-direction: column;

                align-items: stretch;
            }

            .button {
                width: 100%;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- =====================================================
         ENCABEZADO
    ====================================================== -->

    <div class="header">

        <div class="brand">

            <div class="brand-icon">
                💬
            </div>

            <div>

                <h1>
                    UMG Xela
                </h1>

                <div class="subtitle">
                    Espacio de orientación y apoyo
                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         CHAT
    ====================================================== -->

    <div
        class="chat"
        id="chat"
    >

        @if($conversation)

            @forelse($conversation->messages as $message)

                @php

                    $messageClass = match(
                        $message->sender_type
                    ) {

                        'USER' =>
                            'user',

                        'BOT' =>
                            'bot',

                        'MODERATOR' =>
                            'moderator',

                        default =>
                            'bot'

                    };

                @endphp


                <div
                    class="message {{ $messageClass }}"
                    data-message-id="{{ $message->id }}"
                >

                    <div class="message-wrapper">

                        <span class="sender">

                            @switch($message->sender_type)

                                @case('USER')

                                    Tú

                                    @break

                                @case('BOT')

                                    UMG Xela

                                    @break

                                @case('MODERATOR')

                                    Moderador

                                    @break

                                @default

                                    UMG Xela

                            @endswitch

                        </span>


                        <span class="bubble">

                            {{ $message->message }}

                        </span>


                        <span class="time">

                            {{ $message->created_at->format('H:i') }}

                        </span>

                    </div>

                </div>

            @empty

                <div
                    class="empty"
                    id="empty-message"
                >
                    No hay mensajes todavía.
                </div>

            @endforelse

        @else

            <div
                class="empty"
                id="empty-message"
            >
                Inicia una conversación para recibir orientación.
            </div>

        @endif

    </div>


    <!-- =====================================================
         ESTADO
    ====================================================== -->

    <div class="status-area">

        <button
            type="button"
            class="refresh-button"
            onclick="loadMessages(true)"
        >
            ↻ Actualizar conversación
        </button>

        <div
            id="connection-status"
            class="connection-status"
        >
            Conectado
        </div>

    </div>


    <!-- =====================================================
         FORMULARIO
    ====================================================== -->

    <div class="reply">

        <div class="reply-header">

            <h3>
                Escribe tu mensaje
            </h3>

            <span class="reply-info">
                Tus mensajes son privados
            </span>

        </div>


        <form
            action="{{ route('chat.message') }}"
            method="POST"
            class="message-form"
            id="message-form"
        >

            @csrf

            <textarea
                name="message"
                id="message-input"
                placeholder="Escribe tu mensaje..."
                required
                maxlength="2000"
            ></textarea>


            <button
                type="submit"
                class="button"
            >
                Enviar
            </button>

        </form>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| VARIABLES
|--------------------------------------------------------------------------
*/

let currentConversationId = null;

let isLoadingMessages = false;


/*
|--------------------------------------------------------------------------
| INICIAR
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const chat =
            document.getElementById('chat');

        if (chat) {

            chat.scrollTop =
                chat.scrollHeight;

        }

        /*
        |--------------------------------------------------------------
        | PRIMERA CONSULTA
        |--------------------------------------------------------------
        */

        loadMessages(true);


        /*
        |--------------------------------------------------------------
        | ACTUALIZACIÓN AUTOMÁTICA
        |--------------------------------------------------------------
        */

        setInterval(
            function () {

                loadMessages(false);

            },
            2000
        );

    }
);


/*
|--------------------------------------------------------------------------
| OBTENER MENSAJES
|--------------------------------------------------------------------------
*/

async function loadMessages(
    forceScroll = false
) {

    /*
    |----------------------------------------------------------------------
    | EVITAR CONSULTAS SIMULTÁNEAS
    |----------------------------------------------------------------------
    */

    if (isLoadingMessages) {

        return;

    }

    isLoadingMessages = true;


    try {

        const response =
            await fetch(
                "{{ route('chat.messages') }}",
                {

                    method: 'GET',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },

                    credentials:
                        'same-origin',

                    cache:
                        'no-store'

                }
            );


        /*
        |------------------------------------------------------------------
        | ERROR HTTP
        |------------------------------------------------------------------
        */

        if (!response.ok) {

            throw new Error(
                'Error HTTP ' +
                response.status
            );

        }


        const data =
            await response.json();


        /*
        |------------------------------------------------------------------
        | ERROR DEL SERVIDOR
        |------------------------------------------------------------------
        */

        if (!data.success) {

            throw new Error(
                data.message ||
                'No se pudieron obtener los mensajes.'
            );

        }


        /*
        |------------------------------------------------------------------
        | GUARDAR ID DE CONVERSACIÓN
        |------------------------------------------------------------------
        */

        currentConversationId =
            data.conversation_id;


        /*
        |------------------------------------------------------------------
        | RENDERIZAR TODOS LOS MENSAJES
        |------------------------------------------------------------------
        */

        renderMessages(
            data.messages || [],
            forceScroll
        );


        /*
        |------------------------------------------------------------------
        | ESTADO
        |------------------------------------------------------------------
        */

        const status =
            document.getElementById(
                'connection-status'
            );

        if (status) {

            status.textContent =
                'Conectado';

        }

    }
    catch (error) {

        console.error(
            'Error obteniendo mensajes:',
            error
        );


        const status =
            document.getElementById(
                'connection-status'
            );

        if (status) {

            status.textContent =
                'Esperando conexión...';

        }

    }
    finally {

        isLoadingMessages = false;

    }

}


/*
|--------------------------------------------------------------------------
| RENDERIZAR MENSAJES
|--------------------------------------------------------------------------
|
| IMPORTANTE:
|
| No solamente agregamos los mensajes nuevos.
|
| Cada consulta reconstruye el chat utilizando lo que realmente devuelve
| el servidor desde chat_messages.
|
| Esto garantiza que los mensajes del MODERADOR aparezcan para el usuario.
|
|--------------------------------------------------------------------------
*/

function renderMessages(
    messages,
    forceScroll = false
) {

    const chat =
        document.getElementById('chat');


    if (!chat) {

        return;

    }


    /*
    |----------------------------------------------------------------------
    | SABER SI EL USUARIO ESTABA ABAJO
    |----------------------------------------------------------------------
    */

    const wasAtBottom =
        chat.scrollHeight -
        chat.scrollTop -
        chat.clientHeight <
        100;


    /*
    |----------------------------------------------------------------------
    | LIMPIAR CHAT
    |----------------------------------------------------------------------
    */

    chat.innerHTML = '';


    /*
    |----------------------------------------------------------------------
    | SIN MENSAJES
    |----------------------------------------------------------------------
    */

    if (!messages.length) {

        const empty =
            document.createElement('div');

        empty.className =
            'empty';

        empty.id =
            'empty-message';

        empty.textContent =
            'No hay mensajes todavía.';

        chat.appendChild(empty);

        return;

    }


    /*
    |----------------------------------------------------------------------
    | CREAR MENSAJES
    |----------------------------------------------------------------------
    */

    messages.forEach(
        function (message) {

            let messageClass =
                'bot';

            let senderName =
                'UMG Xela';


            /*
            |--------------------------------------------------------------
            | USUARIO
            |--------------------------------------------------------------
            */

            if (
                message.sender_type ===
                'USER'
            ) {

                messageClass =
                    'user';

                senderName =
                    'Tú';

            }


            /*
            |--------------------------------------------------------------
            | MODERADOR
            |--------------------------------------------------------------
            */

            else if (
                message.sender_type ===
                'MODERATOR'
            ) {

                messageClass =
                    'moderator';

                senderName =
                    'Moderador';

            }


            /*
            |--------------------------------------------------------------
            | CONTENEDOR DEL MENSAJE
            |--------------------------------------------------------------
            */

            const messageElement =
                document.createElement(
                    'div'
                );

            messageElement.className =
                'message ' +
                messageClass;

            messageElement.setAttribute(
                'data-message-id',
                message.id
            );


            /*
            |--------------------------------------------------------------
            | WRAPPER
            |--------------------------------------------------------------
            */

            const wrapper =
                document.createElement(
                    'div'
                );

            wrapper.className =
                'message-wrapper';


            /*
            |--------------------------------------------------------------
            | REMITENTE
            |--------------------------------------------------------------
            */

            const sender =
                document.createElement(
                    'span'
                );

            sender.className =
                'sender';

            sender.textContent =
                senderName;


            /*
            |--------------------------------------------------------------
            | BURBUJA
            |--------------------------------------------------------------
            */

            const bubble =
                document.createElement(
                    'span'
                );

            bubble.className =
                'bubble';

            /*
            | IMPORTANTE:
            |
            | textContent evita interpretar HTML enviado por usuarios.
            */

            bubble.textContent =
                message.message;


            /*
            |--------------------------------------------------------------
            | HORA
            |--------------------------------------------------------------
            */

            const time =
                document.createElement(
                    'span'
                );

            time.className =
                'time';

            time.textContent =
                message.time || '';


            /*
            |--------------------------------------------------------------
            | ARMAR MENSAJE
            |--------------------------------------------------------------
            */

            wrapper.appendChild(
                sender
            );

            wrapper.appendChild(
                bubble
            );

            wrapper.appendChild(
                time
            );

            messageElement.appendChild(
                wrapper
            );

            chat.appendChild(
                messageElement
            );

        }
    );


    /*
    |----------------------------------------------------------------------
    | BAJAR AL ÚLTIMO MENSAJE
    |----------------------------------------------------------------------
    */

    if (
        wasAtBottom ||
        forceScroll
    ) {

        requestAnimationFrame(
            function () {

                chat.scrollTop =
                    chat.scrollHeight;

            }
        );

    }

}


/*
|--------------------------------------------------------------------------
| ENVIAR MENSAJE
|--------------------------------------------------------------------------
*/

const messageForm =
    document.getElementById(
        'message-form'
    );


if (messageForm) {

    messageForm.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();


            const form =
                this;

            const input =
                document.getElementById(
                    'message-input'
                );

            const button =
                form.querySelector(
                    'button[type="submit"]'
                );


            const message =
                input.value.trim();


            /*
            |------------------------------------------------------------------
            | VALIDAR
            |------------------------------------------------------------------
            */

            if (!message) {

                return;

            }


            /*
            |------------------------------------------------------------------
            | DESHABILITAR BOTÓN
            |------------------------------------------------------------------
            */

            button.disabled =
                true;

            button.textContent =
                'Enviando...';


            try {

                const formData =
                    new FormData(form);


                /*
                |--------------------------------------------------------------
                | ENVIAR AL CONTROLLER
                |--------------------------------------------------------------
                */

                const response =
                    await fetch(
                        form.action,
                        {

                            method:
                                'POST',

                            body:
                                formData,

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-Requested-With':
                                    'XMLHttpRequest'

                            },

                            credentials:
                                'same-origin'

                        }
                    );


                /*
                |--------------------------------------------------------------
                | ERROR HTTP
                |--------------------------------------------------------------
                */

                if (!response.ok) {

                    throw new Error(
                        'Error HTTP ' +
                        response.status
                    );

                }


                const data =
                    await response.json();


                /*
                |--------------------------------------------------------------
                | ERROR DEL CONTROLLER
                |--------------------------------------------------------------
                */

                if (!data.success) {

                    throw new Error(
                        data.message ||
                        'No se pudo enviar el mensaje.'
                    );

                }


                /*
                |--------------------------------------------------------------
                | LIMPIAR
                |--------------------------------------------------------------
                */

                input.value =
                    '';


                /*
                |--------------------------------------------------------------
                | RECARGAR DESDE BD
                |--------------------------------------------------------------
                |
                | Aquí está una de las partes importantes:
                |
                | Después de enviar el mensaje del usuario volvemos a pedir
                | todos los mensajes al servidor.
                |
                | Si el moderador ya escribió, también aparecerá.
                |
                */

                await loadMessages(
                    true
                );

            }
            catch (error) {

                console.error(
                    'Error enviando mensaje:',
                    error
                );

                alert(
                    'No se pudo enviar el mensaje. Intenta nuevamente.'
                );

            }
            finally {

                button.disabled =
                    false;

                button.textContent =
                    'Enviar';

            }

        }
    );

}

</script>

</body>

</html>