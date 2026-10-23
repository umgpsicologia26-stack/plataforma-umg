<!DOCTYPE html>
<html lang="es">

<head>

            @vite('resources/js/echo.js')

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Foro Anónimo</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            font-family:'Poppins', sans-serif;

            background:
                linear-gradient(
                    rgba(8,15,35,0.94),
                    rgba(8,15,35,0.96)
                ),
                url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop');

            background-size:cover;
            background-position:center;

            min-height:100vh;

            color:white;

            padding:clamp(12px, 3vw, 40px);
        }


        .container{

            max-width:1200px;

            margin:auto;
        }


        .glass-card{

            background:rgba(255,255,255,0.08);

            backdrop-filter:blur(18px);

            border:1px solid rgba(255,255,255,0.08);

            border-radius:28px;

            padding:clamp(18px, 3.5vw, 40px);

            box-shadow:
                0 20px 50px rgba(0,0,0,0.35);
        }


        /* ==============================
           TITULO
        ============================== */

        .title-row{

            display:flex;

            align-items:center;

            gap:15px;

            margin-bottom:12px;
        }


        .back-arrow{

            text-decoration:none;

            color:#7dd3fc;

            font-size:34px;

            font-weight:bold;

            transition:0.3s;
        }


        .back-arrow:hover{

            color:#38bdf8;

            transform:translateX(-5px);
        }


        .title{

            font-size:clamp(30px, 4vw, 48px);

            font-weight:700;

            margin:0;
        }


        .subtitle{

            color:#cbd5e1;

            margin-bottom:40px;

            font-size:17px;

            line-height:1.7;

            max-width:800px;
        }


        /* ==============================
           FORMULARIO
        ============================== */

        .forum-form{

            display:flex;

            flex-direction:column;

            gap:20px;

            margin-bottom:50px;
        }


        .forum-form textarea{

            width:100%;

            border:none;

            outline:none;

            border-radius:18px;

            background:rgba(255,255,255,0.07);

            color:white;

            padding:18px;

            font-size:15px;

            border:1px solid rgba(255,255,255,0.08);

            font-family:'Poppins',sans-serif;
        }


        .forum-form textarea{

            min-height:140px;

            resize:none;
        }


        .forum-form textarea::placeholder{

            color:#94a3b8;
        }


        .publish-btn{

            width:220px;

            border:none;

            background:#7dd3fc;

            color:#081323;

            padding:16px;

            border-radius:18px;

            font-size:16px;

            font-weight:700;

            cursor:pointer;

            transition:0.3s;

            font-family:'Poppins',sans-serif;
        }


        .publish-btn:hover{

            background:#38bdf8;

            transform:translateY(-4px);
        }


        /* ==============================
           IDENTIDAD
        ============================== */

        .identity-box{

            background:rgba(255,255,255,0.06);

            border:1px solid rgba(255,255,255,0.08);

            border-radius:18px;

            padding:20px;
        }


        .identity-title{

            font-size:16px;

            font-weight:600;

            margin-bottom:15px;

            color:#f8fafc;
        }


        .identity-options{

            display:flex;

            gap:15px;

            flex-wrap:wrap;
        }


        .identity-option{

            display:flex;

            align-items:center;

            gap:10px;

            padding:12px 16px;

            border-radius:14px;

            background:rgba(255,255,255,0.05);

            cursor:pointer;

            transition:0.3s;
        }


        .identity-option:hover{

            background:rgba(125,211,252,0.12);
        }


        .identity-option input{

            accent-color:#7dd3fc;
        }


        .identity-box small{

            display:block;

            margin-top:12px;

            color:#94a3b8;

            line-height:1.5;
        }


        /* ==============================
           MENSAJES
           Lista compacta: ancho máximo cómodo para leer y centrada.
           Cada caja crece solo según su contenido (sin alturas fijas).
        ============================== */

        .messages{

            display:flex;

            flex-direction:column;

            gap:14px;

            width:100%;

            max-width:920px;

            margin-inline:auto;

            min-width:0;
        }


        .message-card{

            width:100%;

            min-width:0;

            background:rgba(255,255,255,0.06);

            border:1px solid rgba(255,255,255,0.08);

            padding:clamp(14px, 2.2vw, 20px) clamp(16px, 2.6vw, 24px);

            border-radius:20px;

            transition:0.3s;
        }


        .message-card:hover{

            transform:translateY(-2px);

            background:rgba(125,211,252,0.08);
        }


        .message-header{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:10px;

            flex-wrap:wrap;

            gap:8px 10px;
        }


        .anonymous{

            color:#7dd3fc;

            font-weight:700;

            font-size:15px;

            min-width:0;

            overflow-wrap:anywhere;

            text-align:left;
        }


        .category{

            background:rgba(125,211,252,0.15);

            color:#7dd3fc;

            padding:6px 12px;

            border-radius:12px;

            font-size:12px;

            font-weight:600;

            text-align:left;
        }


        /* Solo el cuerpo del mensaje se justifica, en todos los anchos.
           pre-wrap respeta los saltos de línea que escribe el usuario;
           por eso el contenido va pegado a las etiquetas en el HTML. */

        .message-content{

            color:#f1f5f9;

            line-height:1.65;

            font-size:15px;

            white-space:pre-wrap;

            text-align:justify;

            hyphens:auto;

            -webkit-hyphens:auto;

            overflow-wrap:anywhere;

            word-break:normal;

            min-width:0;
        }


        .message-date{

            margin-top:10px;

            color:#64748b;

            font-size:12px;

            text-align:left;
        }


        /* ==============================
           MENSAJE OCULTO
        ============================== */

        .message-hidden{

            border:1px solid rgba(248,113,113,0.35);

            background:rgba(127,29,29,0.15);
        }


        .hidden-warning{

            margin-bottom:10px;

            padding:10px 14px;

            border-radius:12px;

            background:rgba(248,113,113,0.12);

            color:#fca5a5;

            font-size:13px;

            font-weight:600;

            text-align:left;
        }


        /* ==============================
           MODERACION
        ============================== */

        .moderation-actions{

            margin-top:12px;

            display:flex;

            justify-content:flex-end;

            flex-wrap:wrap;

            gap:10px;
        }


        .restrict-btn{

            border:none;

            background:rgba(248,113,113,0.15);

            color:#fca5a5;

            padding:8px 14px;

            border-radius:12px;

            cursor:pointer;

            font-family:'Poppins',sans-serif;

            font-size:13px;

            font-weight:600;

            transition:.3s;
        }


        .restrict-btn:hover{

            background:rgba(248,113,113,0.30);

            transform:translateY(-2px);
        }


        .restore-btn{

            border:none;

            background:rgba(74,222,128,0.15);

            color:#86efac;

            padding:8px 14px;

            border-radius:12px;

            cursor:pointer;

            font-family:'Poppins',sans-serif;

            font-size:13px;

            font-weight:600;

            transition:.3s;
        }


        .restore-btn:hover{

            background:rgba(74,222,128,0.25);

            transform:translateY(-2px);
        }


        /* ==============================
           MENSAJE VACIO
        ============================== */

        .empty{

            text-align:center;

            color:#cbd5e1;

            margin-top:30px;

            font-size:16px;
        }


        /* ==============================
           MENSAJES DE SESION
        ============================== */

        .alert-success{

            background:rgba(74,222,128,0.15);

            border:1px solid rgba(74,222,128,0.3);

            color:#86efac;

            padding:15px 20px;

            border-radius:14px;

            margin-bottom:25px;

            font-size:14px;

            font-weight:600;
        }


        /* ==============================
           RESPONSIVE
           (padding de body, glass-card y tarjetas ya son fluidos con clamp)
        ============================== */

        @media(max-width:768px){

            .subtitle{

                font-size:15px;

                margin-bottom:28px;
            }


            .forum-form{

                margin-bottom:34px;
            }


            .publish-btn{

                width:100%;
            }


            .moderation-actions{

                justify-content:stretch;
            }


            .moderation-actions form{

                width:100%;
            }


            .restrict-btn,
            .restore-btn{

                width:100%;
            }

        }


        @media(max-width:360px){

            .message-content{

                font-size:14px;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <div class="glass-card">

<div style="
    background:#1e293b;
    color:#fff;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
">

    Rol actual:
    {{ auth()->user()->role ?? 'SIN USUARIO' }}

</div>

    {{-- ==============================
        ENCABEZADO
        ============================== --}}

        <div class="title-row">

            <a
                href="{{ url('/dashboard') }}"
                class="back-arrow"
            >
                ←
            </a>

            <h1 class="title">
                Foro Anónimo
            </h1>

        </div>


        <p class="subtitle">

            Comparte tus pensamientos, emociones y experiencias
            en un entorno seguro, confidencial y libre de juicios.
            Tu identidad permanece protegida.

        </p>


        {{-- ==============================
             MENSAJE DE ÉXITO
        ============================== --}}

        @if(session('success'))

            <div class="alert-success">

                {{ session('success') }}

            </div>

        @endif


        {{-- ==============================
             FORMULARIO DE PUBLICACION
        ============================== --}}

        <form
            action="{{ url('/forum/create') }}"
            method="POST"
            class="forum-form"
        >

            @csrf


            <div class="identity-box">


                <div class="identity-title">

                    ¿Cómo deseas aparecer en el foro?

                </div>


                <div class="identity-options">


                    <label class="identity-option">

                        <input
                            type="radio"
                            name="identity_type"
                            value="name"
                            checked
                        >

                        <span>
                            Usar mi nombre
                        </span>

                    </label>


                    <label class="identity-option">

                        <input
                            type="radio"
                            name="identity_type"
                            value="nickname"
                        >

                        <span>
                            Usar mi nickname
                        </span>

                    </label>


                </div>


                <small>

                    Puedes elegir cómo deseas aparecer públicamente
                    en el foro. Tu cuenta seguirá vinculada internamente
                    a tu identidad real.

                </small>


            </div>


            <textarea
                name="content"
                placeholder="Escribe aquí lo que deseas compartir..."
                required
            ></textarea>


            <button
                type="submit"
                class="publish-btn"
            >

                Publicar Mensaje

            </button>


        </form>


        {{-- PUBLICACIONES --}}

        <div class="messages" id="forum-messages">


            @forelse($messages as $message)


                <div
                    class="message-card
                    @if($message->visibility_status === 'HIDDEN')
                        message-hidden
                    @endif"
                >


                    {{-- ENCABEZADO DEL MENSAJE --}}

                    <div class="message-header">


                        <div class="anonymous">


                            @if($message->is_anonymous)

                                {{ $message->user->anonymous_nickname ?? 'Usuario Anónimo' }}

                            @else

                                {{ $message->user->full_name ?? 'Usuario' }}

                            @endif


                        </div>


                        <div class="category">

                            {{ $message->category }}

                        </div>


                    </div>


                {{-- MENSAJE OCULTO --}}

@if($message->visibility_status === 'HIDDEN')

    <div class="hidden-warning">

        ⚠️ Este mensaje fue ocultado por moderación.

    </div>

@else

    {{-- CONTENIDO DEL MENSAJE VISIBLE
         (sin espacios ni saltos dentro del div: .message-content usa pre-wrap) --}}

    <div class="message-content">{{ $message->content }}</div>

@endif


                    {{-- CONTROLES DE MODERACION --}}

                    @if(
                        auth()->check() &&
                        in_array(
                            auth()->user()->role,
                            ['ADMIN', 'MODERATOR']
                        )
                    )


                        <div class="moderation-actions">


                            {{-- MENSAJE VISIBLE --}}

                            @if($message->visibility_status === 'VISIBLE')


                                <form
                                    action="{{ route('forum.restrict', $message->uuid) }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="restrict-btn"
                                        onclick="return confirm('¿Deseas ocultar este mensaje?')"
                                    >

                                        🚫 Ocultar mensaje

                                    </button>


                                </form>


                            {{-- MENSAJE OCULTO --}}

                            @else


                                <form
                                    action="{{ route('forum.restore', $message->uuid) }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="restore-btn"
                                        onclick="return confirm('¿Deseas restaurar este mensaje?')"
                                    >

                                        ↩ Restaurar mensaje

                                    </button>


                                </form>


                            @endif


                        </div>


                    @endif


                    {{-- FECHA --}}

                    <div class="message-date">

                        Publicado:
                        {{ $message->created_at->format('d/m/Y H:i') }}

                    </div>


                </div>


            @empty


                <div class="empty">

                    Aún no hay publicaciones en el foro.

                </div>


            @endforelse


        </div>


    </div>


</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.Echo) {
        console.error('Laravel Echo no está inicializado.');
        return;
    }

    const container = document.getElementById('forum-messages');

    if (!container) {
        console.error('No se encontró el contenedor de publicaciones.');
        return;
    }

    const canModerate = @json(
        auth()->check() &&
        in_array(auth()->user()->role, ['ADMIN', 'MODERATOR'])
    );

    window.Echo.private('forum')
        .listen('.forum.post.created', function (event) {
            if (!event || !event.uuid) {
                return;
            }

            // Evitar publicaciones duplicadas.
            if (container.querySelector(
                '[data-message-uuid="' + event.uuid + '"]'
            )) {
                return;
            }

            // Los usuarios normales solo reciben publicaciones visibles.
            if (
                !canModerate &&
                event.visibility_status !== 'VISIBLE'
            ) {
                return;
            }

            const emptyMessage = container.querySelector('.empty');

            if (emptyMessage) {
                emptyMessage.remove();
            }

            const card = document.createElement('div');
            card.className = 'message-card';
            card.dataset.messageUuid = event.uuid;

            const header = document.createElement('div');
            header.className = 'message-header';

            const identity = document.createElement('div');
            identity.className = 'anonymous';
            identity.textContent = event.display_name || 'Usuario';

            const category = document.createElement('div');
            category.className = 'category';
            category.textContent = event.category || 'GENERAL';

            header.appendChild(identity);
            header.appendChild(category);

            const content = document.createElement('div');
            content.className = 'message-content';
            content.textContent = event.content || '';

            const date = document.createElement('div');
            date.className = 'message-date';
            date.textContent = 'Publicado: ' + (event.created_at || '');

            card.appendChild(header);
            card.appendChild(content);
            card.appendChild(date);

            // El foro muestra primero las publicaciones más antiguas.
            container.appendChild(card);
        });

    // NOTIFICACIONES EXCLUSIVAS DEL FORO PARA MODERADORES
    const isModerator = @json(
        auth()->check() &&
        strtoupper(auth()->user()->role) === 'MODERATOR'
    );

    const moderatorUuid = @json(auth()->user()->uuid ?? '');

    if (isModerator && moderatorUuid) {
        window.Echo.private('moderator.' + moderatorUuid)
            .listen('.forum.notification.created', function (event) {
                if (!event || !event.message) {
                    return;
                }

                // Crear aviso visual sin modificar las notificaciones existentes.
                const toast = document.createElement('div');

                toast.style.cssText = [
                    'position:fixed',
                    'top:20px',
                    'right:20px',
                    'z-index:99999',
                    'max-width:360px',
                    'padding:16px 20px',
                    'background:#ffffff',
                    'color:#222222',
                    'border-left:5px solid #2563eb',
                    'border-radius:10px',
                    'box-shadow:0 5px 20px rgba(0,0,0,.20)',
                    'font-size:14px',
                    'line-height:1.5'
                ].join(';');

                const title = document.createElement('strong');
                title.textContent = 'Nueva notificación del foro';

                const message = document.createElement('div');
                message.textContent = event.message;
                message.style.marginTop = '6px';

                const date = document.createElement('small');
                date.textContent = event.created_at || '';
                date.style.display = 'block';
                date.style.marginTop = '6px';
                date.style.color = '#666666';

                toast.appendChild(title);
                toast.appendChild(message);
                toast.appendChild(date);

                document.body.appendChild(toast);

                window.setTimeout(function () {
                    toast.remove();
                }, 7000);
            });
    }
});
</script>

</body>

</html>