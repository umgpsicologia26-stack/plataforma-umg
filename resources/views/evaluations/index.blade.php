<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Evaluaciones</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
>

<style>
    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #0a0f2a;
        color: #f8fafc;
        overflow-x: hidden;
    }

    .evaluation-page {
        position: relative;
        min-height: 100vh;
        padding: 40px 20px 60px;
        overflow: hidden;
    }

    /* Capa base: gradiente animado en CSS puro. Se ve siempre,
       sin depender de que cargue una libreria externa, y le da
       color y movimiento de fondo a toda la pagina. */
    #bg-css {
        position: fixed;
        inset: -10%;
        width: 120%;
        height: 120%;
        z-index: 0;
        pointer-events: none;

        background:
            radial-gradient(circle at 18% 22%, rgba(96, 165, 250, 0.55), transparent 42%),
            radial-gradient(circle at 82% 18%, rgba(167, 139, 250, 0.50), transparent 45%),
            radial-gradient(circle at 25% 82%, rgba(94, 234, 212, 0.40), transparent 45%),
            radial-gradient(circle at 80% 78%, rgba(240, 171, 252, 0.35), transparent 45%),
            linear-gradient(160deg, #0a0f2a 0%, #121238 45%, #0a0f2a 100%);

        background-size: 160% 160%;
        animation: driftGradient 22s ease-in-out infinite alternate;
        filter: blur(10px);
    }

    @keyframes driftGradient {
        0% {
            background-position: 0% 20%, 100% 0%, 10% 100%, 90% 80%, 0% 0%;
        }
        50% {
            background-position: 20% 40%, 80% 25%, 25% 80%, 75% 60%, 0% 0%;
        }
        100% {
            background-position: 5% 10%, 95% 15%, 15% 95%, 85% 70%, 0% 0%;
        }
    }

    /* Contenedor del fondo 3D animado (Three.js), transparente,
       se dibuja encima del gradiente CSS para dar profundidad real */
    #bg-scene {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        display: block;
    }

    /* Velo minimo, solo lo necesario para que el texto
       del centro se lea con comodidad, sin apagar el fondo */
    .bg-veil {
        position: fixed;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background:
            radial-gradient(ellipse 65% 60% at 50% 32%, rgba(10, 15, 31, 0.10), rgba(10, 15, 31, 0.40) 78%);
    }

    .container-evaluations {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 3;
    }

    .top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 45px;
        gap: 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 11px 18px;
        border-radius: 12px;
        text-decoration: none;
        color: #e2e8f0;
        background: rgba(30, 41, 59, 0.72);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        transition: all 0.25s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .back-button:hover {
        transform: translateX(-4px);
        background: rgba(51, 65, 85, 0.9);
        border-color: rgba(148, 163, 184, 0.4);
    }

    .page-header {
        text-align: center;
        margin-bottom: 45px;
    }

    .page-header .icon {
        width: 75px;
        height: 75px;
        margin: 0 auto 20px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(96, 165, 250, 0.25);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .page-header h1 {
        margin: 0 0 12px;
        font-size: clamp(30px, 5vw, 46px);
        font-weight: 700;
        letter-spacing: -1px;
    }

    .page-header p {
        max-width: 700px;
        margin: 0 auto;
        color: #cbd5e1;
        font-size: 15px;
        line-height: 1.7;
    }

    .alert {
        max-width: 900px;
        margin: 0 auto 25px;
        padding: 15px 18px;
        border-radius: 14px;
        backdrop-filter: blur(10px);
        font-size: 14px;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.12);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #bbf7d0;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fecaca;
    }

    .alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .validation-errors {
        max-width: 900px;
        margin: 0 auto 25px;
        padding: 16px 20px;
        border-radius: 14px;
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fecaca;
    }

    .validation-errors strong {
        display: block;
        margin-bottom: 8px;
    }

    .validation-errors ul {
        margin: 0;
        padding-left: 20px;
    }

    .evaluations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
        gap: 25px;
    }

    .evaluation-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 310px;
        padding: 28px;
        border-radius: 22px;
        background: rgba(30, 41, 59, 0.62);
        border: 1px solid rgba(148, 163, 184, 0.16);
        backdrop-filter: blur(18px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
        overflow: hidden;
        transition:
            transform 0.3s ease,
            border-color 0.3s ease,
            box-shadow 0.3s ease;
    }

    .evaluation-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(
            90deg,
            #3b82f6,
            #8b5cf6
        );
        opacity: 0.9;
    }

    .evaluation-card:hover {
        transform: translateY(-7px);
        border-color: rgba(96, 165, 250, 0.35);
        box-shadow: 0 28px 65px rgba(0, 0, 0, 0.32);
    }

    .evaluation-card.completed {
        border-color: rgba(34, 197, 94, 0.28);
        background: rgba(30, 41, 59, 0.52);
    }

    .evaluation-card.completed::before {
        background: #22c55e;
    }

    .evaluation-card.completed:hover {
        transform: translateY(-3px);
        border-color: rgba(34, 197, 94, 0.38);
    }

    .evaluation-icon {
        width: 58px;
        height: 58px;
        border-radius: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 22px;
        background: rgba(59, 130, 246, 0.13);
        border: 1px solid rgba(96, 165, 250, 0.2);
    }

    .evaluation-card.completed .evaluation-icon {
        background: rgba(34, 197, 94, 0.12);
        border-color: rgba(34, 197, 94, 0.25);
    }

    .evaluation-card h2 {
        margin: 0 0 12px;
        color: #f8fafc;
        font-size: 20px;
        line-height: 1.35;
        font-weight: 600;
    }

    .evaluation-description {
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.7;
        margin: 0 0 22px;
        flex: 1;
    }

    .evaluation-status {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        margin-bottom: 20px;
        padding: 6px 11px;
        border-radius: 999px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(96, 165, 250, 0.22);
        color: #93c5fd;
        font-size: 12px;
        font-weight: 600;
    }

    .start-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 48px;
        padding: 12px 18px;
        border-radius: 13px;
        text-decoration: none;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            #2563eb,
            #7c3aed
        );
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 14px;
        font-weight: 600;
        transition: all 0.25s ease;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
    }

    .start-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.3);
        filter: brightness(1.08);
    }

    .completed-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 48px;
        padding: 12px 18px;
        border-radius: 13px;
        background: rgba(34, 197, 94, 0.12);
        border: 1px solid rgba(34, 197, 94, 0.25);
        color: #86efac;
        font-size: 14px;
        font-weight: 600;
    }

    .completed-message {
        margin: 10px 0 0;
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.5;
        text-align: center;
    }

    .empty-state {
        max-width: 650px;
        margin: 30px auto 0;
        padding: 50px 30px;
        text-align: center;
        border-radius: 22px;
        background: rgba(30, 41, 59, 0.65);
        border: 1px solid rgba(148, 163, 184, 0.16);
        backdrop-filter: blur(15px);
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .empty-state h2 {
        margin: 0 0 10px;
        font-size: 22px;
    }

    .empty-state p {
        margin: 0;
        color: #94a3b8;
        line-height: 1.7;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .evaluation-page {
            padding: 25px 15px 45px;
        }

        .top-bar {
            margin-bottom: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 32px;
        }

        .page-header p {
            font-size: 14px;
        }

        .evaluations-grid {
            grid-template-columns: 1fr;
        }

        .evaluation-card {
            min-height: auto;
            padding: 24px;
        }
    }

    @media (max-width: 480px) {
        .back-button {
            padding: 9px 13px;
            font-size: 13px;
        }

        .page-header .icon {
            width: 65px;
            height: 65px;
            font-size: 28px;
        }

        .evaluation-card {
            padding: 21px;
            border-radius: 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        #bg-scene {
            display: none;
        }

        #bg-css {
            animation: none;
        }
    }
