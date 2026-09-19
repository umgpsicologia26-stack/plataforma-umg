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
        inputmode="tel"
        maxlength="20"
        required>
</div>

                <div class="input-field">
    <label for="register_email">Correo</label>
    <input type="email"
        name="email"
        id="register_email"
        autocomplete="email"
        required>
    <small id="emailError" style="display:none;">
        Ingresa un correo válido. Ejemplo: juanperez03@gmail.com
    </small>
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

<!-- VENTANA DE AVISO CELULAR -->

<div
    id="phoneModal"
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

            <br><br>

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


        <button
            type="button"
            id="phoneModalAccept">

            Aceptar

        </button>

    </div>

</div>

<!-- VENTANA DE AVISO CORREO -->
<div id="emailModal" class="phone-modal">

    <div class="phone-modal-box">

        <div class="phone-modal-icon">
            <i class="fas fa-envelope"></i>
        </div>

        <h3>Correo no válido</h3>

        <p id="emailModalMessage">
            Ingresa un correo válido.
            <br>
            Ejemplo:
            <strong>juanperez03@gmail.com</strong>
        </p>

        <button type="button" id="emailModalAccept">
            Aceptar
        </button>

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

        const result =  
            await firebase  
                .auth()  
                .signInWithPopup(provider);  

        const user =  
            result.user;  

        const idToken =  
            await user.getIdToken();   
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

        if (!response.ok) {  

            throw new Error(  
                data.message ||  
                'No fue posible iniciar sesión con Google.'  
            );  
        }  

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

