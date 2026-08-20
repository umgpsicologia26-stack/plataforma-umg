<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Plataforma de Apoyo</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    overflow-x:hidden;
}
/* ==========================================
NAVBAR MODERNA
========================================== */

.navbar{
    width:95%;
    max-width:1400px;
    margin:20px auto;
    padding:18px 35px;

    background:rgba(255,255,255,0.95);

    backdrop-filter:blur(15px);

    border-radius:35px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    box-shadow:
    0 10px 30px rgba(0,0,0,.12);

    position:relative;
    z-index:1000;
}

.nav-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.nav-logo{
    width:70px;
    height:70px;
    object-fit:contain;
}

.brand{
    display:flex;
    flex-direction:column;
}

.brand h2{
    font-size:26px;
    font-weight:800;
    color:#2563eb;
}

.brand span{
    font-size:13px;
    color:#64748b;
}

.nav-center{
    display:flex;
    align-items:center;
    gap:30px;
}

.nav-center a{

    display:flex;
    align-items:center;
    gap:8px;
    padding:12px 20px;
    background:#f1f5f9;
    border-radius:14px;
    text-decoration:none;
    color:#334155;
    font-size:14px;
    font-weight:600;
    transition:.3s ease;
}

.nav-center a:hover{
    background:#2563eb;
    color:white;
    transform:translateY(-3px);
    box-shadow:
    0 10px 25px rgba(37,99,235,.25);
}

.nav-right{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:15px;
}

.admin-btn{
    background:linear-gradient(
        135deg,
        #2563eb,
        #1d4ed8
    );

    color:white;
    text-decoration:none;
    padding:12px 22px;
    border-radius:15px;
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:700;
    transition:.3s;
}

.admin-btn:hover{
    color:white;
    transform:translateY(-3px);
    box-shadow:
    0 10px 25px rgba(37,99,235,.35);
}

.logout-btn{
    background:#ef4444;
    color:white;
    border:none;
    padding:12px 22px;
    border-radius:15px;
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:700;
    transition:.3s;
    cursor:pointer;
    font-family:'Poppins',sans-serif;
    font-size:14px;
}

.logout-btn:hover{
    background:#dc2626;
    color:white;
    transform:translateY(-3px);
}

/* ==========================================
HERO SECTION
========================================== */

