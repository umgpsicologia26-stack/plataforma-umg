<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, viewport-fit=cover">

    <title>Acceso Administrativo</title>

    <link rel="stylesheet" href="{{ asset('css/access.css') }}">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="admin-card">

    <div class="logo">
        <i class="fas fa-user-shield"></i>
        <h1>Acceso Administrativo</h1>
        <p>Panel de Gestión</p>
    </div>

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/admin-access">

        @csrf

        <div class="form-group">

            <label>
                Contraseña de Administrador
            </label>

            <input
                type="password"
                name="password"
                placeholder="Ingrese la contraseña"
                autocomplete="current-password"
                required>

        </div>

        <button
            type="submit"
            class="admin-btn">

            <i class="fas fa-lock"></i>
            Ingresar

        </button>

    </form>

    <a href="/dashboard" class="back-btn">

        <i class="fas fa-arrow-left"></i>

        Regresar al Dashboard

    </a>

    <div class="security-info">

        <h4>
            Seguridad
        </h4>

        <p>
            Este acceso está restringido únicamente a administradores autorizados.
        </p>

    </div>

</div>

</body>
</html>