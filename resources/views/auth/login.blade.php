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
                action="/register"
                novalidate>
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
                    min="{{ now()->subYears(100)->format('Y-m-d') }}"
                    max="{{ now()->subYears(15)->format('Y-m-d') }}"
                    required>
                    <small id="birthDateError" style="display:none;">
                        Debes tener entre 15 y 100 años.
                    </small>
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

<!-- VENTANA DE AVISO FECHA DE NACIMIENTO -->
<div id="birthDateModal" class="phone-modal">

    <div class="phone-modal-box">

        <div class="phone-modal-icon">
            <i class="fas fa-calendar-times"></i>
        </div>

        <h3>Fecha de nacimiento no válida</h3>

        <p id="birthDateModalMessage">
            Ingresa una fecha de nacimiento real.
        </p>

        <button type="button" id="birthDateModalAccept">
            Aceptar
        </button>

    </div>

</div>

<!-- VENTANA DE AVISO CON TODOS LOS ERRORES -->
<div id="formErrorsModal" class="phone-modal">

    <div class="phone-modal-box">

        <div class="phone-modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <h3>Revisa los siguientes datos</h3>

        <ul id="formErrorsList" style="text-align:left; margin: 0; padding-left: 20px;">
        </ul>

        <button type="button" id="formErrorsAccept">
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

        const birthDateInput =
            document.getElementById("register_birth_date");

        const birthDateModal =
            document.getElementById("birthDateModal");

        const birthDateModalAccept =
            document.getElementById("birthDateModalAccept");

        const birthDateModalMessage =
            document.getElementById("birthDateModalMessage");

        const formErrorsModal =
            document.getElementById("formErrorsModal");

        const formErrorsList =
            document.getElementById("formErrorsList");

        const formErrorsAccept =
            document.getElementById("formErrorsAccept");

        /*
         * Rango de edad permitido.
         * Cambia estos valores si
         * necesitas otro límite.
         */
        const EDAD_MINIMA = 15;
        const EDAD_MAXIMA = 100;


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
        /* CERRAR VENTANA FECHA */
        /* ========================= */

        if (birthDateModalAccept) {

            birthDateModalAccept.addEventListener(
                "click",
                function () {

                    birthDateModal.classList.remove("show");

                    if (birthDateInput) {
                        birthDateInput.focus();
                    }

                }
            );

        }


        /* ========================= */
        /* CERRAR VENTANA DE ERRORES */
        /* ========================= */

        if (formErrorsAccept) {

            formErrorsAccept.addEventListener(
                "click",
                function () {

                    formErrorsModal.classList.remove("show");

                }
            );

        }


        /* ========================= */
        /* FECHA DE NACIMIENTO */
        /* VALIDACIÓN */
        /* ========================= */

        function calcularEdad(fechaTexto) {

            const nacimiento =
                new Date(fechaTexto + "T00:00:00");

            const hoy = new Date();

            let edad =
                hoy.getFullYear() -
                nacimiento.getFullYear();

            const noHaCumplidoAnios =
                hoy.getMonth() < nacimiento.getMonth() ||
                (
                    hoy.getMonth() === nacimiento.getMonth() &&
                    hoy.getDate() < nacimiento.getDate()
                );

            if (noHaCumplidoAnios) {
                edad--;
            }

            return edad;

        }


        /* ========================= */
        /* VALIDACIÓN COMBINADA */
        /* (celular + fecha + correo) */
        /* ========================= */

        if (registerForm) {

            registerForm.addEventListener(
                "submit",
                function (event) {

                    const errores = [];

                    let primerCampoInvalido = null;


                    /*
                     * ===== CELULAR =====
                     */

                    if (phoneInput) {

                        const phone =
                            phoneInput.value.trim();

                        const cleanPhone =
                            phone.replace(/\s/g, "");

                        const nationalPhone =
                            /^[0-9]{8}$/;

                        const internationalPhone =
                            /^\+502[0-9]{8}$/;

                        if (phone === "") {

                            errores.push(
                                "El celular es obligatorio."
                            );

                            if (!primerCampoInvalido) {
                                primerCampoInvalido = phoneInput;
                            }

                        } else if (
                            !nationalPhone.test(cleanPhone) &&
                            !internationalPhone.test(cleanPhone)
                        ) {

                            errores.push(
                                "El celular no es válido. Debe tener 8 dígitos, con o sin +502 al inicio."
                            );

                            if (!primerCampoInvalido) {
                                primerCampoInvalido = phoneInput;
                            }

                        }

                    }


                    /*
                     * ===== CORREO =====
                     */

                    if (emailInput) {

                        const email =
                            emailInput.value.trim();

                        const emailPattern =
                            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if (email === "") {

                            errores.push(
                                "El correo es obligatorio."
                            );

                            if (!primerCampoInvalido) {
                                primerCampoInvalido = emailInput;
                            }

                        } else if (!emailPattern.test(email)) {

                            errores.push(
                                "El correo no es válido. Ejemplo: juanperez03@gmail.com"
                            );

                            if (!primerCampoInvalido) {
                                primerCampoInvalido = emailInput;
                            }

                        }

                    }


                    /*
                     * ===== FECHA DE NACIMIENTO =====
                     */

                    if (birthDateInput) {

                        const valor =
                            birthDateInput.value;

                        if (!valor) {

                            errores.push(
                                "Debes ingresar tu fecha de nacimiento."
                            );

                            if (!primerCampoInvalido) {
                                primerCampoInvalido = birthDateInput;
                            }

                        } else {

                            const nacimiento =
                                new Date(valor + "T00:00:00");

                            const hoy = new Date();

                            if (nacimiento > hoy) {

                                errores.push(
                                    "La fecha de nacimiento no puede ser una fecha futura."
                                );

                                if (!primerCampoInvalido) {
                                    primerCampoInvalido = birthDateInput;
                                }

                            } else {

                                const edad =
                                    calcularEdad(valor);

                                if (
                                    edad < EDAD_MINIMA ||
                                    edad > EDAD_MAXIMA
                                ) {

                                    errores.push(
                                        "La fecha de nacimiento no es coherente. Debes tener entre " +
                                        EDAD_MINIMA +
                                        " y " +
                                        EDAD_MAXIMA +
                                        " años."
                                    );

                                    if (!primerCampoInvalido) {
                                        primerCampoInvalido = birthDateInput;
                                    }

                                }

                            }

                        }

                    }


                    /*
                     * Si hay uno o más errores,
                     * se detiene el envío y se
                     * muestran TODOS juntos.
                     */

                    if (errores.length > 0) {

                        event.preventDefault();

                        formErrorsList.innerHTML = "";

                        errores.forEach(function (mensaje) {

                            const item =
                                document.createElement("li");

                            item.textContent = mensaje;

                            formErrorsList.appendChild(item);

                        });

                        formErrorsModal.classList.add("show");

                        if (primerCampoInvalido) {
                            primerCampoInvalido.focus();
                        }

                    }

                }
            );

        }

    /* ========================= */
