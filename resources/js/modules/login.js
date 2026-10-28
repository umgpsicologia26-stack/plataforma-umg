const firebaseConfig = {

    apiKey: "AIzaSyCtmqJGlHhehKOAmWrfEpuxB5gFhW1Bw10",

    authDomain: "plataformaumg.firebaseapp.com",

    projectId: "plataformaumg",

    storageBucket: "plataformaumg.firebasestorage.app",

    messagingSenderId: "2360835961",

    appId: "1:2360835961:web:7c57c82f0028bf9621b9a8"

};

firebase.initializeApp(firebaseConfig);


  /* GOOGLE LOGIN */

async function completarInicioSesionGoogle(user) {
    const idToken = await user.getIdToken();

    const urlMeta = document.querySelector(
        'meta[name="google-login-url"]'
    );

    const csrfMeta = document.querySelector(
        'meta[name="csrf-token"]'
    );

    if (!urlMeta || !csrfMeta) {
        throw new Error(
            'No se encontró la configuración necesaria para iniciar sesión.'
        );
    }

    const response = await fetch(urlMeta.getAttribute('content'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfMeta.getAttribute('content')
        },
        body: JSON.stringify({
            idToken: idToken
        })
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(
            data.message ||
            'No fue posible iniciar sesión con Google.'
        );
    }

    if (data.success && data.redirect) {
        window.location.href = data.redirect;
    } else {
        throw new Error(
            'No se recibió una dirección válida para continuar.'
        );
    }
}

