<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Seguimiento de Casos </title>

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
    linear-gradient(rgba(7,15,35,.95),rgba(7,15,35,.97)),
    url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    min-height:100vh;
    padding:40px 20px;

    color:white;
}

.container{
    max-width:950px;
    margin:auto;
}

.card{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.10);

    padding:40px;

    border-radius:30px;

    box-shadow:
        0 25px 60px rgba(0,0,0,.30);
}

/* ENCABEZADO */

.title-row{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:12px;
}

.back{
    display:flex;
    align-items:center;
    justify-content:center;

    width:46px;
    height:46px;

    border-radius:14px;

    background:rgba(125,211,252,.10);

    color:#7dd3fc;

    text-decoration:none;

    font-size:28px;

    transition:.3s;
}

.back:hover{
    background:rgba(125,211,252,.20);
    transform:translateX(-3px);
}

.title{
    font-size:38px;
    font-weight:700;
}

.subtitle{
    color:#cbd5e1;
    line-height:1.8;
    margin-bottom:30px;
}

/* FORMULARIO */

.form-card{
    background:rgba(15,23,42,.55);

    border:1px solid rgba(255,255,255,.08);

    border-radius:22px;

    padding:25px;

    margin-bottom:30px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;

    gap:20px;

    margin-bottom:20px;
}

.field{
    display:flex;
    flex-direction:column;
    gap:8px;
}

label{
    color:#cbd5e1;
    font-size:14px;
    font-weight:500;
}

input{
    width:100%;

    padding:15px 17px;

    border:1px solid rgba(255,255,255,.10);

    border-radius:14px;

    background:rgba(255,255,255,.06);

    color:white;

    font-family:'Poppins',sans-serif;

    font-size:15px;

    outline:none;

    transition:.3s;
}

input:focus{
    border-color:#7dd3fc;

    background:rgba(125,211,252,.08);

    box-shadow:0 0 0 3px rgba(125,211,252,.08);
}

input::placeholder{
    color:#94a3b8;
}

.button{
    width:100%;

    padding:16px;

    border:none;

    border-radius:15px;

    background:#7dd3fc;

    color:#081323;

    font-family:'Poppins',sans-serif;

    font-weight:700;

    font-size:16px;

    cursor:pointer;

    transition:.3s;
}

.button:hover{
    background:#38bdf8;

    transform:translateY(-2px);

    box-shadow:0 8px 20px rgba(56,189,248,.20);
}

/* ALERTAS */

.alert{
    padding:15px 18px;

    border-radius:14px;

    margin-bottom:25px;

    font-size:14px;
}

.alert-error{
    background:rgba(239,68,68,.12);

    border:1px solid rgba(239,68,68,.25);

    color:#fecaca;
}

.alert-success{
    background:rgba(34,197,94,.12);

    border:1px solid rgba(34,197,94,.25);

    color:#bbf7d0;
}

/* RESULTADO DEL CASO */

.case-card{
    background:rgba(15,23,42,.62);

    border:1px solid rgba(255,255,255,.09);

    border-radius:24px;

    overflow:hidden;
}

.case-header{
    padding:25px;

    border-bottom:1px solid rgba(255,255,255,.08);

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;
}

.case-number{
    font-size:22px;

    font-weight:700;
}

.case-type{
    color:#94a3b8;

    font-size:13px;

    margin-top:5px;
}

.status{
    padding:8px 14px;

    border-radius:30px;

    background:rgba(125,211,252,.12);

    border:1px solid rgba(125,211,252,.20);

    color:#7dd3fc;

    font-size:13px;

    font-weight:600;

    white-space:nowrap;
}

.case-description{
    padding:25px;

    color:#e2e8f0;

    line-height:1.8;

    border-bottom:1px solid rgba(255,255,255,.08);
}

.case-description-title{
    font-size:14px;

    color:#94a3b8;

    margin-bottom:8px;

    font-weight:600;
}

/* SEGUIMIENTO */

.tracking{
    padding:25px;
}

.tracking-title{
    font-size:20px;

    font-weight:600;

    margin-bottom:20px;
}

.no-comments{
    padding:20px;

    text-align:center;

    border-radius:16px;

    background:rgba(255,255,255,.04);

    color:#94a3b8;

    font-size:14px;
}

/* COMENTARIOS */

