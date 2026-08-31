<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Editar Caso | UMG</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            max-width: 900px;
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
            margin-bottom: 25px;
            box-shadow:
                0 3px 10px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background: #f3f4f6;
            transform: translateX(-2px);
        }


    /*ENCABEZADO*/
        .page-header {
            background: white;
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

        .case-number {
            margin-top: 8px;
            color: #6b7280;
            font-size: 14px;
        }

        .case-number strong {
            color: #2563eb;
        }

    /*TARJETA*/
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
            margin-bottom: 25px;
            color: #1f2937;
        }

        .card-title i {
            color: #2563eb;
        }


    /*INFORMACIÓN*/
        .info-grid {
            display: grid;
            grid-template-columns:
                repeat(2, 1fr);
            gap: 18px;
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
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }


    /*DESCRIPCIÓN*/
        .description {
            margin-top: 20px;
            padding: 18px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }


        .description-title {
            font-size: 13px;
            font-weight: 700;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .description p {
            line-height: 1.6;
            color: #374151;
            white-space: pre-line;
        }


    /*ESTADO*/
        .status-section {
            margin-top: 5px;
        }

        .status-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 9px;
            color: #374151;
        }

        select {
            width: 100%;
            padding: 13px 15px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            background: white;
            font-size: 15px;
            color: #1f2937;
            outline: none;
            cursor: pointer;
            transition: border-color .2s;
        }


        select:focus {
            border-color: #2563eb;
            box-shadow:
                0 0 0 3px rgba(37,99,235,.1);
        }

    /*BOTÓN GUARDAR*/
        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .save-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: none;
            background: #2563eb;
            color: white;
            padding: 13px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

        .save-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

    /*MENSAJES*/
        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

    /*RESPONSIVE*/
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

            .actions {
                justify-content: stretch;
            }

            .save-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <!--VOLVER-->
    <a
        href="{{ url('/admin-panel') }}"
        class="back-button">
        <i class="fas fa-arrow-left"></i>
        Volver al panel
    </a>

    <!--MENSAJES-->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!--ENCABEZADO-->

    <div class="page-header">
        <div class="title">
            <i class="fas fa-edit"></i>
            Editar caso
        </div>

        <div class="case-number">
            Número de caso:
            <strong>
                {{ $case->case_number }}
            </strong>
        </div>
    </div>

    <!--INFORMACIÓN DEL CASO -->
    <div class="card">
        <div class="card-title">
            <i class="fas fa-folder-open"></i>
            Información del caso
        </div>


        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">
                    Número de caso
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
                    {{ $case->type }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    Usuario
                </span>
                <span class="info-value">
                    {{ $case->user
                        ? $case->user->full_name
                        : 'No disponible'
                    }}
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
                    {{ $case->created_at
                        ? $case->created_at->format('d/m/Y H:i')
                        : 'No disponible'
                    }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    Aprobación administrativa
                </span>
                <span class="info-value">
                    {{ $case->admin_approved
                        ? 'Aprobado'
                        : 'Pendiente'
                    }}
                </span>
            </div>
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="description">
            <div class="description-title">
                Descripción del caso
            </div>
            <p>
                {{ $case->description }}
            </p>
        </div>
    </div>

    <!--ACTUALIZAR ESTADO-->
    <div class="card">
        <div class="card-title">
            <i class="fas fa-sliders-h"></i>
            Actualizar estado
        </div>

        <form
            action="/case/{{ $case->id }}"
            method="POST">

            @csrf
            @method('PUT')
            <div class="status-section">

                <label
                    for="status"
                    class="status-label">
                    Estado del caso
                </label>

                <select
                    name="status"
                    id="status"
                    required>

                    <option
                        value="ABIERTO"
                        {{ $case->status == 'ABIERTO'
                            ? 'selected'
                            : '' }}>
                        Abierto

                    </option>


                    <option
                        value="EN_PROCESO"
                        {{ $case->status == 'EN_PROCESO'
                            ? 'selected'
                            : '' }}>

                        En Proceso
                    </option>

                    <option
                        value="TERMINADO"
                        {{ $case->status == 'TERMINADO'
                            ? 'selected'
                            : '' }}>
                        Terminado
                    </option>

                    <option
                        value="PENDIENTE_APROBACION"
                        {{ $case->status == 'PENDIENTE_APROBACION'
                            ? 'selected'
                            : '' }}>
                        Pendiente de aprobación
                    </option>

                    <option
                        value="CERRADO"
                        {{ $case->status == 'CERRADO'
                            ? 'selected'
                            : '' }}>
                        Cerrado
                    </option>
                </select>
            </div>

            <div class="actions">
                <button
                    type="submit"
                    class="save-button">
                    <i class="fas fa-save"></i>
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>