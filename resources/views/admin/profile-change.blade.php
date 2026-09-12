<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Último cambio de perfil</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #eef2ff;
            --success: #059669;
            --success-bg: #ecfdf5;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --text: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(160deg, #eef2ff 0%, #f4f7fb 40%, #f4f7fb 100%);
            background-attachment: fixed;
            color: var(--text);
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
        }

        .header {
            background: linear-gradient(120deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 18px;
            padding: 30px 32px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.25);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 26px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .header h1 i {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px;
            border-radius: 12px;
            font-size: 20px;
        }

        .header p {
            margin: 0;
            color: rgba(255, 255, 255, 0.85);
            position: relative;
            z-index: 1;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.06);
            border: 1px solid var(--border);
        }

        .card h2 {
            margin: 0 0 18px;
            font-size: 19px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-dark);
        }

        .card h2::before {
            content: "";
            width: 4px;
            height: 20px;
            background: var(--primary);
            border-radius: 4px;
        }

        .user-info {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .user-pill {
            background: var(--primary-light);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 14px;
        }

        .user-pill strong {
            color: var(--primary-dark);
            margin-right: 6px;
        }

        .change-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 5px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .change-table th,
        .change-table td {
            padding: 15px 16px;
            text-align: left;
        }

        .change-table th {
            background: #f9fafb;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .change-table tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--border);
        }

        .change-table tbody tr {
            transition: background 0.15s ease;
        }

        .change-table tbody tr:hover {
            background: #fafaff;
        }

        .change-table td {
            word-break: break-word;
            vertical-align: middle;
        }

        .field-name {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .field-name::before {
            content: "\f044";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: var(--primary);
            font-size: 12px;
        }

        .value-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        .value-before {
            background: var(--danger-bg);
            color: var(--danger);
            text-decoration: line-through;
            text-decoration-color: rgba(220, 38, 38, 0.4);
        }

        .value-after {
            background: var(--success-bg);
            color: var(--success);
        }

        .arrow-cell {
            text-align: center;
            color: var(--text-muted);
            width: 30px;
        }

        .empty {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-muted);
        }

        .empty i {
            font-size: 40px;
            color: var(--primary);
            opacity: 0.5;
            margin-bottom: 14px;
            display: block;
        }

        .date {
            margin-top: 22px;
            color: var(--text-muted);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f9fafb;
            padding: 10px 14px;
            border-radius: 10px;
            width: fit-content;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
            padding: 12px 20px;
            background: var(--text);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: transform 0.15s ease, background 0.15s ease;
        }

        .back-button:hover {
            background: #111827;
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .container {
                width: 94%;
                margin: 20px auto;
            }

            .header {
                padding: 22px;
            }

            .card {
                padding: 20px;
            }

            .change-table th,
            .change-table td {
                padding: 10px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>
            <i class="fas fa-clock-rotate-left"></i>
            Último cambio de perfil
        </h1>

        <p>
            Consulta del último cambio realizado por el usuario.
        </p>
    </div>

    <div class="card">

        <h2>
            Usuario
        </h2>

        <div class="user-info">
            <div class="user-pill">
                <strong>Nombre:</strong>
                {{ $user->first_name }} {{ $user->last_name }}
            </div>

            <div class="user-pill">
                <strong>Nickname:</strong>
                {{ $user->anonymous_nickname }}
            </div>
        </div>

        @if($profileChanges->isNotEmpty())

    @foreach($profileChanges as $lastChange)

        <div style="margin-bottom: 30px;">

            <div class="date" style="margin-top: 0; margin-bottom: 14px;">
                <i class="far fa-calendar"></i>

                Cambio realizado:
                {{ $lastChange->created_at->format('d/m/Y H:i') }}
            </div>

            @if(!empty($lastChange->changes))

                <table class="change-table">

                    <thead>
                        <tr>
                            <th>Campo</th>
                            <th>Antes</th>
                            <th></th>
                            <th>Después</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($lastChange->changes as $field => $change)

                            <tr>

                                <td class="field-name">

                                    @switch($field)

                                        @case('first_name')
                                            Nombre
                                            @break

                                        @case('last_name')
                                            Apellido
                                            @break

                                        @case('email')
                                            Correo electrónico
                                            @break

                                        @case('phone')
                                            Teléfono
                                            @break

                                        @case('anonymous_nickname')
                                            Nickname
                                            @break

                                        @default
                                            {{ $field }}

                                    @endswitch

                                </td>

                                <td>
                                    <span class="value-badge value-before">
                                        {{ $change['before'] ?? '—' }}
                                    </span>
                                </td>

                                <td class="arrow-cell">
                                    <i class="fas fa-arrow-right"></i>
                                </td>

                                <td>
                                    <span class="value-badge value-after">
                                        {{ $change['after'] ?? '—' }}
                                    </span>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

    @endforeach

@else

    <div class="empty">

        <i class="fas fa-info-circle"></i>

        <p>
            Este usuario todavía no ha realizado cambios en su perfil.
        </p>

    </div>

@endif

        <a
            href="{{ url('/admin/users') }}"
            class="back-button"
        >
            <i class="fas fa-arrow-left"></i>
            Volver a usuarios
        </a>

    </div>

</div>

</body>
</html>