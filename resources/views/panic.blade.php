<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Botón de Pánico</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;

            background:
                linear-gradient(
                    rgba(80,0,0,.93),
                    rgba(25,0,0,.95)
                ),
                url('https://images.unsplash.com/photo-1516321310764-8d3d7a52cdb5?q=80&w=2070&auto=format&fit=crop');

            background-size:cover;
            background-position:center;

            min-height:100vh;

            color:white;

            padding:40px;
        }


        /* =========================
           CONTENEDOR PRINCIPAL
        ========================= */

        .container{
            max-width:1100px;
            margin:auto;
        }


        .card{
            background:rgba(255,255,255,.08);

            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);

            padding:40px;

            border-radius:30px;

            border:1px solid rgba(255,255,255,.08);
        }


        /* =========================
           TITULO
        ========================= */

        .title-row{
            display:flex;
            align-items:center;

            gap:15px;

            margin-bottom:25px;
        }


        .back{
            font-size:34px;

            color:#fca5a5;

            text-decoration:none;

            line-height:1;
        }


        .title{
            font-size:46px;
            font-weight:700;

            line-height:1.1;
        }


        .subtitle{
            color:#fecaca;

            line-height:1.8;

            margin-bottom:35px;
        }


        /* =========================
           GRID DE TARJETAS
        ========================= */

        .grid{
            display:grid;

            grid-template-columns:repeat(3, minmax(0, 1fr));

            gap:20px;

            align-items:stretch;
        }


        /* =========================
           TARJETAS
        ========================= */

        .help-card{
            background:rgba(255,255,255,.05);

            padding:26px;

            border-radius:20px;

            border:1px solid rgba(255,255,255,.08);

            display:flex;
            flex-direction:column;

            /*
             * Todas las tarjetas parten
             * del mismo tamaño.
             */
            min-height:300px;

            height:100%;

            transition:
                transform .3s ease,
                background .3s ease;
        }


        .help-card:hover{
            transform:translateY(-5px);

            background:rgba(255,255,255,.08);
        }


        /* =========================
           TITULO DE CADA TARJETA
        ========================= */

        .help-title{
            font-size:21px;

            font-weight:700;

            line-height:1.3;

            margin-bottom:14px;

            /*
             * Reserva espacio para que los títulos
             * de una y dos líneas queden alineados.
             */
            min-height:54px;
        }


        /* =========================
           TEXTO
        ========================= */

        .help-card p{
            font-size:14px;

            line-height:1.5;

            color:#ffffff;

            margin:0;

            /*
             * Hace que el texto ocupe
             * el espacio disponible y empuje
             * los botones hacia abajo.
             */
            flex-grow:1;
        }


        /* =========================
           BOTONES LLAMAR / UBICACIÓN
        ========================= */

        .button-group{

            display:grid;

            grid-template-columns:1fr 1fr;

            gap:8px;

            margin-top:20px;

            width:100%;
        }


        .call-btn,
        .map-btn{

            display:flex;

            align-items:center;

            justify-content:center;

            gap:5px;

            width:100%;

            min-height:50px;

            padding:10px 8px;

            border-radius:13px;

            color:#ffffff;

            text-decoration:none;

            font-family:'Poppins',sans-serif;

            font-size:13px;

            font-weight:600;

            text-align:center;

            cursor:pointer;

            transition:
                background .3s ease,
                transform .3s ease,
                box-shadow .3s ease;

            box-sizing:border-box;
        }


        /* =========================
           BOTON LLAMAR
        ========================= */

        .call-btn{

            background:rgba(255,255,255,.16);

            border:1px solid rgba(255,255,255,.12);

            box-shadow:
                0 6px 18px rgba(220,38,38,.20);

            backdrop-filter:blur(10px);

            -webkit-backdrop-filter:blur(10px);
        }


        .call-btn:hover{

            background:rgba(255,255,255,.23);

            transform:translateY(-2px);

            box-shadow:
                0 10px 25px rgba(220,38,38,.30);
        }


        .call-btn:active{
            transform:translateY(0);
        }


        /* =========================
           BOTON UBICACION
        ========================= */

        .map-btn{

            background:rgba(255,255,255,.16);

            border:1px solid rgba(255,255,255,.18);

            backdrop-filter:blur(10px);

            -webkit-backdrop-filter:blur(10px);
        }


        .map-btn:hover{

            background:rgba(255,255,255,.23);

            transform:translateY(-2px);

            box-shadow:
                0 10px 25px rgba(255,255,255,.08);
        }


        .map-btn:active{
            transform:translateY(0);
        }


        /* =========================
           PNC
           110 + 120
           UBICACION
        ========================= */

        .pnc-buttons{

            display:grid;

            grid-template-columns:1fr 1fr;

            gap:8px;

            margin-top:20px;

            width:100%;
        }


        .pnc-buttons .map-btn{

            grid-column:1 / 2;
        }


        /* =========================
           BOTONES DE ASISTENCIA
        ========================= */

        .action-btn{

            display:flex;

            align-items:center;
            justify-content:center;

            width:100%;

            min-height:50px;

            padding:13px;

            border-radius:14px;

            background:#ef4444;

            color:white;

            text-decoration:none;

            font-weight:700;

            font-size:14px;

            text-align:center;

            margin-top:20px;

            transition:
                background .3s ease,
                transform .3s ease;
        }


        .action-btn:hover{

            background:#dc2626;

            transform:translateY(-2px);
        }


        .action-btn:active{

            transform:translateY(0);
        }


        /* =========================
           RESPONSIVE TABLET
        ========================= */

        @media (max-width:900px){

            .grid{

                grid-template-columns:repeat(2, minmax(0, 1fr));

            }

            .title{

                font-size:40px;
            }

        }


        /* =========================
           RESPONSIVE CELULAR
        ========================= */

        @media (max-width:650px){

            body{

                padding:20px;
            }


            .card{

                padding:25px;

                border-radius:24px;
            }


            .grid{

                grid-template-columns:1fr;

                gap:18px;
            }


            .help-card{

                min-height:280px;
            }


            .title{

                font-size:32px;
            }


            .subtitle{

                font-size:14px;

                line-height:1.6;
            }

        }


        /* =========================
           CELULARES PEQUEÑOS
        ========================= */

        @media (max-width:420px){

            .button-group{

                grid-template-columns:1fr;
            }


            .pnc-buttons{

                grid-template-columns:1fr 1fr;
            }


            .call-btn,
            .map-btn{

                min-height:48px;

                font-size:13px;
            }

        }

    </style>

