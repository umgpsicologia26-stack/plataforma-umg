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

        /* CONTENEDOR */

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

        /* ALERTAS */

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

        /* TARJETAS */

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

        /* FORMULARIOS */

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

        .profile-error-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.profile-error-modal-content {
    position: relative;
    width: 100%;
    max-width: 450px;
    background: #ffffff;
    border-radius: 18px;
    padding: 35px 30px 30px;
    text-align: center;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
    animation: profileErrorAppear 0.25s ease-out;
}

.profile-error-close {
    position: absolute;
    top: 12px;
    right: 16px;
    border: none;
    background: transparent;
    font-size: 28px;
    color: #64748b;
    cursor: pointer;
}

.profile-error-close:hover {
    color: #1e293b;
}

.profile-error-icon {
    width: 65px;
    height: 65px;
    margin: 0 auto 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fef3c7;
    color: #d97706;
    font-size: 28px;
}

.profile-error-modal-content h3 {
    margin: 0 0 12px;
    font-size: 22px;
    color: #1e293b;
}

.profile-error-modal-content p {
    margin: 0 auto 25px;
    max-width: 360px;
    line-height: 1.6;
    color: #475569;
    font-size: 15px;
}

.profile-error-button {
    border: none;
    border-radius: 10px;
    padding: 11px 25px;
    background: #2563eb;
    color: #ffffff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

.profile-error-button:hover {
    background: #1d4ed8;
}

@keyframes profileErrorAppear {
    from {
        opacity: 0;
        transform: translateY(-15px) scale(0.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .page-container {
                width: 92%;
                margin-top: 25px;
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

    {{-- CONTENIDO DEL PERFIL --}}

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

        {{-- MENSAJE DE ERROR --}}
        @if(session('error'))
    <div id="profileErrorModal" class="profile-error-modal">
        <div class="profile-error-modal-content">
            <button type="button"
                    class="profile-error-close"
                    onclick="closeProfileErrorModal()">
                &times;
            </button>

            <div class="profile-error-icon">
                <i class="fas fa-clock"></i>
            </div>

            <h3>Actualización no disponible</h3>

            <p>
                {{ session('error') }}
            </p>

            <button type="button"
                    class="profile-error-button"
                    onclick="closeProfileErrorModal()">
                Entendido
            </button>
        </div>
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


            {{-- INFORMACIÓN PERSONAL --}}

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
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}"
                                    maxlength="150"
                                    required
                                >

                                @error('email')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror
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


            {{-- CAMBIO DE CONTRASEÑA --}}

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


        {{-- VOLVER SEGÚN ROL --}}

        <div class="back-container">

            @if(auth()->check() && auth()->user()->role === 'ADMIN')

                {{-- ADMIN REGRESA AL ADMIN PANEL --}}

                <a href="{{ url('/admin-panel') }}"
                    class="btn btn-back">

                    <i class="fas fa-arrow-left"></i>

                    Volver

                </a>

            @else

                {{-- USUARIO / MODERADOR REGRESA AL DASHBOARD --}}

                <a href="{{ url('/dashboard') }}"
                    class="btn btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Volver al inicio
                </a>
            @endif
        </div>
    </main>
    <script>
    function closeProfileErrorModal() {
        const modal = document.getElementById('profileErrorModal');

        if (modal) {
            modal.remove();
        }
    }
</script>
</body>
</html>