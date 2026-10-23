<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>UMG</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}">

    <link
        rel="stylesheet"
        href="{{ asset('css/home.css') }}">

</head>

<body class="home-body">

    {{-- NAVBAR --}}

<nav class="navbar">

    <div class="nav-left">

        <img
            src="{{ asset('images/logo1.png') }}"
            alt="Logo UMG"
            class="nav-logo">

        <div class="brand">
            <h2>UMG</h2>
        </div>

    </div>


    <div class="nav-center">

        <a href="#top">Inicio</a>

        <a href="#services">Servicios</a>

        <a href="#projects">Proyectos</a>

        <a href="#infos">Nosotros</a>

</div>


    <div class="nav-right">

        {{-- BOTÓN INGRESAR --}}

        <a
            href="{{ route('login') }}"
            class="login-btn">

            <i class="fas fa-right-to-bracket"></i>

            Ingresar

        </a>

    </div>

</nav>

    {{-- HERO --}}

<section
    id="top"
    class="home-hero">
        <div class="hero-card">

        <div class="hero-text">

            <h1>
                Plataforma Informática Preventiva y de Orientación
            </h1>

            <p>
                Conectamos a la comunidad con recursos, orientación y acompañamiento
                para tomar decisiones informadas. Estamos contigo en cada paso.
            </p>

            <a
                href="#services"
                class="hero-btn-primary">

                Descubre más

            </a>

        </div>


        <div class="hero-logo-side">

            <img
                src="{{ asset('images/logo1.png') }}"
                alt="Logo UMG">

            <p class="logo-text">

                "A veces, el acto más valiente es hablar de aquello que más te duele."

                <br>
                <br>

                <span>
                    - Robin Williams -
                </span>

            </p>

        </div>

    </div>

</section>

    {{-- SERVICIOS --}}

<section
    id="services"
    class="home-section">


    <div class="section-heading">

        <span class="eyebrow">
            Lo que ofrecemos
        </span>

        <h2>
            Nuestros <span>servicios</span> de apoyo y orientación
        </h2>

        <p>
            Recursos pensados para acompañarte con información clara y confiable.
        </p>

    </div>


    @php

        $servicios = [

            [
                'title' => 'Orientación y acompañamiento',

                'description' => '',

                'images' => [

                    'services/Orientación-acompañamiento/Orientación1.jpeg',
                    'services/Orientación-acompañamiento/Orientación2.jpeg',
                    'services/Orientación-acompañamiento/Orientación3.jpeg',
                    'services/Orientación-acompañamiento/Orientación4.jpeg',
                    'services/Orientación-acompañamiento/Orientación5.jpeg',
                    'services/Orientación-acompañamiento/Orientación6.jpeg',
                    'services/Orientación-acompañamiento/Orientación7.jpeg',
                    'services/Orientación-acompañamiento/Orientación8.jpeg',
                    'services/Orientación-acompañamiento/Orientación9.jpeg',
                ],
            ],

            [
                'title' => 'Información preventiva',
                'description' =>
                    'Información preventiva para reconocer señales de alerta y conocer recursos de apoyo.',
                'images' => [
                    'services/Información-preventiva/Preventiva1.png',
                    'services/Información-preventiva/Preventiva2.jpeg',
                    'services/Información-preventiva/Preventiva3.jpeg',  
                    'services/Información-preventiva/Preventiva4.jpeg',
                    'services/Información-preventiva/Preventiva5.jpeg',
                    'services/Información-preventiva/Preventiva6.jpeg',
                    'services/Información-preventiva/Preventiva10.jpeg',
                    'services/Información-preventiva/Preventiva11.jpeg',
                    'services/Información-preventiva/Preventiva12.jpeg',
                    'services/Información-preventiva/Preventiva13.jpeg',
                ],
                'videos' => [
                    'services/Información-preventiva/Preventiva7.mp4',
                    'services/Información-preventiva/Preventiva8.mp4',
                    'services/Información-preventiva/Preventiva9.mp4',
                ],
            ],
        ];
    @endphp

    {{-- TARJETAS DE SERVICIOS --}}

    <div class="cards-grid">

        @foreach ($servicios as $index => $servicio)

            <div
                class="glass-card service-clickable"

                @if (!empty($servicio['images']))

                    onclick="abrirModalServicio({{ $index }})"

                    role="button"

                    tabindex="0"

                    onkeydown="if(event.key === 'Enter' || event.key === ' ') abrirModalServicio({{ $index }})"

                @endif
            >


                @if (!empty($servicio['images']))

                    <img
                        src="{{ asset('images/' . $servicio['images'][0]) }}"
                        alt="{{ $servicio['title'] }}"
                        class="service-image">

                @else

                    <div class="service-no-image">

                        <i class="fas fa-image"></i>

                    </div>

                @endif


                <div class="glass-card-body">

                    <h4>
                        {{ $servicio['title'] }}
                    </h4>


                    @if (!empty($servicio['description']))

                        <p>
                            {{ $servicio['description'] }}
                        </p>

                    @endif


                    @if (count($servicio['images']) > 1)

                        <span class="image-count">

                            <i class="fas fa-images"></i>

                            {{ count($servicio['images']) }}

                            imágenes

                        </span>

                    @elseif (count($servicio['images']) === 1)

                        <span class="image-count">

                            <i class="fas fa-image"></i>

                            Ver imagen

                        </span>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

