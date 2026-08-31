<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Gestión de Casos | UMG</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            background:
                linear-gradient(
                    135deg,
                    #eef4ff,
                    #f8fbff
                );
            min-height: 100vh;
            color: #1f2937;
        }

    /*CONTENEDOR*/
    .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 35px 20px 50px;
        }

    /*BOTÓN VOLVER*/
    .back-button {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            color: #374151;
            background: #ffffff;
            padding: 11px 18px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all .2s ease;
        }

    .back-button:hover {
            background: #f3f4f6;
            transform: translateX(-2px);
        }

    /*ENCABEZADO*/
    .page-header {
            background: #ffffff;
            border-radius: 18px;
            padding: 25px 30px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            border: 1px solid #e8edf5;
        }

    .title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 25px;
            font-weight: 700;
            color: #1f2937;
        }

    .title i {
            color: #2563eb;
        }

    .subtitle {
            margin-top: 7px;
            color: #6b7280;
            font-size: 14px;
        }

    /*TARJETA*/
    .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            border: 1px solid #e8edf5;
        }

    /*ENCABEZADO DE TABLA*/
    .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 22px;
        }

    .table-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

    .table-title i {
            color: #2563eb;
        }


    .count {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

    /*TABLA*/
    .table-container {
            width: 100%;
            overflow-x: auto;
        }

    table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 850px;
        }

    th {
            background: #f8fafc;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 14px 16px;
            text-align: left;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }

    th:first-child {
            border-left: 1px solid #e5e7eb;
            border-radius: 10px 0 0 10px;
        }

        th:last-child {
            border-right: 1px solid #e5e7eb;
            border-radius: 0 10px 10px 0;
        }

        td {
            padding: 15px 16px;
            border-bottom: 1px solid #edf0f4;
            color: #374151;
            font-size: 14px;
            background: #ffffff;
        }

        tbody tr {
            transition: background .2s ease;
        }

        tbody tr:hover td {
            background: #f8fafc;
        }

    /*NÚMERO DE CASO*/
    .case-number {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #2563eb;
            font-weight: 700;
            font-size: 13px;
        }

    /*TEMA*/
    .topic {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 10px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
        }

        /*ESTADOS*/
        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .status-open {
            background: #fff7ed;
            color: #c2410c;
        }

        .status-open .status-dot {
            background: #f97316;
        }

        .status-process {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .status-process .status-dot {
            background: #3b82f6;
        }

        .status-finished {
            background: #ecfdf5;
            color: #15803d;
        }

        .status-finished .status-dot {
            background: #22c55e;
        }

        .status-pending {
            background: #fefce8;
            color: #a16207;
        }

        .status-pending .status-dot {
            background: #eab308;
        }


        .status-closed {
            background: #f1f5f9;
            color: #475569;
        }

        .status-closed .status-dot {
            background: #64748b;
        }

    /*ACCIONES*/
        .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            text-decoration: none;
            transition: all .2s ease;
        }

    /*VISUALIZAR*/
        .view-btn {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
        }

        .view-btn:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-1px);
        }

    /*EDITAR*/
        .edit-btn {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }

        .edit-btn:hover {
            background: #f59e0b;
            color: white;
            transform: translateY(-1px);
        }

    /*ELIMINAR*/
        .delete-btn {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .delete-btn:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-1px);
        }


    /*VACÍO*/
        .empty {
            text-align: center;
            padding: 45px 20px;
            color: #6b7280;
        }

        .empty i {
            font-size: 38px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .empty p {
            font-size: 14px;
        }

    /*RESPONSIVE*/
        @media (max-width: 700px) {
            .container {
                padding:
                    20px 14px 40px;
            }

            .page-header,
            .card {
                padding: 22px 18px;
            }

            .title {
                font-size: 21px;
            }

            .table-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!--VOLVER-->
    <a
        href="/admin-panel"
            class="back-button">
                <i class="fas fa-arrow-left"></i>
        Volver al panel
    </a>

    <!--ENCABEZADO-->
    <div class="page-header">
        <div class="title">
            <i class="fas fa-folder-open"></i>
            Gestión de Casos
        </div>
        <div class="subtitle">
            Consulta, visualiza, modifica y administra
            los casos registrados en UMG.
        </div>
    </div>

    <!--TABLA-->
    <div class="card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-folder-tree"></i>
                Casos registrados
            </div>
            <span class="count">
                {{ $cases->count() }}
                {{ $cases->count() == 1
                    ? 'caso'
                    : 'casos'
                }}
            </span>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>
                            Número
                        </th>

                        <th>
                            Tema
                        </th>

                        <th>
                            Moderador
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cases as $case)
                        <tr>
    <!-- NÚMERO -->
    <td>
        <span class="case-number">
            <i class="fas fa-hashtag"></i>
                {{ $case->case_number }}
        </span>
    </td>

    <!-- TEMA -->
    <td>
        <span class="topic">
                @if($case->topic === 'Suicidio')
            <i class="fas fa-heart-pulse"></i>
                Suicidio
                @elseif($case->topic === 'Abuso sexual')
            <i class="fas fa-shield-heart"></i>
                Abuso sexual
                    @else
            <i class="fas fa-folder"></i>
                {{ $case->topic }}
                    @endif
        </span>
    </td>

    <!-- MODERADOR -->
    <td>
        {{ $case->moderator
        ? $case->moderator->first_name
        . ' '
        . $case->moderator->last_name
        : 'No asignado'
        }}
    </td>

    <!-- FECHA -->
    <td>
        {{ $case->created_at->format('d/m/Y') }}
    </td>

    <!-- ESTADO -->
    <td>
        @if($case->status === 'ABIERTO')
        <span class="status status-open">
            <span class="status-dot"></span>
            Abierto
            </span>
        @elseif($case->status === 'EN_PROCESO')
        <span class="status status-process">
            <span class="status-dot"></span>
,,         En proceso
            </span>

        @elseif($case->status === 'TERMINADO')
        <span class="status status-finished">
            <span class="status-dot"></span>
            Terminado
            </span>

        @elseif($case->status === 'PENDIENTE_APROBACION')
        <span class="status status-pending">
            <span class="status-dot"></span>
            Pendiente aprobación
            </span>

        @elseif($case->status === 'CERRADO')
        <span class="status status-closed">
            <span class="status-dot"></span>
            Cerrado
        </span>

        @else
        <span class="status status-process">
            <span class="status-dot"></span>
                {{ $case->status }}
            </span>
        @endif
            </td>

    <!-- ACCIONES -->
            <td>
                <div class="actions">

    <!-- VISUALIZAR -->
    <a
        href="/admin/case/{{ $case->id }}"
        class="action-btn view-btn"
        title="Visualizar caso">
            <i class="fas fa-eye"></i>
    </a>

    <!-- EDITAR -->
    <a
        href="/admin/case/edit/{{ $case->id }}"
        class="action-btn edit-btn"
        title="Editar caso">
            <i class="fas fa-pen"></i>
    </a>

    <!-- ELIMINAR -->
    <a
        href="/admin/case/delete/{{ $case->id }}"
        class="action-btn delete-btn"
        title="Eliminar caso"
        onclick="return confirm('¿Está seguro de eliminar este caso?');">
            <i class="fas fa-trash"></i>
    </a>
        </div>
            </td>
                </tr>
                    @empty
                        <tr>
                            <td
                                colspan="6"
                                class="empty">
                                <i class="fas fa-folder-open"></i>
                                <p>
                                    No hay casos registrados.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>