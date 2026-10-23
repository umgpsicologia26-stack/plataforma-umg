<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verificación de seguridad - UMG</title>

    <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
            href="{{ asset('css/style.css') }}">

    <style>
        .two-factor-card {
            width: 100%;
            max-width: 450px;
            margin: 80px auto;
            padding: 35px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.10);
            text-align: center;
        }

        .two-factor-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .two-factor-card h1 {
            margin-bottom: 12px;
            color: #222;
        }

        .two-factor-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .two-factor-input {
            width: 100%;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 22px;
            text-align: center;
            letter-spacing: 8px;
            margin: 10px 0 18px;
        }

        .two-factor-input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .two-factor-button {
            width: 100%;
            border: none;
            padding: 14px;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .two-factor-button:hover {
            opacity: 0.9;
        }

        .two-factor-error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: left;
        }

        .cancel-link {
            display: inline-block;
            margin-top: 18px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
        }

        .cancel-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="two-factor-card">

    <div class="two-factor-icon">
        🔐
    </div>

    <h1>Verificación de seguridad</h1>

    <p class="two-factor-description">
        Tu cuenta tiene activada la autenticación de dos factores.
        Abre tu aplicación autenticadora e ingresa el código de 6 dígitos
        que aparece en ella.
    </p>

    @if ($errors->any())
        <div class="two-factor-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.verify') }}">
        @csrf

        <label for="one_time_password">
            Código de autenticación
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
            required
            autofocus
        >

        <button type="submit" class="two-factor-button">
            Verificar código
        </button>
    </form>

    <a href="{{ route('two-factor.cancel') }}" class="cancel-link">
        Cancelar e iniciar sesión nuevamente
    </a>

</div>
</body>
</html>