</section>

    {{-- MODALES DE SERVICIOS --}}

@foreach ($servicios as $index => $servicio)

    @if (!empty($servicio['images']))

        <div
            id="modalServicio{{ $index }}"
            class="talleres-modal servicio-modal"
            aria-hidden="true">


            <div
                class="talleres-modal-content"
                role="dialog"
                aria-modal="true">


                <button
                    type="button"
                    class="talleres-modal-close"
                    onclick="cerrarModalServicio({{ $index }})"
                    aria-label="Cerrar">

                    &times;

                </button>


                <div class="talleres-modal-header">

                    <span class="eyebrow">
                        Nuestros servicios
                    </span>

                    <h2>
                        {{ $servicio['title'] }}
                    </h2>

                </div>


                <div class="talleres-media-section">

                    <h3>

                        <i class="fa-solid fa-images"></i>

                        Imágenes

                    </h3>


                    <div class="talleres-gallery">

                        @foreach ($servicio['images'] as $imagen)

                            <div class="taller-gallery-item">

                                <img
                                    src="{{ asset('images/' . $imagen) }}"
                                    alt="{{ $servicio['title'] }}"
                                    loading="lazy"
                                    onclick="abrirImagenServicio(this.src)">

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- VIDEOS --}}
                @if (!empty($servicio['videos']))

                    <div class="talleres-media-section">

                        <h3>
                            <i class="fa-solid fa-video"></i>
                            Videos
                        </h3>

                        <div class="talleres-videos">

                            @foreach ($servicio['videos'] as $video)

                                <div class="taller-video-item">

                                    <video
                                        controls
                                        preload="metadata"
                                        playsinline>

                                        <source
                                            src="{{ asset('images/' . $video) }}"
                                            type="video/mp4">

                                        Tu navegador no soporta la reproducción de videos.

                                    </video>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

        </div>

    @endif

@endforeach

    {{-- VISOR DE IMAGEN DE SERVICIOS --}}

<div
    id="imagenServicioModal"
    class="imagen-taller-modal"
    onclick="cerrarImagenServicio()">


    <button
        type="button"
        class="imagen-taller-close"
        onclick="cerrarImagenServicio()"
        aria-label="Cerrar imagen">

        &times;

    </button>


    <img
        id="imagenServicioGrande"
        src=""
        alt="Imagen ampliada"
        onclick="event.stopPropagation()">

</div>

    {{-- JAVASCRIPT SERVICIOS --}}

<script>

function abrirModalServicio(index)
{
    const modal =
        document.getElementById('modalServicio' + index);

    if (!modal) return;

    modal.classList.add('activo');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'modal-open'
    );
}


function cerrarModalServicio(index)
{
    const modal =
        document.getElementById('modalServicio' + index);

    if (!modal) return;

    /* Pausar videos */
    modal.querySelectorAll('video').forEach(function(video) {
        video.pause();
        video.currentTime = 0;
    });

    modal.classList.remove('activo');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove(
        'modal-open'
    );
}


