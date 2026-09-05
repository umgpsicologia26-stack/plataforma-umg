<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>{{ $evaluacion?->title ?? 'Evaluación' }}</title>

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
    linear-gradient(rgba(8,15,35,.94),rgba(8,15,35,.96)),
    url('https://images.unsplash.com/photo-1493836512294-502baa1986e2?q=80&w=2070&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
    min-height:100vh;
    color:white;
    padding:40px;
}

.container{
    max-width:1000px;
    margin:auto;
}

.card{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    border-radius:30px;
    padding:40px;
    border:1px solid rgba(255,255,255,.08);
}

.title-row{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:20px;
}

.back{
    color:#7dd3fc;
    text-decoration:none;
    font-size:34px;
}

.title{
    font-size:46px;
    font-weight:700;
}

.subtitle{
    color:#cbd5e1;
    margin-bottom:35px;
    line-height:1.8;
}

.question{
    margin-bottom:30px;
}

.question h3{
    margin-bottom:15px;
}

.options{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.option{
    background:rgba(255,255,255,.05);
    padding:16px;
    border-radius:15px;
}

.option input{
    margin-right:10px;
}

.text-input{
    width:100%;
    padding:15px;
    border:1px solid rgba(255,255,255,.15);
    border-radius:15px;
    background:rgba(255,255,255,.05);
    color:white;
    font-family:'Poppins',sans-serif;
    font-size:15px;
    outline:none;
}

.text-input:focus{
    border-color:#7dd3fc;
}

textarea.text-input{
    min-height:120px;
    resize:vertical;
}

.text-input::placeholder{
    color:#94a3b8;
}

.scale-options{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(60px,1fr));
    gap:10px;
}

.scale-option{
    position:relative;
}

.scale-option input{
    position:absolute;
    opacity:0;
}

.scale-option label{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:15px 10px;
    background:rgba(255,255,255,.05);
    border-radius:12px;
    cursor:pointer;
    transition:.2s;
}

.scale-option input:checked + label{
    background:#7dd3fc;
    color:#081323;
    font-weight:700;
}

button{
    width:100%;
    border:none;
    background:#7dd3fc;
    color:#081323;
    padding:18px;
    border-radius:18px;
    font-size:18px;
    font-weight:700;
    cursor:pointer;
    margin-top:20px;
}

button:hover{
    background:#38bdf8;
}

.alert{
    background:rgba(255,255,255,.08);
    border-radius:15px;
    padding:20px;
    color:#cbd5e1;
}

.error-alert{
    background:rgba(239,68,68,.15);
    border:1px solid rgba(239,68,68,.3);
    border-radius:15px;
    padding:20px;
    color:#fecaca;
    margin-bottom:25px;
}

.required{
    color:#f87171;
}

