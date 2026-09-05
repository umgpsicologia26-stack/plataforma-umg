<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Resultado de evaluación</title>

    <style>

        @page {
            margin: 32px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .info-box {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .info-box-header {
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
            padding: 8px 14px;
        }

        .info-box-body {
            padding: 14px;
            font-size: 10.5px;
            color: #1e293b;
        }

        .field {
            margin-bottom: 9px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .badge-completed {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 3px 10px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 9px;
            line-height: normal;
        }

        .answers-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .answers-table th {
            background: #0f172a;
            color: #ffffff;
            text-align: left;
            padding: 9px 10px;
            font-size: 10px;
        }

        .answers-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            vertical-align: top;
        }

        .answers-table tr:nth-child(even) td {
            background: #f8fafc;
        }

        .col-num {
            width: 6%;
            color: #64748b;
            font-weight: bold;
        }

        .col-question {
            width: 47%;
            color: #0f172a;
            font-weight: bold;
        }

        .col-answer {
            width: 47%;
            color: #1e293b;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin: 24px 0 10px;
        }

        .footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }

    </style>
</head>

<body>

    @php
        $documentNumber = $notification->id ?? ($attempt->uuid ?? null);
    @endphp

    @include('pdf.partials.header', [
        'documentTitle' => 'RESULTADO DE EVALUACIÓN',
        'documentDate' => now()->format('d/m/Y H:i'),
        'documentNumber' => $documentNumber,
    ])

    {{-- DATOS DE LA EVALUACIÓN + DATOS DEL USUARIO --}}

    <table style="width:100%; margin-bottom:22px;" cellpadding="0" cellspacing="0">
        <tr>

            <td style="width:48%; vertical-align:top;">

                <div class="info-box">

                    <div class="info-box-header" style="background:#0f172a;">
                        DATOS DE LA EVALUACIÓN
                    </div>

                    <div class="info-box-body">

                        <div class="field">
                            <strong>Evaluación:</strong>
                            {{ $evaluacion->title }}
                        </div>

                        @if($evaluacion->description)
                            <div class="field">
                                <strong>Descripción:</strong>
                                {{ $evaluacion->description }}
                            </div>
                        @endif

                        <div class="field">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="vertical-align:middle; padding-right:6px; white-space:nowrap;">
                                        <strong>Estado:</strong>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <span class="badge-completed">COMPLETADA</span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="field">
                            <strong>Fecha de completado:</strong>
                            {{ $attempt->completed_at
                                ? $attempt->completed_at->format('d/m/Y H:i')
                                : 'No disponible'
                            }}
                        </div>

                    </div>

                </div>

            </td>

            <td style="width:4%;"></td>

            <td style="width:48%; vertical-align:top;">

                <div class="info-box">

                    <div class="info-box-header" style="background:#2563eb;">
                        DATOS DEL USUARIO
                    </div>

                    <div class="info-box-body">

                        <div class="field">
                            <strong>Nombre:</strong>
                            {{ $attempt->usuario?->full_name ?? 'Usuario' }}
                        </div>

                        <div class="field">
                            <strong>Correo electrónico:</strong>
                            {{ $attempt->usuario?->email ?? 'No disponible' }}
                        </div>

                    </div>

                </div>

            </td>

        </tr>
    </table>

    {{-- RESPUESTAS --}}

    <div class="section-title">
        Respuestas registradas
    </div>

    <table class="answers-table">

        <thead>
            <tr>
                <th class="col-num">#</th>
                <th class="col-question">Pregunta</th>
                <th class="col-answer">Respuesta</th>
            </tr>
        </thead>

        <tbody>

            @forelse($attempt->respuestas as $index => $respuesta)

                @php
                    $decoded = json_decode($respuesta->respuesta, true);

                    $textoRespuesta = is_array($decoded)
                        ? implode(', ', $decoded)
                        : $respuesta->respuesta;
                @endphp

                <tr>
                    <td class="col-num">
                        {{ $index + 1 }}
                    </td>

                    <td class="col-question">
                        {{ $respuesta->pregunta?->question ?? 'Pregunta no disponible' }}
                    </td>

                    <td class="col-answer">
                        {{ $textoRespuesta }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3" style="text-align:center; padding:20px; color:#64748b;">
                        No se encontraron respuestas para esta evaluación.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="footer">
        Documento generado automáticamente por UMG Xela — {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>