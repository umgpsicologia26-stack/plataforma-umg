<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detalle del Caso | VitaSafe</title>

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

            max-width: 900px;

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


        .title-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

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


        .case-number {

            margin-top: 8px;

            color: #6b7280;

            font-size: 14px;

        }


        .case-number strong {

            color: #2563eb;

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
           INFORMACIÓN
        ========================================= */

        .info-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 16px;

        }


        .info-item {

            background: #f8fafc;

            border: 1px solid #e5e7eb;

            border-radius: 12px;

            padding: 15px;

        }


        .info-label {

            display: block;

            font-size: 12px;

            color: #6b7280;

            margin-bottom: 6px;

            text-transform: uppercase;

            letter-spacing: .4px;

        }


        .info-value {

            font-size: 15px;

            font-weight: 600;

            color: #1f2937;

        }


        /* =========================================
           ESTADO
        ========================================= */

        .status-badge {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: 700;

            background: #eff6ff;

            color: #2563eb;

        }


        /* =========================================
           DESCRIPCIÓN
        ========================================= */

        .description {

            padding: 18px;

            background: #f8fafc;

            border: 1px solid #e5e7eb;

            border-radius: 12px;

            line-height: 1.7;

            color: #374151;

            white-space: pre-line;

        }


        /* =========================================
           LÍNEA DE TIEMPO
        ========================================= */

        .timeline {

            position: relative;

            padding-left: 28px;

        }


        .timeline::before {

            content: "";

            position: absolute;

            left: 7px;

            top: 5px;

            bottom: 5px;

            width: 2px;

            background: #dbeafe;

        }


        .timeline-item {

            position: relative;

            padding-bottom: 22px;

            color: #374151;

            line-height: 1.6;

        }


        .timeline-item:last-child {

            padding-bottom: 0;

        }


        .timeline-item i {

            position: absolute;

            left: -28px;

            top: 2px;

            width: 16px;

            height: 16px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 8px;

            background: #2563eb;

            color: white;

        }


        .timeline-item strong {

            color: #1f2937;

        }


        .timeline-date {

            font-size: 13px;

            color: #6b7280;

        }


        /* =========================================
           FORMULARIOS
        ========================================= */

        textarea {

            width: 100%;

            min-height: 120px;

            resize: vertical;

            padding: 13px 15px;

            border-radius: 10px;

            border: 1px solid #d1d5db;

            font-family: inherit;

            font-size: 14px;

            outline: none;

            margin-bottom: 12px;

        }


        textarea:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37,99,235,.1);

        }


        select {

            width: 100%;

            padding: 12px 14px;

            border-radius: 10px;

            border: 1px solid #d1d5db;

            background: #ffffff;

            font-family: inherit;

            font-size: 14px;

            margin-bottom: 15px;

            outline: none;

        }


        select:focus {

            border-color: #2563eb;

        }


        /* =========================================
           BOTONES
        ========================================= */

        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 11px 18px;

            border-radius: 10px;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            border: none;

            cursor: pointer;

            transition: all .2s ease;

        }


        .btn-save {

            background: #2563eb;

            color: white;

        }


        .btn-save:hover {

            background: #1d4ed8;

            transform: translateY(-1px);

        }


        .btn-finish {

            background: #f59e0b;

            color: white;

        }


        .btn-finish:hover {

            background: #d97706;

            transform: translateY(-1px);

        }


        .btn-approve {

            background: #16a34a;

            color: white;

        }


        .btn-approve:hover {

            background: #15803d;

            transform: translateY(-1px);

        }


        /* =========================================
           COLORES DE CORRECCIÓN
        ========================================= */

        .colors {

            display: flex;

            gap: 12px;

            margin-bottom: 20px;

        }


        .color {

            width: 38px;

            height: 38px;

            border-radius: 50%;

            border: 3px solid white;

            box-shadow:
                0 2px 8px rgba(0,0,0,.15);

            cursor: pointer;

        }


        .color.red {

            background: #ef4444;

        }


        .color.yellow {

            background: #facc15;

        }


        .color.green {

            background: #22c55e;

        }


        .color.blue {

            background: #3b82f6;

        }


        /* =========================================
           COMENTARIOS
        ========================================= */

        .comment-card {

            background: #f8fafc;

            border: 1px solid #e5e7eb;

            border-radius: 12px;

            padding: 17px;

            margin-bottom: 12px;

        }


        .comment-top {

            display: flex;

            align-items: center;

            gap: 9px;

            margin-bottom: 8px;

        }


        .badge {

            width: 10px;

            height: 10px;

            border-radius: 50%;

            display: inline-block;

        }


        .badge.red {

            background: #ef4444;

        }


        .badge.yellow {

            background: #facc15;

        }


        .badge.green {

            background: #22c55e;

        }


        .badge.blue {

            background: #3b82f6;

        }


        .comment-card strong {

            font-size: 14px;

        }


        .comment-card p {

            color: #374151;

            line-height: 1.6;

            margin-bottom: 7px;

        }


        .comment-card small {

            color: #6b7280;

        }


        /* =========================================
           NOTIFICACIONES
        ========================================= */

        .notification {

            background: #eff6ff;

            border: 1px solid #dbeafe;

            border-radius: 10px;

            padding: 13px 15px;

            margin-bottom: 10px;

            color: #1e40af;

            font-size: 14px;

        }


        /* =========================================
           APROBADO
        ========================================= */

        .approved-stamp {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-top: 15px;

            padding: 9px 15px;

            border-radius: 10px;

            background: #ecfdf5;

            color: #15803d;

            border: 1px solid #bbf7d0;

            font-size: 13px;

            font-weight: 700;

        }


        /* =========================================
           MODAL
        ========================================= */

        .modal {

            display: none;

            position: fixed;

            z-index: 1000;

            inset: 0;

            background:
                rgba(15,23,42,.45);

        }


        .modal-content {

            background: white;

            max-width: 500px;

            margin: 12% auto;

            padding: 30px;

            border-radius: 18px;

            box-shadow:
                0 20px 50px rgba(0,0,0,.2);

        }


        .close {

            float: right;

            font-size: 25px;

            cursor: pointer;

            color: #6b7280;

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 650px) {

            .container {

                padding:
                    20px 14px 40px;

            }


            .page-header,
            .card {

                padding: 22px 18px;

            }


            .info-grid {

                grid-template-columns: 1fr;

            }


            .title {

                font-size: 21px;

            }


            .title-row {

                flex-direction: column;

                align-items: flex-start;

            }


            .btn {

                width: 100%;

            }


            .colors {

                flex-wrap: wrap;

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
        href="{{ url('/admin-panel') }}"
        class="back-button"
    >

        <i class="fas fa-arrow-left"></i>

        Volver al panel

    </a>


    <!-- =========================================
         ENCABEZADO
    ========================================== -->

    <div class="page-header">

        <div class="title-row">

            <div>

                <div class="title">

                    <i class="fas fa-folder-open"></i>

                    Detalle del caso

                </div>


                <div class="case-number">

                    Número de caso:

                    <strong>
                        {{ $case->case_number }}
                    </strong>

                </div>

            </div>


            <div>

                @if($case->status === 'ABIERTO')

                    <span class="status-badge">
                        <i class="fas fa-folder-open"></i>
                        Abierto
                    </span>

                @elseif($case->status === 'EN_PROCESO')

                    <span class="status-badge">
                        <i class="fas fa-spinner"></i>
                        En proceso
                    </span>

                @elseif($case->status === 'TERMINADO')

                    <span class="status-badge">
                        <i class="fas fa-check"></i>
                        Terminado
                    </span>

                @elseif($case->status === 'PENDIENTE_APROBACION')

                    <span class="status-badge">
                        <i class="fas fa-clock"></i>
                        Pendiente de aprobación
                    </span>

                @elseif($case->status === 'CERRADO')

                    <span class="status-badge">
                        <i class="fas fa-lock"></i>
                        Cerrado
                    </span>

                @else

                    <span class="status-badge">
                        {{ $case->status }}
                    </span>

                @endif

            </div>

        </div>

    </div>


    <!-- =========================================
         INFORMACIÓN DEL CASO
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-circle-info"></i>

            Información del caso

        </div>


        <div class="info-grid">


            <div class="info-item">

                <span class="info-label">
                    Número
                </span>

                <span class="info-value">

                    {{ $case->case_number }}

                </span>

            </div>


            <div class="info-item">

                <span class="info-label">
                    Tema
                </span>

                <span class="info-value">

                    @if($case->type === 'SUICIDIO')

                        Suicidio

                    @elseif($case->type === 'ABUSO_SEXUAL')

                        Abuso sexual

                    @else

                        {{ $case->type }}

                    @endif

                </span>

            </div>


            <div class="info-item">

                <span class="info-label">
                    Prioridad
                </span>

                <span class="info-value">

                    {{ $case->priority ?? 'No especificada' }}

                </span>

            </div>


            <div class="info-item">

                <span class="info-label">
                    Moderador
                </span>

                <span class="info-value">

                    {{ $case->moderator
                        ? $case->moderator->first_name . ' ' .
                          $case->moderator->last_name
                        : 'No asignado'
                    }}

                </span>

            </div>


            <div class="info-item">

                <span class="info-label">
                    Fecha de creación
                </span>

                <span class="info-value">

                    {{ $case->created_at->format('d/m/Y H:i') }}

                </span>

            </div>


            <div class="info-item">

                <span class="info-label">
                    Última actualización
                </span>

                <span class="info-value">

                    {{ $case->updated_at->format('d/m/Y H:i') }}

                </span>

            </div>


        </div>

    </div>


    <!-- =========================================
         DESCRIPCIÓN
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-align-left"></i>

            Descripción del caso

        </div>


        <div class="description">

            {{ $case->description }}

        </div>

    </div>


    <!-- =========================================
         LÍNEA DE TIEMPO
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-clock"></i>

            Línea de tiempo

        </div>


        <div class="timeline">


            <div class="timeline-item">

                <i class="fas fa-file-circle-plus"></i>

                <strong>
                    Caso creado
                </strong>

                <br>

                <span class="timeline-date">

                    {{ $case->created_at->format('d/m/Y H:i') }}

                </span>

            </div>


            <div class="timeline-item">

                <i class="fas fa-pen"></i>

                <strong>
                    Última actualización
                </strong>

                <br>

                <span class="timeline-date">

                    {{ $case->updated_at->format('d/m/Y H:i') }}

                </span>

            </div>


        </div>

    </div>


    <!-- =========================================
         OBSERVACIONES
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-comment-medical"></i>

            Observaciones del administrador

        </div>


        <form
            action="/admin/case/comment/{{ $case->id }}"
            method="POST"
        >

            @csrf


            <textarea
                name="comment"
                placeholder="Escribir observación..."
                required
            ></textarea>


            <select name="color">

                <option value="red">
                    Error crítico
                </option>

                <option value="yellow">
                    Revisar
                </option>

                <option value="green">
                    Correcto
                </option>

                <option value="blue">
                    Observación
                </option>

            </select>


            <button
                class="btn btn-save"
                type="submit"
            >

                <i class="fas fa-save"></i>

                Guardar observación

            </button>

        </form>

    </div>


    <!-- =========================================
         CORRECCIÓN
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-clipboard-check"></i>

            Corrección del moderador

        </div>


        <div class="colors">

            <button
                type="button"
                class="color red"
                title="Error"
            ></button>

            <button
                type="button"
                class="color yellow"
                title="Revisar"
            ></button>

            <button
                type="button"
                class="color green"
                title="Correcto"
            ></button>

            <button
                type="button"
                class="color blue"
                title="Información"
            ></button>

        </div>


        <a
            href="/admin/case/{{ $case->id }}/finish"
            class="btn btn-finish"
        >

            <i class="fas fa-check"></i>

            Marcar como terminado

        </a>

    </div>


    <!-- =========================================
         HISTORIAL
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-history"></i>

            Historial de correcciones

        </div>


        @forelse($comments as $comment)

            <div class="comment-card">


                <div class="comment-top">

                    <span
                        class="badge {{ $comment->color }}"
                    ></span>


                    <strong>

                        {{ $comment->user->first_name
                            ?? 'Administrador'
                        }}

                    </strong>

                </div>


                <p>

                    {{ $comment->comment }}

                </p>


                <small>

                    {{ $comment->created_at->format(
                        'd/m/Y H:i'
                    ) }}

                </small>


            </div>

        @empty

            <p style="color:#6b7280;">

                No hay correcciones registradas.

            </p>

        @endforelse

    </div>


    <!-- =========================================
         NOTIFICACIONES
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-bell"></i>

            Notificaciones

        </div>


        @forelse($notifications as $notification)

            <div class="notification">

                <i class="fas fa-circle-info"></i>

                {{ $notification->message }}

            </div>

        @empty

            <p style="color:#6b7280;">

                No hay notificaciones.

            </p>

        @endforelse

    </div>


    <!-- =========================================
         APROBACIÓN
    ========================================== -->

    <div class="card">

        <div class="card-title">

            <i class="fas fa-shield-check"></i>

            Confirmación administrativa

        </div>


        @if(!$case->admin_approved)

            <a
                href="/admin/case/{{ $case->id }}/approve"
                class="btn btn-approve"
            >

                <i class="fas fa-check"></i>

                Confirmar caso

            </a>

        @else

            <div class="approved-stamp">

                <i class="fas fa-circle-check"></i>

                CASO APROBADO

            </div>

        @endif

    </div>


</div>


<!-- =========================================
     MODAL
========================================== -->

<div
    id="reviewModal"
    class="modal"
>

    <div class="modal-content">

        <span
            class="close"
            onclick="closeModal()"
        >

            &times;

        </span>


        <h2>

            Revisión del caso

        </h2>


        <br>


        <p>

            Revise cuidadosamente la información
            antes de aprobar el caso.

        </p>

    </div>

</div>


<script>

function openModal()
{
    document
        .getElementById('reviewModal')
        .style.display = 'block';
}


function closeModal()
{
    document
        .getElementById('reviewModal')
        .style.display = 'none';
}

</script>


</body>

</html>