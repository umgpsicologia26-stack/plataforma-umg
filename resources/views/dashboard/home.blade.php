<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, interactive-widget=resizes-content">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Plataforma de Apoyo - UMG Xela</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ================================================================
           BASE
           ================================================================ */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Variables fluidas compartidas */
            --gutter: clamp(16px, 4vw, 40px);
            --wave-h: clamp(70px, 12vw, 180px);
            --chat-edge: clamp(10px, 2vw, 25px);
            --safe-top: env(safe-area-inset-top, 0px);
            --safe-right: env(safe-area-inset-right, 0px);
            --safe-bottom: env(safe-area-inset-bottom, 0px);
            --safe-left: env(safe-area-inset-left, 0px);
        }

        html {
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            /* Espacio inferior para que el botón flotante no tape el último contenido */
            padding-bottom: calc(100px + var(--safe-bottom));
            /* Red de seguridad: los efectos 3D no deben crear scroll horizontal.
               "clip" no crea contenedor de scroll; "hidden" queda como respaldo. */
            overflow-x: hidden;
            overflow-x: clip;
        }

        img,
        svg {
            max-width: 100%;
        }

        a:focus-visible,
        button:focus-visible,
        textarea:focus-visible {
            outline: 3px solid #f59e0b;
            outline-offset: 2px;
        }

        /* ================================================================
           NAVBAR
           Escritorio: marca | enlaces | acciones (una fila)
           ≤1240px   : marca + acciones arriba, enlaces en segunda fila
           ≤600px    : todo apilado, enlaces en 2 columnas
           ================================================================ */

        .navbar {
            width: 95%;
            max-width: 1400px;
            margin: 20px auto;
            padding: 16px clamp(16px, 2.5vw, 35px);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 35px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
            position: relative;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 0 0 auto;
        }

        .brand h2 {
            font-size: 26px;
            font-weight: 800;
            color: #2563eb;
        }

        .nav-center {
            display: flex;
            flex: 1 1 auto;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 8px 10px;
            min-width: 0;
        }

        .nav-center a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 9px clamp(10px, 1vw, 14px);
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            text-decoration: none;
            color: #334155;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.25;
            white-space: nowrap;
            transition: background .2s ease, border-color .2s ease, color .2s ease,
                box-shadow .2s ease;
        }

        .nav-center a i {
            font-size: 14px;
        }

        .nav-right {
            display: flex;
            flex: 0 0 auto;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            min-width: 0;
        }

        .nav-right form {
            margin: 0;
        }

        .admin-btn {
            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            color: white;
            text-decoration: none;
            min-height: 44px;
            padding: 12px 22px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 700;
            transition: box-shadow .2s ease, transform .2s ease;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            min-height: 44px;
            padding: 12px 22px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: box-shadow .2s ease, transform .2s ease;
        }

        /* ================================================================
           HERO
           ================================================================ */

        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg,
                    #4f46e5 0%,
                    #7c3aed 50%,
                    #d946ef 100%);
            border-radius: 0 0 clamp(32px, 6vw, 80px) clamp(32px, 6vw, 80px);
            padding: clamp(40px, 6vw, 80px) clamp(20px, 5vw, 60px) calc(var(--wave-h) + clamp(16px, 3vw, 30px));
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: clamp(24px, 4vw, 60px);
            color: white;
        }

        .hero-content {
            flex: 1 1 0;
            max-width: 650px;
            min-width: 0;
            z-index: 2;
        }

        .hero-content h1 {
            color: white;
            font-size: clamp(2rem, 1.1rem + 3.6vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: clamp(16px, 2.5vw, 25px);
            overflow-wrap: break-word;
        }

        .hero-content p {
            font-size: clamp(1rem, .92rem + .35vw, 1.2rem);
            line-height: 1.8;
            opacity: .95;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-top: clamp(22px, 3vw, 35px);
            flex-wrap: wrap;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 14px clamp(20px, 2.5vw, 30px);
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            text-align: center;
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
            flex: 0 1 clamp(200px, 38%, 500px);
            max-width: 500px;
            min-width: 0;
            z-index: 1;
        }

        .hero-image img {
            display: block;
            width: 100%;
            height: auto;
        }

        .wave {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .wave svg {
            display: block;
            width: 100%;
            height: var(--wave-h);
        }

        /* ================================================================
           INFORMACIÓN
           ================================================================ */

        .info-section {
            margin-top: calc(var(--wave-h) * -.5);
            position: relative;
            z-index: 3;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
            gap: clamp(16px, 2.5vw, 25px);
            padding: 0 var(--gutter) 40px;
        }

        .info-card {
            min-width: 0;
            background: white;
            border-radius: 25px;
            padding: clamp(20px, 3vw, 30px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, .1);
        }

        .info-card h3 {
            color: #111827;
            margin-bottom: 15px;
            overflow-wrap: break-word;
        }

        .info-card p {
            color: #4b5563;
            line-height: 1.7;
            overflow-wrap: break-word;
        }

        .info-card i {
            display: inline-block;
            font-size: 40px;
            color: #7c3aed;
            margin-bottom: 20px;
        }

        /* ================================================================
           EMERGENCIA
           ================================================================ */

        .emergency-bar {
            margin: 30px var(--gutter);
            background: white;
            border-radius: 25px;
            padding: clamp(20px, 3vw, 25px) clamp(20px, 3vw, 35px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .emergency-bar>div {
            min-width: 0;
        }

        .emergency-title {
            color: #111827;
            font-size: clamp(1.15rem, 1rem + .6vw, 1.4rem);
            font-weight: 700;
        }

        .emergency-info {
            color: #4b5563;
        }

        /* ================================================================
           SERVICIOS
           ================================================================ */

        .services-section {
            padding: clamp(32px, 5vw, 50px) var(--gutter);
        }

        .services-title {
            text-align: center;
            font-size: clamp(1.5rem, 1.2rem + 1vw, 2rem);
            color: #111827;
            margin-bottom: clamp(24px, 4vw, 40px);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
            gap: clamp(16px, 2.5vw, 25px);
        }

        .feature-card {
            min-width: 0;
            background: white;
            border-radius: 25px;
            padding: clamp(20px, 3vw, 30px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: clamp(1.1rem, 1rem + .4vw, 22px);
            font-weight: 700;
            margin-bottom: 12px;
            color: #111827;
            overflow-wrap: break-word;
        }

        .feature-text {
            color: #4b5563;
            line-height: 1.7;
            overflow-wrap: break-word;
        }

        /* ================================================================
           BOTÓN FLOTANTE
           ================================================================ */

        .chat-floating-button {
            position: fixed;
            right: calc(var(--chat-edge) + var(--safe-right));
            bottom: calc(25px + var(--safe-bottom));
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
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .chat-floating-button img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        /* ================================================================
           CHAT FLOTANTE
           Tamaño: nunca mayor que el ancho/alto visibles.
           --vvh lo actualiza un pequeño script (visualViewport) para el teclado
           virtual; si no existe se usa 100dvh y, antes, 100vh como respaldo.
           ================================================================ */

        .floating-chat {
            --chat-bottom: calc(110px + var(--safe-bottom));
            position: fixed;
            right: calc(var(--chat-edge) + var(--safe-right));
            bottom: var(--chat-bottom);
            width: min(380px, calc(100% - (var(--chat-edge) * 2) - var(--safe-left) - var(--safe-right)));
            height: min(520px, calc(100vh - var(--chat-bottom) - var(--safe-top) - 12px));
            height: min(520px, calc(var(--vvh, 100dvh) - var(--chat-bottom) - var(--safe-top) - 12px));
            min-height: 280px;
            max-height: calc(100vh - 24px);
            max-height: calc(var(--vvh, 100dvh) - 24px);
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 18px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .30);
            z-index: 99998;
            display: none;
            flex-direction: column;
            overflow: hidden;
            transform-origin: bottom right;
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
            gap: 10px;
            flex-shrink: 0;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .chat-header-logo {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 50%;
            background: white;
            padding: 4px;
            object-fit: contain;
        }

        .chat-header-title {
            display: flex;
            flex-direction: column;
            min-width: 0;
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
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 50%;
        }

        .chat-close:hover {
            background: rgba(255, 255, 255, .15);
        }

        /* MENSAJES */

        .floating-chat-messages {
            flex: 1 1 auto;
            padding: 18px;
            overflow-y: auto;
            overscroll-behavior: contain;
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
            color: #94a3b8;
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

        /* FORMULARIO CHAT (siempre visible: flex-shrink 0) */

        .floating-chat-form {
            padding: 10px 10px calc(10px + var(--safe-bottom));
            background: #172033;
            border-top: 1px solid #334155;
            display: flex;
            gap: 8px;
            align-items: flex-end;
            flex-shrink: 0;
        }

        .floating-chat-form textarea {
            flex: 1 1 auto;
            min-width: 0;
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
            color: #8294ad;
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
        }

        .floating-send:disabled {
            opacity: .6;
            cursor: wait;
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

        /* ================================================================
           RESPONSIVE (de mayor a menor, sin reglas contradictorias)
           ================================================================ */

        /* Navbar en dos filas: marca + acciones / enlaces */
        @media (max-width: 1240px) {

            .nav-left {
                order: 1;
            }

            .nav-right {
                order: 2;
            }

            .nav-center {
                order: 3;
                flex: 1 1 100%;
            }
        }

        /* Hero en una columna */
        @media (max-width: 860px) {

            .hero-section {
                flex-direction: column;
                text-align: center;
            }

            .hero-content {
                flex: 0 1 auto;
                max-width: 100%;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image {
                flex: 0 1 auto;
                width: min(100%, 320px);
            }
        }

        @media (max-width: 600px) {

            .navbar {
                width: 94%;
                border-radius: 28px;
                padding: 16px;
            }

            .nav-left,
            .nav-right,
            .nav-center {
                flex: 1 1 100%;
            }

            .nav-left {
                justify-content: center;
            }

            .nav-center {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(min(100%, 140px), 1fr));
            }

            .nav-center a {
                white-space: normal;
                text-align: center;
                min-height: 44px;
            }

            .nav-right {
                justify-content: stretch;
            }

            .nav-right form {
                flex: 1 1 140px;
            }

            .admin-btn,
            .logout-btn {
                flex: 1 1 140px;
                width: 100%;
            }

            .emergency-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .chat-floating-button {
                width: 62px;
                height: 62px;
                bottom: calc(18px + var(--safe-bottom));
            }

            .floating-chat {
                --chat-bottom: calc(92px + var(--safe-bottom));
                left: calc(10px + var(--safe-left));
                right: calc(10px + var(--safe-right));
                width: auto;
            }

            .floating-message-wrapper {
                max-width: 82%;
            }
        }

        @media (max-width: 360px) {

            .hero-btn {
                flex: 1 1 100%;
            }

            .floating-chat-messages {
                padding: 12px;
            }
        }

        /* Pantallas táctiles: áreas de toque amplias y sin zoom automático en iOS */
        @media (pointer: coarse) {

            .chat-close {
                width: 44px;
                height: 44px;
            }

            .floating-send {
                width: 44px;
                height: 44px;
                min-width: 44px;
            }

            .floating-chat-form textarea {
                font-size: 16px;
                min-height: 44px;
            }
        }

        /* ================================================================
           EFECTOS HOVER Y 3D
           Solo con puntero preciso (ratón) y sin preferencia de movimiento
           reducido. En táctil o con movimiento reducido no se aplica nada.
           JS controla únicamente variables (--rx, --ry, --ny); el transform
           lo compone el CSS, por lo que no hay conflicto con :hover.
           ================================================================ */

        @media (hover: hover) and (pointer: fine) {

            .nav-center a:hover {
                background: #2563eb;
                border-color: #2563eb;
                color: #fff;
                box-shadow: 0 5px 12px rgba(37, 99, 235, .18);
            }

            .floating-send:hover {
                background: #1d4ed8;
            }
        }

        @media (hover: hover) and (pointer: fine) and (prefers-reduced-motion: no-preference) {

            .info-section,
            .grid {
                perspective: 1400px;
            }

            .info-card,
            .feature-card {
                --rx: 0deg;
                --ry: 0deg;
                --lift: 0px;
                transform: perspective(1000px) rotateX(var(--rx)) rotateY(var(--ry)) translateY(var(--lift));
                transform-style: preserve-3d;
                will-change: transform;
                transition: transform .25s ease, box-shadow .25s ease;
            }

            .info-card:hover,
            .feature-card:hover {
                --lift: -5px;
                box-shadow: 0 25px 45px rgba(0, 0, 0, .18);
            }

            .info-card i,
            .feature-icon,
            .info-card h3,
            .feature-title {
                transform: translateZ(30px);
            }

            .info-card p,
            .feature-text {
                transform: translateZ(15px);
            }

            .navbar {
                --ny: 0deg;
                transform: perspective(1200px) rotateY(var(--ny));
                transform-style: preserve-3d;
                transition: transform .3s ease, box-shadow .3s ease;
            }

            .hero-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 20px rgba(0, 0, 0, .18);
            }

            .hero-btn:active {
                transform: translateY(0);
                box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
            }

            .admin-btn:hover,
            .logout-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 14px 22px rgba(0, 0, 0, .22);
            }

            .admin-btn:active,
            .logout-btn:active {
                transform: translateY(0);
            }

            .chat-floating-button:hover {
                transform: scale(1.08);
                box-shadow: 0 8px 25px rgba(0, 0, 0, .30);
            }

            .emergency-bar {
                transition: transform .3s ease, box-shadow .3s ease;
            }

            .emergency-bar:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 35px rgba(0, 0, 0, .14);
            }
        }

        /* Animaciones automáticas: solo si el usuario no pidió menos movimiento */
        @media (prefers-reduced-motion: no-preference) {

            .hero-section {
                perspective: 1600px;
            }

            .hero-image {
                transform-style: preserve-3d;
                animation: hero3DFloat 6s ease-in-out infinite;
            }

            .floating-chat {
                animation: chat3DOpen .28s ease both;
            }
        }

        @keyframes hero3DFloat {
            0% {
                transform: rotateY(-8deg) rotateX(4deg);
            }

            50% {
                transform: rotateY(8deg) rotateX(-2deg);
            }

            100% {
                transform: rotateY(-8deg) rotateX(4deg);
            }
        }

        @keyframes chat3DOpen {
            from {
                transform: translateY(20px) scale(.96);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
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

    <div class="floating-chat" id="floatingChat" role="dialog" aria-label="Chat UMG Xela">

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

        <div class="floating-chat-messages" id="floatingChatMessages" role="log" aria-live="polite">

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

    <nav class="navbar" aria-label="Navegación principal">

        <div class="nav-left">

            <div class="brand">

                <h2>
                    UMG
                </h2>

            </div>

        </div>

        <div class="nav-center">

            {{-- MI PERFIL: SOLO USUARIOS NO ADMIN --}}

            @if(auth()->check() && auth()->user()->role !== 'ADMIN')

                <a href="{{ route('profile.edit') }}">

                    <i class="fas fa-user"></i>

                    Mi perfil

                </a>

            @endif

            {{-- FORO --}}

            <a href="/forum">

                <i class="fas fa-comments"></i>

                Foro Anónimo

            </a>

            {{-- EVALUACIÓN --}}

            <a href="/evaluation">

                <i class="fas fa-brain"></i>

                Evaluación

            </a>

            {{-- BOTÓN DE PÁNICO --}}

            <a href="/panic-button">

                <i class="fas fa-triangle-exclamation"></i>

                Botón de Pánico

            </a>

            {{-- SEGUIMIENTO DE CASOS --}}

            @if(auth()->user()->role === 'ADMIN')

                <a href="/admin/cases">

                    <i class="fas fa-folder-open"></i>

                    Seguimiento de Casos

                </a>

            @elseif(auth()->user()->role === 'MODERATOR')

                <a href="/moderator/cases">

                    <i class="fas fa-folder-open"></i>

                    Seguimiento de Casos

                </a>

            @else

                <a href="/cases">

                    <i class="fas fa-folder-open"></i>

                    Seguimiento de Casos

                </a>

            @endif

        </div>

        <div class="nav-right">

            {{-- BOTÓN ADMIN: SOLO ADMINISTRADOR --}}

            @if(auth()->check() && auth()->user()->role === 'ADMIN')

                <a href="{{ url('/admin-access') }}" class="admin-btn">

                    <i class="fas fa-shield-halved"></i>

                    Admin

                </a>

            @endif

            {{-- CERRAR SESIÓN --}}

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

    {{-- HERO --}}

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

            <svg viewBox="0 0 1440 320" preserveAspectRatio="none" aria-hidden="true" focusable="false">

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

    {{-- JAVASCRIPT CHAT (lógica original sin cambios) --}}

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

            loadFloatingMessages(true);

            const floatingMessagesInterval = setInterval(function () {
                loadFloatingMessages(false);
            }, 3000);

            const logoutForm = document.querySelector('form[action="{{ url('/logout') }}"]');

            if (logoutForm) {

                logoutForm.addEventListener('submit', function () {

                    clearInterval(floatingMessagesInterval);

                });

            }

            // ABRIR CHAT

            button.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                chat.classList.toggle('active');

                if (chat.classList.contains('active')) {

                    scrollMessages();

                    setTimeout(function () {

                        textarea.focus();

                    }, 100);

                }

            });

            // CERRAR CHAT

            closeButton.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                chat.classList.remove('active');

            });

            // NO CERRAR AL HACER CLICK DENTRO

            chat.addEventListener('click', function (event) {

                event.stopPropagation();

            });

            // CERRAR AL HACER CLICK AFUERA

            document.addEventListener('click', function (event) {

                if (!chat.classList.contains('active')) {
                    return;
                }

                if (
                    !chat.contains(event.target) &&
                    !button.contains(event.target)
                ) {

                    chat.classList.remove('active');

                }

            });

            // ENVIAR MENSAJE

            form.addEventListener('submit', async function (event) {

                event.preventDefault();
                event.stopPropagation();

                const message = textarea.value.trim();

                if (!message) {

                    textarea.focus();

                    return;

                }

                // MOSTRAR CHAT

                chat.classList.add('active');

                // DESACTIVAR BOTÓN

                sendButton.disabled = true;

                // QUITAR BIENVENIDA

                const welcome = document.getElementById('chatWelcome');

                if (welcome) {

                    welcome.remove();

                }

                // MOSTRAR MENSAJE DEL USUARIO

                const localUserElement = addMessage(
                    'user',
                    'Tú',
                    message,
                    getCurrentTime()
                );

                // LIMPIAR INPUT

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

                    // OBTENER RESPUESTA

                    const contentType =
                        response.headers.get('content-type') || '';

                    if (!contentType.includes('application/json')) {

                        throw new Error(
                            'El servidor no devolvió JSON. Código HTTP: ' +
                            response.status
                        );

                    }

                    const data = await response.json();

                    // VERIFICAR RESPUESTA

                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'No fue posible enviar el mensaje.'
                        );

                    }

                    // MARCAR MENSAJE DEL USUARIO CON SU ID REAL

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

                    // RESPUESTA DEL BOT

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

            // ENTER PARA ENVIAR

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

            // AUTO-ALTURA TEXTAREA

            textarea.addEventListener('input', function () {

                this.style.height = 'auto';

                this.style.height =
                    Math.min(
                        this.scrollHeight,
                        100
                    ) + 'px';

            });

            // AGREGAR MENSAJE

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

            // RENDERIZAR MENSAJES DEL SERVIDOR

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

            // SCROLL

            function scrollMessages() {

                setTimeout(function () {

                    messages.scrollTop =
                        messages.scrollHeight;

                }, 50);

            }

        });

    </script>

    {{-- JAVASCRIPT EFECTO 3D + VIEWPORT (independiente del chat) --}}
    {{-- El tilt solo se activa con ratón y sin "movimiento reducido".   --}}
    {{-- JS solo define variables CSS (--rx, --ry, --ny); no escribe     --}}
    {{-- "transform", así no choca con las reglas :hover del CSS.        --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

            function tiltEnabled() {
                return finePointer.matches && !reduceMotion.matches;
            }

            const tiltCards = document.querySelectorAll('.info-card, .feature-card');

            tiltCards.forEach(function (card) {

                card.addEventListener('mousemove', function (event) {

                    if (!tiltEnabled()) {
                        return;
                    }

                    const rect = card.getBoundingClientRect();

                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    card.style.setProperty('--rx', (((y - centerY) / centerY) * -8) + 'deg');
                    card.style.setProperty('--ry', (((x - centerX) / centerX) * 8) + 'deg');

                });

                card.addEventListener('mouseleave', function () {

                    card.style.setProperty('--rx', '0deg');
                    card.style.setProperty('--ry', '0deg');

                });

            });

            // NAVBAR: leve inclinación 3D al mover el mouse cerca

            const navbar = document.querySelector('.navbar');

            if (navbar) {

                navbar.addEventListener('mousemove', function (event) {

                    if (!tiltEnabled()) {
                        return;
                    }

                    const rect = navbar.getBoundingClientRect();

                    const x = event.clientX - rect.left;
                    const centerX = rect.width / 2;

                    navbar.style.setProperty('--ny', (((x - centerX) / centerX) * 1.5) + 'deg');

                });

                navbar.addEventListener('mouseleave', function () {

                    navbar.style.setProperty('--ny', '0deg');

                });

            }

            // VIEWPORT VISUAL: ajusta la altura máxima del chat cuando aparece
            // el teclado virtual (solo si no hay zoom de pellizco activo).

            if (window.visualViewport) {

                const root = document.documentElement;

                const updateViewportHeight = function () {

                    if (window.visualViewport.scale <= 1.01) {

                        root.style.setProperty('--vvh', window.visualViewport.height + 'px');

                    }

                };

                updateViewportHeight();

                window.visualViewport.addEventListener('resize', updateViewportHeight);

            }

        });

    </script>

</body>

</html>