async function googleLogin() {
    const provider = new firebase.auth.GoogleAuthProvider();

    provider.setCustomParameters({
        prompt: 'select_account'
    });

    const esMovil =
        /Android|iPhone|iPad|iPod/i.test(navigator.userAgent) ||
        (
            navigator.platform === 'MacIntel' &&
            navigator.maxTouchPoints > 1
        );

    try {
        if (esMovil) {
            await firebase.auth().signInWithRedirect(provider);
            return;
        }

        const result = await firebase
            .auth()
            .signInWithPopup(provider);

        if (result.user) {
            await completarInicioSesionGoogle(result.user);
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

    /* PROCESAR EL REGRESO DESDE GOOGLE EN DISPOSITIVOS MÓVILES */

firebase.auth().getRedirectResult()
    .then(async function (result) {
        if (result && result.user) {
            await completarInicioSesionGoogle(result.user);
        }
    })
    .catch(function (error) {
        console.error(
            'Error al regresar del inicio de sesión con Google:',
            error
        );

        alert(
            error.message ||
            'No fue posible completar el inicio de sesión con Google.'
        );
    });

    /* MOSTRAR REGISTRO */

function toggleRegisterForm() {

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

    /* REGRESAR LOGIN */

function backToLogin() {

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

    /* VALIDACIONES */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const registerForm =
            document.getElementById(
                "registerForm"
            );

        const phoneInput =
            document.getElementById(
                "register_phone"
            );

        const emailInput =
            document.getElementById(
                "register_email"
            );

        const phoneModal =
            document.getElementById(
                "phoneModal"
            );

        const phoneModalAccept =
            document.getElementById(
                "phoneModalAccept"
            );

        const emailModal =
            document.getElementById(
                "emailModal"
            );

        const emailModalAccept =
            document.getElementById(
                "emailModalAccept"
            );

        const birthDateInput =
            document.getElementById(
                "register_birth_date"
            );

        const birthDateModal =
            document.getElementById(
                "birthDateModal"
            );

        const birthDateModalAccept =
            document.getElementById(
                "birthDateModalAccept"
            );

        const formErrorsModal =
            document.getElementById(
                "formErrorsModal"
            );

        const formErrorsList =
            document.getElementById(
                "formErrorsList"
            );

        const formErrorsAccept =
            document.getElementById(
                "formErrorsAccept"
            );

            const loginErrorModal =
    document.getElementById(
        "loginErrorModal"
    );

const loginErrorModalAccept =
    document.getElementById(
        "loginErrorModalAccept"
    );

if (loginErrorModalAccept) {
    loginErrorModalAccept.addEventListener(
        "click",
        function () {
            loginErrorModal.classList.remove("show");
        }
    );
}

if (loginErrorModal) {
    loginErrorModal.classList.add("show");
}

if (loginErrorModalAccept) {
    loginErrorModalAccept.addEventListener(
        "click",
        function () {
            loginErrorModal.classList.remove("show");
        }
    );
}

        const EDAD_MINIMA = 15;
        const EDAD_MAXIMA = 100;


        /* CERRAR MODALES */

        if (phoneModalAccept) {

            phoneModalAccept.addEventListener(
                "click",
                function () {

                    phoneModal.classList.remove("show");

                    phoneInput?.focus();

                }
            );

        }

        if (emailModalAccept) {

            emailModalAccept.addEventListener(
                "click",
                function () {

                    emailModal.classList.remove("show");

                    emailInput?.focus();

                }
            );

        }

        if (birthDateModalAccept) {

            birthDateModalAccept.addEventListener(
                "click",
                function () {

                    birthDateModal.classList.remove("show");

                    birthDateInput?.focus();

                }
            );

        }

        if (formErrorsAccept) {

            formErrorsAccept.addEventListener(
                "click",
                function () {

                    formErrorsModal.classList.remove("show");

                }
            );

        }

        /* CALCULAR EDAD */

        function calcularEdad(fechaTexto) {

            const nacimiento =
                new Date(
                    fechaTexto + "T00:00:00"
                );

            const hoy =
                new Date();

            let edad =
                hoy.getFullYear() -
                nacimiento.getFullYear();

            const noHaCumplidoAnios =
                hoy.getMonth() <
                    nacimiento.getMonth() ||

                (
                    hoy.getMonth() ===
                        nacimiento.getMonth() &&

                    hoy.getDate() <
                        nacimiento.getDate()
                );

            if (noHaCumplidoAnios) {

                edad--;

            }

            return edad;

        }

        /* VALIDACIÓN DEL REGISTRO */

        if (registerForm) {

            registerForm.addEventListener(
                "submit",
                function (event) {

                    const errores = [];

                    let primerCampoInvalido = null;

                /* CELULAR */

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

                            primerCampoInvalido ??=
                                phoneInput;

                        }
                        else if (
                            !nationalPhone.test(cleanPhone) &&
                            !internationalPhone.test(cleanPhone)
                        ) {

                            errores.push(
                                "El celular no es vÃ¡lido. Debe tener 8 dÃ­gitos, con o sin +502 al inicio."
                            );

                            primerCampoInvalido ??=
                                phoneInput;

                        }

                    }

                    /* CORREO */

                    if (emailInput) {

                        const email =
                            emailInput.value.trim();

                        const emailPattern =
                            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


                        if (email === "") {

                            errores.push(
                                "El correo es obligatorio."
                            );

                            primerCampoInvalido ??=
                                emailInput;

                        }
                        else if (
                            !emailPattern.test(email)
                        ) {

                            errores.push(
                                "El correo no es vÃ¡lido. Ejemplo: juanperez03@gmail.com"
                            );

                            primerCampoInvalido ??=
                                emailInput;

                        }

                    }

                /* FECHA DE NACIMIENTO */

                    if (birthDateInput) {

                        const valor =
                            birthDateInput.value;

                        if (!valor) {

                            errores.push(
                                "Debes ingresar tu fecha de nacimiento."
                            );

                            primerCampoInvalido ??=
                                birthDateInput;

                        }
                        else {

                            const nacimiento =
                                new Date(
                                    valor + "T00:00:00"
                                );

                            const hoy =
                                new Date();

                            if (nacimiento > hoy) {

                                errores.push(
                                    "La fecha de nacimiento no puede ser una fecha futura."
                                );

                                primerCampoInvalido ??=
                                    birthDateInput;

                            }
                            else {

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
                                        " aÃ±os."
                                    );

                                    primerCampoInvalido ??=
                                        birthDateInput;

                                }

                            }

                        }

                    }

                /* MOSTRAR ERRORES */

                    if (errores.length > 0) {

                        event.preventDefault();

                        formErrorsList.innerHTML = "";

                        errores.forEach(
                            function (mensaje) {

                                const item =
                                    document.createElement(
                                        "li"
                                    );

                                item.textContent =
                                    mensaje;

                                formErrorsList.appendChild(
                                    item
                                );

                            }
                        );

                        formErrorsModal.classList.add(
                            "show"
                        );

                        primerCampoInvalido?.focus();

                    }

                }
            );

        }

        /* CELULAR */

        if (phoneInput) {

            phoneInput.addEventListener(
                "beforeinput",
                function (event) {

                    if (
                        event.inputType === "insertText" &&
                        event.data
                    ) {

                        const texto =
                            event.data;

                        if (!/^[0-9+ ]+$/.test(texto)) {

                            event.preventDefault();

                            phoneModal.classList.add(
                                "show"
                            );

                            return;

                        }

                        if (
                            texto.includes("+") &&
                            (
                                this.selectionStart !== 0 ||
                                this.value.includes("+")
                            )
                        ) {

                            event.preventDefault();

                            phoneModal.classList.add(
                                "show"
                            );

                        }

                    }

                }
            );

            phoneInput.addEventListener(
                "input",
                function () {

                    let value =
                        this.value;

                    value =
                        value.replace(
                            /[^0-9+ ]/g,
                            ""
                        );

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
                        hasPlus
                            ? value.substring(1)
                            : value;

                    let result =
                        hasPlus
                            ? "+"
                            : "";

                    let countryDigits =
                        "";

                    let countryDone =
                        !hasPlus;

                    let digitCount =
                        0;


                    for (
                        let i = 0;
                        i < body.length;
                        i++
                    ) {

                        const ch =
                            body[i];

                        if (ch === " ") {

                            result += ch;

                            continue;

                        }

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

                        if (digitCount < 8) {

                            result += ch;

                            digitCount++;

                        }

                    }

                    this.value =
                        result;

                }
            );

        }

    }

);

    /* CERRAR VENTANA DE BLOQUEO */

function closeBruteForceModal() {

    const modal =
        document.getElementById(
            'bruteForceModal'
        );

    if (modal) {

        modal.remove();

    }

}

document.addEventListener('DOMContentLoaded', function () {

    const googleLoginButton =
        document.getElementById('googleLoginButton');

    const createEmailButton =
        document.getElementById('createEmailButton');

    const backToLoginButton =
        document.getElementById('backToLoginButton');

    const closeBruteForceModalButton =
        document.getElementById('closeBruteForceModalButton');

    if (googleLoginButton) {
        googleLoginButton.addEventListener(
            'click',
            googleLogin
        );
    }

    if (createEmailButton) {
        createEmailButton.addEventListener(
            'click',
            toggleRegisterForm
        );
    }

    if (backToLoginButton) {
        backToLoginButton.addEventListener(
            'click',
            backToLogin
        );
    }

    if (closeBruteForceModalButton) {
        closeBruteForceModalButton.addEventListener(
            'click',
            closeBruteForceModal
        );
    }

});