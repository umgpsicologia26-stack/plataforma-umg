<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restablecer contraseña</title>

    <link rel="stylesheet" href="{{ asset('css/recovery.css') }}">
</head>

<body>

    <main class="recovery-card">

        <a href="{{ url('/login') }}" class="back-btn">
            ← Volver al inicio
        </a>

        <h1>Restablecer contraseña</h1>

        <p>
            Ingresa el código de 6 dígitos que recibiste en
            <strong>{{ session('reset_email_masked') }}</strong>.
            El código vence en <strong>3 minutos</strong> y solo puede
            utilizarse una vez.
        </p>


        {{-- MENSAJES DE ERROR --}}

        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        {{-- CÓDIGO DE DEMOSTRACIÓN LOCAL --}}

        @if(session('demo_recovery_code'))

            <div style="
                margin: 20px 0;
                padding: 16px;
                border-radius: 12px;
                background: #fff8e1;
                border: 1px solid #f0c36d;
                color: #7a5a00;
                text-align: center;
            ">

                <div style="
                    font-size: 13px;
                    font-weight: 600;
                    margin-bottom: 8px;
                ">
                    MODO DE DEMOSTRACIÓN LOCAL
                </div>

                <div style="font-size: 14px;">
                    Tu código temporal es:
                </div>

                <div style="
                    margin-top: 8px;
                    font-size: 28px;
                    font-weight: 700;
                    letter-spacing: 6px;
                ">
                    {{ session('demo_recovery_code') }}
                </div>

                <div style="
                    margin-top: 8px;
                    font-size: 12px;
                ">
                    Este código se muestra únicamente durante
                    la demostración local.
                </div>

            </div>

        @endif


        {{-- FORMULARIO --}}

        <form method="POST" action="{{ url('/reset-password') }}">

            @csrf


            <div class="input-field">

                <label for="code">
                    Código de recuperación
                </label>

                <input
                    id="code"
                    type="text"
                    name="code"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    autocomplete="one-time-code"
                    required
                >

            </div>


            <div class="input-field">

                <label for="password">
                    Nueva contraseña
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

            </div>


            <div class="input-field">

                <label for="password_confirmation">
                    Confirmar contraseña
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

            </div>


            <button
                type="submit"
                class="recovery-btn"
            >
                Cambiar contraseña
            </button>

        </form>


        <div class="extra-links">

            <a href="{{ url('/forgot-password') }}">
                Solicitar otro código
            </a>

        </div>

    </main>



    {{-- =====================================================
        MODAL CÓDIGO VENCIDO
    ====================================================== --}}

    @if(session('code_expired'))

        <div class="modal-overlay">

            <div class="modal-box">

                <div class="modal-icon">
                    ⚠
                </div>

                <h2>
                    Código vencido
                </h2>

                <p>
                    El código de recuperación ha expirado.
                </p>

                <p>
                    Por seguridad, los códigos solamente son
                    válidos durante <strong>3 minutos</strong>.
                </p>

                <button
                    type="button"
                    class="modal-button"
                    onclick="window.location.href='{{ url('/forgot-password') }}'"
                >
                    Aceptar
                </button>

            </div>

        </div>

    @endif


    <style>

        /* =====================================================
           MODAL CÓDIGO VENCIDO
        ===================================================== */

        .modal-overlay {

            position: fixed;

            inset: 0;

            background: rgba(15, 23, 42, 0.65);

            display: flex;

            justify-content: center;

            align-items: center;

            z-index: 9999;

            padding: 20px;

        }


        .modal-box {

            width: 100%;

            max-width: 430px;

            background: white;

            border-radius: 25px;

            padding: 35px;

            text-align: center;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, 0.25);

            animation: modalAppear 0.25s ease;

        }


        .modal-icon {

            width: 70px;

            height: 70px;

            margin: 0 auto 20px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #fee2e2;

            color: #dc2626;

            font-size: 30px;

        }


        .modal-box h2 {

            color: #111827;

            font-size: 25px;

            margin-bottom: 15px;

        }


        .modal-box p {

            color: #64748b;

            line-height: 1.6;

            margin-bottom: 10px;

        }


        .modal-button {

            width: 100%;

            margin-top: 20px;

            padding: 14px 20px;

            border: none;

            border-radius: 14px;

            background: #2563eb;

            color: white;

            font-size: 15px;

            font-weight: 700;

            cursor: pointer;

            transition: 0.3s;

        }


        .modal-button:hover {

            background: #1d4ed8;

            transform: translateY(-2px);

        }


        @keyframes modalAppear {

            from {

                opacity: 0;

                transform: scale(0.9);

            }

            to {

                opacity: 1;

                transform: scale(1);

            }

        }

    </style>

</body>

</html>