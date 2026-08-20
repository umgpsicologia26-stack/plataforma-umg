<!DOCTYPE html>
    <html lang="es">
        <head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link
        rel="stylesheet"
        href="{{ asset('css/admin.css') }}">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
        <body>
    <!-- =====================================================
        HEADER MÓVIL
        SOLO APARECE EN CELULARES
    ====================================================== -->
    <header class="mobile-header">
        <button
            type="button"
            class="mobile-menu-btn"
            id="mobileMenuBtn"
            aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>
        <div class="mobile-brand">
            <i class="fas fa-shield-heart"></i>
            <span>UMG Xela</span>
        </div>
    </header>
    <!-- =====================================================
        CONTENEDOR PRINCIPAL
    ====================================================== -->
    <div class="admin-container">
    <!-- =================================================
        SIDEBAR
    ================================================== -->
        <aside class="sidebar">
            <!-- LOGO -->
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shield-heart"></i>
                </div>
                <div>
                    <h2>UMG Xela</h2>
                </div>
            </div>
            <!-- TÍTULO DEL MENÚ -->
            <p class="menu-title">
                MENÚ ADMINISTRATIVO
            </p>
    <!-- =================================================
        OPCIONES
    ================================================== -->
            <ul class="menu">


                <!-- INICIO -->

                <li>

                    <a href="/admin-panel">

                        <i class="fas fa-house"></i>

                        <span>Inicio</span>

                    </a>

                </li>
<!-- NOTIFICACIONES -->
<li>
    <a href="{{ url('/admin/notifications') }}">

        <i class="fas fa-bell"></i>

        <span>Notificaciones</span>

        @if($unreadNotifications > 0)
            <span class="notification-dot"></span>
        @endif

    </a>
</li>

                <!-- MODERADORES -->

                <li>

                    <a href="/admin/moderators">

                        <i class="fas fa-users"></i>

                        <span>Moderadores</span>

                    </a>

                </li>



                <!-- CASOS -->

                <li>

                    <a href="/admin/cases">

                        <i class="fas fa-file-medical"></i>

                        <span>Casos</span>

                    </a>

                </li>



                <!-- REPORTES -->

                <li>

                    <a href="/admin/reports">

                        <i class="fas fa-chart-line"></i>

                        <span>Reportes</span>

                    </a>

                </li>



                <!-- USUARIOS -->

                <li>

                    <a href="/admin/users">

                        <i class="fas fa-user"></i>

                        <span>Usuarios</span>

                    </a>

                </li>



                <!-- CONFIGURACIÓN -->

                <li>

                    <a href="/admin/configuration">

                        <i class="fas fa-gear"></i>

                        <span>Configuración</span>

                    </a>

                </li>



                <!-- VOLVER AL DASHBOARD -->

                <li>

                    <a
                        href="/dashboard"
                        class="menu-item logout"
                    >

                        <i class="fas fa-sign-out-alt"></i>

                        <span>Volver al Dashboard</span>

                    </a>

                </li>


            </ul>


        </aside>



        <!-- =================================================
            FONDO OSCURO PARA MÓVIL
        ================================================== -->

        <div
            class="mobile-overlay"
            id="mobileOverlay"
        ></div>


        <!-- =================================================
            CONTENIDO
        ================================================== -->

        <main class="content">


            <!-- HEADER -->

            <div class="header">


                <div>

                    <h1>
                        Panel Administrativo
                    </h1>


                    <p>

                        Bienvenida,

                        {{ Auth::user()->first_name }}

                    </p>

                </div>


            </div>

            <!-- =================================================
                GESTIÓN DE CASOS
            ================================================== -->

            <div class="card">


                <h3>

                    <i class="fas fa-folder-open"></i>

                    Gestión de Casos

                </h3>



                <!-- CONTENEDOR PARA TABLA -->

                <div class="table-container">


                    <table>


                        <thead>

                            <tr>

                                <th>Número</th>

                                <th>Tema</th>

                                <th>Moderador</th>

                                <th>Fecha</th>

                                <th>Estado</th>

                                <th>Acciones</th>

                            </tr>

                        </thead>



                        <tbody>


                            @foreach($cases as $case)

                                <tr>


                                    <td>

                                        {{ $case->case_number }}

                                    </td>


                                    <td>

                                        {{ $case->type }}

                                    </td>


                                    <td>

                                        {{ $case->moderator->first_name }}

                                        {{ $case->moderator->last_name }}

                                    </td>


                                    <td>

                                        {{ $case->created_at->format('d/m/Y') }}

                                    </td>


                                    <td>

                                        <span class="status open">

                                            {{ $case->status }}

                                        </span>

                                    </td>


                                    <td>


                                        <a
                                            href="/admin/case/{{ $case->id }}"
                                            class="view"
                                        >

                                            <i class="fas fa-eye"></i>

                                        </a>


                                    </td>


                                </tr>

                            @endforeach


                        </tbody>


                    </table>


                </div>


            </div>


        </main>


    </div>



    <!-- =====================================================
        JAVASCRIPT DEL MENÚ MÓVIL
    ====================================================== -->

    <script>


        /* ================================================
        ELEMENTOS
        ================================================= */

        const menuButton =
            document.getElementById('mobileMenuBtn');

        const sidebar =
            document.querySelector('.sidebar');

        const overlay =
            document.getElementById('mobileOverlay');



        /* ================================================
        ABRIR MENÚ
        ================================================= */

        function openMenu() {

            sidebar.classList.add('open');

            overlay.classList.add('active');

            menuButton.innerHTML =
                '<i class="fas fa-times"></i>';

            menuButton.setAttribute(
                'aria-label',
                'Cerrar menú'
            );

            document.body.classList.add(
                'menu-open'
            );

        }



        /* ================================================
        CERRAR MENÚ
        ================================================= */

        function closeMenu() {

            sidebar.classList.remove('open');

            overlay.classList.remove('active');

            menuButton.innerHTML =
                '<i class="fas fa-bars"></i>';

            menuButton.setAttribute(
                'aria-label',
                'Abrir menú'
            );

            document.body.classList.remove(
                'menu-open'
            );

        }



        /* ================================================
        BOTÓN HAMBURGUESA
        ================================================= */

        menuButton.addEventListener(
            'click',
            function () {

                if (
                    sidebar.classList.contains('open')
                ) {

                    closeMenu();

                } else {

                    openMenu();

                }

            }
        );



        /* ================================================
        CERRAR TOCANDO EL FONDO
        ================================================= */

        overlay.addEventListener(
            'click',
            function () {

                closeMenu();

            }
        );



        /* ================================================
        CERRAR AL SELECCIONAR UNA OPCIÓN
        ================================================= */

        const menuLinks =
            document.querySelectorAll('.menu a');


        menuLinks.forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        if (
                            window.innerWidth <= 600
                        ) {

                            closeMenu();

                        }

                    }
                );

            }
        );



        /* ================================================
        CERRAR SI PASAMOS A PC
        ================================================= */

        window.addEventListener(
            'resize',
            function () {

                if (
                    window.innerWidth > 600
                ) {

                    closeMenu();

                }

            }
        );


    </script>


</body>

</html>

