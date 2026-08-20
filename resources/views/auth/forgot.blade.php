<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/recovery.css') }}">
</head>
<body>
    <main class="recovery-card">
        <a href="{{ url('/login') }}" class="back-btn">← Regresar al inicio de sesión</a>

        <div class="recovery-icon"></div>

        <h1>Recuperar contraseña</h1>

        <p>
            Ingresa el correo electrónico asociado a tu cuenta.
            Recibirás un código de recuperación de 6 dígitos con una vigencia de 3 minutos.
        </p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/forgot-password') }}">
            @csrf

            <div class="input-field">
                <label for="email">Correo electrónico</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    maxlength="150"
                    autocomplete="email"
                    required>
            </div>

            <button type="submit" class="recovery-btn">
                Enviar código de recuperación
            </button>
        </form>
    </main>
</body>
</html>