</head>


<body>

<div class="container">

    <div class="card">

        <!-- =========================
             TITULO
        ========================= -->

        <div class="title-row">

            <a href="/dashboard" class="back">
                ←
            </a>

            <h1 class="title">
                Botón de Pánico
            </h1>

        </div>


        <p class="subtitle">

            Solicita ayuda inmediata, denuncia situaciones críticas y contacta asistencia especializada.

        </p>


        <!-- =========================
            TARJETAS
        ========================= -->

        <div class="grid">


            <!-- =========================
                MINISTERIO PUBLICO
            ========================= -->

            <div class="help-card">

                <div class="help-title">
                    Ministerio Público
                </div>

                <p>
                    Es la institución encargada de investigar delitos y buscar que se haga justicia cuando ocurre algo ilegal.
                </p>


                <div class="button-group">

                    <a
                        href="tel:1572"
                        class="call-btn">

                        📞 Llamar 1572

                    </a>


                    <a
                        href="https://www.google.com/maps/search/?api=1&query=Ministerio+P%C3%BAblico+Quetzaltenango+Guatemala"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="map-btn">

                        📍 Ubicación

                    </a>

                </div>

            </div>



            <!-- =========================
                PDH
            ========================= -->

            <div class="help-card">

                <div class="help-title">
                    PDH
                </div>

                <p>
                    Es la institución que ayuda a proteger los derechos de las personas y recibe denuncias cuando alguien considera que sus derechos no están siendo respetados.
                </p>


                <div class="button-group">

                    <a
                        href="tel:1555"
                        class="call-btn">

                        📞 Llamar 1555

                    </a>


                    <a
                        href="https://www.google.com/maps/search/?api=1&query=Procuradur%C3%ADa+de+los+Derechos+Humanos+Quetzaltenango+Guatemala"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="map-btn">

                        📍 Ubicación

                    </a>

                </div>
            </div>



            <!-- =========================
                PNC
            ========================= -->
            <div class="help-card">
                <div class="help-title">
                    PNC
                </div>
                <p>
                    Es la institución que ayuda a proteger a las personas, mantener la seguridad y atender emergencias o situaciones de peligro.
                </p>


                <div class="pnc-buttons">
                    <a
                        href="tel:110"
                        class="call-btn">
                        📞 Llamar 110
                    </a>

                    <a
                        href="tel:120"
                        class="call-btn">
                        📞 Llamar 120
                    </a>


                    <a
                        href="https://www.google.com/maps/search/?api=1&query=Polic%C3%ADa+Nacional+Civil+Quetzaltenango+Guatemala"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="map-btn">
                        📍 Ubicación
                    </a>
                </div>
            </div>

            <!-- =========================
                PGN
            ========================= -->
            <div class="help-card">
                <div class="help-title">
                    PGN
                </div>
                <p>
                    Es una institución que protege y defiende los derechos de las personas que necesitan apoyo, especialmente niños, niñas y adolescentes.
                </p>
                <div class="button-group">
                    <a
                        href="tel:1584"
                        class="call-btn">
                        📞 Llamar 1584
                    </a>
                    <a
                        href="https://www.google.com/maps/search/?api=1&query=Procuradur%C3%ADa+General+de+la+Naci%C3%B3n+7a+Calle+2-55+zona+6+Quetzaltenango+Guatemala"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="map-btn">
                        📍 Ubicación
                    </a>
                </div>
            </div>

            <!-- =========================
            Clínica Psicológica UMG
            ========================= -->
            <div class="help-card">
                <div class="help-title">
                    Clínica Psicológica UMG
                </div>
                <p>
                    Es un centro de salud mental donde profesionales especializados evalúan, diagnostican, previenen y tratan trastornos mentales, problemas emocionales y conductas desadaptativas.
                </p>

                <div class="button-group">

                    <a
                        href="tel:55236036"
                        class="call-btn">

                        📞 Llamar 55236036

                    </a>

                    <a
                        href="https://maps.app.goo.gl/YVHmVAfGiSUujqYL7"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="map-btn">
                        📍 Ubicación
                    </a>
                </div>
            </div>


            <!-- =========================
                ASISTENCIA ABUSO SEXUAL
            ========================= -->
            <div class="help-card">
                <div class="help-title">
                    Asistencia Abuso Sexual
                </div>
                <p>
                    Solicita ayuda y obten seguimiento de tu caso.
                </p>
                <a
                    href="/casesAbusoSexual"
                    class="action-btn">
                    Solicitar Asistencia
                </a>
            </div>

            <!-- =========================
                PREVENCION DEL SUICIDIO
            ========================= -->

            <div class="help-card">
                <div class="help-title">
                    Prevención del Suicidio
                </div>
                <p>
                    Solicita acompañamiento emocional y seguimiento de caso.
                </p>

                <a
                    href="/casesSuicidio"
                    class="action-btn">
                    Solicitar Ayuda
                </a>
            </div>
        </div>
            </div>
                </div>
                    </body>
                        </html>
