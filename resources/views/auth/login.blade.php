<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="google-login-url" content="{{ route('google.login') }}">

@vite('resources/js/app.js')

<title>UMG</title>

<link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet"
        href="{{ asset('css/style.css') }}">

<style>
    /*
    |--------------------------------------------------------------------------
    | VENTANA DE BLOQUEO
    |--------------------------------------------------------------------------
    */

    .bruteforce-overlay {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;

        background: rgba(0, 0, 0, 0.55);

        display: flex;
        align-items: center;
        justify-content: center;

        z-index: 99999;
    }

    .bruteforce-modal {
        width: 360px;
        max-width: calc(100% - 40px);

        background: #ffffff;
        border-radius: 18px;

        padding: 30px 25px;

        text-align: center;

        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);

        animation: bruteForceAppear 0.25s ease-out;
    }

    .bruteforce-icon {
        width: 65px;
        height: 65px;

        margin: 0 auto 18px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #f3f3f3;

        font-size: 28px;
    }

    .bruteforce-modal h2 {
        margin: 0 0 15px;

        font-size: 22px;
    }

    .bruteforce-modal p {
        margin: 8px 0;

        font-size: 15px;

        line-height: 1.5;
    }

    .bruteforce-modal button {
        margin-top: 20px;

        width: 100%;

        padding: 12px 20px;

        border: none;
        border-radius: 8px;

        cursor: pointer;

        font-size: 15px;
        font-weight: 600;

        background: #333;
        color: #fff;
    }

    .bruteforce-modal button:hover {
        opacity: 0.9;
    }

    @keyframes bruteForceAppear {

        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }

    }
</style>

</head>

<body>

<div class="main-card">

<!-- IZQUIERDA -->

<div class="form-side">

    <div id="loginContainer">

        <div class="back-home">

            <a href="/">
                <i class="fas fa-arrow-left"></i>
                Regresar
            </a>

        </div>

        <h1>Iniciar Sesión</h1>

        @if(session('success'))

            <div class="alert-success">
                {{ session('success') }}
            </div>

        @endif

        {{--
        |--------------------------------------------------------------------------
        | ERROR NORMAL
        |--------------------------------------------------------------------------
        | Solo mostrarlo cuando NO sea una cuenta bloqueada.
        --}}

        @if(session('error') && !session('accountBlocked'))
    <div id="loginErrorModal" class="phone-modal">
        <div class="phone-modal-box">

            <div class="phone-modal-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>

            <h3>
                Inicio de sesión
            </h3>

            <p id="loginErrorModalMessage">
                {{ session('error') }}
            </p>

            <button type="button"
                    id="loginErrorModalAccept">
                Aceptar
            </button>

        </div>
    </div>
@endif

        <form method="POST"
            action="/login">

            @csrf

            <div class="input-field">

                <label for="login_email">
                    Email
                </label>

                <input type="email"
                        name="email"
                        id="login_email"
                        autocomplete="email"
                        required>

            </div>


            <div class="input-field">

                <label for="login_password">
                    Contraseña
                </label>

                <input type="password"
                        name="password"
                        id="login_password"
                        autocomplete="current-password"
                        required>

            </div>


            <button type="submit"
                    class="signup-btn">

                Iniciar Sesión

            </button>


            <div class="forgot-password">

                <a href="/forgot-password">
                    ¿Olvidaste tu contraseña?
                </a>

                @if(session('showRecovery') && !session('bruteForceBlocked'))

                    <div class="recovery-options">

                        <a href="/forgot-password-email">
                                Recuperar por Correo
                        </a>

                        <a href="/forgot-password-phone">
                                Recuperar por Celular
                        </a>

                    </div>

                @endif

            </div>

        </form>


        <!-- DIVIDER -->

        <div class="divider">

            <span>
                o continuar con
            </span>

        </div>


        <!-- GOOGLE -->

        <button type="button"
                class="google-btn" id="googleLoginButton">

            <i class="fab fa-google"></i>

            Continuar con Google

        </button>


        <!-- CREAR CUENTA -->

        <button type="button"
                class="create-email-btn" id="createEmailButton">

            <i class="fas fa-user-plus"></i>

            Crear una cuenta

        </button>

    </div>


    <!-- REGISTRO -->

    <div class="register-form"
            id="registerForm">

        <div class="back-arrow" id="backToLoginButton">

            <i class="fas fa-arrow-left"></i>

        </div>

        <h1>
            Crear Cuenta
        </h1>


        <form method="POST"
                action="/register"
                novalidate>

            @csrf


            <div class="input-field">

                <label for="register_first_name">
                    Nombre
                </label>

                <input type="text"
                        name="first_name"
                        id="register_first_name"
                        autocomplete="given-name"
                        required>

            </div>


            <div class="input-field">

                <label for="register_last_name">
                    Apellido
                </label>

                <input type="text"
                        name="last_name"
                        id="register_last_name"
                        autocomplete="family-name"
                        required>

            </div>


            <div class="input-field">

                <label for="register_nickname">
                    Nickname
                </label>

                <input type="text"
                        name="anonymous_nickname"
                        id="register_nickname"
                        autocomplete="off"
                        maxlength="80"
                        required
                        placeholder="Elige tu nickname">

                <small>
                    Este nickname podrá utilizarse de forma anónima en el foro.
                </small>

            </div>


            <div class="input-field">

                <label for="register_birth_date">
                    Fecha Nacimiento
                </label>

                <input type="date"
                        name="birth_date"
                        id="register_birth_date"
                        autocomplete="off"
                        min="{{ now()->subYears(100)->format('Y-m-d') }}"
                        max="{{ now()->subYears(15)->format('Y-m-d') }}"
                        required>

                <small id="birthDateError"
                        style="display:none;">

                    Debes tener entre 15 y 100 años.

                </small>

            </div>


            <div class="input-field">

                <label for="register_phone">
                    Celular
                </label>

                <input type="text"
                        name="phone"
                        id="register_phone"
                        autocomplete="tel"
                        inputmode="tel"
                        maxlength="20"
                        required>

            </div>


            <div class="input-field">

                <label for="register_email">
                    Correo
                </label>

                <input type="email"
                        name="email"
                        id="register_email"
                        autocomplete="email"
                        required>

                <small id="emailError"
                        style="display:none;">

                    Ingresa un correo válido.
                    Ejemplo: juanperez03@gmail.com

                </small>

            </div>


            <div class="input-field">

                <label for="register_password">
                    Contraseña
                </label>

                <input type="password"
                        name="password"
                        id="register_password"
                        autocomplete="new-password"
                        required>

            </div>


            <button type="submit"
                    class="signup-btn">

                Registrarme

            </button>

        </form>

    </div>