/* ========================= */
/* VALIDACIONES */
/* ========================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const registerForm =
            document.getElementById("registerForm");

        const phoneInput =
            document.getElementById("register_phone");

        const emailInput =
            document.getElementById("register_email");

        const phoneModal =
            document.getElementById("phoneModal");

        const phoneModalAccept =
            document.getElementById("phoneModalAccept");

        const emailModal =
            document.getElementById("emailModal");

        const emailModalAccept =
            document.getElementById("emailModalAccept");

        const emailModalMessage =
            document.getElementById("emailModalMessage");


        /* ========================= */
        /* CERRAR VENTANA CELULAR */
        /* ========================= */

        if (phoneModalAccept) {

            phoneModalAccept.addEventListener(
                "click",
                function () {

                    phoneModal.classList.remove("show");

                    if (phoneInput) {
                        phoneInput.focus();
                    }

                }
            );

        }


        /* ========================= */
        /* CERRAR VENTANA CORREO */
        /* ========================= */

        if (emailModalAccept) {

            emailModalAccept.addEventListener(
                "click",
                function () {

                    emailModal.classList.remove("show");

                    if (emailInput) {
                        emailInput.focus();
                    }

                }
            );

        }


        /* ========================= */
        /* CELULAR - BLOQUEO */
        /* ========================= */

        if (phoneInput) {

            phoneInput.addEventListener(
                "beforeinput",
                function (event) {

                    if (
                        event.inputType === "insertText" &&
                        event.data
                    ) {

                        const texto = event.data;

                        /*
                         * Solo números,
                         * espacios y signo +.
                         */

                        if (!/^[0-9+ ]+$/.test(texto)) {

                            event.preventDefault();

                            phoneModal.classList.add("show");

                            return;
                        }


                        /*
                         * El signo + solamente
                         * puede estar al inicio.
                         */

                        if (
                            texto.includes("+") &&
                            this.value.length > 0
                        ) {

                            event.preventDefault();

                            phoneModal.classList.add("show");

                            return;
                        }

                    }

                }
            );


            /* ========================= */
            /* LIMPIEZA DEL CELULAR */
            /* ========================= */

            phoneInput.addEventListener(
                "input",
                function () {

                    let value = this.value;


                    /*
                     * Detectar caracteres inválidos.
                     */

                    if (/[^0-9+ ]/.test(value)) {

                        phoneModal.classList.add("show");

                    }


                    /*
                     * Eliminar letras,
                     * guiones y otros símbolos.
                     */

                    value = value.replace(
                        /[^0-9+ ]/g,
                        ""
                    );


                    /*
                     * Si existe +,
                     * dejar solamente uno.
                     */

                    if (value.includes("+")) {

                        const numbers =
                            value.replace(/\+/g, "");

                        value = "+" + numbers;

                    }


                    /*
                     * El + siempre debe
                     * quedar al inicio.
                     */

                    if (
                        value.includes("+") &&
                        !value.startsWith("+")
                    ) {

                        value =
                            "+" +
                            value.replace(/\+/g, "");

                    }


                    this.value = value;

                }
            );

        }


        /* ========================= */
        /* VALIDACIÓN AL ENVIAR */
        /* ========================= */

        if (registerForm) {

            registerForm.addEventListener(
                "submit",
                function (event) {


                    /* ========================= */
                    /* CELULAR */
                    /* ========================= */

                    const phone =
                        phoneInput.value.trim();


                    /*
                     * CELULAR VACÍO
                     */

                    if (phone === "") {

                        event.preventDefault();

                        phoneModal.classList.add("show");

                        phoneInput.focus();

                        return;
                    }


                    /*
                     * Solo +, números y espacios.
                     */

                    if (
                        !/^\+?[0-9 ]+$/.test(phone)
                    ) {

                        event.preventDefault();

                        phoneModal.classList.add("show");

                        phoneInput.focus();

                        return;
                    }


                    /*
                     * El + solamente puede
                     * estar al inicio.
                     */

                    if (
                        phone.includes("+") &&
                        !phone.startsWith("+")
                    ) {

                        event.preventDefault();

                        phoneModal.classList.add("show");

                        phoneInput.focus();

                        return;
                    }


                    /* ========================= */
                    /* CORREO */
                    /* ========================= */

                    const email =
                        emailInput.value.trim();


                    /*
                     * CORREO VACÍO
                     */

                    if (email === "") {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "Ingresa un correo válido. Ejemplo: majoreyna432@gmail.com.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * CONTAR @
                     */

                    const atCount =
                        (
                            email.match(/@/g) || []
                        ).length;


                    /*
                     * FALTA @
                     */

                    if (atCount === 0) {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "Error en correo: falta @. Ejemplo: majoreyna432@gmail.com.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * MÁS DE UNA @
                     */

                    if (atCount !== 1) {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "El correo debe contener solamente una @. Ejemplo: majoreyna432@gmail.com.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * SEPARAR USUARIO Y DOMINIO
                     */

                    const parts =
                        email.split("@");

                    const username =
                        parts[0];

                    const domain =
                        parts[1];


                    /*
                     * ANTES DE @
                     *
                     * Solo letras y números.
                     */

                    if (
                        !/^[A-Za-z0-9]+$/.test(username)
                    ) {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "Antes de @ solo se permiten letras y números. Ejemplo: majoreyna432@gmail.com.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * DOMINIO VACÍO
                     */

                    if (!domain) {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "Error en correo: falta el dominio. Ejemplo: majoreyna432@gmail.com.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * NO PERMITIR NÚMEROS
                     * DESPUÉS DE @
                     */

                    if (/[0-9]/.test(domain)) {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "Después de @ no se permiten números. Ejemplo: majoreyna432@gmail.com.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * DOMINIO VÁLIDO
                     *
                     * Ejemplos:
                     * gmail.com
                     * outlook.com
                     * yahoo.com
                     * miumg.edu.gt
                     */

                    const domainPattern =
                        /^[A-Za-z]+(?:\.[A-Za-z]+)+$/;


                    if (!domainPattern.test(domain)) {

                        event.preventDefault();

                        emailModalMessage.textContent =
                            "Después de @ solo se permiten dominios válidos como gmail.com, yahoo.com, outlook.com o miumg.edu.gt.";

                        emailModal.classList.add("show");

                        emailInput.focus();

                        return;
                    }


                    /*
                     * CORREO CORRECTO
                     *
                     * No hacemos nada.
                     * El formulario continúa normalmente.
                     */

                }
            );

        }

    }
);

</script>
</body>
</html>