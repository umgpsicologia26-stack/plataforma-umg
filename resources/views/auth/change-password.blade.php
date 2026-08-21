<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualiza tu contraseña</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f7fb;
            font-family: Arial, sans-serif;
        }

        .card {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.10);
        }

        .icon {
            text-align: center;
            font-size: 45px;
            margin-bottom: 15px;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .description {
            text-align: center;
            color: #666;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 15px;
        }

        button {
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

        button:hover {
            opacity: 0.9;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="card">

    <div class="icon">
        🔐
    </div>

    <h1>Actualiza tu contraseña</h1>

    <p class="description">
        Por seguridad, debes actualizar tu contraseña
        antes de continuar utilizando VitaSafe.
    </p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('password.update') }}">

        @csrf

        <label for="password">
            Nueva contraseña
        </label>

        <input
            type="password"
            id="password"
            name="password"
            required
            minlength="8"
            autocomplete="new-password">

        <label for="password_confirmation">
            Confirmar contraseña
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            minlength="8"
            autocomplete="new-password">

        <button type="submit">
            Actualizar contraseña
        </button>

    </form>

</div>

</body>

</html>