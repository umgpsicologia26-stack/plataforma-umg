<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de Casos - UMG Xela</title>

    <style>
        @page {
            margin: 32px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 18px;
            color: #0f172a;
        }

        .summary {
            width: 100%;
            margin-bottom: 22px;
        }

        .summary-box {
            border: 1px solid #dbeafe;
            background: #eff6ff;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
        }

        .summary-number {
            font-size: 19px;
            font-weight: bold;
            color: #2563eb;
        }

        .summary-label {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        table.cases {
            width: 100%;
            border-collapse: collapse;
        }

        table.cases th {
            background: #0f172a;
            color: #ffffff;
            padding: 9px 8px;
            text-align: left;
            font-size: 10px;
        }

        table.cases td {
            border-bottom: 1px solid #e5e7eb;
            padding: 9px 8px;
            font-size: 10px;
        }

        table.cases tr:nth-child(even) td {
            background: #f8fafc;
        }

        .case-number {
            color: #2563eb;
            font-weight: bold;
        }

        .status {
            font-weight: bold;
        }

        .open {
            color: #c2410c;
        }

        .process {
            color: #1d4ed8;
        }

        .finished {
            color: #15803d;
        }

        .pending {
            color: #a16207;
        }

        .closed {
            color: #475569;
        }

        .footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #94a3b8;
            font-size: 9px;
        }
    </style>
</head>

<body>

    @include('pdf.partials.header', [
        'documentTitle' => 'REPORTE DE CASOS',
        'documentDate' => now()->format('d/m/Y H:i'),
        'documentNumber' => null,
    ])

    <div class="report-title">
        Reporte de Casos Administrativos
    </div>

    {{-- RESUMEN --}}

    <table class="summary" cellpadding="0" cellspacing="0">
        <tr>

            <td width="32%">
                <div class="summary-box">

                    <div class="summary-number">
                        {{ $cases->count() }}
                    </div>

                    <div class="summary-label">
                        Total de casos
                    </div>

                </div>
            </td>

            <td width="2%"></td>

            <td width="32%">
                <div class="summary-box">

                    <div class="summary-number">
                        {{ $cases->where('status', 'Abierto')->count() }}
                    </div>

                    <div class="summary-label">
                        Casos abiertos
                    </div>

                </div>
            </td>

            <td width="2%"></td>

            <td width="32%">
                <div class="summary-box">

                    <div class="summary-number">
                        {{ $cases->where('status', 'Cerrado')->count() }}
                    </div>

                    <div class="summary-label">
                        Casos cerrados
                    </div>

                </div>
            </td>

        </tr>
    </table>

    {{-- TABLA DE CASOS --}}

    <table class="cases">

        <thead>
            <tr>
                <th>Número de caso</th>
                <th>Tema</th>
                <th>Estado</th>
                <th>Moderador</th>
                <th>Fecha</th>
            </tr>
        </thead>

        <tbody>

            @forelse($cases as $case)

                    <tr>

                        <td>
                            <span class="case-number">
                                {{ $case->case_number }}
                            </span>
                        </td>

                        <td>
                            @if($case->type === 'SUICIDIO')
                                Suicidio
                            @elseif($case->type === 'ABUSO_SEXUAL')
                                Abuso sexual
                            @else
                                {{ $case->type }}
                            @endif
                        </td>

                        <td>

                            @if($case->status === 'Abierto')
                                <span class="status open">Abierto</span>

                            @elseif($case->status === 'En seguimiento')
                                <span class="status process"> En seguimiento</span>

                            @elseif($case->status === 'Cerrado')
                                <span class="status closed">Cerrado</span>

                            @else
                                {{ $case->status }}
                            @endif
                        </td>

                        <td>
                            {{ $case->moderator
                ? $case->moderator->first_name . ' ' . $case->moderator->last_name
                : 'No asignado'
                                }}
                        </td>

                        <td>
                            {{ $case->created_at->format('d/m/Y') }}
                        </td>

                    </tr>

            @empty

                <tr>
                    <td colspan="5" style="text-align:center; padding:25px; color:#64748b;">
                        No hay casos registrados.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="footer">
        UMG Xela — Reporte administrativo de casos generado automáticamente
    </div>

</body>

</html>