document
    .querySelectorAll('.servicio-modal')
    .forEach(function(modal)
    {

        modal.addEventListener(
            'click',
            function(event)
            {

                if (event.target === modal)
                {

                    const id =
                        modal.id.replace(
                            'modalServicio',
                            ''
                        );

                    cerrarModalServicio(id);

                }

            }
        );

    });


function abrirImagenServicio(src)
{
    const modal =
        document.getElementById(
            'imagenServicioModal'
        );

    const imagen =
        document.getElementById(
            'imagenServicioGrande'
        );

    if (!modal || !imagen) return;

    imagen.src = src;

    modal.classList.add('activo');
}


function cerrarImagenServicio()
{
    const modal =
        document.getElementById(
            'imagenServicioModal'
        );

    const imagen =
        document.getElementById(
            'imagenServicioGrande'
        );

    if (!modal) return;

    modal.classList.remove('activo');

    if (imagen)
    {
        imagen.src = '';
    }
}


document.addEventListener(
    'keydown',
    function(event)
    {

        if (event.key !== 'Escape') return;


        const visor =
            document.getElementById(
                'imagenServicioModal'
            );


        if (
            visor &&
            visor.classList.contains('activo')
        )
        {

            cerrarImagenServicio();

            return;

        }


        document
            .querySelectorAll('.servicio-modal')
            .forEach(function(modal)
            {

                if (
                    modal.classList.contains('activo')
                )
                {

                    const id =
                        modal.id.replace(
                            'modalServicio',
                            ''
                        );

                    cerrarModalServicio(id);

                }

            });

    }
);

</script>

    {{-- PROYECTOS --}}

