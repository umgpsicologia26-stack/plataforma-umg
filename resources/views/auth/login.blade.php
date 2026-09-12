<!DOCTYPE html>
    <html lang="es">
        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>UMG</title>
            <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet"
                    href="{{ asset('css/style.css') }}">
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
@if(session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>

    @endif
            <form method="POST"
                action="/login">
                @csrf
                <div class="input-field">
                    <label for="login_email">Email</label>
                    <input type="email"
                        name="email"
                        id="login_email"
                        autocomplete="email"
                        required>

                    </div>
                <div class="input-field">
                    <label for="login_password">Contraseña</label>
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

        @if(session('showRecovery'))
<div class="recovery-options">
    <a href="/forgot-password-email">
        📧 Recuperar por Correo
    </a>

    <a href="/forgot-password-phone">
        📱 Recuperar por Celular
    </a>
</div>

@endif
</div>
            </form>

            <!-- DIVIDER -->
            <div class="divider">
                <span>o continuar con</span>
            </div>

            <!-- GOOGLE -->
            <button type="button"
                    class="google-btn"
                    onclick="googleLogin()">
                <i class="fab fa-google"></i>
                Continuar con Google
            </button>

            <!-- CREAR CUENTA -->
                <button type="button"
                    class="create-email-btn"
                    onclick="toggleRegisterForm()">
                <i class="fas fa-user-plus"></i>
                Crear una cuenta
            </button>
        </div>

        <!-- REGISTRO -->
        <div class="register-form"
            id="registerForm">

            <!-- FLECHA -->
            <div class="back-arrow"
                onclick="backToLogin()">
                <i class="fas fa-arrow-left"></i>
            </div>

            <h1>Crear Cuenta</h1>
            <form method="POST"
                action="/register">
                @csrf

                <div class="input-field">
                    <label for="register_first_name">Nombre</label>
                    <input type="text"
                        name="first_name"
                        id="register_first_name"
                        autocomplete="given-name"
                        required>
                    
                </div>

                <div class="input-field">
                    <label for="register_last_name">Apellido</label>
                    <input type="text"
                        name="last_name"
                        id="register_last_name"
                        autocomplete="family-name"
                        required>                    
                </div>

                <div class="input-field">
            <label for="register_nickname">Nickname</label>
            <input
    type="text"
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
                    <label for="register_birth_date">Fecha Nacimiento</label>
                    <input type="date"
                    name="birth_date"
                    id="register_birth_date"
                    autocomplete="off"
                    required>
                </div>

                <div class="input-field">
                    <label for="register_phone">Celular</label>
                    <input type="text"
                        name="phone"
                        id="register_phone"
                        autocomplete="tel"
                        required>                   
                </div>

                <div class="input-field">
                    <label for="register_email">Correo</label>
                    <input type="email"
                        name="email"
                        id="register_email"
                        autocomplete="email"
                        required>
                </div>

                <div class="input-field">
                    <label for="register_password">Contraseña</label>
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
            <P class="logo-text">
                “A veces, el acto más valiente es hablar de aquello que más te duele.” 
                <br><br>
                    <span>- Robin Williams -</span>
            </P>
    </div>
    </div>

    <!-- FIREBASE -->
        <script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-auth-compat.js"></script> 
    <script> 
        const firebaseConfig = { 
    apiKey: "AIzaSyCtmqJGlHhehKOAmWrfEpuxB5gFhW1Bw10", 
    authDomain: "plataformaumg.firebaseapp.com", 
    projectId: "plataformaumg", 
    storageBucket: "plataformaumg.firebasestorage.app", 
    messagingSenderId: "2360835961", 
    appId: "1:2360835961:web:7c57c82f0028bf9621b9a8" 
}; 
 
firebase.initializeApp(firebaseConfig); 
 
    /*GOOGLE LOGIN*/ 
async function googleLogin() { 
 
    const provider = 
        new firebase.auth.GoogleAuthProvider(); 
 
    provider.setCustomParameters({ 
        prompt: 'select_account' 
    }); 
 
    try { 
 
        /* 
         * Abrir ventana de Google. 
         */ 
        const result = 
            await firebase 
                .auth() 
                .signInWithPopup(provider); 
 
        /* 
         * Obtener usuario autenticado. 
         */ 
        const user = 
            result.user; 
 
        /* 
         * Obtener ID Token de Firebase. 
         */ 
        const idToken = 
            await user.getIdToken(); 
 
        /* 
         * Enviar el token a Laravel. 
         */ 
        const response = 
            await fetch( 
                '{{ route("google.login") }}', 
                { 
                    method: 'POST', 
 
                    headers: { 
                        'Content-Type': 
                            'application/json', 
 
                        'Accept': 
                            'application/json', 
 
                        'X-CSRF-TOKEN': 
                            document 
                                .querySelector( 
                                    'meta[name="csrf-token"]' 
                                ) 
                                .getAttribute('content') 
                    }, 
 
                    body: JSON.stringify({ 
                        idToken: idToken 
                    }) 
                } 
            ); 
 
        const data = 
            await response.json(); 
 
        /* 
         * Si Laravel rechazó el inicio 
         * de sesión. 
         */ 
        if (!response.ok) { 
 
            throw new Error( 
                data.message || 
                'No fue posible iniciar sesión con Google.' 
            ); 
        } 
 
        /* 
         * Laravel creó correctamente 
         * la sesión. 
         */ 
        if (data.success) { 
 
            window.location.href = 
                data.redirect; 
        } 
 
    } catch (error) { 
 
        console.error( 
            'Error en inicio de sesión con Google:', 
            error 
        ); 
 
        alert( 
            error.message || 
            'No fue posible iniciar sesión con Google.' 
        ); 
    } 
} 
    /*MOSTRAR REGISTRO*/ 
function toggleRegisterForm(){ 
    const login = 
        document.getElementById( 
            'loginContainer' 
        ); 
    const register = 
        document.getElementById( 
            'registerForm' 
        ); 
    login.style.display = 'none'; 
    register.style.display = 'block'; 
} 
    /*REGRESAR LOGIN*/ 
function backToLogin(){ 
    const register = 
        document.getElementById( 
            'registerForm' 
        ); 
    const login = 
        document.getElementById( 
            'loginContainer' 
        ); 
    register.style.display = 'none'; 
    login.style.display = 'block'; 
} 
    </script> 
        </body> 
    </html>
