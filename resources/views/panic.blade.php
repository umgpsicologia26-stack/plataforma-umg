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

            /* 100vh como respaldo; 100dvh evita el salto de la barra del navegador en móviles */
            min-height:100vh;
            min-height:100dvh;

            color:white;

            /* 40px en escritorio, ~17-20px en móviles */
            padding:clamp(16px, 3vw + 8px, 40px);
        }

        /* CONTENEDOR PRINCIPAL */

        .container{
            max-width:1100px;
            margin:auto;
        }

        .card{
            background:rgba(255,255,255,.08);

            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);

            /* 40px en escritorio, 20px en móviles pequeños */
            padding:clamp(20px, 2.5vw + 12px, 40px);

            border-radius:30px;

            border:1px solid rgba(255,255,255,.08);

            /* Evita que palabras largas desborden el contenedor */
            overflow-wrap:break-word;
        }

        /* TITULO */

        .title-row{
            display:flex;
            align-items:center;

            gap:15px;

            margin-bottom:25px;
        }

        .back{
            /* Área táctil mínima de 44x44px sin cambiar el tamaño de la flecha */
            display:inline-flex;
            align-items:center;
            justify-content:center;

            flex:0 0 auto;

            min-width:44px;
            min-height:44px;

            font-size:34px;

            color:#fca5a5;

            text-decoration:none;

            line-height:1;
        }

        .title{
            /* 46px en escritorio, ~40px en tablet, 28px en móviles pequeños */
            font-size:clamp(1.75rem, 1.1rem + 2.8vw, 2.875rem);
            font-weight:700;

            line-height:1.1;

            /* Permite que el título se ajuste dentro de la fila flex */
            min-width:0;
        }

        .subtitle{
            color:#fecaca;

            line-height:1.8;

            margin-bottom:35px;
        }

        /* GRID DE TARJETAS */

        .grid{
            display:grid;

            grid-template-columns:repeat(3, minmax(0, 1fr));

            gap:20px;

            align-items:stretch;
        }

        /* TARJETAS */

        .help-card{
            background:rgba(255,255,255,.05);

            /* 26px en pantallas normales, 20px en móviles muy pequeños */
            padding:clamp(20px, 5vw, 26px);

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

            /*
             * Permite que los botones se adapten al ancho
             * real de la tarjeta (ver @container más abajo).
             */
            container-type:inline-size;

            transition:
                transform .3s ease,
                background .3s ease;
        }

        /* TITULO DE CADA TARJETA */

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

        /* TEXTO */

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

        /* BOTONES LLAMAR / UBICACIÓN */

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

            /* Evita que el contenido fuerce el ancho de la celda del grid */
            min-width:0;

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

        /* BOTON LLAMAR */

        .call-btn{

            background:rgba(255,255,255,.16);

            border:1px solid rgba(255,255,255,.12);

            box-shadow:
                0 6px 18px rgba(220,38,38,.20);

            backdrop-filter:blur(10px);

            -webkit-backdrop-filter:blur(10px);
        }

        .call-btn:active{
            transform:translateY(0);
        }

        /* BOTON UBICACION */

        .map-btn{

            background:rgba(255,255,255,.16);

            border:1px solid rgba(255,255,255,.18);

            backdrop-filter:blur(10px);

            -webkit-backdrop-filter:blur(10px);
        }

        .map-btn:active{
            transform:translateY(0);
        }

        /* PNC
        110 + 120
        UBICACION */

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

        /* BOTONES DE ASISTENCIA */

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


        .action-btn:active{

            transform:translateY(0);
        }

        /* HOVER (solo dispositivos con puntero)
        Evita el "hover pegado" en pantallas táctiles */

        @media (hover:hover){

            .help-card:hover{
                transform:translateY(-5px);

                background:rgba(255,255,255,.08);
            }

            .call-btn:hover{

                background:rgba(255,255,255,.23);

                transform:translateY(-2px);

                box-shadow:
                    0 10px 25px rgba(220,38,38,.30);
            }

            .map-btn:hover{

                background:rgba(255,255,255,.23);

                transform:translateY(-2px);

                box-shadow:
                    0 10px 25px rgba(255,255,255,.08);
            }

            .action-btn:hover{

                background:#dc2626;

                transform:translateY(-2px);
            }

        }

        /* FOCO DE TECLADO */

        .back:focus-visible,
        .call-btn:focus-visible,
        .map-btn:focus-visible,
        .action-btn:focus-visible{

            outline:3px solid #fecaca;

            outline-offset:3px;
        }

        /* BOTONES EN TARJETAS ESTRECHAS
        Se evalúa según el ancho real de la tarjeta,
        no el de la ventana. En navegadores sin soporte
           de @container se mantienen las 2 columnas. */

        @@container (max-width:230px){

            .button-group,
            .pnc-buttons{

                grid-template-columns:1fr;
            }


            .pnc-buttons .map-btn{

                grid-column:auto;
            }

        }


        /* RESPONSIVE LAPTOP PEQUEÑA / TABLET HORIZONTAL */

        @media (max-width:1099px){

            .grid{

                grid-template-columns:repeat(2, minmax(0, 1fr));

            }

        }

        /* RESPONSIVE UNA COLUMNA */

        @media (max-width:739px){

            .grid{

                grid-template-columns:1fr;

                gap:18px;
            }


            /* Sin tarjetas vecinas que alinear, no hace falta reservar alto */
            .help-card{

                min-height:0;
            }


            .help-title{

                min-height:0;
            }

        }

        /* RESPONSIVE CELULAR */

        @media (max-width:650px){

            .card{

                border-radius:24px;
            }


            .subtitle{

                font-size:14px;

                line-height:1.6;
            }

        }

        /* CELULARES PEQUEÑOS */

        @media (max-width:420px){

            .button-group{

                grid-template-columns:1fr;
            }


            .call-btn,
            .map-btn{

                min-height:48px;

                font-size:13px;
            }

        }


        /* =========================
           MOVIMIENTO REDUCIDO
        ========================= */

        @media (prefers-reduced-motion:reduce){

            .help-card,
            .call-btn,
            .map-btn,
            .action-btn{

                transition:none;
            }


            .help-card:hover,
            .call-btn:hover,
            .map-btn:hover,
            .action-btn:hover{

                transform:none;
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