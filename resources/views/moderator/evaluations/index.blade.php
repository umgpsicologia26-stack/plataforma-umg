<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite('resources/js/app.js')
    @vite('resources/js/echo.js')
    <title>Evaluaciones | Panel del Moderador</title>

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
            min-height: 100vh;
            color: #1e293b;
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
            display: flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            font-size: 22px;
        }

        .brand h2 {
            font-size: 20px;
            color: #1e3a8a;
        }

        .brand span {
            display: block;
            font-size: 12px;
            color: #64748b;
        }

        .logout-btn {
            border: none;
            background: #ef4444;
            color: white;
            padding: 11px 20px;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 40px auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 32px;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #64748b;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .alert {
            padding: 15px 18px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-size: 14px;
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

        .evaluations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 25px;
        }

        .evaluation-card {
            background: white;
            border-radius: 25px;
            padding: 28px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
            transition: .3s;
            position: relative;
        }

        .evaluation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
        }

        .evaluation-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 18px;
        }

        .evaluation-icon {
            width: 58px;
            height: 58px;
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            font-size: 24px;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #e2e8f0;
            color: #475569;
        }

        .evaluation-card h2 {
            font-size: 21px;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .evaluation-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            min-height: 48px;
            margin-bottom: 20px;
        }

        .evaluation-info {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .info-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f8fafc;
            color: #475569;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .info-item i {
            color: #2563eb;
        }

        .evaluation-actions {
            display: flex;
            gap: 10px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .evaluation-actions .btn {
            flex: 1;
        }

        .delete-form {
            flex: 1;
        }

        .delete-form .btn {
            width: 100%;
        }

        .empty-state {
            background: white;
            border-radius: 25px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
        }

        .empty-icon {
            width: 75px;
            height: 75px;
            margin: 0 auto 20px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            font-size: 30px;
        }

        .empty-state h2 {
            color: #0f172a;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .notifications-section {
            margin-bottom: 35px;
        }

        .notifications-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 18px;
        }

        .notifications-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notifications-title-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            font-size: 20px;
        }

        .notifications-title h2 {
            color: #0f172a;
            font-size: 22px;
            margin-bottom: 3px;
        }

        .notifications-title p {
            color: #64748b;
            font-size: 13px;
        }

        .notification-count {
            min-width: 36px;
            height: 36px;
            padding: 0 11px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            font-size: 13px;
            font-weight: 800;
        }

        .notification-users {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 20px;
        }

        .notification-user-card {
            background: white;
            border-radius: 22px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .07);
            transition: .25s;
        }

        .notification-user-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .10);
        }

        .notification-user-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 18px;
        }

        .notification-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .notification-user-avatar {
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            font-size: 20px;
        }

        .notification-user-info h3 {
            color: #0f172a;
            font-size: 17px;
            margin-bottom: 3px;
        }

        .notification-user-info p {
            color: #64748b;
            font-size: 12px;
        }

        .notification-user-count {
            flex-shrink: 0;
            padding: 7px 11px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 800;
        }

        .notification-message {
            padding: 15px;
            border-radius: 14px;
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .notification-evaluations {
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            margin-bottom: 18px;
        }

        .notification-evaluation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 11px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .notification-evaluation:last-child {
            border-bottom: none;
        }

        .notification-evaluation-name {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }

        .notification-evaluation-name i {
            color: #2563eb;
        }

        .notification-evaluation-name span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .notification-evaluation-date {
            flex-shrink: 0;
            color: #94a3b8;
            font-size: 11px;
        }

        .notification-view-button {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .notification-view-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .notifications-empty {
            background: white;
            border-radius: 22px;
            padding: 35px 25px;
            text-align: center;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .notifications-empty i {
            font-size: 32px;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .notifications-empty h3 {
            color: #334155;
            font-size: 17px;
            margin-bottom: 6px;
        }

        .notifications-empty p {
            color: #94a3b8;
            font-size: 13px;
        }

        @media(max-width: 800px) {

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }

            .notifications-header {
                align-items: flex-start;
            }

        }

        @media(max-width: 600px) {

            .navbar {
                width: 92%;
                padding: 16px 20px;
            }

            .brand h2 {
                font-size: 16px;
            }

            .brand span {
                font-size: 10px;
            }

            .logout-btn {
                padding: 9px 12px;
                font-size: 11px;
            }

            .logout-btn i {
                margin-right: 0;
            }

            .container {
                width: 92%;
                margin: 30px auto;
            }

            .page-header h1 {
                font-size: 26px;
            }

            .evaluations-grid {
                grid-template-columns: 1fr;
            }

            .evaluation-actions {
                flex-direction: column;
            }

            .notification-users {
                grid-template-columns: 1fr;
            }

            .notification-evaluation {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
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

        <form method="POST" action="{{ url('/logout') }}">

            @csrf

            <button type="submit" class="logout-btn">

                <i class="fas fa-right-from-bracket"></i>

                Cerrar sesión

            </button>

        </form>

    </nav>

    <main class="container">

        <div class="page-header">

            <div>

                <h1>
                    Evaluaciones
                </h1>

                <p>
                    Crea y administra las evaluaciones que estarán disponibles
                    para los usuarios de la plataforma.
                </p>

            </div>

            <div class="header-actions">

                <a href="{{ route('moderator.dashboard') }}" class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>

                    Volver

                </a>

                <a href="{{ route('moderator.evaluations.create') }}" class="btn btn-primary">

                    <i class="fas fa-plus"></i>

                    Nueva evaluación

                </a>

            </div>

        </div>

        @if(session('success'))

            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-error">

                <i class="fas fa-exclamation-circle"></i>

                {{ session('error') }}

            </div>

        @endif

        @php
            $notificacionesEvaluaciones = $notificacionesEvaluaciones ?? collect();

            $usuariosConNotificaciones = $notificacionesEvaluaciones->groupBy(function ($notificacion) {
                return $notificacion->intento?->user_uuid
                    ?? $notificacion->intento?->usuario?->uuid
                    ?? 'sin-usuario-' . $notificacion->id;
            });

            $usuariosPendientes = $usuariosConNotificaciones
                ->filter(function ($notificaciones) {
                    return $notificaciones->contains(function ($notificacion) {
                        return !$notificacion->read;
                    });
                })
                ->count();
        @endphp

        <div class="notifications-section">

            <div class="notifications-header">

                <div class="notifications-title">

                    <div class="notifications-title-icon">

                        <i class="fas fa-bell"></i>

                    </div>

                    <div>

                        <h2>
                            Notificaciones de evaluaciones
                        </h2>

                        <p>
                            Usuarios que han completado evaluaciones creadas por ti.
                        </p>

                    </div>

                </div>

                @if($usuariosPendientes > 0)

                    <span class="notification-count">

                        {{ $usuariosPendientes }}

                    </span>

                @endif

            </div>

            @if($usuariosConNotificaciones->isEmpty())

                <div class="notifications-empty">

                    <i class="fas fa-clipboard-check"></i>

                    <h3>
                        No hay notificaciones de evaluaciones
                    </h3>

                    <p>
                        Cuando un usuario complete una evaluación creada por ti,
                        aparecerá aquí.
                    </p>

                </div>

            @else

                <div class="notification-users">

                    @foreach($usuariosConNotificaciones as $userUuid => $notificacionesUsuario)

                        @php

                            $primeraNotificacion = $notificacionesUsuario->first();

                            $usuario = $primeraNotificacion->intento?->usuario;

                            $notificacionesValidas = $notificacionesUsuario
                                ->filter(function ($notificacion) {

                                    return $notificacion->intento !== null
                                        && $notificacion->evaluacion !== null
                                        && $notificacion->intento->status === 'COMPLETADA';

                                })
                                ->unique(function ($notificacion) {

                                    return $notificacion->attempt_uuid;

                                });

                            $cantidadEvaluaciones = $notificacionesValidas->count();

                            $nombreUsuario = $usuario?->full_name
                                ?? trim(
                                    ($usuario?->first_name ?? '') .
                                    ' ' .
                                    ($usuario?->last_name ?? '')
                                );

                            if (!$nombreUsuario) {

                                $nombreUsuario =
                                    $usuario?->anonymous_nickname
                                    ?? 'Usuario';

                            }

                            $notificacionPrincipal = $notificacionesValidas
                                ->sortByDesc('created_at')
                                ->first();

                        @endphp

                        @if($notificacionPrincipal && $cantidadEvaluaciones > 0)

                                <article class="notification-user-card">

                                    <div class="notification-user-top">

                                        <div class="notification-user-info">

                                            <div class="notification-user-avatar">

                                                <i class="fas fa-user"></i>

                                            </div>

                                            <div>

                                                <h3>
                                                    {{ $nombreUsuario }}
                                                </h3>

                                                <p>
                                                    Usuario de la plataforma
                                                </p>

                                            </div>

                                        </div>

                                        <span class="notification-user-count">

                                            {{ $cantidadEvaluaciones }}

                                            {{ $cantidadEvaluaciones === 1
                                ? 'evaluación'
                                : 'evaluaciones'
                                                }}

                                        </span>

                                    </div>

                                    <div class="notification-message">

                                        <i class="fas fa-circle-check"></i>

                                        {{ $nombreUsuario }}

                                        ha completado

                                        {{ $cantidadEvaluaciones }}

                                        {{ $cantidadEvaluaciones === 1
                                ? 'evaluación'
                                : 'evaluaciones'
                                            }}

                                        creadas por ti.

                                    </div>

                                    <div class="notification-evaluations">

                                        @foreach(
                                                $notificacionesValidas
                                                    ->sortByDesc('created_at')
                                                as $notificacion
                                            )

                                            <div class="notification-evaluation">

                                                <div class="notification-evaluation-name">

                                                    <i class="fas fa-clipboard-list"></i>

                                                    <span>

                                                        {{ $notificacion->evaluacion->title }}

                                                    </span>

                                                </div>

                                                <span class="notification-evaluation-date">

                                                    @if($notificacion->intento->completed_at)

                                                        {{ $notificacion->intento->completed_at->format('d/m/Y H:i') }}

                                                    @elseif($notificacion->created_at)

                                                        {{ $notificacion->created_at->format('d/m/Y H:i') }}

                                                    @endif

                                                </span>

                                            </div>

                                        @endforeach

                                    </div>

                                    <a href="{{ route(
                                'moderator.evaluation-results.user',
                                $userUuid
                            ) }}" class="notification-view-button">

                                        <i class="fas fa-eye"></i>

                                        Ver resultados

                                    </a>

                                </article>

                        @endif

                    @endforeach

                </div>

            @endif

        </div>

        @if($evaluaciones->isEmpty())

            <div class="empty-state">

                <div class="empty-icon">

                    <i class="fas fa-clipboard-question"></i>

                </div>

                <h2>
                    No hay evaluaciones creadas
                </h2>

                <p>
                    Todavía no existe ninguna evaluación.
                    Puedes crear la primera desde aquí.
                </p>

                <a href="{{ route('moderator.evaluations.create') }}" class="btn btn-primary">

                    <i class="fas fa-plus"></i>

                    Crear evaluación

                </a>

            </div>

        @else

            <div class="evaluations-grid">

                @foreach($evaluaciones as $evaluacion)

                        <div class="evaluation-card">

                            <div class="evaluation-top">

                                <div class="evaluation-icon">

                                    <i class="fas fa-clipboard-list"></i>

                                </div>

                                @if($evaluacion->status === 'ACTIVA')

                                    <span class="status status-active">

                                        ACTIVA

                                    </span>

                                @else

                                    <span class="status status-inactive">

                                        INACTIVA

                                    </span>

                                @endif

                            </div>

                            <h2>

                                {{ $evaluacion->title }}

                            </h2>

                            <p class="evaluation-description">

                                @if($evaluacion->description)

                                    {{ Str::limit($evaluacion->description, 120) }}

                                @else

                                    <span>
                                        Sin descripción.
                                    </span>

                                @endif

                            </p>

                            <div class="evaluation-info">

                                <div class="info-item">

                                    <i class="fas fa-list-check"></i>

                                    {{ $evaluacion->preguntas->count() }}

                                    {{ $evaluacion->preguntas->count() === 1
                        ? 'pregunta'
                        : 'preguntas'
                                    }}

                                </div>

                                <div class="info-item">

                                    <i class="fas fa-calendar"></i>

                                    @if($evaluacion->created_at)

                                        {{ $evaluacion->created_at->format('d/m/Y') }}

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                            <div class="evaluation-actions">

                                <a href="{{ route(
                        'moderator.evaluations.edit',
                        $evaluacion->uuid
                    ) }}" class="btn btn-warning">

                                    <i class="fas fa-pen"></i>

                                    Editar

                                </a>

                                <form method="POST" action="{{ route(
                        'moderator.evaluations.destroy',
                        $evaluacion->uuid
                    ) }}" class="delete-form" onsubmit="return confirm(
                                        '¿Estás seguro de eliminar esta evaluación? Esta acción también eliminará sus preguntas y respuestas relacionadas.'
                                    );">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">

                                        <i class="fas fa-trash"></i>

                                        Eliminar

                                    </button>

                                </form>

                            </div>

                        </div>

                @endforeach

            </div>

        @endif

    </main>

<script>
    window.addEventListener('load', function () {
        if (!window.Echo) {
            console.error('Echo no está disponible en el panel de evaluaciones.');
            return;
        }

        const moderatorUuid = @json(auth()->user()->uuid);

        window.Echo
            .private('moderator.' + moderatorUuid)
            .listen('.evaluation.completed', function () {
                window.location.reload();
            });
    });
</script>
</body>
</html>