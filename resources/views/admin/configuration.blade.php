<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Configuración | UMG</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    /*CONTENEDOR*/
        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 35px 20px 50px;
        }

    /*BOTÓN VOLVER*/
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
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all .2s ease;
        }

    /*ENCABEZADO*/
        .page-header {
            background: #ffffff;
            border-radius: 18px;
            padding: 25px 30px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
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


    /*TARJETAS*/
        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            border: 1px solid #e8edf5;
        }

    /*TÍTULOS DE SECCIÓN*/
        .section {
            margin-bottom: 30px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 18px;
            color: #1f2937;
        }

        .section-title i {
            color: #2563eb;
        }


    /*INFORMACIÓN DEL SISTEMA*/
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all .2s ease;
        }


        .form-group input:focus {
            border-color: #2563eb;
            box-shadow:
                0 0 0 3px rgba(37,99,235,.25);
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }


    /*LISTA DE CONFIGURACIONES*/
        .settings-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .setting {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: #f8fafc;
            padding: 16px 18px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all .2s ease;
        }

        .setting-info {
            display: flex;
            align-items: center;
            gap: 14px;
            /* Ocupa el espacio disponible y deja que el texto se ajuste sin empujar el interruptor */
            flex: 1;
            min-width: 0;
        }

        .setting-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            color: #2563eb;
            flex-shrink: 0;
        }


        .setting-text {
            min-width: 0;
            overflow-wrap: break-word;
        }

        .setting-text strong {
            display: block;
            color: #1f2937;
            font-size: 15px;
        }

        .setting-text span {
            display: block;
            margin-top: 3px;
            color: #6b7280;
            font-size: 12px;
        }

    /*SWITCH*/
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #cbd5e1;
            border-radius: 30px;
            transition: .3s;
        }

        .slider:before {
            content: "";
            position: absolute;
            height: 20px;
            width: 20px;
            left: 3px;
            top: 3px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,.20);
            transition: .3s;
        }

        .switch input:checked + .slider {
            background: #2563eb;
        }

        .switch input:checked + .slider:before {
            transform: translateX(22px);
        }

    /*MANTENIMIENTO*/
        .maintenance {
            border: 1px solid #fde68a;
            background: #fffbeb;
        }

        .maintenance .setting-icon {
            background: #fef3c7;
            border-color: #fde68a;
            color: #d97706;
        }

        .maintenance .setting-text strong {
            color: #92400e;
        }

        .maintenance .setting-text span {
            color: #92400e;
        }

    /*BOTONES / ACCIONES*/
        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e5e7eb;
        }

        .save-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 10px;
            border: none;
            background: #2563eb;
            color: #ffffff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

    /*MENSAJES*/
        .alert-success {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ecfdf5;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            overflow-wrap: break-word;
        }

        .alert-error {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            overflow-wrap: break-word;
        }

        .alert-success i,
        .alert-error i {
            flex-shrink: 0;
        }

    /*HOVER (solo dispositivos con puntero)
      Evita el "hover pegado" en pantallas táctiles*/
        @media (hover: hover) {
            .back-button:hover {
                background: #f3f4f6;
                transform: translateX(-2px);
            }

            .setting:hover {
                background: #f1f5f9;
                border-color: #dbe3ef;
            }

            .maintenance:hover {
                background: #fef3c7;
            }

            .save-btn:hover {
                background: #1d4ed8;
                transform: translateY(-1px);
            }
        }

    /*FOCO DE TECLADO*/
        .back-button:focus-visible,
        .save-btn:focus-visible,
        .switch input:focus-visible + .slider {
            outline: 3px solid rgba(37,99,235,.45);
            outline-offset: 2px;
        }

    /*PANTALLAS TÁCTILES: área mínima de 44px*/
        @media (pointer: coarse) {
            .back-button,
            .save-btn {
                min-height: 44px;
            }

            /* Amplía la zona de toque del interruptor sin cambiar su apariencia */
            .switch::after {
                content: "";
                position: absolute;
                inset: -9px -6px;
            }
        }

    /*RESPONSIVE*/
        @media (max-width: 700px) {
            .container {
                padding: 20px 14px 40px;
            }

            .page-header,
            .card {
                padding: 22px 18px;
            }

            .title {
                font-size: 21px;
            }

            .setting {
                padding: 14px;
            }

            .setting-info {
                align-items: flex-start;
            }


            .actions {
                justify-content: stretch;
            }

            .save-btn {
                width: 100%;
            }
        }

    /*CELULARES PEQUEÑOS*/
        @media (max-width: 420px) {
            .page-header,
            .card {
                padding: 18px 14px;
            }

            .setting {
                padding: 12px;
                gap: 12px;
            }

            .setting-info {
                gap: 12px;
            }
        }

    /*MOVIMIENTO REDUCIDO*/
        @media (prefers-reduced-motion: reduce) {
            .back-button,
            .setting,
            .slider,
            .slider:before,
            .save-btn,
            .form-group input {
                transition: none;
            }

            .back-button:hover,
            .save-btn:hover {
                transform: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">

    <!--VOLVER AL PANEL-->
    <a
        href="/admin-panel"
        class="back-button">
            <i class="fas fa-arrow-left"></i>
        Volver al panel
    </a>

    <!-- ENCABEZADO-->
    <div class="page-header">
        <div class="title">
            <i class="fas fa-cog"></i>
            Configuración del Sistema
        </div>

        <div class="subtitle">
            Administra las funciones principales de UMG.
        </div>
    </div>

    <!--MENSAJES-->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    <!--TARJETA DE CONFIGURACIÓN-->
    <div class="card">
        <form
            action="/admin/configuration/save"
            method="POST">
            @csrf

    <!--INFORMACIÓN DEL SISTEMA-->
            <div class="section">
                <div class="section-title">
                    <i class="fas fa-sliders"></i>
                    Información del sistema
                </div>

    <!--FUNCIONES DEL SISTEMA-->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-toggle-on"></i>
                Funciones del sistema
            </div>
        <div class="settings-list">

    <!-- FORO -->
        <div class="setting">
            <div class="setting-info">
            <div class="setting-icon">
                <i class="fas fa-comments"></i>
        </div>

        <div class="setting-text">
            <strong>
            Habilitar Foro
            </strong>
                <span>
                    Permite que los usuarios utilicen el foro.
                </span>
        </div>
        </div>

    <label class="switch">
        <input
            type="checkbox"
            name="forum_enabled"
            {{ $settings->forum_enabled ? 'checked' : '' }}>
        <span class="slider"></span>
                        </label>
                    </div>

    <!-- BOTÓN DE PÁNICO -->
        <div class="setting">
            <div class="setting-info">
            <div class="setting-icon">
                <i class="fas fa-triangle-exclamation"></i>
        </div>

            <div class="setting-text">
                <strong>
                    Habilitar Botón de Pánico
                </strong>

        <span>
            Permite utilizar la función de emergencia.
        </span>
        </div>
        </div>

        <label class="switch">
            <input
                type="checkbox"
                name="panic_enabled"
                {{ $settings->panic_enabled ? 'checked' : '' }}>
        <span class="slider"></span>
    </label>
            </div>

    <!-- REGISTRO -->
        <div class="setting">
            <div class="setting-info">
                <div class="setting-icon">
                    <i class="fas fa-user-plus"></i>
                    </div>

                            <div class="setting-text">
                                <strong>
                                    Permitir Registro de Usuarios
                                </strong>

                                <span>
                                    Permite crear nuevas cuentas en UMG.
                                </span>
                            </div>
                        </div>

                        <label class="switch">
                            <input
                                type="checkbox"
                                name="registration_enabled"
                                {{ $settings->registration_enabled ? 'checked' : '' }}>

                            <span class="slider"></span>
                        </label>
                    </div>

    <!-- CREACIÓN DE CASOS -->
        <div class="setting">
            <div class="setting-info">
                <div class="setting-icon">
                    <i class="fas fa-folder-plus"></i>
                    </div>

                            <div class="setting-text">
                                <strong>
                                    Permitir Creación de Casos
                                </strong>

                                <span>
                                    Permite que los usuarios creen nuevos casos.
                                </span>
                            </div>
                        </div>

                        <label class="switch">
                            <input
                                type="checkbox"
                                name="case_creation_enabled"
                                {{ $settings->case_creation_enabled ? 'checked' : '' }}>

                            <span class="slider"></span>
                        </label>
                    </div>

                </div>
            </div>

    <!--MANTENIMIENTO-->
        <div class="section">
                <div class="section-title">
                    <i class="fas fa-screwdriver-wrench"></i>
                    Mantenimiento
                </div>

                <div class="settings-list">
                    <div class="setting maintenance">
                        <div class="setting-info">
                            <div class="setting-icon">
                                <i class="fas fa-power-off"></i>
                            </div>

                            <div class="setting-text">
                                <strong>
                                    Activar Modo Mantenimiento
                                </strong>

                                <span>
                                    Restringe temporalmente el acceso de los usuarios al sistema.
                                </span>
                            </div>
                        </div>

                        <label class="switch">
                            <input
                                type="checkbox"
                                name="maintenance_mode"
                                {{ $settings->maintenance_mode ? 'checked' : '' }}>
                            <span class="slider"></span>

                        </label>
                    </div>
                </div>
            </div>

    <!--GUARDAR -->
            <div class="actions">
                <button
                    type="submit"
                    class="save-btn">
                    <i class="fas fa-save"></i>
                    Guardar configuración
                </button>
            </div>
    </form>
    </div>
</div>
</body>
</html>