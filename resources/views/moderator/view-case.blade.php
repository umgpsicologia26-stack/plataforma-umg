<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Caso {{ $case->case_number }}
    </title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #071123;
            color: white;
            min-height: 100vh;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .back {
            display: inline-block;
            color: #7dd3fc;
            text-decoration: none;
            margin-bottom: 25px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 38px;
            margin-bottom: 8px;
        }

        .header p {
            color: #94a3b8;
        }

        .card {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 25px;
        }

        .case-number {
            color: #7dd3fc;
            font-size: 26px;
            font-weight: 700;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 25px;
        }

        .info-box {
            background: rgba(255,255,255,.04);
            padding: 18px;
            border-radius: 15px;
        }

        .label {
            display: block;
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .description {
            margin-top: 25px;
            line-height: 1.8;
            color: #e2e8f0;
            white-space: pre-wrap;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .comment {
            background: rgba(255,255,255,.04);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 15px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-type {
            color: #7dd3fc;
            font-weight: 700;
        }

        .comment-date {
            color: #94a3b8;
            font-size: 13px;
        }

        .comment-text {
            color: #cbd5e1;
            line-height: 1.7;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
        }

        select,
        textarea {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            background: rgba(255,255,255,.08);
            color: white;
            font-family: inherit;
            margin-bottom: 20px;
        }

        select option {
            color: black;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        button {
            border: none;
            border-radius: 14px;
            padding: 14px 22px;
            background: #7dd3fc;
            color: #071123;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #38bdf8;
        }

        .success {
            background: rgba(34,197,94,.15);
            border: 1px solid rgba(34,197,94,.3);
            color: #86efac;
            padding: 15px;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .error {
            background: rgba(239,68,68,.15);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5;
            padding: 15px;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .status-form {
            display: flex;
            gap: 15px;
            align-items: end;
        }

        .status-form div {
            flex: 1;
        }

        @media(max-width:700px) {

            body {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .status-form {
                flex-direction: column;
                align-items: stretch;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <a
        href="{{ route('moderator.cases') }}"
        class="back">

        ← Volver a mis casos

    </a>


    <div class="header">

        <h1>
            Detalle del caso
        </h1>

        <p>
            Información y seguimiento del caso asignado.
        </p>

    </div>


    {{-- MENSAJE DE ÉXITO --}}

    @if(session('success'))

        <div class="success">

            {{ session('success') }}

        </div>

    @endif


    {{-- ERRORES --}}

    @if($errors->any())

        <div class="error">

            @foreach($errors->all() as $error)

                <p>{{ $error }}</p>

            @endforeach

        </div>

    @endif


    {{-- INFORMACIÓN DEL CASO --}}

    <div class="card">

        <div class="case-number">

            {{ $case->case_number }}

        </div>


        <div class="info-grid">

            <div class="info-box">

                <span class="label">
                    Tipo de caso
                </span>

                {{ $case->type }}

            </div>


            <div class="info-box">

                <span class="label">
                    Usuario
                </span>

                {{ $case->user->anonymous_nickname ?? 'No disponible' }}

            </div>


            <div class="info-box">

                <span class="label">
                    Fecha de creación
                </span>

                {{ $case->created_at?->format('d/m/Y H:i') }}

            </div>


            <div class="info-box">

                <span class="label">
                    Estado actual
                </span>

                {{ $case->status }}

            </div>

        </div>


        <div class="description">

            <strong>
                Situación reportada por el usuario
            </strong>

            <br><br>

            {{ $case->description }}

        </div>

    </div>


    {{-- ACTUALIZAR ESTADO --}}

    <div class="card">

        <h2 class="section-title">
            Actualizar estado
        </h2>


        <form
            method="POST"
            action="{{ route('moderator.case.status', $case->id) }}">

            @csrf

            @method('PUT')

            <div class="status-form">

                <div>

                    <label>
                        Estado del caso
                    </label>

                    <select name="status">

                        <option
                            value="ABIERTO"
                            @selected($case->status === 'ABIERTO')>

                            ABIERTO

                        </option>

                        <option
                            value="En seguimiento"
                            @selected($case->status === 'En seguimiento')>

                            En seguimiento

                        </option>

                        <option
                            value="Atendido"
                            @selected($case->status === 'Atendido')>

                            Atendido

                        </option>

                        <option
                            value="Cerrado"
                            @selected($case->status === 'Cerrado')>

                            Cerrado

                        </option>

                    </select>

                </div>


                <button type="submit">

                    Actualizar estado

                </button>

            </div>

        </form>

    </div>


    {{-- AGREGAR SEGUIMIENTO --}}

    <div class="card">

        <h2 class="section-title">
            Agregar seguimiento
        </h2>


        <form
            method="POST"
            action="{{ route('moderator.case.comment', $case->id) }}">

            @csrf


            <label>
                Tipo de seguimiento
            </label>

            <select name="type" required>

                <option value="">
                    Seleccionar
                </option>

                <option value="OBSERVACION">
                    Observación
                </option>

                <option value="CORRECCION">
                    Corrección
                </option>

            </select>


            <label>
                Comentario
            </label>

            <textarea
                name="comment"
                placeholder="Escribe la observación o corrección..."
                required
                minlength="3"></textarea>


            <button type="submit">

                Guardar seguimiento

            </button>

        </form>

    </div>


    {{-- HISTORIAL --}}

    <div class="card">

        <h2 class="section-title">
            Historial del caso
        </h2>


        @forelse($case->comments as $comment)

            <div class="comment">

                <div class="comment-header">

                    <span class="comment-type">

                        {{ $comment->type }}

                    </span>

                    <span class="comment-date">

                        {{ $comment->created_at?->format('d/m/Y H:i') }}

                    </span>

                </div>


                <div class="comment-text">

                    {{ $comment->comment }}

                </div>

            </div>

        @empty

            <p style="color:#94a3b8;">

                Todavía no hay seguimiento registrado para este caso.

            </p>

        @endforelse

    </div>

</div>

</body>

</html>