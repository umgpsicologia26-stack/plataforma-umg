<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mi perfil - UMG Xela</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #111827;
            overflow-x: hidden;
        }

        /* =========================
           NAVBAR
        ========================== */

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
            gap: 15px;
        }

        .nav-center a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: #f1f5f9;
            border-radius: 14px;
            text-decoration: none;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            transition: .3s ease;
        }

        .nav-center a:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-2px);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
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

        .profile-btn {
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
        }

        .admin-btn {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
        }

        /* =========================
           CONTENEDOR
        ========================== */

        .page-container {
            width: 95%;
            max-width: 1100px;
            margin: 40px auto 70px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #64748b;
            font-size: 1rem;
        }

        /* =========================
           ALERTAS
        ========================== */

        .alert {
            border-radius: 15px;
            padding: 15px 18px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin: 8px 0 0 20px;
        }

        /* =========================
           TARJETAS
        ========================== */

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .card-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header i {
            color: #2563eb;
            font-size: 21px;
        }

        .card-header h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #111827;
        }

        .card-body {
            padding: 30px;
        }

        /* =========================
           FORMULARIOS
        ========================== */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 13px;
            background: white;
            color: #111827;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            outline: none;
            transition: .2s ease;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .form-control:disabled {
            background: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
        }

        .help-text {
            margin-top: 7px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
        }

        .is-invalid {
            border-color: #dc2626;
        }

        .form-actions {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            border: none;
            padding: 13px 22px;
            border-radius: 13px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .25s ease;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .back-container {
            margin-top: 25px;
            text-align: center;
        }

        .btn-back {
            background: white;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .btn-back:hover {
            background: #f1f5f9;
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 1000px) {

            .navbar {
                flex-direction: column;
                gap: 18px;
                padding: 20px;
            }

            .nav-center {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-right {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 700px) {

            .page-container {
                width: 92%;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: auto;
            }

            .card-body {
                padding: 22px;
            }

            .card-header {
                padding: 20px 22px;
            }

            .nav-center a {
                width: 100%;
                justify-content: center;
            }

            .nav-right {
                flex-direction: column;
            }

            .profile-btn,
            .admin-btn,
            .logout-btn {
                width: 100%;
                justify-content: center;
            }

            .form-actions {
                justify-content: stretch;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    {{-- =========================
         NAVBAR
    ========================== --}}

    <nav class="navbar">

        <div class="nav-left">
            <div class="brand">
                <h2>UMG</h2>
            </div>
        </div>

        <div class="nav-center">

            <a href="{{ url('/dashboard') }}">
                <i class="fas fa-home"></i>
                Inicio
            </a>

            <a href="{{ url('/forum') }}">
                <i class="fas fa-comments"></i>
                Foro
            </a>

            <a href="{{ url('/evaluation') }}">
                <i class="fas fa-brain"></i>
                Evaluación
            </a>

            <a href="{{ url('/cases') }}">
                <i class="fas fa-folder-open"></i>
                Casos
            </a>

            <a href="{{ route('profile.edit') }}">
                <i class="fas fa-user"></i>
                Mi perfil
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

                <form method="POST"
                      action="{{ route('logout') }}"
                      style="margin:0;">

                    @csrf

                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar sesión
                    </button>

                </form>

            @endauth

        </div>

    </nav>


    {{-- =========================
         CONTENIDO
    ========================== --}}

    <main class="page-container">

        <div class="page-header">

            <h1>
                Mi perfil
            </h1>

            <p>
                Administra la información asociada a tu cuenta.
            </p>

        </div>


        {{-- MENSAJE DE ÉXITO --}}

        @if(session('success'))

            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>

        @endif


        {{-- ÉXITO CONTRASEÑA --}}

        @if(session('password_success'))

            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                {{ session('password_success') }}
            </div>

        @endif


        {{-- ERRORES --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Revisa los siguientes errores:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="profile-grid">


            {{-- =========================
                 INFORMACIÓN PERSONAL
            ========================== --}}

            <section class="card">

                <div class="card-header">

                    <i class="fas fa-user-circle"></i>

                    <h2>
                        Información personal
                    </h2>

                </div>

                <div class="card-body">

                    <form action="{{ route('profile.update') }}"
                          method="POST">

                        @csrf
                        @method('PUT')


                        <div class="form-grid">


                            {{-- NOMBRE --}}

                            <div class="form-group">

                                <label for="first_name">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    maxlength="100"
                                    required
                                >

                                @error('first_name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- APELLIDO --}}

                            <div class="form-group">

                                <label for="last_name">
                                    Apellido
                                </label>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    maxlength="100"
                                    required
                                >

                                @error('last_name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- CORREO --}}

                            <div class="form-group full-width">

                                <label for="email">
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ $user->email }}"
                                    disabled
                                >

                                <span class="help-text">
                                    El correo electrónico no puede modificarse desde esta sección.
                                </span>

                            </div>


                            {{-- TELÉFONO --}}

                            <div class="form-group">

                                <label for="phone">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}"
                                    maxlength="20"
                                >

                                @error('phone')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- NICKNAME --}}

                            <div class="form-group">

                                <label for="anonymous_nickname">
                                    Nickname anónimo
                                </label>

                                <input
                                    type="text"
                                    id="anonymous_nickname"
                                    name="anonymous_nickname"
                                    class="form-control @error('anonymous_nickname') is-invalid @enderror"
                                    value="{{ old('anonymous_nickname', $user->anonymous_nickname) }}"
                                    maxlength="80"
                                    required
                                >

                                @error('anonymous_nickname')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <span class="help-text">
                                    Este nombre puede utilizarse para proteger tu identidad dentro de la plataforma.
                                </span>

                            </div>

                        </div>


                        <div class="form-actions">

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="fas fa-save"></i>

                                Guardar cambios

                            </button>

                        </div>

                    </form>

                </div>

            </section>


            {{-- =========================
                 CAMBIO DE CONTRASEÑA
            ========================== --}}

            <section class="card">

                <div class="card-header">

                    <i class="fas fa-lock"></i>

                    <h2>
                        Cambiar contraseña
                    </h2>

                </div>

                <div class="card-body">

                    <form action="{{ route('profile.password.update') }}"
                          method="POST">

                        @csrf
                        @method('PUT')


                        <div class="form-grid">


                            {{-- CONTRASEÑA ACTUAL --}}

                            <div class="form-group full-width">

                                <label for="current_password">
                                    Contraseña actual
                                </label>

                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    required
                                >

                                @error('current_password')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- NUEVA CONTRASEÑA --}}

                            <div class="form-group">

                                <label for="password">
                                    Nueva contraseña
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    minlength="8"
                                    required
                                >

                                @error('password')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <span class="help-text">
                                    Debe contener al menos 8 caracteres.
                                </span>

                            </div>


                            {{-- CONFIRMAR --}}

                            <div class="form-group">

                                <label for="password_confirmation">
                                    Confirmar nueva contraseña
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    minlength="8"
                                    required
                                >

                            </div>

                        </div>


                        <div class="form-actions">

                            <button type="submit"
                                    class="btn btn-warning">

                                <i class="fas fa-key"></i>

                                Cambiar contraseña

                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>


        {{-- VOLVER --}}

        <div class="back-container">

            <a href="{{ url('/dashboard') }}"
               class="btn btn-back">

                <i class="fas fa-arrow-left"></i>

                Volver al inicio

            </a>

        </div>

    </main>

</body>
</html>
