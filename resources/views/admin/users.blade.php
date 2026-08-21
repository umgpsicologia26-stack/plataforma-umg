<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Usuarios | UMG</title>

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
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
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
            max-width: 1250px;
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
            box-shadow:
                0 3px 10px rgba(0,0,0,0.05);
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
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            border: 1px solid #e8edf5;
        }

    /*ENCABEZADO TABLA*/
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
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
            min-width: 1050px;
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
            vertical-align: middle;
        }

        tbody tr {
            transition: background .2s ease;
        }

        tbody tr:hover td {
            background: #f8fafc;
        }

    /*CÓDIGO ÚNICO*/
        .anonymous-code {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 10px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .4px;
        }

    /*ESTADOS*/
        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .status.active {
            background: #ecfdf5;
            color: #15803d;
        }

        .status.active .status-dot {
            background: #22c55e;
        }

        .status.blocked {
            background: #fff7ed;
            color: #c2410c;
        }

        .status.blocked .status-dot {
            background: #f97316;
        }

        .status.pending {
            background: #fffbeb;
            color: #a16207;
        }

        .status.pending .status-dot {
            background: #eab308;
        }

        .status.unknown {
            background: #f3f4f6;
            color: #4b5563;
        }

        .status.unknown .status-dot {
            background: #9ca3af;
        }

    /*ACCIONES*/
        .actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 11px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid transparent;
            font-size: 12px;
            font-weight: 600;
            transition: all .2s ease;
            white-space: nowrap;
        }

        .action-button:hover {
            transform: translateY(-1px);
        }

    /*ACTIVAR*/
        .activate {
            background: #ecfdf5;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .activate:hover {
            background: #dcfce7;
        }

    /*SUSPENDER*/
        .suspend {
            background: #fff7ed;
            color: #c2410c;
            border-color: #fed7aa;
        }

        .suspend:hover {
            background: #ffedd5;
        }


    /*ELIMINAR*/
        .delete {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .delete:hover {
            background: #fee2e2;
        }

    /*RESTAURAR*/
        .restore {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .restore:hover {
            background: #dbeafe;
        }

    /*MENSAJE VACÍO*/
        .empty {
            text-align: center;
            padding: 35px 20px !important;
            color: #6b7280;
        }

        .empty i {
            font-size: 35px;
            color: #cbd5e1;
            margin-bottom: 12px;
            display: block;
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

    <!--VOLVER AL PANEL-->
    <a
        href="/admin-panel"
        class="back-button">
        <i class="fas fa-arrow-left"></i>
        Volver al panel
    </a>

    <!--ENCABEZADO-->
    <div class="page-header">
        <div class="title">
            <i class="fas fa-users"></i>
            Gestión de Usuarios
        </div>

        <div class="subtitle">
            Administra los usuarios registrados
            en la plataforma UMG.
        </div>
    </div>

    <!--LISTADO DE USUARIOS-->
    <div class="card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-user-group"></i>
                Usuarios registrados
            </div>
            <span class="count">
                {{ $users->count() }}
                {{ $users->count() == 1
                    ? 'usuario'
                    : 'usuarios'
                }}
            </span>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>
                            Código único
                        </th>

                        <th>
                            Nombre
                        </th>

                        <th>
                            Apellido
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Celular
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Fecha registro
                        </th>

                        <th>
                            Acciones
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>

    <!-- CÓDIGO -->
        <td>
            <span class="anonymous-code">
            <i class="fas fa-fingerprint"></i>
                {{ $user->anonymous_nickname }}
            </span>
        </td>

    <!-- NOMBRE -->
        <td>
            {{ $user->first_name }}
        </td>

    <!-- APELLIDO -->
        <td>
            {{ $user->last_name }}
        </td>

    <!-- EMAIL -->
        <td>
            {{ $user->email }}
        </td>

    <!-- TELÉFONO -->
        <td>
            {{ $user->phone ?? 'No registrado' }}
        </td>

    <!-- ESTADO -->
        <td>
            @if($user->status === 'ACTIVE')
                <span class="status active">
                    <span class="status-dot"></span>
                    Activo
                        </span>

            @elseif($user->status === 'BLOCKED')
                <span class="status blocked">
                    <span class="status-dot"></span>
                    Bloqueado
                        </span>

            @elseif($user->status === 'PENDING')
                <span class="status pending">
                    <span class="status-dot"></span>
                    Pendiente
                        </span>

            @else
                <span class="status unknown">
                    <span class="status-dot"></span>
                    {{ $user->status }}
                        </span>

            @endif
                </td>

    <!-- FECHA -->
        <td>
            {{ $user->created_at
            ? $user->created_at->format('d/m/Y')
            : '—'
            }}
        </td>

    <!-- ACCIONES -->
        <td>
            <div class="actions">
                <a
                    href="/admin/user/{{ $user->id }}/activate"
                    class="action-button activate"
                    title="Activar usuario">

        <i class="fas fa-check"></i>
            Activar
        </a>

        <a
            href="/admin/user/{{ $user->id }}/suspend"
            class="action-button suspend"
            title="Suspender usuario">

            <i class="fas fa-ban"></i>
                Suspender
                </a>

        <a
            href="/admin/user/{{ $user->id }}/delete"
            class="action-button delete"
            title="Eliminar usuario">

            <i class="fas fa-trash"></i>
                Eliminar
        </a>

        <a
            href="/admin/user/{{ $user->id }}/restore"
            class="action-button restore"
            title="Restaurar usuario">

            <i class="fas fa-rotate-left"></i>
                Restaurar
        </a>
            </div>
        </td>
            </tr>
                @empty
                        <tr>
                            <td
                                colspan="8"
                                class="empty">
                                <i class="fas fa-user-slash"></i>

                                <p>
                                    No hay usuarios registrados.
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