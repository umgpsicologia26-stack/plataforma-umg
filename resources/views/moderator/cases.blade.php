<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
    {{ isset($case) ? 'Detalle del caso' : 'Mis casos' }} | Panel del Moderador
</title>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

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
        font-family: 'Poppins', sans-serif;
        background: #f4f7fb;
        color: #1e293b;
        min-height: 100vh;
    }

    /* NAVBAR */

    .navbar {
        width: 95%;
        max-width: 1400px;
        margin: 20px auto;
        padding: 18px 30px;
        background: white;
        border-radius: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-icon {
        width: 48px;
        height: 48px;
        border-radius: 15px;
        background: #2563eb;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .brand h2 {
        font-size: 19px;
        color: #1e3a8a;
    }

    .brand span {
        display: block;
        font-size: 12px;
        color: #64748b;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-btn {
        text-decoration: none;
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: .2s;
    }

    .nav-btn-dashboard {
        background: #eff6ff;
        color: #2563eb;
    }

    .nav-btn-dashboard:hover {
        background: #dbeafe;
    }

    /* CONTENEDOR */

    .container {
        width: 95%;
        max-width: 1200px;
        margin: 40px auto 60px;
    }

    /* VOLVER */

    .back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #2563eb;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 22px;
    }

    .back:hover {
        color: #1d4ed8;
    }

    /* TITULO */

    .page-title {
        margin-bottom: 28px;
    }

    .page-title h1 {
        font-size: 30px;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .page-title p {
        color: #64748b;
        font-size: 14px;
    }

    /* ALERTAS */

    .alert {
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ESTADISTICAS */

    .stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        border: 1px solid #eef2f7;
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .stat-total .stat-icon {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-open .stat-icon {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .stat-follow .stat-icon {
        background: #fef3c7;
        color: #92400e;
    }

    .stat-closed .stat-icon {
        background: #e2e8f0;
        color: #475569;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
    }

    .stat-number {
        font-size: 25px;
        font-weight: 800;
        color: #0f172a;
    }

    /* CARD */

    .card {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .07);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title-icon {
        width: 45px;
        height: 45px;
        border-radius: 13px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .card-title h2 {
        font-size: 20px;
        color: #0f172a;
    }

    .card-title p {
        color: #64748b;
        font-size: 12px;
        margin-top: 2px;
    }

    /* CARPETAS POR TIPO DE CASO */

    .type-group {
        background: #fbfcfe;
        border: 1px solid #eef2f7;
        border-radius: 20px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .type-group[open] {
        border-color: #dbeafe;
    }

    .type-group.type-suicide[open] {
        border-color: #fecaca;
    }

    .type-group.type-abuse[open] {
        border-color: #fde68a;
    }

    .type-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 20px 24px;
        cursor: pointer;
        list-style: none;
        transition: background .2s;
    }

    .type-summary:hover {
        background: #f1f5f9;
    }

    .type-summary::-webkit-details-marker {
        display: none;
    }

    .type-summary-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .type-icon {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .type-icon.suicide {
        background: #fee2e2;
        color: #b91c1c;
    }

    .type-icon.abuse {
        background: #fef3c7;
        color: #92400e;
    }

    .type-icon.other {
        background: #e2e8f0;
        color: #475569;
    }

    .type-meta {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .type-name {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }

    .type-sub {
        font-size: 12px;
        color: #64748b;
    }

    .type-summary-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .type-count-badge {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .type-chevron {
        color: #94a3b8;
        transition: transform .2s;
    }

    .type-group[open] .type-chevron {
        transform: rotate(180deg);
    }

    .type-cases {
        padding: 4px 22px 22px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* SUB-CARPETA POR USUARIO */

    .user-subgroup {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: white;
        overflow: hidden;
    }

    .user-subgroup[open] {
        border-color: #cbd5e1;
    }

    .user-subgroup-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        cursor: pointer;
        list-style: none;
        background: #f8fafc;
        transition: background .2s;
    }

    .user-subgroup-summary:hover {
        background: #f1f5f9;
    }

    .user-subgroup-summary::-webkit-details-marker {
        display: none;
    }

    .user-subgroup-left {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #0f172a;
        min-width: 0;
    }

    .user-subgroup-left i {
        color: #2563eb;
        font-size: 13px;
    }

    .user-subgroup-name {
        font-size: 13px;
        font-weight: 700;
    }

    .user-subgroup-count {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        background: #e2e8f0;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .user-subgroup-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .user-subgroup-body {
        padding: 16px 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background: white;
    }

    /* CASOS */

    .case-card {
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
        background: #f8fafc;
        transition: .2s;
    }

    .case-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 8px 25px rgba(37, 99, 235, .08);
        transform: translateY(-1px);
    }

    .case-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 18px;
    }

    .case-main {
        min-width: 0;
    }

    .case-title-label {
        font-size: 10px;
        color: #64748b;
        margin-bottom: 3px;
    }

    .case-number {
        font-size: 17px;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 5px;
    }

    .case-date {
        font-size: 11px;
        color: #94a3b8;
    }

    .case-badges {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 7px;
    }

    /* BADGES */

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-suicide {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-abuse {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-open {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-follow {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-closed {
        background: #e2e8f0;
        color: #475569;
    }

    /* INFORMACION */

    .case-info {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }

    .info-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 14px;
    }

    .info-label {
        display: block;
        color: #64748b;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #0f172a;
        font-size: 13px;
        font-weight: 600;
        word-break: break-word;
    }

    /* DESCRIPCION */

    .description {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 18px;
    }

    .description-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .description-text {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
        white-space: pre-line;
    }

    /* FOOTER */

    .case-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
    }

    .case-user {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #64748b;
        font-size: 12px;
    }

    .user-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-view,
    .btn-save,
    .btn-back {
        text-decoration: none;
        border: none;
        cursor: pointer;
        border-radius: 11px;
        padding: 10px 17px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: .2s;
        font-family: 'Poppins', sans-serif;
    }

    .btn-view,
    .btn-save {
        background: #2563eb;
        color: white;
    }

    .btn-view:hover,
    .btn-save:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-back {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-back:hover {
        background: #dbeafe;
    }

    /* DETALLE */

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 25px;
    }

    .detail-title h1 {
        font-size: 28px;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .detail-title p {
        color: #64748b;
        font-size: 13px;
    }

    .detail-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        justify-content: flex-end;
    }

    .detail-section {
        margin-bottom: 25px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #0f172a;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .section-title i {
        color: #2563eb;
    }

    /* COMENTARIOS */

    .comments {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .comment {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        padding: 16px;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 8px;
    }

    .comment-user {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .comment-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .comment-name {
        color: #0f172a;
        font-size: 12px;
        font-weight: 700;
    }

    .comment-date {
        color: #94a3b8;
        font-size: 10px;
    }

    .comment-text {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
    }

    .no-comments {
        text-align: center;
        padding: 25px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 15px;
        color: #94a3b8;
        font-size: 12px;
    }

    /* FORMULARIO */

    .form-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #334155;
        font-size: 12px;
        font-weight: 600;
    }

    .form-group select,
    .form-group textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 11px 13px;
        background: white;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        outline: none;
        transition: .2s;
    }

    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 15px;
    }

    /* EMPTY */

    .empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        background: #f1f5f9;
        color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 28px;
    }

    .empty h3 {
        color: #475569;
        font-size: 17px;
        margin-bottom: 6px;
    }

    .empty p {
        font-size: 13px;
    }

    /* RESPONSIVE */

    @media(max-width: 1000px) {

        .stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .case-info {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media(max-width: 700px) {

        .navbar {
            width: 92%;
            padding: 15px 18px;
        }

        .container {
            width: 92%;
            margin-top: 30px;
        }

        .nav-actions {
            display: none;
        }

        .page-title h1 {
            font-size: 25px;
        }

        .card {
            padding: 20px;
        }

        .stats {
            grid-template-columns: 1fr 1fr;
        }

        .type-summary {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .type-summary-right {
            width: 100%;
            justify-content: space-between;
        }

        .case-header {
            flex-direction: column;
        }

        .case-badges {
            justify-content: flex-start;
        }

        .case-info {
            grid-template-columns: 1fr;
        }

        .case-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-view {
            width: 100%;
        }

        .detail-header {
            flex-direction: column;
        }

        .detail-badges {
            justify-content: flex-start;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

    }

    @media(max-width: 450px) {

        .stats {
            grid-template-columns: 1fr;
        }

        .brand h2 {
            font-size: 16px;
        }

        .brand span {
            font-size: 10px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
        }

    }

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar">

    <div class="brand">

        <div class="brand-icon">
            <i class="fas fa-shield-halved"></i>
        </div>

        <div>

            <h2>
                Panel del Moderador
            </h2>

            <span>
                Plataforma UMG Xela
            </span>

        </div>

    </div>

    <div class="nav-actions">

        <a
            href="{{ route('moderator.dashboard') }}"
            class="nav-btn nav-btn-dashboard">

            <i class="fas fa-chart-line"></i>

            Dashboard

        </a>

    </div>

</nav>

<main class="container">

    <!-- ALERTAS -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fas fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-error">

            <i class="fas fa-circle-exclamation"></i>

            {{ session('error') }}

        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-error">

            <strong>
                Se encontraron errores:
            </strong>

            <ul style="margin-top: 7px; padding-left: 20px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- LISTADO DE CASOS --}}

    @if(!isset($case))

        <a
            href="{{ route('moderator.dashboard') }}"
            class="back">

            <i class="fas fa-arrow-left"></i>

            Volver al dashboard

        </a>

        <div class="page-title">

            <h1>
                Mis casos asignados
            </h1>

            <p>
                Consulta y gestiona los casos que han sido asignados a tu cuenta.
            </p>

        </div>

        @php

            $totalCases = $cases->count();

            $openCases = $cases
                ->filter(fn($item) => strtolower($item->status ?? '') === 'abierto')
                ->count();

            $inProcessCases = $cases
                ->filter(fn($item) => strtolower($item->status ?? '') === 'en seguimiento')
                ->count();

            $closedCases = $cases
                ->filter(fn($item) => strtolower($item->status ?? '') === 'cerrado')
                ->count();

        @endphp

        <!-- ESTADISTICAS -->

        <div class="stats">

            <div class="stat-card stat-total">

                <div class="stat-top">

                    <div>

                        <span class="stat-label">
                            Total de casos
                        </span>

                        <div class="stat-number">
                            {{ $totalCases }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="fas fa-folder"></i>
                    </div>

                </div>

            </div>

            <div class="stat-card stat-open">

                <div class="stat-top">

                    <div>

                        <span class="stat-label">
                            Casos abiertos
                        </span>

                        <div class="stat-number">
                            {{ $openCases }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>

                </div>

            </div>

            <div class="stat-card stat-follow">

                <div class="stat-top">

                    <div>

                        <span class="stat-label">
                            En seguimiento
                        </span>

                        <div class="stat-number">
                            {{ $inProcessCases }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="fas fa-spinner"></i>
                    </div>

                </div>

            </div>

            <div class="stat-card stat-closed">

                <div class="stat-top">

                    <div>

                        <span class="stat-label">
                            Casos cerrados
                        </span>

                        <div class="stat-number">
                            {{ $closedCases }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="fas fa-lock"></i>
                    </div>

                </div>

            </div>

        </div>

        <!-- LISTADO -->

        <div class="card">

            <div class="card-header">

                <div class="card-title">

                    <div class="card-title-icon">

                        <i class="fas fa-folder-tree"></i>

                    </div>

                    <div>

                        <h2>
                            Casos asignados
                        </h2>

                        <p>
                            Selecciona un caso para consultar su información y realizar seguimiento.
                        </p>

                    </div>

                </div>

            </div>

            @if($cases->count() > 0)

                @php
    $typeGroups = [
        [
            'key'   => 'Suicidio',
            'label' => 'Casos de suicidio',
            'sub'   => 'Casos reportados por riesgo de suicidio.',
            'icon'  => 'fa-heart-pulse',
            'class' => 'suicide',
            'cases' => $cases->filter(
                fn($c) => strtoupper(trim($c->type ?? '')) === 'SUICIDIO'
            )->values(),
        ],
        [
            'key'   => 'Abuso sexual',
            'label' => 'Casos de abuso sexual',
            'sub'   => 'Casos reportados por abuso sexual.',
            'icon'  => 'fa-shield-heart',
            'class' => 'abuse',
            'cases' => $cases->filter(
                fn($c) => strtoupper(trim($c->type ?? '')) === 'ABUSO SEXUAL'
            )->values(),
        ],
    ];
@endphp
                @foreach($typeGroups as $group)

                    @continue($group['cases']->isEmpty())

                    <details
                        class="type-group type-{{ $group['class'] }}"
                        open
                    >

                        <summary class="type-summary">

                            <div class="type-summary-left">

                                <div class="type-icon {{ $group['class'] }}">
                                    <i class="fas {{ $group['icon'] }}"></i>
                                </div>

                                <div class="type-meta">

                                    <span class="type-name">
                                        {{ $group['label'] }}
                                    </span>

                                    <span class="type-sub">
                                        {{ $group['sub'] }}
                                    </span>

                                </div>

                            </div>

                            <div class="type-summary-right">

                                <span class="type-count-badge">

                                    {{ $group['cases']->count() }}

                                    caso{{ $group['cases']->count() != 1 ? 's' : '' }}

                                </span>

                                <i class="fas fa-chevron-down type-chevron"></i>

                            </div>

                        </summary>

                        <div class="type-cases">

                            @php

                                $casesByUser = $group['cases']->groupBy(function ($c) {

                                    return optional($c->user)->uuid
                                        ?? ('sin-usuario-' . $c->id);

                                });

                            @endphp

                            @foreach($casesByUser as $userKey => $userCases)

                                @if($userCases->count() >= 1)

                                    @php

                                        $subUserObj = $userCases->first()->user;

                                        $subUserName = $subUserObj
                                            ? (
                                                $subUserObj->anonymous_nickname
                                                ?? $subUserObj->full_name
                                                ?? $subUserObj->first_name
                                                ?? 'Usuario'
                                            )
                                            : 'Usuario';

                                        $subOpenCount = $userCases
                                            ->filter(
                                                fn($c) =>
                                                    strtolower(trim($c->status ?? '')) === 'abierto'
                                            )
                                            ->count();

                                    @endphp

                                    <details
                                        class="user-subgroup"
                                        {{ $subOpenCount > 0 ? 'open' : '' }}
                                    >

                                        <summary class="user-subgroup-summary">

                                            <div class="user-subgroup-left">

                                                <i class="fas fa-user"></i>

                                                <span class="user-subgroup-name">
                                                    {{ $subUserName }}
                                                </span>

                                                <span class="user-subgroup-count">

                                                    {{ $userCases->count() }}

                                                    casos

                                                </span>

                                            </div>

                                            <div class="user-subgroup-right">

                                                <i class="fas fa-chevron-down type-chevron"></i>

                                            </div>

                                        </summary>

                                        <div class="user-subgroup-body">

                                            @foreach($userCases as $caseItem)

                                                @include(
                                                    'moderator.partials._case-card',
                                                    ['caseItem' => $caseItem]
                                                )

                                            @endforeach

                                        </div>

                                    </details>

                                @else

                                    @foreach($userCases as $caseItem)

                                        @include(
                                            'moderator.partials._case-card',
                                            ['caseItem' => $caseItem]
                                        )

                                    @endforeach

                                @endif

                            @endforeach

                        </div>

                    </details>

                @endforeach

            @else

                <div class="empty">

                    <div class="empty-icon">

                        <i class="fas fa-folder-open"></i>

                    </div>

                    <h3>
                        No tienes casos asignados
                    </h3>

                    <p>
                        Cuando se te asigne un caso, aparecerá aquí.
                    </p>

                </div>

            @endif

        </div>


    {{-- DETALLE DEL CASO --}}

    @else

        <a
            href="{{ route('moderator.cases') }}"
            class="back">

            <i class="fas fa-arrow-left"></i>

            Volver a mis casos

        </a>

        <div class="card">

            <!-- CABECERA -->

            <div class="detail-header">

                <div class="detail-title">

                    <h1>
                        Caso {{ $case->case_number }}
                    </h1>

                    <p>
                        Detalle y seguimiento del caso asignado.
                    </p>

                </div>

                <div class="detail-badges">

                    @php
                        $caseType = strtoupper(trim($case->type ?? ''));
                        $caseStatus = strtolower(trim($case->status ?? ''));
                    @endphp

                    <!-- TIPO -->

                    @if($caseType === 'SUICIDIO')

                        <span class="badge badge-suicide">

                            <i class="fas fa-heart-pulse"></i>

                            Suicidio

                        </span>

                    @elseif($caseType === 'ABUSO SEXUAL')

                        <span class="badge badge-abuse">

                            <i class="fas fa-shield-heart"></i>

                            Abuso sexual

                        </span>

                    @endif


                    <!-- ESTADO -->

                    @if($caseStatus === 'abierto')

                        <span class="badge badge-open">
                            Abierto
                        </span>

                    @elseif($caseStatus === 'en seguimiento')

                        <span class="badge badge-follow">
                            En seguimiento
                        </span>

                    @elseif($caseStatus === 'cerrado')

                        <span class="badge badge-closed">
                            Cerrado
                        </span>

                    @endif

                </div>

            </div>


            <!-- INFORMACION -->

            <div class="detail-section">

                <div class="section-title">

                    <i class="fas fa-circle-info"></i>

                    Información del caso

                </div>

                <div class="case-info">

                    <div class="info-box">

                        <span class="info-label">
                            Número de caso
                        </span>

                        <span class="info-value">
                            {{ $case->case_number }}
                        </span>

                    </div>

                    <div class="info-box">

                        <span class="info-label">
                            Tipo
                        </span>

                        <span class="info-value">

                            @if($caseType === 'SUICIDIO')
                                Suicidio
                            @elseif($caseType === 'ABUSO SEXUAL')
                                Abuso sexual
                            @else
                                No especificado
                            @endif

                        </span>

                    </div>

                    <div class="info-box">

                        <span class="info-label">
                            Estado
                        </span>

                        <span class="info-value">

                            @if($caseStatus === 'abierto')
                                Abierto
                            @elseif($caseStatus === 'en seguimiento')
                                En seguimiento
                            @elseif($caseStatus === 'cerrado')
                                Cerrado
                            @else
                                Sin estado
                            @endif

                        </span>

                    </div>

                    <div class="info-box">

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

                    <div class="info-box">

                        <span class="info-label">
                            Última actualización
                        </span>

                        <span class="info-value">

                            {{ $case->updated_at
                                ? $case->updated_at->format('d/m/Y H:i')
                                : 'No disponible'
                            }}

                        </span>

                    </div>

                    <div class="info-box">

                        <span class="info-label">
                            Usuario
                        </span>

                        <span class="info-value">

                            @if($case->user)

                                {{
                                    $case->user->anonymous_nickname
                                    ?? $case->user->full_name
                                    ?? trim(
                                        ($case->user->first_name ?? '') . ' ' .
                                        ($case->user->last_name ?? '')
                                    )
                                    ?: 'Usuario'
                                }}

                            @else

                                Usuario

                            @endif

                        </span>

                    </div>

                    <div class="info-box">

                        <span class="info-label">
                            Moderador
                        </span>

                        <span class="info-value">

                            @if($case->moderator)

                                {{
                                    $case->moderator->full_name
                                    ?? trim(
                                        ($case->moderator->first_name ?? '') . ' ' .
                                        ($case->moderator->last_name ?? '')
                                    )
                                    ?: 'Moderador'
                                }}

                            @else

                                Sin asignar

                            @endif

                        </span>

                    </div>

                </div>

            </div>


            <!-- USUARIO -->

            <div class="detail-section">

                <div class="section-title">

                    <i class="fas fa-user"></i>

                    Usuario

                </div>

                <div class="description">

                    <div class="description-title">

                        <i class="fas fa-user-shield"></i>

                        Información del usuario

                    </div>

                    @if($case->user)

                        <div class="case-info">

                            <div class="info-box">

                                <span class="info-label">
                                    Nombre
                                </span>

                                <span class="info-value">

                                    {{
                                        $case->user->anonymous_nickname
                                        ?? $case->user->full_name
                                        ?? trim(
                                            ($case->user->first_name ?? '') . ' ' .
                                            ($case->user->last_name ?? '')
                                        )
                                        ?: 'Usuario'
                                    }}

                                </span>

                            </div>

                            <div class="info-box">

                                <span class="info-label">
                                    Correo
                                </span>

                                <span class="info-value">

                                    {{ $case->user->email ?? 'No disponible' }}

                                </span>

                            </div>

                            <div class="info-box">

                                <span class="info-label">
                                    Teléfono
                                </span>

                                <span class="info-value">

                                    {{ $case->user->phone ?? 'No disponible' }}

                                </span>

                            </div>

                            <div class="info-box">

                                <span class="info-label">
                                    Estado
                                </span>

                                <span class="info-value">

                                    @php
                                        $userStatus = strtoupper(
                                            trim($case->user->status ?? '')
                                        );
                                    @endphp

                                    @if($userStatus === 'ACTIVE')
                                        Activo
                                    @elseif($userStatus === 'BLOCKED')
                                        Bloqueado
                                    @elseif($userStatus === 'PENDING')
                                        Pendiente
                                    @elseif($userStatus === 'INACTIVE')
                                        Inactivo
                                    @elseif($userStatus === 'SUSPENDED')
                                        Suspendido
                                    @elseif($userStatus === 'DELETED')
                                        Eliminado
                                    @else
                                        {{ $case->user->status ?? 'No disponible' }}
                                    @endif

                                </span>

                            </div>

                        </div>

                    @else

                        <p class="description-text">
                            No se encontró información del usuario.
                        </p>

                    @endif

                </div>

            </div>


            <!-- DESCRIPCION -->

            <div class="detail-section">

                <div class="section-title">

                    <i class="fas fa-file-lines"></i>

                    Descripción

                </div>

                <div class="description">

                    <div class="description-text">

                        {{ $case->description ?? 'Sin descripción registrada.' }}

                    </div>

                </div>

            </div>


            <!-- COMENTARIOS -->

            <div class="detail-section">

                <div class="section-title">

                    <i class="fas fa-comments"></i>

                    Comentarios y seguimiento

                </div>

                <div class="comments">

                    @forelse($case->comments as $comment)

                        <div class="comment">

                            <div class="comment-header">

                                <div class="comment-user">

                                    <div class="comment-avatar">

                                        <i class="fas fa-user-shield"></i>

                                    </div>

                                    <div>

                                        <div class="comment-name">

                                            @if($comment->user)

                                                {{
                                                    $comment->user->full_name
                                                    ?? trim(
                                                        ($comment->user->first_name ?? '') . ' ' .
                                                        ($comment->user->last_name ?? '')
                                                    )
                                                    ?: 'Usuario'
                                                }}

                                            @else

                                                Moderador

                                            @endif

                                        </div>

                                        <div class="comment-date">

                                            {{ $comment->created_at
                                                ? $comment->created_at->format('d/m/Y H:i')
                                                : 'Fecha no disponible'
                                            }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="comment-text">

                                {{ $comment->comment }}

                            </div>

                        </div>

                    @empty

                        <div class="no-comments">

                            <i class="fas fa-comment-slash"></i>

                            No hay comentarios registrados para este caso.

                        </div>

                    @endforelse

                </div>

            </div>


            <!-- FORMULARIO DE SEGUIMIENTO -->

            <div class="detail-section">

                <div class="section-title">

                    <i class="fas fa-clipboard-check"></i>

                    Formulario de seguimiento

                </div>

                <div class="form-card">

                    @can('update', $case)

    <form
        method="POST"
        action="{{ route('moderator.case.update', ['id' => $case->id]) }}"
    >

        @csrf

        @method('PUT')

        <div class="form-grid">

            <!-- ESTADO -->

            <div class="form-group">

                <label for="status">
                    Estado
                </label>

                <select
                    name="status"
                    id="status"
                    required
                >

                    <option
                        value="Abierto"
                        {{ strtolower($case->status ??'') === 'abierto' ? 'selected' : '' }}
                    >
                        Abierto
                    </option>

                    <option
                        value="En seguimiento"
                        {{ strtolower($case->status ??'') === 'en seguimiento' ? 'selected' : '' }}
                    >
                        En seguimiento
                    </option>

                    <option
                        value="Cerrado"
                        {{ strtolower($case->status ??'') === 'cerrado' ? 'selected' : '' }}
                    >
                        Cerrado
                    </option>

                </select>

            </div>


            <!-- COMENTARIO -->

            <div class="form-group full">

                <label for="comment">
                    Comentario de seguimiento
                </label>

                <textarea
                    name="comment"
                    id="comment"
                    placeholder="Escribe las observaciones, acciones realizadas o información relevante del seguimiento..."
                ></textarea>

            </div>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn-save"
            >

                <i class="fas fa-save"></i>

                Guardar cambios

            </button>

        </div>

    </form>

@endcan

                </div>

            </div>

        </div>

    @endif

</main>

</body>

</html>