<section
    id="projects"
    class="home-section">

    <div class="section-heading">

        <span class="eyebrow">
            Nuestro trabajo
        </span>

        <h2>
            Proyectos y <span>campañas</span> realizadas
        </h2>

        <p>
            Iniciativas en las que hemos trabajado junto a la comunidad.
        </p>

    </div>


    @php

        $proyectos = [
            [
                'title' => 'Campaña de prevención comunitaria',
                'images' => [
                    'projects/Campaña-prevencion/Campaña1.jpg',
                    'projects/Campaña-prevencion/Campaña2.jpg',
                    'projects/Campaña-prevencion/Campaña3.jpg',
                    'projects/Campaña-prevencion/Campaña4.jpg',
                    'projects/Campaña-prevencion/Campaña5.jpg',
                    'projects/Campaña-prevencion/Campaña6.jpg',
                    'projects/Campaña-prevencion/Campaña7.jpg',
                    'projects/Campaña-prevencion/Campaña8.jpg',
                    'projects/Campaña-prevencion/Campaña9.jpg',
                    'projects/Campaña-prevencion/Campaña10.jpg',
                    'projects/Campaña-prevencion/Campaña11.jpg',
                    'projects/Campaña-prevencion/Campaña12.jpg',
                    'projects/Campaña-prevencion/Campaña13.jpg',
                    'projects/Campaña-prevencion/Campaña14.jpg', 
                ],
            ],

            [
                'title' => 'Talleres de orientación y apoyo',
                'images' => [
                    'projects/Talleres de orientación y apoyo/Taller1.jpeg',
                    'projects/Talleres de orientación y apoyo/Taller2.jpeg',
                    'projects/Talleres de orientación y apoyo/Taller3.jpeg',
                    'projects/Talleres de orientación y apoyo/Taller4.jpeg',
                    'projects/Talleres de orientación y apoyo/Taller5.jpeg',
                    'projects/Talleres de orientación y apoyo/Taller8.jpg',
                ],
                'videos' => [
                    'projects/Talleres de orientación y apoyo/Taller6.mp4',
                ],
            ],

            [
                'title' => 'Material educativo digital',
                'pdfs' => [
                    'projects/Material educativo digital/Material1.pdf',
                    'projects/Material educativo digital/Material3.pdf',
                ],
                'videos' => [
                    'projects/Material educativo digital/Material2.mp4',
                ],
            ],
        ];
    @endphp

        {{-- TARJETAS --}}
    <div class="cards-grid">

        {{-- CAMPAÑA --}}
        <div
            class="project-tile project-clickable"
            onclick="abrirModalProyecto('modalCampania')"
            role="button"
            tabindex="0"
            onkeydown="if(event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                abrirModalProyecto('modalCampania');}">

            <img
                src="{{ asset('images/' . $proyectos[0]['images'][0]) }}"
                alt="{{ $proyectos[0]['title'] }}">

            <div class="project-overlay">

                <h5>
                    {{ $proyectos[0]['title'] }}
                </h5>

                <span class="project-view-more">
                    Ver imágenes →
                </span>

            </div>
        </div>

        {{-- TALLERES --}}

        <div
            class="project-tile project-clickable"
            onclick="abrirModalProyecto('modalTalleres')"
            role="button"
            tabindex="0"
            onkeydown="if(event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                abrirModalProyecto('modalTalleres');}">

            <img
                src="{{ asset('images/' . $proyectos[1]['images'][0]) }}"
                alt="{{ $proyectos[1]['title'] }}">

            <div class="project-overlay">

                <h5>
                    {{ $proyectos[1]['title'] }}
                </h5>

                <span class="project-view-more">
                    Ver imágenes y videos →
                </span>
            </div>
        </div>

        {{-- MATERIAL EDUCATIVO --}}
        <div
            class="project-tile project-clickable"
            onclick="abrirModalProyecto('modalMaterial')"
            role="button"
            tabindex="0"
            onkeydown="if(event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                abrirModalProyecto('modalMaterial');}">

            <div class="project-no-image">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="project-overlay">
                <h5>

                    {{ $proyectos[2]['title'] }}
                </h5>

                <span class="project-view-more">
                    Ver documentos y video →
                </span>

            </div>
        </div>
    </div>


    {{-- MODAL CAMPAÑA --}}
    <div
        id="modalCampania"
        class="talleres-modal"
        aria-hidden="true">

        <div
            class="talleres-modal-content"
            role="dialog"
            aria-modal="true"
            aria-labelledby="tituloCampania">

            <button
                type="button"
                class="talleres-modal-close"
                onclick="cerrarModalProyecto('modalCampania')"
                aria-label="Cerrar">
                &times;
            </button>


            <div class="talleres-modal-header">
                <span class="eyebrow">
                    Nuestro trabajo
                </span>

                <h2 id="tituloCampania">
                    Campaña de <span>prevención comunitaria</span>
                </h2>
            </div>


            <div class="talleres-media-section">
                <h3>
                    <i class="fa-solid fa-images"></i>
                    Imágenes
                </h3>


                <div class="talleres-gallery">
                    @foreach ($proyectos[0]['images'] as $imagen)
                        <div class="taller-gallery-item">
                            <img
                                src="{{ asset('images/' . $imagen) }}"
                                alt="Campaña de prevención comunitaria"
                                loading="lazy"
                                onclick="abrirImagenTaller(this.src)">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL TALLERES --}}
    <div
        id="modalTalleres"
        class="talleres-modal"
        aria-hidden="true">

        <div
            class="talleres-modal-content"
            role="dialog"
            aria-modal="true"
            aria-labelledby="tituloTalleres">

            <button
                type="button"
                class="talleres-modal-close"
                onclick="cerrarModalProyecto('modalTalleres')"
                aria-label="Cerrar">
                &times;
            </button>


            <div class="talleres-modal-header">
                <span class="eyebrow">
                    Nuestro trabajo
                </span>

                <h2 id="tituloTalleres">
                    Talleres de <span>orientación y apoyo</span>
                </h2>
            </div>


            {{-- IMÁGENES --}}
            <div class="talleres-media-section">
                <h3>
                    <i class="fa-solid fa-images"></i>
                    Imágenes
                </h3>


                <div class="talleres-gallery">
                    @foreach ($proyectos[1]['images'] as $imagen)
                        <div class="taller-gallery-item">
                            <img
                                src="{{ asset('images/' . $imagen) }}"
                                alt="Taller de orientación y apoyo"
                                loading="lazy"
                                onclick="abrirImagenTaller(this.src)">
                        </div>
                    @endforeach
                </div>
            </div>


            {{-- VIDEOS --}}

            <div class="talleres-media-section">
                <h3>
                    <i class="fa-solid fa-video"></i>
                    Videos
                </h3>


                <div class="talleres-videos">
                    @foreach ($proyectos[1]['videos'] as $video)
                        <div class="taller-video-item">
                            <video
                                controls
                                preload="metadata"
                                playsinline>
                                <source
                                    src="{{ asset('images/' . $video) }}"
                                    type="video/mp4">
                                Tu navegador no soporta la reproducción de videos.
                            </video>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL MATERIAL EDUCATIVO --}}
    <div
        id="modalMaterial"
        class="talleres-modal"
        aria-hidden="true">

        <div
            class="talleres-modal-content"
            role="dialog"
            aria-modal="true"
            aria-labelledby="tituloMaterial">


            {{-- X --}}
            <button
                type="button"
                class="talleres-modal-close"
                onclick="cerrarModalProyecto('modalMaterial')"
                aria-label="Cerrar">
                &times;
            </button>


            {{-- CONTENIDO DEL MATERIAL --}}
            <div
                id="materialContenido"
                class="material-contenido">

                <div class="talleres-modal-header">

                    <span class="eyebrow">
                        Nuestro trabajo
                    </span>

                    <h2 id="tituloMaterial">
                        Material <span>educativo digital</span>
                    </h2>

                </div>

                {{-- PDF --}}
                <div class="talleres-media-section">
                    <h3>
                        <i class="fas fa-file-pdf"></i>
                        Documentos
                    </h3>

                    <div class="material-pdf-grid">
                        @foreach ($proyectos[2]['pdfs'] as $pdf)
                            <a
                                href="{{ asset('images/' . $pdf) }}"
                                class="material-pdf-item"
                                onclick="abrirPdfMaterial('{{ asset('images/' . $pdf) }}'); return false;">
                                <i class="fas fa-file-pdf"></i>
                                <span>
                                    {{ basename($pdf) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- VIDEO --}}
                <div class="talleres-media-section">
                    <h3>
                        <i class="fa-solid fa-video"></i>
                        Videos
                    </h3>

                    <div class="talleres-videos">
                        @foreach ($proyectos[2]['videos'] as $video)
                            <div class="taller-video-item">
                                <video
                                    controls
                                    preload="metadata"
                                    playsinline>
                                    <source
                                        src="{{ asset('images/' . $video) }}"
                                        type="video/mp4">
                                    Tu navegador no soporta la reproducción de videos.
                                </video>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- VISOR PDF --}}
            <div
                id="pdfMaterialViewer"
                class="pdf-material-viewer"
                aria-hidden="true">

                <button
                    type="button"
                    class="pdf-material-close"
                    onclick="cerrarPdfMaterial()"
                    aria-label="Volver a Material educativo">
                    <i class="fas fa-arrow-left"></i>
                    <span>
                        Volver
                    </span>
                </button>

                <iframe
                    id="pdfMaterialFrame"
                    src=""
                    title="Visor PDF">
                </iframe>
            </div>
        </div>
    </div>

    {{-- VISOR DE IMÁGENES --}}
    <div
        id="imagenTallerModal"
        class="imagen-taller-modal"
        onclick="cerrarImagenTaller()">

        <button
            type="button"
            class="imagen-taller-close"
            onclick="cerrarImagenTaller()"
            aria-label="Cerrar imagen">
            &times;
        </button>

        <img
            id="imagenTallerGrande"
            src=""
            alt="Imagen ampliada"
            onclick="event.stopPropagation()">
    </div>
        </section>

    {{-- JAVASCRIPT PROYECTOS --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {


    /* ABRIR MODAL */
    window.abrirModalProyecto = function (id) {
        const modal = document.getElementById(id);
        if (!modal) {
            console.error('No existe el modal: ' + id);
            return;
        }

        /* Cerrar cualquier otro modal abierto */
        document
            .querySelectorAll('.talleres-modal.activo')
            .forEach(function (otroModal) {
                if (otroModal.id !== id) {
                    cerrarModalProyecto(otroModal.id);
                }
            });

        modal.classList.add('activo');
        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add(
            'modal-open'
        );
    };

    /* CERRAR MODAL */
    window.cerrarModalProyecto = function (id) {
        const modal = document.getElementById(id);
        if (!modal) {
            return;
        }

        /* Pausar videos */
        modal
            .querySelectorAll('video')
            .forEach(function (video) {
                video.pause();
                video.currentTime = 0;
            });


        /* Si es Material, cerrar también PDF */
        if (id === 'modalMaterial') {
            cerrarPdfMaterial();
        }

        modal.classList.remove(
            'activo'
        );

        modal.setAttribute(
            'aria-hidden',
            'true'
        );


        /* Solo quitar modal-open si no queda otro modal */
        const quedaOtroModal =
            document.querySelector(
                '.talleres-modal.activo'
            );

        if (!quedaOtroModal) {
            document.body.classList.remove(
                'modal-open'
            );
        }
    };

    /* ABRIR PDF */
    window.abrirPdfMaterial = function (url) {
        const contenido =
            document.getElementById(
                'materialContenido'
            );

        const visor =
            document.getElementById(
                'pdfMaterialViewer'
            );

        const frame =
            document.getElementById(
                'pdfMaterialFrame'
            );

        if (!visor || !frame) {
            console.error(
                'No se encontró el visor PDF.'
            );
            return;
        }

        frame.src = url;
        if (contenido) {
            contenido.style.display =
                'none';
        }

        visor.classList.add(
            'activo'
        );

        visor.setAttribute(
            'aria-hidden',
            'false'
        );
    };

    /* CERRAR PDF / VOLVER A MATERIAL */
    window.cerrarPdfMaterial = function () {
        const contenido =
            document.getElementById(
                'materialContenido'
            );

        const visor =
            document.getElementById(
                'pdfMaterialViewer'
            );

        const frame =
            document.getElementById(
                'pdfMaterialFrame'
            );

        if (visor) {
            visor.classList.remove(
                'activo'
            );

            visor.setAttribute(
                'aria-hidden',
                'true'
            );
        }

        if (frame) {
            frame.src = '';
        }

        if (contenido) {
            contenido.style.display =
                '';
        }
    };

    /* VISOR DE IMAGEN */
    window.abrirImagenTaller = function (src) {
        const modal =
            document.getElementById(
                'imagenTallerModal'
            );

        const imagen =
            document.getElementById(
                'imagenTallerGrande'
            );

        if (!modal || !imagen) {
            return;
        }

        imagen.src = src;
        modal.classList.add(
            'activo'
        );
    };

    /* CERRAR VISOR DE IMAGEN */
    window.cerrarImagenTaller = function () {
        const modal =
            document.getElementById(
                'imagenTallerModal'
            );

        const imagen =
            document.getElementById(
                'imagenTallerGrande'
            );

        if (!modal) {
            return;
        }

        modal.classList.remove(
            'activo'
        );

        if (imagen) {
            imagen.src = '';
        }
    };

    /* CERRAR AL HACER CLICK FUERA DEL CONTENIDO */
    document
        .querySelectorAll('.talleres-modal')
        .forEach(function (modal) {

            modal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target === modal
                    ) {

                        cerrarModalProyecto(
                            modal.id
                        );
                    }
                }
            );
        });

    /* ESCAPE */
    document.addEventListener(
        'keydown',
        function (event) {
            if (event.key !== 'Escape') {
                return;
            }

            /* Primero cerrar visor de imagen */
            const imagenModal =
                document.getElementById(
                    'imagenTallerModal'
                );

            if (
                imagenModal &&
                imagenModal.classList.contains(
                    'activo'
                )
            ) {

                cerrarImagenTaller();
                return;
            }

            /* Después cerrar PDF */
            const pdfViewer =
                document.getElementById(
                    'pdfMaterialViewer'
                );

            if (
                pdfViewer &&
                pdfViewer.classList.contains(
                    'activo'
                )
            ) {

                cerrarPdfMaterial();
                return;
            }

            /* Finalmente cerrar modal */
            document
                .querySelectorAll(
                    '.talleres-modal.activo'
                )
                .forEach(function (modal) {
                    cerrarModalProyecto(
                        modal.id
                    );
                });
        }
    );
    });
    </script>

    {{-- NOSOTROS --}}
