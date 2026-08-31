<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Plataforma de Apoyo - UMG Xela</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            overflow-x: hidden;
        }

        /* NAVBAR */

        .navbar {
            width: 95%;
            max-width: 1400px;
            margin: 20px auto;
            padding: 18px 35px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
            position: relative;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand h2 {
            font-size: 26px;
            font-weight: 800;
            color: #2563eb;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-center a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #f1f5f9;
            border-radius: 14px;
            text-decoration: none;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
            transition: .3s ease;
        }

        .nav-center a:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-btn {
            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            color: white;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        /* HERO */

        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg,
                    #4f46e5 0%,
                    #7c3aed 50%,
                    #d946ef 100%);
            border-radius: 0 0 80px 80px;
            padding: 80px 60px 180px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .hero-content {
            max-width: 650px;
            z-index: 2;
        }

        .hero-content h1 {
            color: white;
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
        }

        .hero-content p {
            font-size: 1.2rem;
            line-height: 1.8;
            opacity: .95;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 15px 30px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            transition: .3s;
        }

        .hero-btn-primary {
            background: white;
            color: #4f46e5;
        }

        .hero-btn-secondary {
            border: 2px solid rgba(255, 255, 255, .5);
            color: white;
        }

        .hero-image {
            max-width: 500px;
        }

        .hero-image img {
            width: 100%;
        }

        .wave {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
        }

        .wave svg {
            display: block;
            width: 100%;
            height: 180px;
        }

        /* INFORMACIÓN */

        .info-section {
            margin-top: -90px;
            position: relative;
            z-index: 3;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 0 40px 40px;
        }

        .info-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .1);
        }

        .info-card h3 {
            color: #111827;
            margin-bottom: 15px;
        }

        .info-card p {
            color: #4b5563;
            line-height: 1.7;
        }

        .info-card i {
            font-size: 40px;
            color: #7c3aed;
            margin-bottom: 20px;
        }

        /* EMERGENCIA */

        .emergency-bar {
            margin: 30px 40px;
            background: white;
            border-radius: 25px;
            padding: 25px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .emergency-title {
            color: #111827;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .emergency-info {
            color: #4b5563;
        }

        /* SERVICIOS */

        .services-section {
            padding: 50px 40px;
        }

        .services-title {
            text-align: center;
            font-size: 2rem;
            color: #111827;
            margin-bottom: 40px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
            transition: .3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #111827;
        }

        .feature-text {
            color: #4b5563;
            line-height: 1.7;
        }

        /* BOTÓN FLOTANTE */

        .chat-floating-button {
            position: fixed;
            right: 25px;
            bottom: 25px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .25);
            cursor: pointer;
            padding: 7px;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s ease;
        }

        .chat-floating-button:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 25px rgba(0, 0, 0, .30);
        }

        .chat-floating-button img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        /* CHAT FLOTANTE */

        .floating-chat {
            position: fixed;
            right: 25px;
            bottom: 110px;
            width: 380px;
            height: 520px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 18px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .30);
            z-index: 99998;
            display: none;
            flex-direction: column;
            overflow: hidden;
        }

        .floating-chat.active {
            display: flex;
        }

        /* HEADER CHAT */

        .floating-chat-header {
            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            color: white;
            padding: 15px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chat-header-logo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: white;
            padding: 4px;
            object-fit: contain;
        }

        .chat-header-title {
            display: flex;
            flex-direction: column;
        }

        .chat-header-title strong {
            font-size: 15px;
        }

        .chat-header-title span {
            font-size: 11px;
            opacity: .85;
        }

        .chat-close {
            border: none;
            background: transparent;
            color: white;
            font-size: 20px;
            cursor: pointer;
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .chat-close:hover {
            background: rgba(255, 255, 255, .15);
        }

        /* MENSAJES */

        .floating-chat-messages {
            flex: 1;
            padding: 18px;
            overflow-y: auto;
            background: #1e293b;
            min-height: 0;
        }

        .floating-message {
            display: flex;
            width: 100%;
            margin-bottom: 16px;
        }

        .floating-message.user {
            justify-content: flex-start;
        }

        .floating-message.bot,
        .floating-message.moderator {
            justify-content: flex-end;
        }

        .floating-message-wrapper {
            display: flex;
            flex-direction: column;
            width: fit-content;
            max-width: 75%;
            min-width: 0;
        }

        .floating-message.user .floating-message-wrapper {
            align-items: flex-start;
        }

        .floating-message.bot .floating-message-wrapper,
        .floating-message.moderator .floating-message-wrapper {
            align-items: flex-end;
        }

        .floating-sender {
            display: block;
            width: fit-content;
            margin-bottom: 4px;
            padding: 0 5px;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 600;
        }

        .floating-bubble {
            display: block;
            width: fit-content;
            max-width: 100%;
            padding: 9px 13px;
            border-radius: 14px;
            font-size: 13px;
            line-height: 1.45;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
            word-break: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .12);
        }

        .floating-message.user .floating-bubble {
            background: #334155;
            color: #f8fafc;
            border-bottom-left-radius: 5px;
        }

        .floating-message.bot .floating-bubble {
            background: #475569;
            color: #f8fafc;
            border-bottom-right-radius: 5px;
        }

        .floating-message.moderator .floating-bubble {
            background: #2563eb;
            color: white;
            border-bottom-right-radius: 5px;
        }

        .floating-time {
            display: block;
            width: fit-content;
            margin-top: 3px;
            padding: 0 5px;
            color: #64748b;
            font-size: 9px;
        }

        /* BIENVENIDA */

        .chat-welcome {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px 20px;
            color: #cbd5e1;
        }

        .chat-welcome-logo {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            padding: 7px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .20);
        }

        .chat-welcome-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .chat-welcome strong {
            color: white;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .chat-welcome p {
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.7;
            margin: 0;
        }

        /* FORMULARIO CHAT */

        .floating-chat-form {
            padding: 10px;
            background: #172033;
            border-top: 1px solid #334155;
            display: flex;
            gap: 8px;
            align-items: flex-end;
            flex-shrink: 0;
        }

        .floating-chat-form textarea {
            flex: 1;
            min-height: 42px;
            max-height: 100px;
            resize: none;
            border: 1px solid #475569;
            border-radius: 14px;
            background: #0f172a;
            color: white;
            padding: 10px 13px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            outline: none;
        }

        .floating-chat-form textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, .15);
        }

        .floating-chat-form textarea::placeholder {
            color: #64748b;
        }

        .floating-send {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border: none;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: .2s ease;
        }

        .floating-send:hover {
            background: #1d4ed8;
            transform: scale(1.05);
        }

        .floating-send:disabled {
            opacity: .6;
            cursor: wait;
            transform: none;
        }

        /* SCROLL */

        .floating-chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .floating-chat-messages::-webkit-scrollbar-track {
            background: #0f172a;
        }

        .floating-chat-messages::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        /* RESPONSIVE */

        @media(max-width: 1100px) {

            .nav-center {
                gap: 10px;
            }

            .nav-center a {
                padding: 10px 12px;
                font-size: 12px;
            }

            .navbar {
                padding: 15px 20px;
            }

        }

        @media(max-width: 900px) {

            .navbar {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }

            .nav-center {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .nav-right {
                width: 100%;
                justify-content: center;
            }

            .hero-section {
                flex-direction: column;
                text-align: center;
                padding: 60px 25px 180px;
            }

            .hero-content h1 {
                font-size: 2.8rem;
            }

            .hero-image {
                margin-top: 40px;
            }

            .hero-image img {
                width: 250px;
            }

        }

        @media(max-width: 600px) {

            .navbar {
                width: 94%;
            }

            .nav-center {
                width: 100%;
            }

            .nav-center a {
                flex: 1;
                justify-content: center;
                min-width: 130px;
            }

            .nav-right {
                flex-direction: column;
            }

            .admin-btn,
            .logout-btn {
                width: 100%;
                justify-content: center;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .info-section {
                padding-left: 20px;
                padding-right: 20px;
            }

            .services-section {
                padding-left: 20px;
                padding-right: 20px;
            }

            .emergency-bar {
                margin-left: 20px;
                margin-right: 20px;
            }

            .floating-chat {
                right: 10px;
                left: 10px;
                bottom: 95px;
                width: auto;
                height: 70vh;
                max-height: 520px;
            }

            .chat-floating-button {
                right: 18px;
                bottom: 18px;
                width: 62px;
                height: 62px;
            }

            .floating-message-wrapper {
                max-width: 82%;
            }

        }
    </style>

</head>

<body>

    {{-- BOTÓN FLOTANTE --}}

    <button type="button" class="chat-floating-button" id="chatFloatingButton" aria-label="Abrir UMG Xela">


        <img src="{{ asset('images/umg.png') }}" alt="UMG Xela">


    </button>

    {{-- CHAT FLOTANTE --}}

    <div class="floating-chat" id="floatingChat">

        {{-- HEADER --}}

        <div class="floating-chat-header">

            <div class="chat-header-info">

                <img src="{{ asset('images/umg.png') }}" alt="UMG Xela" class="chat-header-logo">

                <div class="chat-header-title">

                    <strong>
                        UMG Xela
                    </strong>

                    <span>
                        Orientación y apoyo
                    </span>

                </div>

            </div>


            <button type="button" class="chat-close" id="chatClose" aria-label="Cerrar chat">
                ×
            </button>

        </div>


        {{-- MENSAJES --}}

        <div class="floating-chat-messages" id="floatingChatMessages">

            <div class="chat-welcome" id="chatWelcome">

                <div class="chat-welcome-logo">

                    <img src="{{ asset('images/umg.png') }}" alt="UMG Xela">

                </div>

                <strong>
                    Hola 👋
                </strong>

                <p>
                    Soy UMG Xela.
                    <br>
                    Estoy aquí para escucharte y orientarte.
                </p>

            </div>

        </div>


        {{-- FORMULARIO --}}

        <form id="floatingChatForm" action="{{ route('chat.message') }}" method="POST" class="floating-chat-form"
            autocomplete="off">

            @csrf

            <textarea id="floatingChatTextarea" name="message" placeholder="Escribe tu mensaje..." required
                maxlength="2000" rows="1"></textarea>

            <button type="submit" class="floating-send" id="floatingSend" aria-label="Enviar mensaje">

                <i class="fas fa-paper-plane"></i>

            </button>

        </form>

    </div>

    {{-- NAVBAR --}}

    <nav class="navbar">
        <div class="nav-left">

            <div class="brand">

                <h2>
                    UMG
                </h2>

            </div>

        </div>

        <div class="nav-center">

            <a href="/forum">
                <i class="fas fa-comments"></i>
                Foro Anónimo
            </a>

            <a href="/evaluation">
                <i class="fas fa-brain"></i>
                Evaluación
            </a>

            <a href="/panic-button">
                <i class="fas fa-triangle-exclamation"></i>
                Botón de Pánico
            </a>

            <a href="/cases">
                <i class="fas fa-folder-open"></i>
                Seguimiento de Casos
            </a>

        </div>

        <div class="nav-right">

            @if(auth()->check() && auth()->user()->role === 'ADMIN')

                <a href="{{ url('/admin-access') }}" class="admin-btn">

                    <i class="fas fa-shield-halved"></i>

                    Admin

                </a>

            @endif

            @auth

                <form method="POST" action="{{ url('/logout') }}" style="margin:0;">

                    @csrf

                    <button type="submit" class="logout-btn">

                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar sesión
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    {{--HERO--}}

    <section class="hero-section">
        <div class="hero-content">
            <h1>
                Tu bienestar es nuestra prioridad
            </h1>
            <p>
                Plataforma segura y anónima para reportar casos
                de abuso sexual, riesgo suicida y situaciones que
                afecten la integridad física y emocional.
                <br><br>
                Denunciar y solicitar ayuda es completamente gratuito.
            </p>

            <div class="hero-buttons">
                <a href="/panic-button" class="hero-btn hero-btn-primary">
                    Reportar Caso
                </a>

                <a href="/panic-button" class="hero-btn hero-btn-secondary">
                    Pedir Ayuda
                </a>
            </div>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo UMG Xela">
        </div>

        <div class="wave">
            <svg viewBox="0 0 1440 320">
                <path fill="#f8fafc"
                    d="M0,256L60,266.7C120,277,240,299,360,293.3C480,288,600,256,720,229.3C840,203,960,181,1080,192C1200,203,1320,245,1380,266.7L1440,288L1440,320L0,320Z">
                </path>

            </svg>

        </div>

    </section>

    {{-- INFORMACIÓN --}}

    <section class="info-section">

        <div class="info-card">

            <i class="fas fa-heartbeat"></i>

            <h3>
                ¿Qué es el suicidio?
            </h3>

            <p>
                El suicidio es el acto de quitarse la vida.
                Es un problema que puede prevenirse mediante
                apoyo emocional, acompañamiento profesional
                y atención oportuna.
            </p>

        </div>

        <div class="info-card">

            <i class="fas fa-hand-paper"></i>

            <h3>
                ¿Qué es el abuso sexual?
            </h3>

            <p>
                Es cualquier conducta sexual realizada sin consentimiento.
                Puede provocar daños físicos y emocionales severos y debe
                ser atendida para proteger a las víctimas.
            </p>

        </div>

        <div class="info-card">

            <i class="fas fa-shield-heart"></i>

            <h3>
                Denunciar es GRATIS
            </h3>

            <p>
                Todos los servicios de esta plataforma son completamente
                gratuitos. Puedes denunciar, solicitar ayuda y recibir
                apoyo sin ningún costo.

            </p>

        </div>

    </section>

    {{-- SERVICIOS --}}

    <section class="services-section">

        <h2 class="services-title">
            Herramientas de Apoyo
        </h2>


        <div class="grid">

            <div class="feature-card">

                <div class="feature-icon">
                    💬
                </div>

                <div class="feature-title">
                    Foro Seguro
                </div>

                <div class="feature-text">
                    Comparte pensamientos y emociones de manera anónima
                    en un entorno protegido.

                </div>

            </div>

            <div class="feature-card">

                <div class="feature-icon">
                    🧠
                </div>

                <div class="feature-title">
                    Salud Emocional
                </div>

                <div class="feature-text">
                    Accede a evaluaciones emocionales y recomendaciones
                    inteligentes.

                </div>

            </div>

            <div class="feature-card">

                <div class="feature-icon">
                    🚨
                </div>

                <div class="feature-title">
                    Ayuda Inmediata
                </div>

                <div class="feature-text">
                    Utiliza el botón de pánico para solicitar apoyo
                    rápidamente en situaciones críticas.

                </div>

            </div>

            <div class="feature-card">

                <div class="feature-icon">
                    🔒
                </div>

                <div class="feature-title">
                    Privacidad Total
                </div>

                <div class="feature-text">
                    Tu información se mantiene protegida mediante
                    sistemas de seguridad y anonimato.

                </div>

            </div>

        </div>

    </section>

    {{-- EMERGENCIA --}}

    <div class="emergency-bar">

        <div>

            <div class="emergency-title">
                ¿Necesitas ayuda inmediata?
            </div>

            <div class="emergency-info">
                Buscar apoyo es un acto de valentía. No estás solo.
            </div>

        </div>

        <div>

            <strong>
                Servicio gratuito y confidencial
            </strong>

        </div>
    </div>

    {{--JAVASCRIPT CHAT --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const button = document.getElementById('chatFloatingButton');
            const chat = document.getElementById('floatingChat');
            const closeButton = document.getElementById('chatClose');
            const form = document.getElementById('floatingChatForm');
            const textarea = document.getElementById('floatingChatTextarea');
            const sendButton = document.getElementById('floatingSend');
            const messages = document.getElementById('floatingChatMessages');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            // VERIFICAR ELEMENTOS

            if (
                !button ||
                !chat ||
                !closeButton ||
                !form ||
                !textarea ||
                !sendButton ||
                !messages
            ) {
                console.error('UMG Xela: faltan elementos del chat.');
                return;
            }

            // CARGAR HISTORIAL Y ACTIVAR ACTUALIZACIÓN AUTOMÁTICA
            // Esto permite que los mensajes del MODERADOR
            // aparezcan aquí sin recargar la página.

            loadFloatingMessages(true);

            setInterval(function () {
                loadFloatingMessages(false);
            }, 3000);


            //ABRIR CHAT

            button.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                chat.classList.toggle('activo');

                if (chat.classList.contains('activo')) {

                    scrollMessages();

                    setTimeout(function () {
                        textarea.focus();
                    }, 100);

                }

            });

            //CERRAR CHAT

            closeButton.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                chat.classList.remove('activo');

            });


            //NO CERRAR AL HACER CLICK DENTRO

            chat.addEventListener('click', function (event) {

                event.stopPropagation();

            });


            //CERRAR AL HACER CLICK AFUERA

            document.addEventListener('click', function (event) {

                if (!chat.classList.contains('activo')) {
                    return;
                }

                if (
                    !chat.contains(event.target) &&
                    !button.contains(event.target)
                ) {

                    chat.classList.remove('activo');

                }

            });

            //ENVIAR MENSAJE

            form.addEventListener('submit', async function (event) {

                event.preventDefault();
                event.stopPropagation();

                const message = textarea.value.trim();

                if (!message) {
                    textarea.focus();
                    return;
                }


                //MOSTRAR CHAT

                chat.classList.add('activo');


                //DESACTIVAR BOTÓN

                sendButton.disabled = true;

                //QUITAR BIENVENIDA

                const welcome = document.getElementById('chatWelcome');

                if (welcome) {
                    welcome.remove();
                }


                //MOSTRAR MENSAJE DEL USUARIO

                const localUserElement = addMessage(
                    'user',
                    'Tú',
                    message,
                    getCurrentTime()
                );

                //LIMPIAR INPUT

                textarea.value = '';
                textarea.style.height = '42px';

                scrollMessages();


                // ENVIAR A LARAVEL MEDIANTE FETCH

                try {

                    const response = await fetch(
                        form.getAttribute('action'),
                        {
                            method: 'POST',

                            credentials: 'same-origin',

                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            body: JSON.stringify({
                                message: message
                            })
                        }
                    );

                    //OBTENER RESPUESTA

                    const contentType =
                        response.headers.get('content-type') || '';

                    if (!contentType.includes('application/json')) {

                        throw new Error(
                            'El servidor no devolvió JSON. Código HTTP: ' +
                            response.status
                        );

                    }

                    const data = await response.json();

                    //VERIFICAR RESPUESTA

                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'No fue posible enviar el mensaje.'
                        );

                    }


                    // MARCAR EL MENSAJE DEL USUARIO CON SU ID REAL
                    // (evita que se duplique cuando llegue el polling)

                    if (
                        data.user_message &&
                        data.user_message.id &&
                        localUserElement
                    ) {

                        localUserElement.setAttribute(
                            'data-message-id',
                            data.user_message.id
                        );

                    }


                    //RESPUESTA DEL BOT

                    if (
                        data.bot_message &&
                        data.bot_message.message
                    ) {

                        const botElement = addMessage(
                            'bot',
                            'UMG Xela',
                            data.bot_message.message,
                            data.bot_message.time || getCurrentTime()
                        );

                        if (
                            data.bot_message.id &&
                            botElement
                        ) {

                            botElement.setAttribute(
                                'data-message-id',
                                data.bot_message.id
                            );

                        }

                    }


                    // SINCRONIZAR
                    // (por si el moderador ya respondió mientras tanto)

                    loadFloatingMessages(true);


                    // SCROLL

                    scrollMessages();

                }


                catch (error) {

                    console.error(
                        'Error UMG Xela:',
                        error
                    );


                    addMessage(
                        'bot',
                        'UMG Xela',
                        'Lo siento, ocurrió un problema al enviar tu mensaje. Intenta nuevamente.',
                        getCurrentTime()
                    );


                    scrollMessages();

                }


                finally {

                    sendButton.disabled = false;

                    textarea.focus();

                }

                return false;

            });


            //ENTER PARA ENVIAR

            textarea.addEventListener('keydown', function (event) {

                if (
                    event.key === 'Enter' &&
                    !event.shiftKey
                ) {

                    event.preventDefault();
                    event.stopPropagation();

                    form.dispatchEvent(
                        new Event('submit', {
                            bubbles: true,
                            cancelable: true
                        })
                    );

                }

            });


            //AUTO-ALTURA TEXTAREA

            textarea.addEventListener('input', function () {

                this.style.height = 'auto';

                this.style.height =
                    Math.min(
                        this.scrollHeight,
                        100
                    ) + 'px';

            });


            //AGREGAR MENSAJE

            function addMessage(
                type,
                sender,
                message,
                time
            ) {

                const container =
                    document.createElement('div');

                container.className =
                    'floating-message ' + type;


                const wrapper =
                    document.createElement('div');

                wrapper.className =
                    'floating-message-wrapper';


                const senderElement =
                    document.createElement('span');

                senderElement.className =
                    'floating-sender';

                senderElement.textContent =
                    sender;


                const bubble =
                    document.createElement('span');

                bubble.className =
                    'floating-bubble';

                bubble.textContent =
                    message;


                const timeElement =
                    document.createElement('span');

                timeElement.className =
                    'floating-time';

                timeElement.textContent =
                    time;


                wrapper.appendChild(
                    senderElement
                );

                wrapper.appendChild(
                    bubble
                );

                wrapper.appendChild(
                    timeElement
                );

                container.appendChild(
                    wrapper
                );

                messages.appendChild(
                    container
                );

                return container;

            }


            // OBTENER MENSAJES DESDE EL SERVIDOR
            //
            // Se usa tanto al abrir la página (para cargar el
            // historial) como cada pocos segundos (para que los
            // mensajes del MODERADOR aparezcan automáticamente,
            // igual que en la vista de chat de página completa).

            async function loadFloatingMessages(forceScroll) {

                try {

                    const response = await fetch(
                        "{{ route('chat.messages') }}",
                        {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            cache: 'no-store'
                        }
                    );

                    if (!response.ok) {
                        return;
                    }

                    const data = await response.json();

                    if (!data.success) {
                        return;
                    }

                    renderFloatingMessages(
                        data.messages,
                        forceScroll
                    );

                }
                catch (error) {

                    console.error(
                        'Error UMG Xela (polling):',
                        error
                    );

                }

            }


            //RENDERIZAR MENSAJES DEL SERVIDOR

            function renderFloatingMessages(serverMessages, forceScroll) {

                if (
                    !serverMessages ||
                    serverMessages.length === 0
                ) {
                    return;
                }

                const welcome =
                    document.getElementById('chatWelcome');

                if (welcome) {
                    welcome.remove();
                }

                let addedNew = false;

                serverMessages.forEach(function (message) {

                    // EVITAR DUPLICADOS

                    const existing =
                        messages.querySelector(
                            '[data-message-id="' + message.id + '"]'
                        );

                    if (existing) {
                        return;
                    }

                    let senderName = 'UMG Xela';
                    let type = 'bot';

                    if (message.sender_type === 'USER') {
                        type = 'user';
                        senderName = 'Tú';
                    }
                    else if (message.sender_type === 'MODERATOR') {
                        type = 'moderator';
                        senderName = 'Moderador';
                    }

                    const element = addMessage(
                        type,
                        senderName,
                        message.message,
                        message.time
                    );

                    element.setAttribute(
                        'data-message-id',
                        message.id
                    );

                    addedNew = true;

                });

                if (addedNew || forceScroll) {
                    scrollMessages();
                }

            }

            // HORA

            function getCurrentTime() {

                const now = new Date();

                return now.toLocaleTimeString(
                    'es-GT',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }
                );

            }


            //SCROLL
            
            function scrollMessages() {

                setTimeout(function () {

                    messages.scrollTop =
                        messages.scrollHeight;

                }, 50);

            }

        });

    </script>
</body>
</html>