</div>


<!-- DERECHA -->

<div class="image-side">

    <div class="logo-container">

        <img src="{{ asset('images/logo1.png') }}"
            alt="Logo UMG">

        <p class="logo-text">

            A veces, el acto más valiente es hablar de aquello que más te duele.

            <br>
            <br>

            <span>
                - Robin Williams -
            </span>

        </p>

    </div>

</div>

</div>

<!-- VENTANA DE AVISO CELULAR -->

<div id="phoneModal"
    class="phone-modal">

<div class="phone-modal-box">

    <div class="phone-modal-icon">

        <i class="fas fa-mobile-alt"></i>

    </div>

    <h3>
        Celular no válido
    </h3>

    <p>

        El celular solo puede contener
        números, espacios y el signo +.
        No se permiten letras ni guiones.

        <br>
        <br>

        Ejemplo:

        <br>

        <strong>
            +502 57896578
        </strong>

        o

        <strong>
            57896578
        </strong>

    </p>

    <button type="button"
            id="phoneModalAccept">

        Aceptar

    </button>

</div>

</div>

<!-- VENTANA DE AVISO CORREO -->

<div id="emailModal"
    class="phone-modal">

<div class="phone-modal-box">

    <div class="phone-modal-icon">

        <i class="fas fa-envelope"></i>

    </div>

    <h3>
        Correo no válido
    </h3>

    <p id="emailModalMessage">

        Ingresa un correo válido.

        <br>

        Ejemplo:

        <strong>
            juanperez03@gmail.com
        </strong>

    </p>

    <button type="button"
            id="emailModalAccept">

        Aceptar

    </button>

</div>

</div>

<!-- VENTANA DE AVISO FECHA DE NACIMIENTO -->

<div id="birthDateModal"
    class="phone-modal">

<div class="phone-modal-box">

    <div class="phone-modal-icon">

        <i class="fas fa-calendar-times"></i>

    </div>

    <h3>
        Fecha de nacimiento no válida
    </h3>

    <p id="birthDateModalMessage">

        Ingresa una fecha de nacimiento real.

    </p>

    <button type="button"
            id="birthDateModalAccept">

        Aceptar

    </button>

</div>

</div>

<!-- VENTANA DE AVISO CON TODOS LOS ERRORES -->

<div id="formErrorsModal"
    class="phone-modal">

<div class="phone-modal-box">

    <div class="phone-modal-icon">

        <i class="fas fa-exclamation-triangle"></i>

    </div>

    <h3>
        Revisa los siguientes datos
    </h3>

    <ul id="formErrorsList"
        style="text-align:left; margin:0; padding-left:20px;">
    </ul>

    <button type="button"
            id="formErrorsAccept">

        Aceptar

    </button>

</div>


</div>

<!-- FIREBASE -->

<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js"></script>

<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-auth-compat.js"></script>



{{--                                                                       |
| -------------------------------------------------------------------------- |
| VENTANA DE CUENTA BLOQUEADA                                                |
| -------------------------------------------------------------------------- |
|                                                                            |
| IMPORTANTE:                                                                |
| Esta ventana aparece si AuthController envÃ­a:                              |
|                                                                            |
| session('accountBlocked')                                                  |
|                                                                            |
| --}}                                                                       

@if(session('accountBlocked'))

<div class="bruteforce-overlay"
    id="bruteForceModal">


<div class="bruteforce-modal">

    <div class="bruteforce-icon">

        <i class="fas fa-lock"></i>

    </div>


    <h2>
        Cuenta bloqueada
    </h2>


    <p>
        Tu cuenta se encuentra bloqueada.
    </p>


    <p>
        Contacta a un administrador.
    </p>


    <button type="button"
            id="closeBruteForceModalButton">

        Entendido

    </button>

</div>


</div>

@endif

</body>

</html>