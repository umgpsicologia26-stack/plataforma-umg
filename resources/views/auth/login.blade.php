<!DOCTYPE html>
    <html lang="es">
        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
                    <label>Email</label>
                    <input type="email"
                        name="email"
                        required>

                    </div>
                <div class="input-field">
                    <label>Contraseña</label>
                    <input type="password"
                        name="password"
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
                    <label>Nombre</label>
                    <input type="text"
                        name="first_name"
                        required>
                    
                </div>

                <div class="input-field">
                    <label>Apellido</label>
                    <input type="text"
                        name="last_name"
                        required>                    
                </div>

                <div class="input-field">
            <label>Nickname</label>
            <input
                type="text"
                name="anonymous_nickname"
                maxlength="80"
                required
                placeholder="Elige tu nickname">
                <small>
    Este nickname podrá utilizarse de forma anónima en el foro.
</small>
        </div>
                <div class="input-field">
                    <label>Fecha Nacimiento</label>
                    <input type="date"
                        name="birth_date"
                        required>
                </div>

                <div class="input-field">
                    <label>Celular</label>
                    <input type="text"
                        name="phone"
                        required>                   
                </div>

                <div class="input-field">
                    <label>Correo</label>
                    <input type="email"
                        name="email"
                        required>
                </div>

                <div class="input-field">
                    <label>Contraseña</label>
                    <input type="password"
                        name="password"
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
    apiKey: "TU_API_KEY",
    authDomain: "TU_DOMINIO",
    projectId: "TU_PROJECT_ID",
    storageBucket: "TU_BUCKET",
    messagingSenderId: "TU_SENDER",
    appId: "TU_APP_ID"
};
firebase.initializeApp(firebaseConfig);

    /*GOOGLE LOGIN*/
async function googleLogin(){
    const provider =
        new firebase.auth.GoogleAuthProvider();
    provider.setCustomParameters({
        prompt: 'select_account'
    });
    try{
        await firebase
            .auth()
            .signInWithPopup(provider);
        window.location.href =
            '/dashboard';
    }catch(error){
        alert(error.message);
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