@media(max-width:700px){

    body{
        padding:20px;
    }

    .card{
        padding:25px;
    }

    .title{
        font-size:30px;
    }

    .back{
        font-size:28px;
    }

    .scale-options{
        grid-template-columns:repeat(5,1fr);
    }

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="title-row">

<a href="/dashboard" class="back">←</a>

<h1 class="title">
    {{ $evaluacion?->title ?? 'Evaluación' }}
</h1>

</div>

@if(!$evaluacion)


<div class="alert">
    Actualmente no hay ninguna evaluación activa disponible.
</div>


@else

<p class="subtitle">
    {{ $evaluacion->description }}
</p>

@if($errors->any())

    <div class="error-alert">

        <strong>
            No fue posible enviar la evaluación.
        </strong>

        <ul style="margin-top:10px; margin-left:20px;">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif

<form
    method="POST"
    action="{{ route('evaluation.submit', $evaluacion->uuid) }}">

    @csrf

    @foreach($evaluacion->preguntas as $pregunta)

        <div class="question">

            <h3>

                {{ $pregunta->question_order }}.
                {{ $pregunta->question }}

                @if($pregunta->required)

                    <span class="required">*</span>

                @endif

            </h3>


            @php

                $options = is_array($pregunta->options)
                    ? $pregunta->options
                    : [];

            @endphp


            @if($pregunta->question_type === 'TEXTO')

                <textarea
                    class="text-input"
                    name="respuestas[{{ $pregunta->uuid }}]"
                    placeholder="Escribe tu respuesta..."
                    {{ $pregunta->required ? 'required' : '' }}>{{ old("respuestas.{$pregunta->uuid}") }}</textarea>


            @elseif($pregunta->question_type === 'NUMERO')

                <input
                    type="number"
                    class="text-input"
                    name="respuestas[{{ $pregunta->uuid }}]"
                    placeholder="Ingresa un número entero"
                    step="1"
                    {{ $pregunta->required ? 'required' : '' }}
                    value="{{ old("respuestas.{$pregunta->uuid}") }}">


            @elseif($pregunta->question_type === 'DECIMAL')

                <input
                    type="number"
                    class="text-input"
                    name="respuestas[{{ $pregunta->uuid }}]"
                    placeholder="Ingresa un número decimal"
                    step="any"
                    {{ $pregunta->required ? 'required' : '' }}
                    value="{{ old("respuestas.{$pregunta->uuid}") }}">


            @elseif($pregunta->question_type === 'FECHA')

                <input
                    type="date"
                    class="text-input"
                    name="respuestas[{{ $pregunta->uuid }}]"
                    {{ $pregunta->required ? 'required' : '' }}
                    value="{{ old("respuestas.{$pregunta->uuid}") }}">


            @elseif($pregunta->question_type === 'OPCION_UNICA')

                <div class="options">

                    @foreach($options as $option)

                        <label class="option">

                            <input
                                type="radio"
                                name="respuestas[{{ $pregunta->uuid }}]"
                                value="{{ $option }}"
                                {{ $pregunta->required ? 'required' : '' }}
                                {{ old("respuestas.{$pregunta->uuid}") === $option ? 'checked' : '' }}>

                            {{ $option }}

                        </label>

                    @endforeach

                </div>


            @elseif($pregunta->question_type === 'OPCION_MULTIPLE')

                <div class="options">

                    @foreach($options as $option)

                        <label class="option">

                            <input
                                type="checkbox"
                                name="respuestas[{{ $pregunta->uuid }}][]"
                                value="{{ $option }}">

                            {{ $option }}

                        </label>

                    @endforeach

                </div>


            @elseif($pregunta->question_type === 'ESCALA')

                <div class="scale-options">

                    @foreach($options as $option)

                        <div class="scale-option">

                            <input
                                type="radio"
                                id="scale_{{ $pregunta->uuid }}_{{ $loop->index }}"
                                name="respuestas[{{ $pregunta->uuid }}]"
                                value="{{ $option }}"
                                {{ $pregunta->required ? 'required' : '' }}>

                            <label
                                for="scale_{{ $pregunta->uuid }}_{{ $loop->index }}">

                                {{ $option }}

                            </label>

                        </div>

                    @endforeach

                </div>


            @elseif($pregunta->question_type === 'SI_NO')

                <div class="options">

                    <label class="option">

                        <input
                            type="radio"
                            name="respuestas[{{ $pregunta->uuid }}]"
                            value="Sí"
                            {{ $pregunta->required ? 'required' : '' }}>

                        Sí

                    </label>

                    <label class="option">

                        <input
                            type="radio"
                            name="respuestas[{{ $pregunta->uuid }}]"
                            value="No"
                            {{ $pregunta->required ? 'required' : '' }}>

                        No

                    </label>

                </div>


            @else

                <input
                    type="text"
                    class="text-input"
                    name="respuestas[{{ $pregunta->uuid }}]"
                    placeholder="Escribe tu respuesta..."
                    {{ $pregunta->required ? 'required' : '' }}
                    value="{{ old("respuestas.{$pregunta->uuid}") }}">

            @endif

        </div>

    @endforeach


    <button type="submit">

        Finalizar Evaluación

    </button>

</form>


@endif

</div>

</div>

</body>
</html>
