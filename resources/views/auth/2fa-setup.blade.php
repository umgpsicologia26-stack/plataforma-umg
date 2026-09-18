<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Configurar autenticación de dos factores - UMG</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">

    <style>
    * {
        box-sizing: border-box;
    }

    html {
        margin: 0;
        padding: 0;
    }

    body {
        margin: 0;
        padding: 24px 16px 32px;

        /*
         * La altura es natural.
         * No se fuerza a 100vh/dvh para evitar
         * espacios verticales innecesarios.
         */
        min-height: 100vh;

        background: linear-gradient(135deg, #b7e0f6 0%, #d6ecf5 40%, #dff3ec 70%, #e3f5ea 100%);
        background-attachment: fixed;

        overflow-x: hidden;
        overflow-y: auto;
    }


    /* ==========================================
       CARD PRINCIPAL
       ========================================== */

    .two-factor-card {
        width: min(100%, 460px);

        margin: 0 auto;

        padding: 26px 28px 24px;

        background: #ffffff;

        border-radius: 18px;

        box-shadow:
            0 10px 35px rgba(0, 0, 0, 0.10);

        text-align: center;
    }


    /* ==========================================
       ICONO
       ========================================== */

    .two-factor-icon {
        font-size: 34px;

        line-height: 1;

        margin-bottom: 9px;
    }


    /* ==========================================
       TITULO
       ========================================== */

    .two-factor-card h1 {
        margin: 0 0 9px;

        color: #222222;

        font-size: 22px;

        line-height: 1.25;
    }


    /* DESCRIPCION */

    .two-factor-description {
        max-width: 410px;

        margin: 0 auto 15px;

        color: #666666;

        font-size: 14px;

        line-height: 1.5;
    }


    /* QR */

    .qr-container {
        width: 100%;

        display: flex;
        justify-content: center;
        align-items: center;

        margin: 12px 0 14px;

        padding: 10px;

        background: #ffffff;

        border: 1px solid #e5e7eb;

        border-radius: 12px;

        overflow: hidden;
    }

    .qr-container svg,
    .qr-container img {
        display: block;

        /*
         * El QR mantiene un tamaño estable.
         * No depende de la altura del dispositivo.
         */
        width: 160px !important;
        height: 160px !important;

        max-width: 100% !important;

        aspect-ratio: 1 / 1;
    }


    /* AVISO */

    .secret-warning {
        background: #f8fafc;

        border: 1px solid #e2e8f0;

        border-radius: 10px;

        padding: 10px 12px;

        margin-bottom: 14px;

        color: #475569;

        font-size: 12.5px;

        line-height: 1.4;

        text-align: left;
    }

    .secret-warning strong {
        display: block;

        margin-bottom: 3px;
    }


    /* LABEL */

    .two-factor-card label {
        display: block;

        margin-bottom: 6px;

        font-size: 13px;

        color: #444444;
    }


    /* INPUT */

    .two-factor-input {
        display: block;

        width: 100%;

        padding: 10px;

        border: 1px solid #d1d5db;

        border-radius: 10px;

        font-size: 20px;

        text-align: center;

        letter-spacing: 6px;

        margin: 8px 0 12px;

        outline: none;
    }

    .two-factor-input:focus {
        border-color: #2563eb;

        box-shadow:
            0 0 0 2px rgba(37, 99, 235, 0.10);
    }


    /* BOTON */

    .two-factor-button {
        display: block;

        width: 100%;

        border: none;

        padding: 12px;

        border-radius: 10px;

        background: #2563eb;

        color: white;

        font-size: 15px;

        font-weight: bold;

        cursor: pointer;
    }

    .two-factor-button:hover {
        opacity: 0.9;
    }


    /* ERROR */

    .two-factor-error {
        color: #dc2626;

        font-size: 13px;

        margin-bottom: 10px;

        text-align: left;
    }


    /* CANCELAR */

    .cancel-link {
        display: inline-block;

        margin-top: 12px;

        color: #64748b;

        text-decoration: none;

        font-size: 13px;
    }

    .cancel-link:hover {
        text-decoration: underline;
    }


    /* TELEFONOS 334px - 599px */

    @media (max-width: 599px) {

        body {
            padding: 14px 12px 24px;
        }

        .two-factor-card {
            width: 100%;

            padding: 21px 17px 20px;

            border-radius: 16px;
        }

        .two-factor-icon {
            font-size: 30px;

            margin-bottom: 7px;
        }

        .two-factor-card h1 {
            font-size: 20px;

            margin-bottom: 8px;
        }

        .two-factor-description {
            font-size: 13.5px;

            line-height: 1.45;

            margin-bottom: 13px;
        }

        .qr-container {
            margin: 10px 0 13px;

            padding: 9px;
        }

        .qr-container svg,
        .qr-container img {
            width: 155px !important;
            height: 155px !important;
        }

        .secret-warning {
            padding: 9px 10px;

            font-size: 12px;

            margin-bottom: 13px;
        }

        .two-factor-input {
            font-size: 19px;

            padding: 10px;

            margin-top: 7px;
        }

        .two-factor-button {
            padding: 12px 10px;

            font-size: 14px;
        }
    }


    /* TELEFONOS MUY ESTRECHOS 334px - 380px Galaxy Z Fold / Galaxy S8+ */

    @media (max-width: 380px) {

        body {
            padding: 10px 8px 20px;
        }

        .two-factor-card {
            padding: 18px 13px 18px;

            border-radius: 14px;
        }

        .two-factor-icon {
            font-size: 28px;
        }

        .two-factor-card h1 {
            font-size: 18px;
        }

        .two-factor-description {
            font-size: 12.5px;
        }

        .qr-container {
            margin-top: 8px;

            margin-bottom: 11px;

            padding: 7px;
        }

        .qr-container svg,
        .qr-container img {
            width: 140px !important;
            height: 140px !important;
        }

        .secret-warning {
            font-size: 11.5px;

            padding: 8px 9px;
        }

        .two-factor-card label {
            font-size: 12px;
        }

        .two-factor-input {
            font-size: 18px;

            letter-spacing: 5px;

            padding: 9px;
        }

        .two-factor-button {
            font-size: 13px;

            padding: 11px 8px;
        }

        .cancel-link {
            margin-top: 10px;

            font-size: 12px;
        }
    }


    /* TABLETS 600px - 1024px */

    @media (min-width: 600px) and (max-width: 1024px) {

        body {
            padding: 28px 24px 36px;
        }

        .two-factor-card {
            width: min(100%, 460px);

            padding: 26px 28px 24px;
        }

        .qr-container svg,
        .qr-container img {
            width: 160px !important;
            height: 160px !important;
        }
    }


    /* PANTALLAS DE ESCRITORIO */

    @media (min-width: 1025px) {

        body {
            padding-top: 32px;
            padding-bottom: 40px;
        }

        .two-factor-card {
            max-width: 460px;
        }
    }


    /* PANTALLAS BAJAS Nest Hub / Nest Hub Max 1024 x 600 */

    @media (min-width: 800px) and (max-height: 650px) {

        body {
            padding: 8px 20px 16px;
        }

        .two-factor-card {
            max-width: 460px;

            padding: 14px 24px 13px;

            border-radius: 15px;
        }

        .two-factor-icon {
            font-size: 25px;

            margin-bottom: 4px;
        }

        .two-factor-card h1 {
            font-size: 18px;

            margin-bottom: 5px;
        }

        .two-factor-description {
            font-size: 11.5px;

            line-height: 1.3;

            margin-bottom: 6px;
        }

        .qr-container {
            margin: 5px 0 7px;

            padding: 5px;
        }

        .qr-container svg,
        .qr-container img {
            width: 120px !important;
            height: 120px !important;
        }

        .secret-warning {
            padding: 6px 8px;

            margin-bottom: 7px;

            font-size: 10.5px;

            line-height: 1.25;
        }

        .two-factor-card label {
            font-size: 11px;

            margin-bottom: 3px;
        }

        .two-factor-input {
            padding: 7px;

            font-size: 16px;

            letter-spacing: 4px;

            margin: 4px 0 7px;
        }

        .two-factor-button {
            padding: 8px;

            font-size: 12px;
        }

        .cancel-link {
            margin-top: 6px;

            font-size: 11px;
        }
    }


    /* ==========================================
       PANTALLAS EXTREMADAMENTE BAJAS
       ========================================== */

    @media (min-width: 800px) and (max-height: 500px) {

        body {
            padding-top: 5px;
            padding-bottom: 10px;
        }

        .two-factor-card {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .qr-container svg,
        .qr-container img {
            width: 100px !important;
            height: 100px !important;
        }

        .two-factor-description {
            display: none;
        }

        .secret-warning {
            font-size: 10px;

            padding: 5px 7px;
        }
    }
</style>
</head>

<body>

<div class="two-factor-card">

    <div class="two-factor-icon">
        🔐
    </div>

    <h1>Configurar autenticación de dos factores</h1>

    <p class="two-factor-description">
        Para proteger tu cuenta, configura la autenticación de dos factores.
        Escanea el código QR con una aplicación autenticadora como
        Google Authenticator o Microsoft Authenticator.
    </p>

    <div class="qr-container">
    {!! $qrCode !!}
</div>

    <div class="secret-warning">
        <strong>Importante</strong>
        Si no puedes escanear el código QR, utiliza la clave de configuración
        de tu aplicación autenticadora.
    </div>

    @if ($errors->any())
        <div class="two-factor-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.enable') }}">
        @csrf

        <label for="one_time_password">
            Ingresa el código de 6 dígitos
        </label>

        <input
            type="text"
            id="one_time_password"
            name="one_time_password"
            class="two-factor-input"
            inputmode="numeric"
            autocomplete="one-time-code"
            maxlength="6"
            pattern="[0-9]{6}"
            required>

        <button type="submit" class="two-factor-button">
            Activar autenticación de dos factores
        </button>
    </form>

    <a href="{{ route('two-factor.cancel') }}" class="cancel-link">
        Cancelar
    </a>
</div>
</body>
</html>