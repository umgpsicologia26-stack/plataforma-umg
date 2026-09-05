<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Resultados de evaluaciones</title>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: #0f172a;
        color: #e2e8f0;
    }

    .container {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 20px 60px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        margin: 0 0 8px;
        font-size: 30px;
        font-weight: 700;
        color: #f8fafc;
    }

    .page-description {
        margin: 0;
        font-size: 15px;
        color: #94a3b8;
    }

    .user-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 32px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .user-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        flex-shrink: 0;
    }

    .user-name {
        margin: 0 0 5px;
        font-size: 21px;
        font-weight: 700;
        color: #f8fafc;
    }

    .user-email {
        margin: 0;
        color: #94a3b8;
        font-size: 14px;
    }

    .user-total {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #334155;
        font-size: 15px;
        color: #cbd5e1;
    }

    .user-total-number {
        font-size: 25px;
        font-weight: 700;
        color: #f8fafc;
        margin-right: 7px;
    }

    .section-title {
        margin: 0 0 18px;
        font-size: 21px;
        font-weight: 700;
        color: #f8fafc;
    }

    .evaluations-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .evaluation-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 22px;
    }

    .evaluation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 10px;
    }

    .evaluation-title {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
        color: #f8fafc;
    }

    .evaluation-description {
        margin: 7px 0 0;
        color: #94a3b8;
        font-size: 14px;
        line-height: 1.5;
    }

    .status {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 6px;
        background: #064e3b;
        color: #6ee7b7;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .evaluation-info {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid #334155;
        color: #94a3b8;
        font-size: 13px;
    }

    .evaluation-info-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .evaluation-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 9px 15px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .btn-result {
        background: #334155;
        color: #f8fafc;
        border: 1px solid #475569;
    }

    .btn-pdf {
        background: #475569;
        color: #f8fafc;
        border: 1px solid #64748b;
    }

    .back-container {
        margin-top: 28px;
    }

    .btn-back {
        background: transparent;
        color: #cbd5e1;
        border: 1px solid #475569;
    }

    .empty-state {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 35px 25px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state-icon {
        font-size: 35px;
        margin-bottom: 10px;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    @media (max-width: 700px) {
        .container {
            padding: 25px 15px 40px;
        }

        .page-title {
            font-size: 25px;
        }

        .user-info {
            align-items: flex-start;
        }

        .evaluation-header {
            flex-direction: column;
            gap: 12px;
        }

        .evaluation-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

</head>

<body>

<div class="container">


<div class="page-header">
    <h1 class="page-title">
        Resultados de evaluaciones
    </h1>

    <p class="page-description">
        Consulta las evaluaciones completadas por este usuario.
    </p>
</div>


<div class="user-card">

    <div class="user-info">

        <div class="user-avatar">
            👤
        </div>

        <div>
            <h2 class="user-name">
                {{ $usuario->full_name ?? 'Usuario' }}
            </h2>

            <p class="user-email">
                {{ $usuario->email ?? 'Correo no disponible' }}
            </p>
        </div>

    </div>

    <div class="user-total">

        <span class="user-total-number">
            {{ $resultados->count() }}
        </span>

        {{ $resultados->count() === 1 ? 'evaluación completada' : 'evaluaciones completadas' }}

    </div>

</div>


<h2 class="section-title">
    Evaluaciones completadas
</h2>


@if($resultados->isEmpty())

    <div class="empty-state">

        <div class="empty-state-icon">
            📋
        </div>

        <p>
            Este usuario no tiene evaluaciones completadas.
        </p>

    </div>

@else

    <div class="evaluations-list">

        @foreach($resultados as $resultado)

            @php
                $evaluacion = $resultado->evaluacion;
                $attempt = $resultado->intento;
            @endphp

            <div class="evaluation-card">

                <div class="evaluation-header">

                    <div>

                        <h3 class="evaluation-title">
                            {{ $evaluacion?->title ?? 'Evaluación sin título' }}
                        </h3>

                        @if($evaluacion?->description)

                            <p class="evaluation-description">
                                {{ $evaluacion->description }}
                            </p>

                        @endif

                    </div>

                    <span class="status">
                        COMPLETADA
                    </span>

                </div>


                <div class="evaluation-info">

                    <div class="evaluation-info-item">
                        📅

                        <span>
                            @if($attempt?->completed_at)
                                {{ $attempt->completed_at->format('d/m/Y H:i') }}
                            @else
                                Fecha no disponible
                            @endif
                        </span>
                    </div>


                    <div class="evaluation-info-item">
                        📝

                        <span>
                            {{ $attempt?->respuestas?->count() ?? 0 }}
                            {{ ($attempt?->respuestas?->count() ?? 0) === 1 ? 'respuesta' : 'respuestas' }}
                        </span>
                    </div>

                </div>


                <div class="evaluation-actions">

                    @if($resultado->id)

                        <a
                            href="{{ route('moderator.evaluation.result', $resultado->id) }}"
                            class="btn btn-result"
                        >
                            👁 Ver resultado
                        </a>

                        <a
                            href="{{ route('moderator.evaluation.pdf', $resultado->id) }}"
                            class="btn btn-pdf"
                        >
                            📄 Descargar PDF
                        </a>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

@endif


<div class="back-container">

    <a
        href="{{ route('moderator.evaluations') }}"
        class="btn btn-back"
    >
        ← Volver a evaluaciones
    </a>

</div>

</div>

</body>
</html>
