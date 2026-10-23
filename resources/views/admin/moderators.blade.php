<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

<title>Moderadores</title>

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

        /* 100vh como respaldo; 100dvh evita el salto de la barra del navegador en móviles */
        min-height: 100vh;
        min-height: 100dvh;

        color: #1f2937;
    }

    /* CONTENEDOR */

    .container {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 35px 20px 50px;
    }

    /* BOTÓN VOLVER */

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

    /* ENCABEZADO */

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

    /* TARJETAS */

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

    /* ALERTAS (mensajes de validación, éxito y error)
       Reutilizan los colores de .btn-danger y .btn-success */

    .alert {
        padding: 12px 16px;

        border-radius: 10px;

        border: 1px solid transparent;

        font-size: 14px;

        line-height: 1.5;

        margin-bottom: 18px;

        overflow-wrap: break-word;
    }

    .alert ul {
        margin: 6px 0 0 18px;
    }

    .alert-danger {
        background: #fee2e2;

        color: #b91c1c;

        border-color: #fecaca;
    }

    .alert-success {
        background: #dcfce7;

        color: #15803d;

        border-color: #bbf7d0;
    }

    /* FORMULARIO */

    .form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

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
            0 0 0 3px
            rgba(37,99,235,.25);
    }

    .form-group input::placeholder {
        color: #9ca3af;
    }

    /* BOTONES */

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

        padding: 9px 14px;

        border-radius: 9px;

        border: none;

        font-family: inherit;

        font-size: 13px;

        font-weight: 600;

        cursor: pointer;

        text-decoration: none;

        transition: all .2s ease;
    }

    .btn-primary {
        background: #2563eb;

        color: #ffffff;
    }

    /* BOTÓN ELIMINAR */

    .btn-danger {
        background: #fee2e2;

        color: #b91c1c;

        border: 1px solid #fecaca;
    }

    /* BOTÓN RESTAURAR */

    .btn-success {
        background: #dcfce7;

        color: #15803d;

        border: 1px solid #bbf7d0;
    }

    /* ENCABEZADO TABLA */

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

    /* TABLA */

    .table-container {
        width: 100%;

        overflow-x: auto;
    }

    table {
        width: 100%;

        border-collapse: separate;

        border-spacing: 0;

        /* Respaldo: scroll interno solo si el contenido no cabe (ver vista de tarjetas ≤900px) */
        min-width: 760px;
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

        border-radius:
            10px 0 0 10px;
    }

    th:last-child {
        border-right: 1px solid #e5e7eb;

        border-radius:
            0 10px 10px 0;
    }

    td {
        padding: 15px 16px;

        border-bottom:
            1px solid #edf0f4;

        color: #374151;

        font-size: 14px;

        background: #ffffff;
    }

    tbody tr {
        transition:
            background .2s ease;
    }

    /* CÓDIGO ANÓNIMO */

    .anonymous-code {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 6px 10px;

        background: #eff6ff;

        color: #2563eb;

        border:
            1px solid #dbeafe;

        border-radius: 8px;

        font-size: 12px;

        font-weight: 700;

        letter-spacing: .4px;
    }

    /* ESTADO ACTIVO */

    .status {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 6px 10px;

        border-radius: 20px;

        font-size: 12px;

        font-weight: 700;
    }

    .status-active {
        background: #ecfdf5;

        color: #15803d;
    }

    .status-deleted {
        background: #fef2f2;

        color: #b91c1c;
    }

    .status-dot {
        width: 7px;

        height: 7px;

        border-radius: 50%;
    }

    .status-dot-active {
        background: #22c55e;
    }

    .status-dot-deleted {
        background: #ef4444;
    }

    /* ACCIONES */

    .actions {
        display: flex;

        align-items: center;

        gap: 8px;

        flex-wrap: wrap;
    }

    .actions form {
        margin: 0;
    }

    /* MENSAJE VACÍO */

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

    /* HOVER (solo dispositivos con puntero)
       Evita el "hover pegado" en pantallas táctiles */

    @media (hover: hover) {

        .back-button:hover {
            background: #f3f4f6;
            transform: translateX(-2px);
        }

        .btn-primary:hover {
            background: #1d4ed8;

            transform: translateY(-1px);
        }

        .btn-danger:hover {
            background: #fecaca;

            color: #991b1b;
        }

        .btn-success:hover {
            background: #bbf7d0;

            color: #166534;
        }

        tbody tr:hover td {
            background: #f8fafc;
        }

    }

    /* FOCO DE TECLADO */

    .back-button:focus-visible,
    .btn:focus-visible {
        outline: 3px solid rgba(37,99,235,.45);

        outline-offset: 2px;
    }

    /* PANTALLAS TÁCTILES: área mínima de 44px */

    @media (pointer: coarse) {

        .back-button,
        .btn {
            min-height: 44px;
        }

    }

    /* RESPONSIVE: TABLA EN FORMATO TARJETA (tablet vertical y móviles)
       Cada fila pasa a ser una tarjeta con etiqueta + valor.
       Las etiquetas siguen el orden actual de las 7 columnas;
       si se agregan o reordenan columnas, hay que actualizarlas aquí. */

    @media (max-width: 900px) {

        table {
            min-width: 0;
        }

        table,
        tbody {
            display: block;
        }

        /* Cabecera oculta visualmente, se mantiene en el DOM */
        thead {
            position: absolute;

            width: 1px;

            height: 1px;

            overflow: hidden;

            clip: rect(0, 0, 0, 0);

            white-space: nowrap;
        }

        tbody tr {
            display: block;

            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 6px 16px;

            margin-bottom: 12px;
        }

        tbody tr:last-child {
            margin-bottom: 0;
        }

        .table-container td {
            display: grid;

            grid-template-columns:
                minmax(90px, 34%)
                minmax(0, 1fr);

            align-items: center;

            gap: 10px;

            padding: 11px 0;

            background: transparent;

            /* Correos y nombres largos se parten dentro de la tarjeta */
            overflow-wrap: anywhere;
        }

        .table-container td:last-child {
            border-bottom: none;
        }

        .table-container td::before {
            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .4px;

            color: #6b7280;
        }

        .table-container td:nth-child(1)::before { content: "Código único"; }
        .table-container td:nth-child(2)::before { content: "Nombre"; }
        .table-container td:nth-child(3)::before { content: "Apellido"; }
        .table-container td:nth-child(4)::before { content: "Email"; }
        .table-container td:nth-child(5)::before { content: "Celular"; }
        .table-container td:nth-child(6)::before { content: "Estado"; }
        .table-container td:nth-child(7)::before { content: "Acciones"; }

        /* Los badges no se estiran al ancho de la celda */
        .anonymous-code,
        .status {
            justify-self: start;
        }

        /* Mensaje de "sin moderadores": una sola celda sin etiqueta */
        .table-container td.empty {
            display: block;

            border-bottom: none;
        }

        .table-container td.empty::before {
            content: none;
        }

    }

    /* RESPONSIVE */

    @media (max-width: 700px) {

        .container {
            padding:
                20px 14px 40px;
        }

        .page-header,
        .card {
            padding:
                22px 18px;
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

        /* 16px evita el zoom automático de iOS al enfocar un campo */
        .form-group input {
            font-size: 16px;
        }

        .btn-primary {
            width: 100%;
        }

        .table-header {
            align-items: flex-start;

            flex-direction: column;
        }

    }

    /* MOVIMIENTO REDUCIDO */

    @media (prefers-reduced-motion: reduce) {

        .back-button,
        .btn,
        .form-group input,
        tbody tr {
            transition: none;
        }

        .back-button:hover,
        .btn-primary:hover {
            transform: none;
        }

    }

</style>


</head>

<body>

<div class="container">

<!-- VOLVER AL PANEL -->

<a
    href="/admin-panel"
    class="back-button">

    <i class="fas fa-arrow-left"></i>

    Volver al panel

</a>


<!-- ENCABEZADO -->

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


<!-- AGREGAR MODERADOR -->

<div class="card">

    <div class="card-title">

        <i class="fas fa-user-plus"></i>

        Agregar Moderador

    </div>

    
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>No se pudo completar la operación:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif


    <form
        action="/moderator/create"
        method="POST">

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
                    autocomplete="given-name"
                    required>

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
                    autocomplete="family-name"
                    required>

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
                    autocomplete="email"
                    required>

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
                    autocomplete="tel"
                    required>

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
                    autocomplete="new-password"
                    required>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fas fa-user-plus"></i>

                    Crear moderador

                </button>

            </div>

        </div>

    </form>

</div>


<!-- LISTADO DE MODERADORES -->

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

                    <th>
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($moderators as $moderator)

                    <tr>

                        <!-- CÓDIGO -->

                        <td>

                            <span class="anonymous-code">

                                <i class="fas fa-fingerprint"></i>

                                {{ $moderator->anonymous_nickname }}

                            </span>

                        </td>


                        <!-- NOMBRE -->

                        <td>
                            {{ $moderator->first_name }}
                        </td>


                        <!-- APELLIDO -->

                        <td>
                            {{ $moderator->last_name }}
                        </td>


                        <!-- EMAIL -->

                        <td>
                            {{ $moderator->email }}
                        </td>


                        <!-- CELULAR -->

                        <td>
                            {{ $moderator->phone }}
                        </td>


                        <!-- ESTADO -->

                        <td>

                            @if($moderator->trashed())

                                <span
                                    class="status status-deleted">

                                    <span
                                        class="status-dot status-dot-deleted">
                                    </span>

                                    Eliminado

                                </span>

                            @else

                                <span
                                    class="status status-active">

                                    <span
                                        class="status-dot status-dot-active">
                                    </span>

                                    Activo

                                </span>

                            @endif

                        </td>


                        <!-- ACCIONES -->

                        <td>

                            <div class="actions">

                                @if($moderator->trashed())

                                    <!-- RESTAURAR -->

                                    <form
                                        method="POST"
                                        action="/moderator/restore/{{ $moderator->uuid }}">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-success">

                                            <i class="fas fa-rotate-left"></i>

                                            Restaurar

                                        </button>

                                    </form>

                                @else

                                    <!-- ELIMINAR -->

                                    <form
                                        method="POST"
                                        action="/moderator/{{ $moderator->uuid }}"
                                        onsubmit="return confirm('¿Está seguro de eliminar este moderador?');">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger">

                                            <i class="fas fa-trash"></i>

                                            Eliminar

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="empty">

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
