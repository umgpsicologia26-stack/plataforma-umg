<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    
        <title>Notificaciones | UMG</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite('resources/js/echo.js')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            background:
                linear-gradient(
                    135deg,
                    #eef4ff,
                    #f8fbff
                );
            /* 100vh como respaldo; 100dvh evita el salto de la barra del navegador en móviles */
            min-height: 100vh;
            min-height: 100dvh;
            color: #1f2937;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 35px 20px 50px;
        }


    /*VOLVER*/
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            color: #374151;
            background: #ffffff;
            padding: 11px 18px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,.05);
            transition: all .2s ease;
        }

    /*ENCABEZADO*/
        .page-header {
            background: #ffffff;
            border-radius: 18px;
            padding: 25px 30px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.07);
            border: 1px solid #e8edf5;
        }

        .title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 25px;
            font-weight: 700;
            color: #1f2937;
        }

        .title i {
            color: #2563eb;
            flex-shrink: 0;
        }

        .subtitle {
            margin-top: 7px;
            color: #6b7280;
            font-size: 14px;
        }

    /*TARJETA*/
        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,.07);
            border: 1px solid #e8edf5;
        }

    /*NOTIFICACIÓN (estilo base = estado "leída": fondo normal de la plataforma)*/
        .notification {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            margin-bottom: 12px;
            background: #ffffff;
            transition: .2s ease;
        }

    /*NO LEÍDA: fondo rojo con texto blanco (contraste ≈ 6.5:1)*/
        .notification--unread {
            background: #b91c1c;
            border-color: #991b1b;
            border-left: 4px solid #7f1d1d;
            color: #ffffff;
        }

        .notification--unread .notification-icon {
            background: rgba(255,255,255,.2);
            color: #ffffff;
        }

        .notification--unread .notification-text strong,
        .notification--unread .notification-text span,
        .notification--unread .notification-date {
            color: #ffffff;
        }

        .notification--unread .read-button {
            background: #ffffff;
            color: #991b1b;
        }

    /*LEÍDA: conserva exactamente el estilo normal de la tarjeta*/
        .notification--read {
            background: #ffffff;
        }


        .notification-info {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            /* Ocupa el espacio disponible y deja que el mensaje se ajuste sin empujar el botón */
            flex: 1;
            min-width: 0;
        }


        .notification-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb;
            flex-shrink: 0;
        }

        .notification-text {
            min-width: 0;
            /* Mensajes con URLs o palabras largas se parten dentro de la tarjeta */
            overflow-wrap: anywhere;
        }

        .notification-text strong {
            display: block;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .notification-text span {
            display: block;
            font-size: 13px;
            color: #6b7280;
        }

        .notification-date {
            margin-top: 6px;
            font-size: 12px;
            color: #9ca3af;
        }

    /*BOTÓN LEÍDO*/
        .read-button {
            border: none;
            background: #2563eb;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

    /*VACÍO*/
        .empty {
            text-align: center;
            padding: 50px 20px;
            color: #6b7280;
        }

        .empty i {
            display: block;
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 15px;
        }

        .empty p {
            font-size: 14px;
        }

    /*HOVER (solo dispositivos con puntero)
    Evita el "hover pegado" en pantallas táctiles.
    Las no leídas conservan su fondo rojo al pasar el cursor.*/
        @media (hover: hover) {
            .back-button:hover {
                background: #f3f4f6;
                transform: translateX(-2px);
            }

            .notification:hover {
                transform: translateY(-1px);
            }

            .notification--read:hover {
                background: #f8fafc;
            }

            .read-button:hover {
                background: #1d4ed8;
            }

            .notification--unread .read-button:hover {
                background: #fee2e2;
            }
        }

    /*FOCO DE TECLADO*/
        .back-button:focus-visible,
        .read-button:focus-visible {
            outline: 3px solid rgba(37,99,235,.45);
            outline-offset: 2px;
        }

        .notification--unread .read-button:focus-visible {
            outline-color: #ffffff;
        }

    /*PANTALLAS TÁCTILES: área mínima de 44px*/
        @media (pointer: coarse) {
            .back-button,
            .read-button {
                min-height: 44px;
            }
        }

    /*RESPONSIVE*/
        @media(max-width:700px) {
            .container {
                padding: 20px 14px 40px;
            }

            .page-header,
            .card {
                padding:
                    22px 18px;
            }

            .title {
                font-size: 21px;
            }

            .notification {
                align-items:
                    flex-start;
                flex-direction:
                    column;
            }

            .notification-info,
            .notification form {
                width: 100%;
            }

            .read-button {
                width: 100%;
            }
        }

    /*MOVIMIENTO REDUCIDO*/
        @media (prefers-reduced-motion: reduce) {
            .back-button,
            .notification {
                transition: none;
            }

            .back-button:hover,
            .notification:hover {
                transform: none;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <a
        href="/admin-panel"
        class="back-button">
        <i class="fas fa-arrow-left"></i>
        Volver al panel
    </a>

    <div class="page-header">
        <div class="title">
            <i class="fas fa-bell"></i>
            Notificaciones
        </div>

        <div class="subtitle">
            Consulta las notificaciones y actualizaciones
            importantes del sistema.
        </div>
    </div>

    <div class="card">
        @forelse($notifications as $notification)
            @php($isRead = $notification->isRead())

            <div
                class="notification
                {{ $isRead
                    ? 'notification--read'
                    : 'notification--unread' }}">

                <div class="notification-info">
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                    </div>

                    <div class="notification-text">
                        <strong>
                            Notificación del sistema
                        </strong>

                        <span>
                            {{ $notification->message }}
                        </span>
                        <div class="notification-date">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at
                                ? $notification->created_at->format('d/m/Y H:i')
                                : ''
                            }}
                        </div>
                    </div>
                </div>

                @unless($isRead)
                    <form
                        action="{{ route(
                            'admin.notifications.read',
                            $notification->id
                        ) }}"
                        method="POST">

                        @csrf
                        <button
                            type="submit"
                            class="read-button">
                            <i class="fas fa-check"></i>
                            Marcar como leída
                        </button>
                    </form>
                @endunless
            </div>
        @empty

            <div class="empty">
                <i class="fas fa-bell-slash"></i>
                <p>
                    No hay notificaciones.
                </p>
            </div>
        @endforelse
    </div>
</div>
@include('partials.live-refresh')
<script>
umgLive.whenEchoReady(function (echo) {
    const adminUuid = @json(auth()->user()->uuid);

    // La lista se vuelve a pedir al servidor: solo las no leídas de ESTE
    // administrador, sin duplicados y sin tocar el botón "Marcar como leída".
    const refresher = umgLive.createRefresher({
        apply: function (doc) {
            umgLive.swapContent('.card', doc);
        }
    });

    umgLive.listen(echo, 'admin.' + adminUuid, '.admin.notifications.changed', refresher.trigger);
    umgLive.onReconnect(echo, refresher.trigger);
});
</script>
</body>
</html>