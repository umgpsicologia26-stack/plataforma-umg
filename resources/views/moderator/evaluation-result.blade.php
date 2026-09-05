<!DOCTYPE html> <html lang="es"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resultado de evaluación</title>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: #0f172a;
        color: #f8fafc;
    }

    .evaluation-result-page {
        min-height: 100vh;
        padding: 35px;
        background: #0f172a;
    }

    .evaluation-result-container {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-title {
        margin: 0 0 8px;
        color: #ffffff;
        font-size: 30px;
        font-weight: 700;
    }

    .page-description {
        margin: 0;
        color: #94a3b8;
        font-size: 15px;
        line-height: 1.5;
    }

    .evaluation-summary {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 18px;
    }

    .evaluation-summary-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .evaluation-title {
        margin: 0 0 8px;
        color: #ffffff;
        font-size: 22px;
        font-weight: 700;
    }

    .evaluation-description {
        margin: 0;
        color: #94a3b8;
        font-size: 14px;
        line-height: 1.6;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        border-radius: 20px;
        background: #14532d;
        color: #bbf7d0;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #4ade80;
    }

    .user-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 22px 24px;
        margin-bottom: 25px;
    }

    .user-card-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .user-avatar {
        width: 54px;
        height: 54px;
        min-width: 54px;
        border-radius: 50%;
        background: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 22px;
    }

    .user-information {
        flex: 1;
        min-width: 0;
    }

    .user-name {
        margin: 0 0 5px;
        color: #ffffff;
        font-size: 18px;
        font-weight: 700;
    }

    .user-email {
        margin: 0;
        color: #94a3b8;
        font-size: 13px;
        word-break: break-word;
    }

    .completion-info {
        text-align: right;
    }

    .completion-label {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 11px;
    }

    .completion-date {
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 600;
    }

    .answers-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .answers-title {
        margin: 0;
        color: #ffffff;
        font-size: 21px;
        font-weight: 700;
    }

    .answers-count {
        color: #94a3b8;
        font-size: 13px;
    }

    .answers-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .answer-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 20px 22px;
    }

    .question-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        margin-bottom: 10px;
        border-radius: 7px;
        background: #334155;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
    }

    .question-text {
        margin: 0 0 15px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.5;
    }

    .answer-label {
        margin-bottom: 6px;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .answer-value {
        padding: 12px 14px;
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 8px;
        color: #e2e8f0;
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
    }

    .empty-answers {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 40px 25px;
        text-align: center;
    }

    .empty-icon {
        margin-bottom: 12px;
        font-size: 35px;
    }

    .empty-answers h3 {
        margin: 0 0 7px;
        color: #ffffff;
        font-size: 18px;
    }

    .empty-answers p {
        margin: 0;
        color: #94a3b8;
        font-size: 13px;
    }

    .bottom-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #334155;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 40px;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-back {
        background: #334155;
        color: #ffffff;
        border: 1px solid #475569;
    }

    .btn-back:hover {
        background: #475569;
    }

    .btn-pdf {
        background: #334155;
        color: #ffffff;
        border: 1px solid #475569;
    }

    .btn-pdf:hover {
        background: #475569;
    }

    @media (max-width: 768px) {

        .evaluation-result-page {
            padding: 25px 18px 40px;
        }

        .page-title {
            font-size: 25px;
        }

        .evaluation-summary-header {
            flex-direction: column;
        }

        .user-card-content {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .completion-info {
            width: 100%;
            margin-left: 70px;
            text-align: left;
        }

        .answers-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

        .bottom-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }
    }
</style>
</head> <body> <div class="evaluation-result-page">
<div class="evaluation-result-container">

    <div class="page-header">

        <h1 class="page-title">
            Resultado de evaluación
        </h1>

        <p class="page-description">
            Consulta detallada de las respuestas proporcionadas por el usuario.
        </p>

    </div>


    <div class="evaluation-summary">

        <div class="evaluation-summary-header">

            <div>

                <h2 class="evaluation-title">
                    {{ $evaluacion->title }}
                </h2>

                @if(!empty($evaluacion->description))

                    <p class="evaluation-description">
                        {{ $evaluacion->description }}
                    </p>

                @endif

            </div>


            <span class="status-badge">

                <span class="status-dot"></span>

                COMPLETADA

            </span>

        </div>

    </div>


    <div class="user-card">

        <div class="user-card-content">

            <div class="user-avatar">
                👤
            </div>


            <div class="user-information">

                <p class="user-name">

                    @if($attempt->usuario)

                        {{ $attempt->usuario->full_name
                            ?? trim(
                                ($attempt->usuario->first_name ?? '') .
                                ' ' .
                                ($attempt->usuario->last_name ?? '')
                            )
                            ?: 'Usuario'
                        }}

                    @else

                        Usuario

                    @endif

                </p>


                @if($attempt->usuario && !empty($attempt->usuario->email))

                    <p class="user-email">
                        {{ $attempt->usuario->email }}
                    </p>

                @endif

            </div>


            <div class="completion-info">

                <span class="completion-label">
                    Evaluación completada
                </span>

                <span class="completion-date">

                    @if($attempt->completed_at)

                        {{ $attempt->completed_at->format('d/m/Y H:i') }}

                    @elseif($notification->created_at)

                        {{ $notification->created_at->format('d/m/Y H:i') }}

                    @endif

                </span>

            </div>

        </div>

    </div>


    <div class="answers-header">

        <h2 class="answers-title">
            Respuestas
        </h2>

        <span class="answers-count">

            {{ $attempt->respuestas->count() }}

            {{ $attempt->respuestas->count() === 1 ? 'respuesta' : 'respuestas' }}

        </span>

    </div>


    @if($attempt->respuestas->count() > 0)

        <div class="answers-list">

            @foreach($attempt->respuestas as $indice => $respuesta)

                <div class="answer-card">

                    <div class="question-number">
                        {{ $indice + 1 }}
                    </div>


                    <p class="question-text">

                        @if($respuesta->pregunta)

                            {{ $respuesta->pregunta->question }}

                        @else

                            Pregunta no disponible

                        @endif

                    </p>


                    <div class="answer-label">
                        Respuesta
                    </div>


                    <div class="answer-value">
                        {{ $respuesta->respuesta }}
                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-answers">

            <div class="empty-icon">
                📋
            </div>

            <h3>
                No hay respuestas
            </h3>

            <p>
                No se encontraron respuestas registradas para esta evaluación.
            </p>

        </div>

    @endif


    <div class="bottom-actions">

        <a
            href="{{ route('moderator.evaluation-results.user', $attempt->user_uuid) }}"
            class="btn btn-back"
        >
            ← Volver a resultados
        </a>


        <a
            href="{{ route('moderator.evaluation.pdf', $notification->id) }}"
            class="btn btn-pdf"
            target="_blank"
        >
            📄 Descargar PDF
        </a>

    </div>

</div>
</div> 
</body>
 </html>