<section
    id="infos"
    class="home-section">

    {{-- TÍTULO DE NOSOTROS --}}
    <div class="section-heading">
        <span class="eyebrow">
            Conócenos
        </span>

        <h2>
            <span>Nosotros</span>
        </h2>
    </div>


    {{-- CONTENIDO DE NOSOTROS --}}
    <div
        class="row align-items-center"
        style="
            display:flex;
            flex-wrap:wrap;
            gap:40px;">

        {{-- IMAGEN / LOGO --}}
        <div
            style="
                flex:1 1 380px;
                text-align:center;">

            <img
                src="{{ asset('images/logo2.png') }}"
                alt="Sobre nosotros"
                class="about-img-glass"
                style="
                    width:100%;
                    max-width:550px;
                    display:block;
                    margin:0 auto;">
        </div>


        {{-- INFORMACIÓN --}}
        <div
            style="
                flex:1 1 380px;">


            <h2
                style="
                    color:#111827;
                    margin:12px 0 18px;">

                Comprometidos con tu

                <span style="color:#111827;">
                    bienestar
                </span>
            </h2>

            <p
                style="
                    color:#6b7280;
                    margin-bottom:25px;">

                Trabajamos para acercar información clara, preventiva
                y humana a quienes la necesitan, con el objetivo de
                generar comunidades más informadas y resilientes.
            </p>


            {{-- ORIENTACIÓN --}}

            <div class="progress-item">
                <div class="progress-label">
                    <span>
                        Orientación
                    </span>
                    <span>
                        95%
                    </span>
                </div>
                <div class="progress-track">
                    <div
                        class="progress-fill"
                        style="width:95%;">
                    </div>
                </div>
            </div>


            {{-- ACOMPAÑAMIENTO --}}

            <div class="progress-item">
                <div class="progress-label">
                    <span>
                        Acompañamiento
                    </span>
                    <span>
                        100%
                    </span>
                </div>
                <div class="progress-track">
                    <div
                        class="progress-fill"
                        style="width:100%;">
                    </div>
                </div>
            </div>


            {{-- DIFUSIÓN COMUNITARIA --}}

            <div class="progress-item">
                <div class="progress-label">
                    <span>
                        Difusión Comunitaria
                    </span>
                    <span>
                        95%
                    </span>
                </div>
                <div class="progress-track">
                    <div
                        class="progress-fill"
                        style="width:95%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
        </section>

    {{-- GALERÍA --}}
