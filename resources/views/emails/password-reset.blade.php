<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Código de recuperación</title>
</head>

<body style="margin:0; padding:0; background:#f4f7fb; font-family:Arial, Helvetica, sans-serif;">

    <div style="width:100%; padding:40px 0;">

        <div style="
            max-width:600px;
            margin:0 auto;
            background:#ffffff;
            border-radius:16px;
            padding:40px;
            box-sizing:border-box;
            box-shadow:0 8px 30px rgba(0,0,0,.08);">

            <h1 style="
                margin:0 0 10px;
                text-align:center;
                color:#1f2937;
                font-size:28px;">
                VitaSafe - UMG
            </h1>

            <p style="
                margin:0 0 30px;
                text-align:center;
                color:#6b7280;
                font-size:15px;">
                Recuperación segura de contraseña
            </p>

            <p style="
                color:#374151;
                font-size:16px;
                line-height:1.6;">
                Hemos recibido una solicitud para recuperar la contraseña de tu
                cuenta en VitaSafe - UMG.
            </p>

            <p style="
                color:#374151;
                font-size:16px;
                line-height:1.6;">
                Tu código de recuperación es:
            </p>

            <div style="
                margin:30px 0;
                padding:20px;
                background:#f3f6fa;
                border-radius:12px;
                text-align:center;">

                <span style="
                    font-size:36px;
                    font-weight:bold;
                    letter-spacing:8px;
                    color:#2563eb;">
                    {{ $code }}
                </span>

            </div>

            <p style="
                color:#6b7280;
                font-size:14px;
                line-height:1.6;">
                Este código tiene una vigencia de 3 minutos y solamente puede
                utilizarse una vez.
            </p>

            <p style="
                color:#6b7280;
                font-size:14px;
                line-height:1.6;">
                Si tú no solicitaste este cambio, puedes ignorar este mensaje.
            </p>

            <hr style="
                border:none;
                border-top:1px solid #e5e7eb;
                margin:30px 0;">

            <p style="
                margin:0;
                text-align:center;
                color:#9ca3af;
                font-size:12px;">
                © {{ date('Y') }} VitaSafe - UMG. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>