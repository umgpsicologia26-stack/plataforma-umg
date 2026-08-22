<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Casos - UMG</title>

<style>
        @page {
            margin: 35px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 11px;
        }

    /*ENCABEZADO*/
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }

        .subtitle {
            margin-top: 5px;
            color: #6b7280;
            font-size: 11px;
        }

        .date {
            margin-top: 8px;
            color: #6b7280;
            font-size: 10px;
        }

    /*TÍTULO*/
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 18px;
            color: #1f2937;
        }

    /*RESUMEN*/
        .summary {
            width: 100%;
            margin-bottom: 22px;
        }

        .summary-box {
            border: 1px solid #dbeafe;
            background: #eff6ff;
            padding: 10px;
            text-align: center;
        }

        .summary-number {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }

        .summary-label {
            font-size: 9px;
            color: #64748b;
        }

    /*TABLA*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2563eb;
            color: white;
            padding: 9px 7px;
            text-align: left;
            font-size: 10px;
        }

        td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 7px;
            font-size: 10px;
        }

        tr:nth-child(even) td {
            background: #f8fafc;
        }

        .case-number {
            color: #2563eb;
            font-weight: bold;
        }

    /*ESTADOS+*/
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

    /*PIE*/
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #94a3b8;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <!--ENCABEZADO-->
    <div class="header">
        <div class="brand">
            UMG
        </div>
        <div class="subtitle">
            Plataforma informática preventiva y de orientación
        </div>

        <div class="date">
            Reporte generado:
            {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <!--TÍTULO-->
    <div class="report-title">
        Reporte de Casos Administrativos
    </div>

    <!--RESUMEN-->
    <table class="summary">
        <tr>
            <td width="33%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{ $cases->count() }}
                    </div>

                    <div class="summary-label">
                        Total de casos
                    </div>
                </div>
            </td>

            <td width="33%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{
                            $cases
                                ->where('status', 'ABIERTO')
                                ->count()
                        }}
                    </div>

                    <div class="summary-label">
                        Casos abiertos
                    </div>
                </div>
            </td>

            <td width="33%">
                <div class="summary-box">
                    <div class="summary-number">
                        {{
                            $cases
                                ->where('status', 'CERRADO')
                                ->count()
                        }}
                    </div>

                    <div class="summary-label">
                        Casos cerrados
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!--TABLA DE CASOS-->
    <table>
        <thead>
            <tr>
                <th>
                    Número de caso
                </th>

                <th>
                    Tema
                </th>

                <th>
                    Estado
                </th>

                <th>
                    Moderador
                </th>

                <th>
                    Fecha
                </th>
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
                        @if($case->status === 'ABIERTO')
                            <span class="status open">
                                Abierto
                            </span>

                        @elseif($case->status === 'EN_PROCESO')
                            <span class="status process">
                                En proceso
                            </span>

                        @elseif($case->status === 'TERMINADO')
                            <span class="status finished">
                                Terminado
                            </span>

                        @elseif($case->status === 'PENDIENTE_APROBACION')
                            <span class="status pending">
                                Pendiente aprobación
                            </span>

                        @elseif($case->status === 'CERRADO')
                            <span class="status closed">
                                Cerrado
                            </span>

                        @else
                            {{ $case->status }}
                        @endif
                    </td>

                    <td>
                        {{ $case->moderator
                            ? $case->moderator->first_name
                            . ' '
                            . $case->moderator->last_name
                            : 'No asignado'
                        }}
                    </td>

                    <td>
                        {{ $case->created_at->format('d/m/Y') }}
                    </td>

                </tr>
            @empty
                <tr>

                    <td
                        colspan="5"
                        style="text-align:center; padding:25px;">
                        No hay casos registrados.
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>

    <!--PIE-->
    <div class="footer">
        UMG — Reporte administrativo de casos
    </div>
</body>
</html>