.comment{
    padding:18px;

    border-radius:18px;

    background:rgba(255,255,255,.045);

    border:1px solid rgba(255,255,255,.07);

    margin-bottom:15px;
}

.comment:last-child{
    margin-bottom:0;
}

.comment-top{
    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:15px;

    margin-bottom:10px;
}

.comment-author{
    font-weight:600;

    color:#7dd3fc;
}

.comment-date{
    color:#64748b;

    font-size:12px;
}

.comment-text{
    color:#e2e8f0;

    line-height:1.7;

    white-space:pre-line;
}

/* RESPONSIVE */

@media(max-width:700px){

    body{
        padding:20px 12px;
    }

    .card{
        padding:22px;

        border-radius:22px;
    }

    .title{
        font-size:28px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .case-header{
        flex-direction:column;

        align-items:flex-start;
    }

    .status{
        align-self:flex-start;
    }

}

</style>

</head>

<body>

<div class="container">

<div class="card">

{{-- ENCABEZADO --}}

<div class="title-row">

    <a href="/dashboard" class="back">
        ←
    </a>

    <h1 class="title">
        Seguimiento de Casos
    </h1>

</div>

<p class="subtitle">
    Consulta el estado de tu caso y revisa las observaciones
    realizadas por el equipo de moderación.
</p>


{{-- MENSAJE DE ERROR --}}

@if(session('error'))

    <div class="alert alert-error">
        {{ session('error') }}
    </div>

@endif


{{-- MENSAJE DE ÉXITO --}}

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- FORMULARIO --}}

<div class="form-card">

    <form
        method="GET"
        action="{{ route('cases.tracking') }}"
    >

        <div class="form-grid">

            <div class="field">

                <label for="anonymous_nickname">
                    Nombre de usuario
                </label>

                <input
                    type="text"
                    id="anonymous_nickname"
                    name="anonymous_nickname"
                    value="{{ old('anonymous_nickname', request('anonymous_nickname')) }}"
                    placeholder="Ejemplo: User1234"
                    required
                >

            </div>


            <div class="field">

                <label for="case_number">
                    Número de caso
                </label>

                <input
                    type="text"
                    id="case_number"
                    name="case_number"
                    value="{{ old('case_number', request('case_number')) }}"
                    placeholder="Ejemplo: VS-2026-0001"
                    required
                >

            </div>

        </div>


        <button
            type="submit"
            class="button"
        >
            Ver Seguimiento
        </button>

    </form>

</div>


{{-- RESULTADO DEL CASO --}}

@if($case)

    <div class="case-card">

        {{-- ENCABEZADO DEL CASO --}}

        <div class="case-header">

            <div>

                <div class="case-number">
                    {{ $case->case_number }}
                </div>

                <div class="case-type">

                    @if($case->type === 'Suicidio')

                        Orientación y prevención

                    @elseif($case->type === 'Abuso sexual')

                        Orientación sobre abuso sexual

                    @else

                        {{ $case->type }}

                    @endif

                </div>

            </div>


            <div class="status">

                {{ $case->status }}

            </div>

        </div>


        {{-- DESCRIPCIÓN ORIGINAL --}}

        <div class="case-description">

            <div class="case-description-title">
                Situación reportada
            </div>

            {{ $case->description }}

        </div>


        {{-- SEGUIMIENTO --}}

        <div class="tracking">

            <div class="tracking-title">
                Seguimiento del caso
            </div>


            @if($case->comments->count() > 0)

                @foreach($case->comments as $comment)

                    <div class="comment">

                        <div class="comment-top">

                            <div class="comment-author">

                                @if($comment->user)

                                    @if($comment->user->role === 'MODERATOR')

                                        Moderador

                                    @else

                                        {{ $comment->user->anonymous_nickname ?? 'Usuario' }}

                                    @endif

                                @else

                                    Equipo UMG Xela

                                @endif

                            </div>


                            <div class="comment-date">

                                {{ $comment->created_at->format('d/m/Y H:i') }}

                            </div>

                        </div>


                        <div class="comment-text">

                            {{ $comment->comment }}

                        </div>

                    </div>

                @endforeach

            @else

                <div class="no-comments">

                    Aún no hay observaciones de seguimiento
                    realizadas por el moderador.

                </div>

            @endif

        </div>

    </div>

@endif

</div>

</div>

</body>
</html>