<section
    id="gallery"
    class="home-section">
    <div class="section-heading">
        <span class="eyebrow">
            Nuestra actividad
        </span>

        <h2>
            Galería de <span>actividades</span>
        </h2>

        <p>
            Conoce algunas de las actividades, campañas, talleres
            y acciones realizadas por nuestra comunidad.
        </p>
    </div>

    @php
        $galeria = [
            'titulo' => 'Galería de actividades',
            'images' => [
                'Nosotros/01.jpeg',
                'Nosotros/Clínica1.jpg',
                'Nosotros/Clínica2.jpg',
                'Nosotros/Clínica3.jpeg',
                'Nosotros/Clínica4.jpg',
                'Nosotros/Clínica5.jpeg',
                'Nosotros/Clínica6.jpeg',
                'Nosotros/Clínica7.jpeg',
            ],

            'videos' => [
                'Nosotros/Clínica8.mp4',
                'Nosotros/Clínica9.mp4',
                'Nosotros/Clínica10.mp4',
                'Nosotros/Clínica11.mp4',
            ],
        ];
    @endphp


    {{-- TARJETA DE GALERÍA --}}
    <div class="cards-grid">
        <div
            class="project-tile project-clickable gallery-project-card"
            onclick="abrirModalGaleria()"
            role="button"
            tabindex="0"
            onkeydown="
                if(event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    abrirModalGaleria();}">

            <img
                src="{{ asset('images/' . $galeria['images'][0]) }}"
                alt="{{ $galeria['titulo'] }}">
            <div class="project-overlay">

                <h5>
                    {{ $galeria['titulo'] }}
                </h5>
                <span class="project-view-more">
                    Ver imágenes y videos →
                </span>
            </div>
        </div>
    </div>


    {{-- MODAL GALERÍA --}}
    <div
        id="modalGaleria"
        class="talleres-modal"
        aria-hidden="true">

        <div
            class="talleres-modal-content"
            role="dialog"
            aria-modal="true"
            aria-labelledby="tituloGaleria">

            {{-- BOTÓN X --}}
            <button
                type="button"
                class="talleres-modal-close"
                onclick="cerrarModalGaleria()"
                aria-label="Cerrar">
                &times;
            </button>

            <div class="talleres-modal-header">
                <span class="eyebrow">
                    Nuestra actividad
                </span>

                <h2 id="tituloGaleria">
                    Galería de <span>actividades</span>
                </h2>
            </div>

            {{-- IMÁGENES --}}
            <div class="talleres-media-section">
                <h3>
                    <i class="fa-solid fa-images"></i>
                    Imágenes
                </h3>

                <div class="talleres-gallery">
                    @foreach ($galeria['images'] as $imagen)
                        <div class="taller-gallery-item">

                            <img
                                src="{{ asset('images/' . $imagen) }}"
                                alt="Actividad de la galería"
                                loading="lazy"
                                onclick="abrirImagenGaleria(this.src)">
                        </div>
                    @endforeach
                </div>
            </div>


            {{-- VIDEOS --}}
            <div class="talleres-media-section">
                <h3>
                    <i class="fa-solid fa-video"></i>
                    Videos
                </h3>

                <div class="talleres-videos">
                    @foreach ($galeria['videos'] as $video)
                        <div class="taller-video-item">
                            <video
                                controls
                                preload="metadata"
                                playsinline>
                                <source
                                    src="{{ asset('images/' . $video) }}"
                                    type="video/mp4">
                                Tu navegador no puede reproducir este video.
                            </video>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    {{-- VISOR DE IMAGEN DE GALERÍA --}}
    <div
        id="imagenGaleriaModal"
        class="imagen-taller-modal"
        onclick="cerrarImagenGaleria()">

        <button
            type="button"
            class="imagen-taller-close"
            onclick="cerrarImagenGaleria()"
            aria-label="Cerrar imagen">
            &times;
        </button>

        <img
            id="imagenGaleriaGrande"
            src=""
            alt="Imagen ampliada"
            onclick="event.stopPropagation()">
    </div>
