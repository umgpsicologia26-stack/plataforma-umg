<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Detalle del caso | Panel del Moderador
    </title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            color: #1e293b;
            min-height: 100vh;
        }

        .navbar {
            width: 95%;
            max-width: 1400px;
            margin: 20px auto;
            padding: 18px 30px;

            background: white;

            border-radius: 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;

            border-radius: 15px;

            background: #2563eb;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 21px;
        }

        .brand h2 {
            font-size: 19px;
            color: #1e3a8a;
        }

        .brand span {
            display: block;
            font-size: 12px;
            color: #64748b;
        }

        .container {
            width: 95%;
            max-width: 1100px;
            margin: 40px auto 60px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            text-decoration: none;

            color: #2563eb;

            font-size: 14px;
            font-weight: 600;

            margin-bottom: 22px;
        }

        .back:hover {
            color: #1d4ed8;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 30px;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .page-title p {
            color: #64748b;
            font-size: 14px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 25px;

            box-shadow:
                0 15px 40px rgba(0, 0, 0, .07);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 25px;
        }

        .card-title-icon {
            width: 45px;
            height: 45px;

            border-radius: 13px;

            background: #eff6ff;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
        }

        .card-title h2 {
            font-size: 20px;
            color: #0f172a;
        }

        .card-title p {
            color: #64748b;
            font-size: 12px;
            margin-top: 2px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 15px;
            padding: 17px;
        }

        .info-label {
            display: block;
            color: #64748b;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .info-value {
            color: #0f172a;
            font-size: 14px;
            font-weight: 600;
            word-break: break-word;
        }

        .case-number {
            color: #2563eb;
            font-weight: 700;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-suicide {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-abuse {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-open {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-follow {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-closed {
            background: #e2e8f0;
            color: #475569;
        }

        .situation {
            background: #f8fafc;

            border-left: 4px solid #2563eb;

            border-radius: 12px;

            padding: 22px;

            color: #334155;

            line-height: 1.8;

            font-size: 14px;

            white-space: pre-line;
        }

        .situation-label {
            display: flex;

            align-items: center;

            gap: 8px;

            color: #0f172a;

            font-weight: 700;

            font-size: 14px;

            margin-bottom: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            font-size: 13px;

            font-weight: 600;

            color: #334155;

            margin-bottom: 8px;
        }

        select,
        textarea {
            width: 100%;

            border: 1px solid #cbd5e1;

            border-radius: 12px;

            padding: 13px 15px;

            font-family: 'Poppins', sans-serif;

            font-size: 14px;

            color: #1e293b;

            background: white;

            outline: none;

            transition: .2s;
        }

        select:focus,
        textarea:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }

        textarea {
            min-height: 150px;

            resize: vertical;

            line-height: 1.6;
        }

        .btn {
            border: none;

            border-radius: 12px;

            padding: 12px 20px;

            font-family: 'Poppins', sans-serif;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            transition: .2s;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .history {
            display: flex;

            flex-direction: column;

            gap: 16px;
        }

        .history-item {
            border: 1px solid #e2e8f0;

            border-radius: 16px;

            padding: 20px;

            background: #f8fafc;
        }

        .history-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

            margin-bottom: 12px;
        }

        .history-user {
            display: flex;

            align-items: center;

            gap: 10px;
        }

        .history-avatar {
            width: 38px;
            height: 38px;

            border-radius: 12px;

            background: #dbeafe;
            color: #2563eb;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .history-user strong {
            display: block;

            color: #0f172a;

            font-size: 13px;
        }

        .history-date {
            display: block;

            color: #94a3b8;

            font-size: 11px;

            margin-top: 2px;
        }

        .history-comment {
            color: #475569;

            font-size: 13px;

            line-height: 1.7;

            white-space: pre-line;
        }

        .type-observacion {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .type-correccion {
            background: #fee2e2;
            color: #b91c1c;
        }

        .type-seguimiento {
            background: #dcfce7;
            color: #166534;
        }

        .empty {
            text-align: center;

            padding: 35px 20px;

            color: #94a3b8;
        }

        .empty-icon {
            font-size: 35px;

            margin-bottom: 12px;

            color: #cbd5e1;
        }

        .alert {
            border-radius: 14px;

            padding: 14px 18px;

            margin-bottom: 20px;

            font-size: 13px;

            font-weight: 500;
        }

        .alert-success {
            background: #dcfce7;

            color: #166534;

            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;

            color: #991b1b;

            border: 1px solid #fecaca;
        }

        @media(max-width: 900px) {

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media(max-width: 650px) {

            .navbar {
                width: 92%;
                padding: 15px 18px;
            }

            .container {
                width: 92%;
            }

            .card {
                padding: 22px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .page-title h1 {
                font-size: 25px;
            }

            .history-header {
                align-items: flex-start;
                flex-direction: column;
            }

        }
    </style>

</head>


<body>


    <nav class="navbar">

        <div class="brand">

            <div class="brand-icon">

                <i class="fas fa-shield-halved"></i>

            </div>

            <div>

                <h2>
                    Panel del Moderador
                </h2>

                <span>
                    Plataforma UMG Xela
                </span>

            </div>

        </div>

    </nav>


    <main class="container">


        {{-- VOLVER --}}

        <a href="{{ route('moderator.cases') }}" class="back">

            <i class="fas fa-arrow-left"></i>

            Volver a mis casos

        </a>


        {{-- MENSAJES --}}

        @if(session('success'))

            <div class="alert alert-success">

                <i class="fas fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-error">

                <strong>
                    Se encontraron errores:
                </strong>

                <ul style="margin-top: 7px; padding-left: 20px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- TITULO --}}

        <div class="page-title">

            <h1>
                Detalle del caso
            </h1>

            <p>
                Información y seguimiento del caso asignado.
            </p>

        </div>


        {{-- INFORMACIÓN DEL CASO --}}

        <div class="card">

            <div class="card-title">

                <div class="card-title-icon">

                    <i class="fas fa-folder-open"></i>

                </div>

                <div>

                    <h2>
                        Información del caso
                    </h2>

                    <p>
                        Datos registrados por el usuario.
                    </p>

                </div>

            </div>


            <div class="info-grid">


                {{-- NUMERO --}}

                <div class="info-box">

                    <span class="info-label">
                        Número de caso
                    </span>

                    <span class="info-value case-number">

                        {{ $case->case_number }}

                    </span>

                </div>


                {{-- TIPO --}}

                <div class="info-box">

                    <span class="info-label">
                        Tipo de caso
                    </span>

                    <span class="info-value">

                        @if($case->type === 'SUICIDIO')

                            <span class="badge badge-suicide">

                                <i class="fas fa-heart-pulse"></i>

                                &nbsp; SUICIDIO

                            </span>

                        @elseif($case->type === 'ABUSO')

                            <span class="badge badge-abuse">

                                <i class="fas fa-shield-heart"></i>

                                &nbsp; ABUSO

                            </span>

                        @else

                            {{ $case->type }}

                        @endif

                    </span>

                </div>


                {{-- USUARIO --}}

                <div class="info-box">

                    <span class="info-label">
                        Usuario
                    </span>

                    <span class="info-value">

                        @if($case->user)

                                            {{ $case->user->anonymous_nickname
                            ?? $case->user->full_name
                            ?? $case->user->first_name
                            ?? 'Usuario' }}

                        @else

                            Usuario

                        @endif

                    </span>

                </div>


                {{-- FECHA --}}

                <div class="info-box">

                    <span class="info-label">
                        Fecha de creación
                    </span>

                    <span class="info-value">

                        {{ $case->created_at
    ? $case->created_at->format('d/m/Y H:i')
    : 'No disponible' }}

                    </span>

                </div>


        {{-- ESTADO --}}

        <div class="info-box">

            <span class="info-label">
                Estado actual
        
            <span class="info-value">
                @if($case->status === 'En seguimiento')

            <span class="badge badge-follow">
                En seguimiento
                </span>

                @elseif($case->status === 'Cerrado')

            <span class="badge badge-closed">
                Cerrado
                </span>

                @else

            <span class="badge badge-open">
                {{ $case->status }}
                </span>

                @endif

            </span>

                </div>

            </div>
        </div>

        {{-- SITUACIÓN REPORTADA --}}

        <div class="card">

            <div class="card-title">

                <div class="card-title-icon">

                    <i class="fas fa-file-lines"></i>

                </div>

                <div>

                    <h2>
                        Situación reportada por el usuario
                    </h2>

                    <p>
                        Información proporcionada al registrar el caso.
                    </p>

                </div>

            </div>


            <div class="situation">

                <div class="situation-label">

                    <i class="fas fa-circle-info"></i>

                    Situación reportada

                </div>

                {{ $case->description }}

            </div>

        </div>


        {{-- ACTUALIZAR ESTADO --}}

        <div class="card">

            <div class="card-title">

                <div class="card-title-icon">

                    <i class="fas fa-arrows-rotate"></i>

                </div>

                <div>

                    <h2>
                        Actualizar estado
                    </h2>

                    <p>
                        Modifica el estado actual del caso.
                    </p>

                </div>

            </div>


            <form method="POST" action="{{ route('moderator.case.status', $case->id) }}">

                @csrf

                @method('PUT')


                <div class="form-group">

                    <label for="status">

                    Estado del caso

                    </label>


                    <select name="status" id="status" required>

                    <option value="">
                        Seleccionar estado
                    </option>

                    <option value="En seguimiento" {{ $case->status === 'En seguimiento' ? 'selected' : '' }}>
                        En seguimiento
                    </option>

                    <option value="Cerrado" {{ $case->status === 'Cerrado' ? 'selected' : '' }}>
                        Cerrado
                    </option>

                    </select>

                </div>

                <button type="submit" class="btn btn-primary">

                    <i class="fas fa-check"></i>

                    Actualizar estado

                </button>

            </form>

        </div>


        {{-- AGREGAR COMENTARIO --}}

        <div class="card">

            <div class="card-title">

                <div class="card-title-icon">

                    <i class="fas fa-comment-medical"></i>

                </div>

                <div>

                    <h2>
                        Agregar comentario
                    </h2>

                    <p>
                        Registra una orientación o seguimiento relacionado con la situación reportada.
                    </p>

                </div>

            </div>


            <form method="POST" action="{{ route('moderator.case.comment', $case->id) }}">

                @csrf

                <div class="form-group">

                    <label for="comment">

                        Comentario

                    </label>

                    <textarea id="comment" name="comment"
                        placeholder="Escribe aquí el comentario relacionado con la situación reportada por el usuario..."
                        required>{{ old('comment') }}</textarea>

                </div>

                <button type="submit" class="btn btn-primary">

                    <i class="fas fa-comment-medical"></i>

                    Guardar comentario

                </button>

            </form>

        </div>

        {{-- HISTORIAL --}}

        <div class="card">

            <div class="card-title">

                <div class="card-title-icon">

                    <i class="fas fa-clock-rotate-left"></i>

                </div>

                <div>

                    <h2>
                        Historial del caso
                    </h2>

                    <p>
                        Registro de comentarios y seguimiento.
                    </p>

                </div>

            </div>

            @if($case->comments && $case->comments->count() > 0)

                <div class="history">

                    @foreach($case->comments->sortByDesc('created_at') as $comment)

                            <div class="history-item">

                                <div class="history-header">

                                    <div class="history-user">

                                        <div class="history-avatar">

                            <i class="fas fa-user-shield"></i>

                        </div>

                        <div>

                            <strong>

                            @if($comment->user)
                    {{ $comment->user->full_name
                            ?? $comment->user->first_name
                                ?? 'Usuario' }}

                            @else

                            Moderador

                            @endif

                            </strong>

            <span class="history-date">

                {{ $comment->created_at
                    ? $comment->created_at->format('d/m/Y H:i')
                        : '' }}

                        </span>

            </div>

            </div>


            {{-- TIPO --}}

            @if($comment->type === 'OBSERVACION')

                <span class="badge type-observacion">

                    OBSERVACIÓN

                </span>

                    @elseif($comment->type === 'CORRECCION')

                <span class="badge type-correccion">

                    CORRECCIÓN

                </span>

                    @elseif($comment->type === 'SEGUIMIENTO')

                <span class="badge type-seguimiento">

                    SEGUIMIENTO

                </span>

                    @else

                <span class="badge type-seguimiento">

                    {{ $comment->type }}

                </span>

                    @endif

        </div>


        <div class="history-comment">

            {{ $comment->comment }}

        </div>

        </div>

            @endforeach

        </div>

            @else

            <div class="empty">

                <div class="empty-icon">

                    <i class="fas fa-comments"></i>

            </div>

                <p>
                    Todavía no hay seguimiento registrado para este caso.
                </p>

            </div>

            @endif

        </div>

    </main>

</body>
</html>