/* CELULAR - VALIDACIÓN */
/* ========================= */

if (phoneInput) {

    /* ========================= */
    /* BLOQUEO INMEDIATO */
    /* ========================= */

    phoneInput.addEventListener(
        "beforeinput",
        function (event) {

            if (
                event.inputType === "insertText" &&
                event.data
            ) {

                const texto = event.data;

                /*
                 * Solamente se permiten:
                 * números
                 * espacios
                 * signo +
                 */

                if (!/^[0-9+ ]+$/.test(texto)) {

                    event.preventDefault();

                    phoneModal.classList.add("show");

                    return;
                }

                /*
                 * El signo + solamente puede:
                 *
                 * - estar al inicio
                 * - aparecer una sola vez
                 */

                if (
                    texto.includes("+") &&
                    (
                        this.selectionStart !== 0 ||
                        this.value.includes("+")
                    )
                ) {

                    event.preventDefault();

                    phoneModal.classList.add("show");

                    return;
                }

            }

        }
    );


    /* ========================= */
    /* LIMPIEZA Y FORMATEO */
    /* ========================= */

    phoneInput.addEventListener(
        "input",
        function () {

            let value = this.value;

            /*
             * Eliminar cualquier carácter
             * que no sea número, espacio o +.
             */

            value = value.replace(
                /[^0-9+ ]/g,
                ""
            );


            /*
             * Si existe +:
             *
             * - dejar solamente uno
             * - colocarlo al inicio
             */

            if (value.includes("+")) {

                value =
                    "+" +
                    value.replace(
                        /\+/g,
                        ""
                    );

            }


            const hasPlus =
                value.startsWith("+");

            const body =
                hasPlus ?
                    value.substring(1) :
                    value;


            /*
             * Reconstruir el valor
             * respetando los espacios
             * que el propio usuario
             * escriba (no se le fuerza
             * ningún formato): solo se
             * limita a 8 dígitos para
             * el número, sin contar los
             * 3 dígitos del código de
             * país (502) cuando aplica.
             */

            let result =
                hasPlus ? "+" : "";

            let countryDigits = "";
            let countryDone = !hasPlus;
            let digitCount = 0;

            for (
                let i = 0;
                i < body.length;
                i++
            ) {

                const ch = body[i];

                if (ch === " ") {

                    result += ch;
                    continue;

                }

                /*
                 * Dígito del código
                 * de país (+502).
                 */

                if (!countryDone) {

                    countryDigits += ch;
                    result += ch;

                    if (
                        countryDigits.length === 3
                    ) {

                        countryDone = true;

                    }

                    continue;

                }

                /*
                 * Dígito del número,
                 * máximo 8.
                 */

                if (digitCount < 8) {

                    result += ch;
                    digitCount++;

                }

                /*
                 * Si ya hay 8 dígitos,
                 * se ignora todo lo
                 * que sigan escribiendo.
                 */

            }

            value = result;


            this.value = value;

        }
    );

}

    }
);
</script>
</body>
</html>