</style>


</head>

<body>

<div id="bg-css"></div>
<canvas id="bg-scene"></canvas>
<div class="bg-veil"></div>

<div class="evaluation-page">

<div class="container-evaluations">

    <div class="top-bar">

        <a
            href="{{ route('dashboard') }}"
            class="back-button"
        >
            ← Volver al inicio
        </a>

    </div>

    <div class="page-header">

        <div class="icon">
            📝
        </div>

        <h1>
            Evaluaciones
        </h1>

        <p>
            Responde las evaluaciones disponibles para conocer mejor
            tu situación y recibir orientación de acuerdo con tus respuestas.
        </p>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-error">
            {{ session('error') }}
        </div>

    @endif

    @if($errors->any())

        <div class="validation-errors">

            <strong>
                No se pudo completar la operación:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    @if($evaluaciones->isEmpty())

        <div class="empty-state">

            <div class="empty-state-icon">
                📋
            </div>

            <h2>
                No hay evaluaciones disponibles
            </h2>

            <p>
                Actualmente no existen evaluaciones activas.
                Puedes volver más tarde para consultar si hay nuevas
                evaluaciones disponibles.
            </p>

        </div>

    @else

        <div class="evaluations-grid">

            @foreach($evaluaciones as $evaluacion)

                @php
                    $completada = in_array(
                        $evaluacion->uuid,
                        $evaluacionesCompletadas ?? []
                    );
                @endphp

                <article
                    class="evaluation-card {{ $completada ? 'completed' : '' }}"
                >

                    <div class="evaluation-icon">
                        {{ $completada ? '✓' : '📝' }}
                    </div>

                    <h2>
                        {{ $evaluacion->title }}
                    </h2>

                    <p class="evaluation-description">
                        {{ $evaluacion->description ?: 'Esta evaluación contiene una serie de preguntas que debes responder de acuerdo con tu situación.' }}
                    </p>

                    <div class="evaluation-status">

                        {{ $evaluacion->preguntas->count() }}

                        {{ $evaluacion->preguntas->count() === 1 ? 'pregunta' : 'preguntas' }}

                    </div>

                    @if($completada)

                        <div class="completed-badge">
                            ✓ Evaluación completada
                        </div>

                        <p class="completed-message">
                            Ya has respondido esta evaluación.
                            No es posible realizarla nuevamente.
                        </p>

                    @else

                        <a
                            href="{{ route('evaluation.show', $evaluacion->uuid) }}"
                            class="start-button"
                        >
                            Comenzar evaluación →
                        </a>

                    @endif

                </article>

            @endforeach

        </div>

    @endif

