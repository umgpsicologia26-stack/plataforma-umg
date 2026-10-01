<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Reportes | UMG</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            margin: auto;
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

    /*FILTRO*/
        .filter-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 25px 30px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            border: 1px solid #e8edf5;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 18px;
            color: #1f2937;
        }

        .section-title i {
            color: #2563eb;
        }

        .filter-form {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            flex-wrap: wrap;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
        }

        .date-input {
            background: #f8fafc;
            color: #374151;
            border: 1px solid #e5e7eb;
            padding: 11px 13px;
            border-radius: 10px;
            outline: none;
        }

        .date-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.10);
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all .2s ease;
        }

        .filter-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

    /*ESTADÍSTICAS */
        .dashboard {
            display: grid;
            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(210px, 1fr)
                );
            gap: 18px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 23px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            transition: all .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,.09);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
        }

        .stat-title {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
        }

        .number {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
        }

    /*GRÁFICA*/
        .chart-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 20px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        }

        .chart-wrapper {
            position: relative;
            height: 350px;
        }

    /*EXPORTACIONES*/
        .export-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 25px 30px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        }

        .export-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .pdf-btn {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .pdf-btn:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-1px);
        }

        .excel-btn {
            background: #ecfdf5;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .excel-btn:hover {
            background: #16a34a;
            color: white;
            transform: translateY(-1px);
        }

    /*RESPONSIVE*/
        @media (max-width: 650px) {
            .container {
                padding: 20px 14px 40px;
            }

            .page-header,
            .filter-card,
            .chart-card,
            .export-card {
                padding: 22px 18px;
            }

            .title {
                font-size: 21px;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .date-input,
            .filter-btn {
                width: 100%;
            }

            .chart-wrapper {
                height: 280px;
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

    <!--ENCABEZADO -->
    <div class="page-header">
        <div class="title">
            <i class="fas fa-chart-line"></i>
            Reportes Administrativos
        </div>

        <div class="subtitle">
            Consulta las estadísticas y genera reportes
            de los casos registrados en UMG.
        </div>
    </div>

       <!--FILTRO-->
    <div class="filter-card">
        <div class="section-title">
            <i class="fas fa-filter"></i>
            Filtrar por fecha
        </div>

        <form
            class="filter-form"
            method="GET">
            <div class="field">
                <label for="start_date">
                    Fecha inicial
                </label>

                <input
                    type="date"
                    id="start_date"
                    name="from"
                    class="date-input"
                    value="{{ request('from') }}">
            </div>

            <div class="field">
                <label for="end_date">
                    Fecha final
                </label>

                <input
                    type="date"
                    id="end_date"
                    name="to"
                    class="date-input"
                    value="{{ request('to') }}">
            </div>

            <button
                type="submit"
                class="filter-btn">
                <i class="fas fa-filter"></i>
                Filtrar
            </button>
        </form>
    </div>

    <!--ESTADÍSTICAS-->
    <div class="dashboard">

        <!-- ABIERTOS -->
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-title">
                    Casos abiertos
                </span>
                <div class="stat-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
            <div class="number">
                {{ $openCases }}
            </div>
        </div>

        <!-- CERRADOS -->
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-title">
                    Casos cerrados
                </span>
                <div class="stat-icon">
                    <i class="fas fa-folder-closed"></i>
                </div>
            </div>
            <div class="number">
                {{ $closedCases }}
            </div>
        </div>

            <!-- USUARIOS -->
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-title">
                    Usuarios registrados
                </span>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="number">
                {{ $usersCount }}
            </div>
        </div>

        <!-- MODERADORES -->
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-title">
                    Moderadores activos
                </span>
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
            <div class="number">
                {{ $moderatorsCount }}
            </div>
        </div>
    </div>

    <!--GRÁFICA-->
    <div class="chart-card">
        <div class="section-title">
            <i class="fas fa-chart-column"></i>
            Casos registrados por mes
        </div>
        <div class="chart-wrapper">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <!--EXPORTACIONES-->
    <div class="export-card">
        <div class="section-title">
            <i class="fas fa-file-export"></i>
            Exportar reporte
        </div>
        <div class="export-buttons">
            <a
                href="/admin/reports/pdf?from={{ request('from') }}&to={{ request('to') }}"
                class="export-btn pdf-btn">
                <i class="fas fa-file-pdf"></i>
                Exportar PDF
            </a>

            <a
                href="/admin/reports/excel?from={{ request('from') }}&to={{ request('to') }}"
                class="export-btn excel-btn">
                <i class="fas fa-file-excel"></i>
                Exportar Excel
            </a>
        </div>
    </div>
</div>

<script>
const lineChart =
new Chart(
    document.getElementById('lineChart'),
    {
        type: 'line',
        data: {
            labels: [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Ago',
                'Sep',
                'Oct',
                'Nov',
                'Dic'
            ],

            datasets: [
                {
                    label: 'Casos',
                    data:
                        @json($monthlyCases),
                    fill: false,
                    borderWidth: 3,
                    tension: 0.35,
                    pointRadius: 4
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    }
);

</script>
</body>
</html>