</section>
<script>

function abrirModalGaleria()
{
    const modal = document.getElementById('modalGaleria');
    if (!modal) return;

    modal.classList.add('activo');
    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add('modal-open');
}

function cerrarModalGaleria()
{
    const modal = document.getElementById('modalGaleria');

    if (!modal) return;

    modal.querySelectorAll('video').forEach(function(video) {
        video.pause();
        video.currentTime = 0;
    });

    modal.classList.remove('activo');
    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove('modal-open');
}

function abrirImagenGaleria(src)
{
    const modal =
        document.getElementById('imagenGaleriaModal');

    const imagen =
        document.getElementById('imagenGaleriaGrande');

    if (!modal || !imagen) return;
        imagen.src = src;
        modal.classList.add('activo');
}

function cerrarImagenGaleria()
{
    const modal =
        document.getElementById('imagenGaleriaModal');

    const imagen =
        document.getElementById('imagenGaleriaGrande');

    if (!modal) return;
        modal.classList.remove('activo');

    if (imagen) {
        imagen.src = '';
    }
}

document.addEventListener('DOMContentLoaded', function()
{
    const modal =
        document.getElementById('modalGaleria');

    if (modal) {
        modal.addEventListener('click', function(event)
        {
    if (event.target === modal) {
        cerrarModalGaleria();
        }
        });
    }
});

document.addEventListener('keydown', function(event)
{
    if (event.key !== 'Escape') return;
    const imagen =
        document.getElementById('imagenGaleriaModal');

    if (
        imagen &&
        imagen.classList.contains('activo')
    ) {

        cerrarImagenGaleria();
        return;
    }

    const galeria =
        document.getElementById('modalGaleria');

    if (
        galeria &&
        galeria.classList.contains('activo')
    ) {

        cerrarModalGaleria();
    }
});

</script>

    {{-- CONTACTO --}}
<section
    id="contact"
    class="home-section contact-section">
    <div class="section-heading">
    <h2 style="
        font-size: 1.2rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;">
        Dirección
    </h2>

    <p style="
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin: 0;">
        6ta. calle 22-39 Zona 3, Quetzaltenango, Guatemala
    </p>
        </div>

    {{-- FOOTER --}}
<footer class="home-footer">
    Copyright &copy; {{ date('Y') }}
    <a href="#">
        UMG
    </a>
    Todos los derechos reservados.
    </footer>
        </body>
            </html>