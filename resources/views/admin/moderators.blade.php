<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Moderadores | VitaSafe</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

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


        /* =========================================
           CONTENEDOR
        ========================================= */

        .container {

            width: 100%;

            max-width: 1100px;

            margin: 0 auto;

            padding: 35px 20px 50px;

        }


        /* =========================================
           BOTÓN VOLVER
        ========================================= */

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


        /* =========================================
           ENCABEZADO
        ========================================= */

        .page-header {

            background: #ffffff;

            border-radius: 18px;

            padding: 25px 30px;

            margin-bottom: 20px;

            box-shadow:
                0 8px 25px rgba(0,0,0,0.07);

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


        /* =========================================
           TARJETAS
        ========================================= */

        .card {

            background: #ffffff;

            border-radius: 18px;

            padding: 30px;

            margin-bottom: 20px;

            box-shadow:
                0 8px 25px rgba(0,0,0,0.07);

            border: 1px solid #e8edf5;

        }


        .card-title {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 18px;

            font-weight: 700;

            margin-bottom: 22px;

            color: #1f2937;

        }


        .card-title i {

            color: #2563eb;

        }


        /* =========================================
           FORMULARIO
        ========================================= */

        .form-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 16px;

        }


        .form-group {

            display: flex;

            flex-direction: column;

            gap: 7px;

        }


        .form-group label {

            font-size: 13px;

            font-weight: 600;

            color: #4b5563;

        }


        .form-group input {

            width: 100%;

            padding: 12px 14px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            background: #ffffff;

            color: #1f2937;

            font-family: inherit;

            font-size: 14px;

            outline: none;

            transition: all .2s ease;

        }


        .form-group input:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37,99,235,.10);

        }


        .form-group input::placeholder {

            color: #9ca3af;

        }


        /* =========================================
           BOTÓN CREAR
        ========================================= */

        .form-actions {

            grid-column: 1 / -1;

            display: flex;

            justify-content: flex-end;

            margin-top: 4px;

        }


        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 11px 20px;

            border-radius: 10px;

            border: none;

            font-family: inherit;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: all .2s ease;

        }


        .btn-primary {

            background: #2563eb;

            color: #ffffff;

        }


        .btn-primary:hover {

            background: #1d4ed8;

            transform: translateY(-1px);

        }


        /* =========================================
           ENCABEZADO TABLA
        ========================================= */

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


        /* =========================================
           TABLA
        ========================================= */

        .table-container {

            width: 100%;

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: separate;

            border-spacing: 0;

            min-width: 700px;

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


        /* =========================================
           CÓDIGO ANÓNIMO
        ========================================= */

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


        /* =========================================
           ESTADO
        ========================================= */

        .status {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 6px 10px;

            border-radius: 20px;

            background: #ecfdf5;

            color: #15803d;

            font-size: 12px;

            font-weight: 700;

        }


        .status-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: #22c55e;

        }


        /* =========================================
           MENSAJE VACÍO
        ========================================= */

        .empty {

            text-align: center;

            padding: 35px 20px;

            color: #6b7280;

        }


        .empty i {

            font-size: 35px;

            color: #cbd5e1;

            margin-bottom: 12px;

        }


        .empty p {

            font-size: 14px;

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

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


            .form-grid {

                grid-template-columns: 1fr;

            }


            .form-actions {

                grid-column: auto;

            }


            .btn-primary {

                width: 100%;

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


    <!-- =========================================
         VOLVER AL PANEL
    ========================================== -->

    <a
        href="/admin-panel"
        class="back-button"
    >

        <i class="fas fa-arrow-left"></i>

        Volver al panel

    </a>


    <!-- =========================================
         ENCABEZADO
    ========================================== -->

    <div class="page-header">

        <div class="title">

            <i class="fas fa-user-shield"></i>

            Gestión de Moderadores

        </div>


        <div class="subtitle">

            Administra los moderadores que tienen acceso
            a la plataforma UMG.

        </div>

    </div>


    <!-- =========================================
         AGREGAR MODERADOR
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-user-plus"></i>

            Agregar Moderador

        </div>


        <form
            action="/moderator/create"
            method="POST"
        >

            @csrf


            <div class="form-grid">


                <div class="form-group">

                    <label for="first_name">
                        Nombre
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        placeholder="Ingrese el nombre"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="last_name">
                        Apellido
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        placeholder="Ingrese el apellido"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="email">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="correo@ejemplo.com"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="phone">
                        Celular
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="Número de celular"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Contraseña"
                        required
                    >

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-user-plus"></i>

                        Crear moderador

                    </button>

                </div>


            </div>

        </form>

    </div>


    <!-- =========================================
         LISTADO DE MODERADORES
    ========================================== -->

    <div class="card">


        <div class="table-header">

            <div class="table-title">

                <i class="fas fa-users"></i>

                Moderadores registrados

            </div>


            <span class="count">

                {{ $moderators->count() }}

                {{ $moderators->count() == 1
                    ? 'moderador'
                    : 'moderadores'
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

                    </tr>

                </thead>


                <tbody>


                    @forelse($moderators as $moderator)


                        <tr>


                            <td>

                                <span class="anonymous-code">

                                    <i class="fas fa-fingerprint"></i>

                                    {{ $moderator->anonymous_nickname }}

                                </span>

                            </td>


                            <td>

                                {{ $moderator->first_name }}

                            </td>


                            <td>

                                {{ $moderator->last_name }}

                            </td>


                            <td>

                                {{ $moderator->email }}

                            </td>


                            <td>

                                {{ $moderator->phone }}

                            </td>


                            <td>

                                <span class="status">

                                    <span class="status-dot"></span>

                                    Activo

                                </span>

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                class="empty"
                            >

                                <i class="fas fa-user-slash"></i>

                                <p>
                                    No hay moderadores registrados.
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