</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    (function () {

        var prefersReducedMotion =
            window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion || typeof THREE === 'undefined') {
            return;
        }

        var canvas = document.getElementById('bg-scene');

        var renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true,
            alpha: true
        });

        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x000000, 0);

        var scene = new THREE.Scene();

        var camera = new THREE.PerspectiveCamera(
            55,
            window.innerWidth / window.innerHeight,
            0.1,
            200
        );

        camera.position.set(0, 0, 24);

        scene.fog = new THREE.FogExp2(0x0a0f2a, 0.009);

        scene.add(new THREE.AmbientLight(0x9db4ff, 0.85));

        var lightA = new THREE.PointLight(0x7dd3fc, 2.2, 140);
        lightA.position.set(-18, 12, 22);
        scene.add(lightA);

        var lightB = new THREE.PointLight(0xc084fc, 2.0, 140);
        lightB.position.set(20, -8, 18);
        scene.add(lightB);

        var lightC = new THREE.PointLight(0xffffff, 0.8, 100);
        lightC.position.set(0, 0, 30);
        scene.add(lightC);

                var palette = [0x60a5fa, 0xa78bfa, 0x5eead4, 0xf0abfc, 0x818cf8];

        var orbs = [];
        var orbCount = 20;

        for (var i = 0; i < orbCount; i++) {

            var radius = 2.2 + Math.random() * 4.2;
            var orbColor = palette[i % palette.length];

            var geometry = new THREE.SphereGeometry(radius, 32, 32);

            var material = new THREE.MeshPhysicalMaterial({
                color: orbColor,
                emissive: orbColor,
                emissiveIntensity: 0.35,
                transparent: true,
                opacity: 0.38 + Math.random() * 0.20,
                roughness: 0.15,
                metalness: 0.05,
                transmission: 0.25,
                clearcoat: 0.8
            });

            var mesh = new THREE.Mesh(geometry, material);

            mesh.position.set(
                (Math.random() - 0.5) * 55,
                (Math.random() - 0.5) * 36,
                (Math.random() - 0.5) * 38 - 6
            );

            mesh.userData = {
                baseY: mesh.position.y,
                baseX: mesh.position.x,
                speed: 0.15 + Math.random() * 0.25,
                offset: Math.random() * Math.PI * 2,
                drift: 1.5 + Math.random() * 2.5
            };

            scene.add(mesh);
            orbs.push(mesh);

        }

        /* --------------------------------------------------
           Constelacion de particulas conectadas: alude a
           conexiones neuronales / procesos de pensamiento,
           con un movimiento lento tipo "respiracion".
           -------------------------------------------------- */
        var particleCount = 90;
        var positions = new Float32Array(particleCount * 3);
        var basePositions = new Float32Array(particleCount * 3);

        for (var p = 0; p < particleCount; p++) {

            var x = (Math.random() - 0.5) * 80;
            var y = (Math.random() - 0.5) * 55;
            var z = (Math.random() - 0.5) * 60 - 5;

            positions[p * 3] = x;
            positions[p * 3 + 1] = y;
            positions[p * 3 + 2] = z;

            basePositions[p * 3] = x;
            basePositions[p * 3 + 1] = y;
            basePositions[p * 3 + 2] = z;

        }

        var particlesGeometry = new THREE.BufferGeometry();
        particlesGeometry.setAttribute(
            'position',
            new THREE.BufferAttribute(positions, 3)
        );

        var particlesMaterial = new THREE.PointsMaterial({
            color: 0xbfdbfe,
            size: 0.5,
            transparent: true,
            opacity: 0.75,
            sizeAttenuation: true
        });

        var particles = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particles);

        /* Lineas tenues entre particulas cercanas, evocando
           una red de conexiones mentales. */
        var lineGeometry = new THREE.BufferGeometry();
        var maxLines = 70;
        var linePositions = new Float32Array(maxLines * 2 * 3);
        lineGeometry.setAttribute(
            'position',
            new THREE.BufferAttribute(linePositions, 3)
        );

        var lineMaterial = new THREE.LineBasicMaterial({
            color: 0x93e8f9,
            transparent: true,
            opacity: 0.28
        });

        var lines = new THREE.LineSegments(lineGeometry, lineMaterial);
        scene.add(lines);

        function rebuildLines() {

            var lineIndex = 0;

            for (var a = 0; a < particleCount && lineIndex < maxLines; a++) {

                for (var b = a + 1; b < particleCount && lineIndex < maxLines; b++) {

                    var dx = positions[a * 3] - positions[b * 3];
                    var dy = positions[a * 3 + 1] - positions[b * 3 + 1];
                    var dz = positions[a * 3 + 2] - positions[b * 3 + 2];

                    var distSq = dx * dx + dy * dy + dz * dz;

                    if (distSq < 60) {

                        linePositions[lineIndex * 6] = positions[a * 3];
                        linePositions[lineIndex * 6 + 1] = positions[a * 3 + 1];
                        linePositions[lineIndex * 6 + 2] = positions[a * 3 + 2];

                        linePositions[lineIndex * 6 + 3] = positions[b * 3];
                        linePositions[lineIndex * 6 + 4] = positions[b * 3 + 1];
                        linePositions[lineIndex * 6 + 5] = positions[b * 3 + 2];

                        lineIndex++;

                    }

                }

            }

            lineGeometry.attributes.position.needsUpdate = true;
            lineGeometry.setDrawRange(0, lineIndex * 2);

        }

        /* Paralaje suave con el movimiento del mouse,
           para que el fondo se sienta interactivo. */
        var mouseX = 0;
        var mouseY = 0;

        window.addEventListener('mousemove', function (event) {

            mouseX = (event.clientX / window.innerWidth - 0.5) * 2;
            mouseY = (event.clientY / window.innerHeight - 0.5) * 2;

        });

        window.addEventListener('touchmove', function (event) {

            if (!event.touches || !event.touches.length) {
                return;
            }

            var touch = event.touches[0];

            mouseX = (touch.clientX / window.innerWidth - 0.5) * 2;
            mouseY = (touch.clientY / window.innerHeight - 0.5) * 2;

        }, { passive: true });

        var clock = new THREE.Clock();
        var frame = 0;

        function animate() {

            requestAnimationFrame(animate);

            var t = clock.getElapsedTime();

            orbs.forEach(function (orb) {

                var d = orb.userData;

                orb.position.y = d.baseY + Math.sin(t * d.speed + d.offset) * d.drift;
                orb.position.x = d.baseX + Math.cos(t * d.speed * 0.6 + d.offset) * (d.drift * 0.6);

                orb.rotation.x += 0.0009;
                orb.rotation.y += 0.0013;

            });

            for (var p = 0; p < particleCount; p++) {

                positions[p * 3 + 1] =
                    basePositions[p * 3 + 1] +
                    Math.sin(t * 0.3 + p) * 1.4;

                positions[p * 3] =
                    basePositions[p * 3] +
                    Math.cos(t * 0.2 + p) * 1.0;

            }

            particlesGeometry.attributes.position.needsUpdate = true;

            /* Reconstruir lineas cada pocos frames por rendimiento */
            frame++;
            if (frame % 4 === 0) {
                rebuildLines();
            }

            /* Paralaje de camara segun el mouse, con
               interpolacion suave para sensacion organica */
            camera.position.x += (mouseX * 4 - camera.position.x) * 0.02;
            camera.position.y += (-mouseY * 3 - camera.position.y) * 0.02;
            camera.lookAt(scene.position);

            scene.rotation.y = Math.sin(t * 0.03) * 0.05;

            renderer.render(scene, camera);

        }

        animate();

        window.addEventListener('resize', function () {

            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();

            renderer.setSize(window.innerWidth, window.innerHeight);

        });

    })();
</script>

</body>

</html>