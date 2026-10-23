<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/js/echo.js')
    <title>Detalle del caso | Panel del Moderador</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            box-shadow: 0 15px 40px rgba(0, 0, 0, .07);
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
            flex-shrink: 0;
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
            gap: 5px;
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
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
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
            transform: translateY(-1px);
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
            flex-shrink: 0;
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
            overflow-wrap: anywhere;
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

            .btn {
                width: 100%;
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
            <h2>Panel del Moderador</h2>
            <span>Plataforma UMG Xela</span>
        </div>
    </div>
</nav>

<main class="container">

    <a href="{{ route('moderator.cases') }}" class="back">
        <i class="fas fa-arrow-left"></i>
        Volver a mis casos
    </a>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- ERRORES DE VALIDACIÓN --}}
    @if($errors->any())
        <div class="alert alert-error">
            <strong>Se encontraron errores:</strong>
            <ul style="margin-top: 7px; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-title">
        <h1>Detalle del caso</h1>
        <p>Información y seguimiento del caso asignado.</p>
    </div>

    {{-- INFORMACIÓN DEL CASO --}}
    <div class="card" id="case-info">
        <div class="card-title">
            <div class="card-title-icon">
                <i class="fas fa-folder-open"></i>
            </div>

            <div>
                <h2>Información del caso</h2>
                <p>Datos registrados por el usuario.</p>
            </div>
        </div>

        <div class="info-grid">

            {{-- NÚMERO DE CASO --}}
            <div class="info-box">
                <span class="info-label">Número de caso</span>
                <span class="info-value case-number">
                    {{ $case->case_number }}
                </span>
            </div>

            {{-- TIPO DE CASO --}}
            <div class="info-box">
                <span class="info-label">Tipo de caso</span>
                <span class="info-value">
                    @if(strtoupper(trim($case->type)) === 'SUICIDIO')
                        <span class="badge badge-suicide">
                            <i class="fas fa-heart-pulse"></i>
                            Suicidio
                        </span>
                    @elseif(in_array(strtoupper(trim($case->type)), ['ABUSO', 'ABUSO_SEXUAL', 'ABUSO SEXUAL']))
                        <span class="badge badge-abuse">
                            <i class="fas fa-shield-heart"></i>
                            Abuso sexual
                        </span>
                    @else
                        {{ $case->type }}
                    @endif
                </span>
            </div>

            {{-- USUARIO --}}
            <div class="info-box">
                <span class="info-label">Usuario</span>
                <span class="info-value">
                    @if($case->user)
                        @php
                            $anonymousName = $case->user->anonymous_nickname ?? null;
                            $fullName = $case->user->full_name ?? null;
                            $firstLastName = trim(
                                ($case->user->first_name ?? '') . ' ' .
                                ($case->user->last_name ?? '')
                            );
                        @endphp

                        {{ $anonymousName ?: $fullName ?: ($firstLastName ?: 'Usuario') }}
                    @else
                        Usuario
                    @endif
                </span>
            </div>

            {{-- FECHA DE CREACIÓN --}}
            <div class="info-box">
                <span class="info-label">Fecha de creación</span>
                <span class="info-value">
                    {{ $case->created_at ? $case->created_at->format('d/m/Y H:i') : 'No disponible' }}
                </span>
            </div>

            {{-- ESTADO --}}
            <div class="info-box">
                <span class="info-label">Estado actual</span>
                <span class="info-value">
                    @if(strtolower(trim($case->status)) === 'en seguimiento')
                        <span class="badge badge-follow">
                            <i class="fas fa-spinner"></i>
                            En seguimiento
                        </span>
                    @elseif(strtolower(trim($case->status)) === 'cerrado')
                        <span class="badge badge-closed">
                            <i class="fas fa-lock"></i>
                            Cerrado
                        </span>
                    @elseif(strtolower(trim($case->status)) === 'abierto')
                        <span class="badge badge-open">
                            <i class="fas fa-folder-open"></i>
                            Abierto
                        </span>
                    @else
                        <span class="badge badge-open">{{ $case->status }}</span>
                    @endif
                </span>
            </div>

            {{-- MODERADOR --}}
            <div class="info-box">
                <span class="info-label">Moderador asignado</span>
                <span class="info-value">
                    @if($case->moderator)
                        {{ $case->moderator->first_name ?? '' }}
                        {{ $case->moderator->last_name ?? '' }}
                    @else
                        No asignado
                    @endif
                </span>
            </div>

            {{-- ACTUALIZACIÓN --}}
            <div class="info-box">
                <span class="info-label">Última actualización</span>
                <span class="info-value">
                    {{ $case->updated_at ? $case->updated_at->format('d/m/Y H:i') : 'No disponible' }}
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
                <h2>Situación reportada por el usuario</h2>
                <p>Información proporcionada al registrar el caso.</p>
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

    {{-- ACTUALIZAR CASO --}}
    <div class="card">
        <div class="card-title">
            <div class="card-title-icon">
                <i class="fas fa-sliders"></i>
            </div>

            <div>
                <h2>Actualizar caso</h2>
                <p>
                    Selecciona el estado y registra un comentario de seguimiento para el usuario.
                </p>
            </div>
        </div>

        @can('update', $case)
            <form method="POST" action="{{ route('moderator.case.update', $case->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="status">Estado del caso</label>

                    <select name="status" id="status" required>
                        <option value="" disabled>Seleccionar estado</option>

                        <option value="Abierto"
                            {{ old('status', $case->status) === 'Abierto' ? 'selected' : '' }}>
                            Abierto
                        </option>

                        <option value="En seguimiento"
                            {{ old('status', $case->status) === 'En seguimiento' ? 'selected' : '' }}>
                            En seguimiento
                        </option>

                        <option value="Cerrado"
                            {{ old('status', $case->status) === 'Cerrado' ? 'selected' : '' }}>
                            Cerrado
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="comment">Comentario de seguimiento</label>

                    <textarea
                        id="comment"
                        name="comment"
                        placeholder="Escribe aquí la respuesta, orientación o seguimiento para el usuario..."
                        maxlength="5000">{{ old('comment') }}</textarea>

                    <small style="display:block; margin-top:7px; color:#64748b; font-size:11px;">
                        Este comentario quedará registrado en el historial del caso y podrá ser consultado por el usuario como parte del seguimiento.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Guardar cambios
                </button>
            </form>
        @endcan
    </div>

    {{-- HISTORIAL DEL CASO --}}
    <div class="card" id="case-history">
        <div class="card-title">
            <div class="card-title-icon">
                <i class="fas fa-clock-rotate-left"></i>
            </div>

            <div>
                <h2>Historial del caso</h2>
                <p>Registro de comentarios y seguimiento.</p>
            </div>
        </div>

        @if($case->comments && $case->comments->count() > 0)
            <div class="history">
                @foreach($case->comments->sortByDesc('created_at') as $comment)
                    @php
                        $commentType = strtoupper(trim((string) $comment->type));

                        $typeLabels = [
                            'RESPUESTA_USUARIO' => 'Respuesta del usuario',
                            'OBSERVACION' => 'Observación',
                            'CORRECCION' => 'Corrección',
                            'SEGUIMIENTO' => 'Seguimiento',
                        ];

                        $typeLabel = $typeLabels[$commentType] ?? $comment->type;

                        $authorName = 'Usuario del sistema';

                        if ($comment->user) {
                            $authorName = $comment->user->full_name
                                ?? trim(
                                    ($comment->user->first_name ?? '') . ' ' .
                                    ($comment->user->last_name ?? '')
                                );

                            if (empty(trim($authorName))) {
                                $authorName = 'Usuario';
                            }
                        } elseif ($commentType === 'RESPUESTA_USUARIO') {
                            $authorName = 'Usuario';
                        } else {
                            $authorName = 'Equipo de seguimiento';
                        }

                        $badgeClass = match ($commentType) {
                            'RESPUESTA_USUARIO', 'SEGUIMIENTO' => 'type-seguimiento',
                            'CORRECCION' => 'type-correccion',
                            default => 'type-observacion',
                        };
                    @endphp

                    <div class="history-item">
                        <div class="history-header">
                            <div class="history-user">
                                <div class="history-avatar">
                                    @if($commentType === 'RESPUESTA_USUARIO')
                                        <i class="fas fa-user"></i>
                                    @else
                                        <i class="fas fa-user-shield"></i>
                                    @endif
                                </div>

                                <div>
                                    <strong>{{ $authorName }}</strong>

                                    <span class="history-date">
                                        {{ $comment->created_at ? $comment->created_at->format('d/m/Y H:i') : '' }}
                                    </span>
                                </div>
                            </div>

                            <span class="badge {{ $badgeClass }}">
                                {{ $typeLabel }}
                            </span>
                        </div>

                        <div class="history-comment">{{ $comment->comment }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty">
                <div class="empty-icon">
                    <i class="fas fa-comments"></i>
                </div>

                <p>Todavía no hay seguimiento registrado para este caso.</p>
            </div>
        @endif
    </div>

</main>
@include('partials.live-refresh')
<script>
umgLive.whenEchoReady(function (echo) {
    const moderatorUuid = @json(auth()->user()->uuid);
    const caseId = String(@json($case->id));

    // El formulario de actualización NO se toca (no se pierde lo que se está escribiendo).
    const refresher = umgLive.createRefresher({
        apply: function (doc) {
            umgLive.swapContent('#case-info', doc);
            umgLive.swapContent('#case-history', doc);
        }
    });

    umgLive.listen(echo, 'moderator.' + moderatorUuid, '.case.activity.updated', function (event) {
        // Solo eventos de ESTE caso.
        if (String(event.case_id) !== caseId) {
            return;
        }

        refresher.trigger();
    });

    umgLive.onReconnect(echo, refresher.trigger);
});
</script>
</body>
</html>