.hero-section{
    position:relative;
    overflow:hidden;
    background:linear-gradient(
        135deg,
        #4f46e5 0%,
        #7c3aed 50%,
        #d946ef 100%
    );

    border-radius:0 0 80px 80px;
    padding:80px 60px 180px 60px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.hero-content{
    max-width:650px;
    z-index:2;
}

.hero-content h1{
    color:white;
    font-size:4rem;
    font-weight:800;
    line-height:1.1;
    margin-bottom:25px;
}

.hero-content p{
    font-size:1.2rem;
    line-height:1.8;
    opacity:.95;
}

.hero-buttons{
    display:flex;
    gap:15px;
    margin-top:35px;
    flex-wrap:wrap;
}

.hero-btn{
    padding:15px 30px;
    border-radius:15px;
    text-decoration:none;
    font-weight:700;
    transition:.3s;
}

.hero-btn-primary{
    background:white;
    color:#4f46e5;
}

.hero-btn-secondary{
    border:2px solid rgba(255,255,255,.5);
    color:white;
}

.hero-btn:hover{
    transform:translateY(-3px);
}

.hero-image{
    max-width:500px;
}

.hero-image img{
    width:100%;
}

.wave{
    position:absolute;
    bottom:-5px;
    left:0;
    width:100%;
}

.wave svg{
    display:block;
    width:100%;
    height:180px;
}

/* ==========================================
INFO CARDS
========================================== */

.info-section{
    margin-top:-90px;
    position:relative;
    z-index:3;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
    padding:0 40px 40px;
}

.info-card{
    background:white;
    border-radius:25px;
    padding:30px;
    box-shadow:
    0 15px 40px rgba(0,0,0,.1);
    transition:.3s;
}

.info-card:hover{
    transform:translateY(-5px);
}

.info-card h3{
    color:#111827;
    margin-bottom:15px;
}

.info-card p{
    color:#4b5563;
    line-height:1.7;
}

.info-card i{
    font-size:40px;
    color:#7c3aed;
    margin-bottom:20px;
}

/* ==========================================
EMERGENCY BAR
========================================== */

.emergency-bar{

    margin:30px 40px;
    background:white;
    border-radius:25px;
    padding:25px 35px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    box-shadow:
    0 10px 30px rgba(0,0,0,.08);
}

.emergency-title{
    color:#111827;
    font-size:1.4rem;
    font-weight:700;
}

.emergency-info{
    color:#4b5563;
}

/* ==========================
SERVICIOS
========================== */
.services-section{
    padding:50px 40px;
}
.services-title{
    text-align:center;
    font-size:2rem;
    color:#111827;
    margin-bottom:40px;
}

.grid{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.feature-card{
    background:white;
    border-radius:25px;
    padding:30px;
    box-shadow:
    0 15px 40px rgba(0,0,0,.08);
    transition:.3s;
}

.feature-card:hover{
    transform:translateY(-5px);
}

.feature-icon{
    font-size:40px;
    margin-bottom:15px;
}

.feature-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:12px;
    color:#111827;
}

.feature-text{
    color:#4b5563;
    line-height:1.7;
}


@media(max-width:900px){
    .navbar{
        flex-direction:column;
        gap:20px;
        padding:20px;
    }

    .nav-center{
        flex-wrap:wrap;
        justify-content:center;
        gap:15px;
    }

    .nav-right{
        width:100%;
        justify-content:center;
    }

    .hero-section{
        flex-direction:column;
        text-align:center;
        padding:60px 25px 180px;
    }

    .hero-content h1{
        font-size:2.8rem;
    }

    .hero-image{
        margin-top:40px;
    }

    .hero-image img{
        width:250px;
    }
}

</style>
</head>
<body>

<nav class="navbar">

    <div class="nav-left">
        <div class="brand">
            <h2>
                UMG
            </h2>
                    </div>

    </div>
<div class="nav-center">

    <a href="/forum">
        <i class="fas fa-comments"></i>
        Foro Anónimo
    </a>

    <a href="/evaluation">
        <i class="fas fa-brain"></i>
        Evaluación
    </a>

    <a href="/panic-button">
        <i class="fas fa-triangle-exclamation"></i>
        Botón de Pánico
    </a>

        <a href="/cases">
    <i class="fas fa-folder-open"></i>
    Seguimiento de Casos
</a>
</div>

<div class="nav-right">

    @if(auth()->check() && auth()->user()->role === 'ADMIN')

        <a href="{{ url('/admin-access') }}" class="admin-btn">
            <i class="fas fa-shield-halved"></i>
            Admin
        </a>

    @endif


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @auth

        <form method="POST" action="{{ url('/logout') }}" style="margin:0;">

            @csrf

            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Cerrar sesión
            </button>

        </form>

    @endauth

</div>

</nav>
</nav>
<section class="hero-section">
<div class="hero-content">
    <h1>
        Tu bienestar es nuestra prioridad
    </h1>
    <p>
        Plataforma segura y anónima para reportar casos de abuso sexual,
        riesgo suicida y situaciones que afecten la integridad física y emocional.
        <br><br>
        Denunciar y solicitar ayuda es completamente gratuito.
    </p>
    <div class="hero-buttons">
        <a href="/panic-button"
        class="hero-btn hero-btn-primary">
            Reportar Caso
        </a>
        <a href="/panic-button"
        class="hero-btn hero-btn-secondary">
            Pedir Ayuda
        </a>
    </div>
</div>
<div class="hero-image">
    <img
    src="{{ asset('images/logo2.png') }}"
    alt="Logo">
</div>
<div class="wave">
    <svg viewBox="0 0 1440 320">
        <path fill="#f8fafc"
        d="M0,256L60,266.7C120,277,240,299,360,293.3C480,288,600,256,720,229.3C840,203,960,181,1080,192C1200,203,1320,245,1380,266.7L1440,288L1440,320L0,320Z">
        </path>
    </svg>
</div>
</section>
<section class="info-section">
<div class="info-card">
    <i class="fas fa-heartbeat"></i>
    <h3>¿Qué es el suicidio?</h3>
    <p>
        El suicidio es el acto de quitarse la vida. Es un problema de salud
        mental que puede prevenirse mediante apoyo emocional, acompañamiento
        profesional y atención oportuna.
    </p>
</div>
<div class="info-card">
    <i class="fas fa-hand-paper"></i>
    <h3>¿Qué es el abuso sexual?</h3>
    <p>
        Es cualquier conducta sexual realizada sin consentimiento.
        Puede provocar daños físicos y emocionales severos y debe ser
        denunciada para proteger a las víctimas.
    </p>
</div>
<div class="info-card">
    <i class="fas fa-shield-heart"></i>
    <h3>Denunciar es GRATIS</h3>
    <p>
        Todos los servicios de esta plataforma son completamente gratuitos.
        Puedes denunciar, solicitar ayuda y recibir apoyo sin ningún costo.
    </p>
</div>
</section>

<section class="services-section">
<h2 class="services-title">
    Herramientas de Apoyo
</h2>
<div class="grid">
    <div class="feature-card">
        <div class="feature-icon">💬</div>
        <div class="feature-title">
            Foro Seguro
        </div>
        <div class="feature-text">
            Comparte pensamientos y emociones de manera anónima
            en un entorno protegido.
        </div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🧠</div>
        <div class="feature-title">
            Salud Emocional
        </div>
        <div class="feature-text">
            Accede a evaluaciones emocionales y recomendaciones
            inteligentes.
        </div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🚨</div>
        <div class="feature-title">
            Ayuda Inmediata
        </div>
        <div class="feature-text">
            Utiliza el botón de pánico para solicitar apoyo
            rápidamente en situaciones críticas.
        </div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <div class="feature-title">
            Privacidad Total
        </div>
        <div class="feature-text">
            Tu información se mantiene protegida mediante
            sistemas de seguridad y anonimato.
        </div>
    </div>
</div>
</section>
<div class="emergency-bar">
<div>
    <div class="emergency-title">
        ¿Necesitas ayuda inmediata?
    </div>
    <div class="emergency-info">
        Buscar apoyo es un acto de valentía. No estás solo.
    </div>
</div>
<div>
    <strong>
        Servicio gratuito y confidencial
    </strong>
</div>
</div>
</body>
</html>