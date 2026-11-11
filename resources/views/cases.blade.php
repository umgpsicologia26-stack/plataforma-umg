<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    @vite('resources/js/echo.js')
                <title>Seguimiento de Casos | UMG Xela</title>
                        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; 
        padding: 0; 
        box-sizing: 
        border-box; 
    }
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #f8fafc; 
            min-height: 100vh; 
            padding: 35px 20px; 
            color: #1e293b; 
        }
            .container { 
                max-width: 1100px; 
                margin: 0 
                auto; 
            }

            .main-card { 
                background: #ffffff; 
                border: 1px solid #e2e8f0; 
                padding: 40px; 
                border-radius: 24px; 
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            }

                /* ENCABEZADO */
            .title-row { 
                display: flex; 
                align-items: center; 
                gap: 15px; 
                margin-bottom: 12px; 
            }

            .back { 
                width: 46px; 
                height: 46px; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                border-radius: 14px; 
                background: #eff6ff; color: #0284c7; 
                text-decoration: none; 
                font-size: 28px; 
                transition: all .3s ease; 
            }

            .back:hover { 
                background: #e0f2fe; 
                color: #0369a1; 
                transform: translateX(-3px); 
            }

            .title { 
                font-size: 38px; 
                font-weight: 700; 
                color: #0f172a; 
            }

            .subtitle { 
                color: #64748b; 
                line-height: 1.8; 
                margin-bottom: 35px; 
            }

                /* ALERTAS */
            .alert {
                padding: 16px 20px; 
                border-radius: 16px; 
                margin-bottom: 25px; 
                font-size: 14px; 
            }

            .alert-error { 
                background: #fef2f2; 
                border: 1px solid #fecaca; 
                color: #b91c1c; 
            }

            .alert-success { 
                background: #f0fdf4; 
                border: 1px solid #bbf7d0; 
                color: #166534; 
            }

                /* ESTADISTICAS */
            .stats { 
                display: grid; 
                grid-template-columns: repeat(3, 1fr); 
                gap: 18px; 
                margin-bottom: 40px; 
            }

            .stat { 
                background: #ffffff; 
                border: 1px solid #e2e8f0; 
                border-radius: 18px; 
                padding: 23px; 
                text-align: center; 
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05); 
                transition: all .25s ease; 
            }

            .stat:hover { 
                transform: translateY(-2px); 
                box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08); 
            }

            .stat-number { 
                font-size: 32px; 
                font-weight: 700; 
                color: #0284c7; 
                margin-bottom: 5px; 
            }

            .stat-label { 
                color: #64748b; 
                font-size: 13px; 
            }

            /* CARPETAS */
        .folder { 
            margin-bottom: 30px; 
            background: #ffffff; 
            border: 1px solid #e2e8f0; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.06); 
        }

        .folder-header { 
            padding: 24px 26px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 20px; 
            background: #f8fafc; 
            border-bottom: 1px solid #e2e8f0; 
        }

        .folder-title { 
            display: flex; 
            align-items: center; 
            gap: 13px; 
        }

        .folder-icon { 
            width: 45px; 
            height: 45px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 13px; 
            background: #eff6ff; 
            color: #0284c7; 
            font-size: 22px; 
        }

        .folder-title h2 { 
            font-size: 20px; 
            font-weight: 600; 
            color: #0f172a; 
        }

        .folder-count { 
            color: #64748b; 
            font-size: 13px; 
            margin-top: 3px; 
        }

        .folder-body { 
            padding: 22px; 
            background: #ffffff; 
        }

        /* ESTADOS */

        .status-section { 
            margin-bottom: 22px; 
        }

        .status-section:last-child { 
            margin-bottom: 0; 
        }

        .status-header { 
            width: 100%; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 15px 18px; 
            background: #f8fafc; 
            border: 1px solid #e2e8f0; 
            border-radius: 14px; 
            cursor: pointer; 
            color: #1e293b; 
            font-family: 'Poppins', sans-serif; 
            transition: all .25s ease; 
        }

        .status-header:hover { 
            background: #f1f5f9; 
            border-color: #cbd5e1; 
        }

        .status-header-left { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }

        .status-name { 
            font-size: 14px; 
            font-weight: 600; 
            color: #334155; 
        }

        .status-count { 
            padding: 4px 9px; 
            border-radius: 20px; 
            background: #e2e8f0; 
            color: #475569; 
            font-size: 11px; 
        }

        .arrow { 
            font-size: 15px; 
            color: #64748b;
            transition: transform .3s;
        }

        .status-header.active .arrow { 
            transform: rotate(180deg);
        }

        .status-content { 
            padding-top: 15px; 
        }

        .status-content.collapsed { 
            display: none; 
        }

            /* CASO */
        .case-card { 
            background: #ffffff; 
            border: 1px solid #e2e8f0; 
            border-radius: 18px; 
            overflow: hidden; 
            margin-bottom: 16px; 
            box-shadow: 0 5px 15px rgba(15, 23, 42, 0.06); 
            transition: all .25s ease; 
        }

        .case-card:hover { 
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.09); 
        }

        .case-card:last-child { 
            margin-bottom: 0; 
        }

        .case-header { 
            padding: 22px 24px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 20px; 
            background: #ffffff; 
            border-bottom: 1px solid #e2e8f0; 
        }

        .case-info { 
            min-width: 0; 
        }

        .case-number { 
            font-size: 19px; 
            font-weight: 700; 
            color: #0f172a; 
        }

        .case-date { 
            color: #64748b; 
            font-size: 12px; 
            margin-top: 5px; 
        }

        /* ESTADO DEL CASO */
        .case-status { 
            padding: 8px 14px; 
            border-radius: 30px; 
            font-size: 11px; 
            font-weight: 700; 
            white-space: nowrap; 
        }

        .status-open { 
            color: #15803d; 
            background: #f0fdf4; 
            border: 1px solid #bbf7d0; 
        }

        .status-following { 
            color: #0369a1; 
            background: #f0f9ff; 
            border: 1px solid #bae6fd; 
        }

        .status-closed { 
            color: #475569; 
            background: #f1f5f9; 
            border: 1px solid #cbd5e1; 
        }

            /* INFORMACION DEL CASO */
        .case-section { 
            padding: 22px 24px; 
            background: #ffffff; 
            border-bottom: 1px solid #e2e8f0; 
        }

        .section-label { 
            color: #64748b; 
            font-size: 12px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: .5px; 
            margin-bottom: 10px; 
        }

        .description-box { 
            background: #f8fafc; 
            border: 1px solid #e2e8f0; 
            border-radius: 14px; 
            padding: 17px 18px; 
            color: #334155; 
            font-size: 14px; 
            line-height: 1.8; 
            white-space: pre-line; 
            overflow-wrap: anywhere; 
        }

            /* OBSERVACIONES */
        .observations { 
            padding: 22px 24px 25px; 
            background: #ffffff; 
        }

        .observations-title { 
            display: flex; 
            align-items: center; 
            gap: 9px; 
            font-size: 16px; 
            font-weight: 600; 
            color: #1e293b; 
            margin-bottom: 18px; 
        }

        .observations-title span { 
            color: #0284c7; 
        }

            /* MENSAJES */
        .comment { 
            margin-bottom: 18px; 
            display: flex; 
            flex-direction: column; 
            align-items: flex-start; 
        }
        
.comment:last-child { margin-bottom: 0; }
.comment-meta { display: flex; align-items: center; gap: 10px; margin-bottom: 7px; padding-left: 4px; }
.comment-author { font-size: 12px; font-weight: 600; color: #0284c7; }
.comment-date { font-size: 11px; color: #94a3b8; }
.comment-bubble { width: 100%; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px 17px 17px 17px; padding: 16px 18px; color: #334155; font-size: 13px; line-height: 1.75; white-space: pre-line; overflow-wrap: anywhere; word-break: break-word; box-shadow: 0 2px 5px rgba(15, 23, 42, 0.03); }

/* SIN COMENTARIOS */
.no-comments { padding: 20px; text-align: center; border-radius: 14px; background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b; font-size: 13px; line-height: 1.7; }

/* SIN CASOS */
.empty-folder { padding: 35px 20px; text-align: center; color: #64748b; }
.empty-icon { font-size: 34px; margin-bottom: 10px; opacity: .7; }
.empty-folder p { font-size: 13px; }

/* RESPUESTA DEL USUARIO */
.case-reply-form { padding: 0 24px 24px; background: #ffffff; }
.case-reply-form form { display: flex; flex-direction: column; gap: 10px; }
.case-reply-form label { color: #334155; font-size: 13px; font-weight: 600; }
.case-reply-form textarea { width: 100%; min-height: 100px; padding: 13px 15px; border: 1px solid #cbd5e1; border-radius: 12px; color: #334155; font-family: 'Poppins', sans-serif; font-size: 13px; line-height: 1.6; resize: vertical; }
.case-reply-form textarea:focus { outline: 2px solid #bae6fd; border-color: #0284c7; }
.case-reply-form button { align-self: flex-start; padding: 11px 18px; border: none; border-radius: 10px; background: #0284c7; color: #ffffff; font-size: 13px; font-weight: 600; cursor: pointer; transition: background .2s ease; }
.case-reply-form button:hover { background: #0369a1; }
button { font-family: 'Poppins', sans-serif; }

/* SCROLLBAR */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: #f1f5f9; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

/* RESPONSIVE */
@media (max-width: 800px) {
    body { padding: 20px 12px; }
    .main-card { padding: 22px; border-radius: 23px; }
    .title { font-size: 28px; }
    .stats { grid-template-columns: 1fr; }
    .folder-header { padding: 20px; }
    .folder-body { padding: 15px; }
    .case-header { align-items: flex-start; flex-direction: column; }
    .case-status { align-self: flex-start; }
    .case-section, .observations, .case-reply-form { padding-left: 18px; padding-right: 18px; }
}
@media (max-width: 500px) {
    .title-row { align-items: flex-start; }
    .back { flex-shrink: 0; }
    .title { font-size: 24px; }
    .subtitle { font-size: 13px; }
    .folder-title h2 { font-size: 17px; }
    .case-number { font-size: 17px; }
    .comment-meta { flex-wrap: wrap; }
}
</style>
</head>
<body>
<div class="container">
<div class="main-card">

{{-- ENCABEZADO --}}
<div class="title-row">
    <a href="{{ url('/dashboard') }}" class="back">←</a>
    <h1 class="title">Seguimiento de Casos</h1>
</div>
<p class="subtitle">Aquí puedes consultar todos tus casos, conocer su estado y revisar las observaciones realizadas por el equipo de moderación.</p>

{{-- ALERTAS --}}
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div id="live-cases">
    

{{-- ESTADISTICAS --}}
@php
    $allCases = collect($cases ?? []);
    $totalCases = $allCases->count();

    $openCases = $allCases->filter(function ($case) {
        $status = strtoupper(trim((string) data_get($case, 'status', '')));
        return in_array($status, ['ABIERTO', 'ABIERTA', 'OPEN'], true);
    })->count();

    $followingCases = $allCases->filter(function ($case) {
        $status = strtoupper(trim((string) data_get($case, 'status', '')));
        return in_array($status, ['EN_SEGUIMIENTO', 'EN SEGUIMIENTO', 'SEGUIMIENTO'], true);
    })->count();
@endphp

<div class="stats">
    <div class="stat">
        <div class="stat-number">{{ $totalCases }}</div>
        <div class="stat-label">Casos registrados</div>
    </div>
    <div class="stat">
        <div class="stat-number">{{ $openCases }}</div>
        <div class="stat-label">Casos abiertos</div>
    </div>
    <div class="stat">
        <div class="stat-number">{{ $followingCases }}</div>
        <div class="stat-label">En seguimiento</div>
    </div>
</div>

{{-- SEPARACION DE CASOS POR TIPO --}}
@php
    $allCases = collect($allCases ?? []);

    $suicideCases = $allCases->filter(function ($case) {
        $type = strtoupper(trim((string) data_get($case, 'type', '')));
        return in_array($type, ['SUICIDIO', 'SUICIDE'], true);
    });

    $abuseCases = $allCases->filter(function ($case) {
        $type = strtoupper(trim((string) data_get($case, 'type', '')));
        return in_array($type, ['ABUSO_SEXUAL', 'ABUSO SEXUAL'], true);
    });

    $getStatusGroup = function ($case) {
        $status = strtoupper(trim((string) data_get($case, 'status', '')));
        if (in_array($status, ['CERRADO', 'CERRADA', 'CLOSED'], true)) { return 'closed'; }
        if (in_array($status, ['EN_SEGUIMIENTO', 'EN SEGUIMIENTO', 'SEGUIMIENTO'], true)) { return 'following'; }
        if (in_array($status, ['ABIERTO', 'ABIERTA', 'OPEN'], true)) { return 'open'; }
        return 'other';
    };

    $suicideOpen = $suicideCases->filter(function ($case) use ($getStatusGroup) { return $getStatusGroup($case) === 'open'; });
    $suicideFollowing = $suicideCases->filter(function ($case) use ($getStatusGroup) { return $getStatusGroup($case) === 'following'; });
    $suicideClosed = $suicideCases->filter(function ($case) use ($getStatusGroup) { return $getStatusGroup($case) === 'closed'; });

    $abuseOpen = $abuseCases->filter(function ($case) use ($getStatusGroup) { return $getStatusGroup($case) === 'open'; });
    $abuseFollowing = $abuseCases->filter(function ($case) use ($getStatusGroup) { return $getStatusGroup($case) === 'following'; });
    $abuseClosed = $abuseCases->filter(function ($case) use ($getStatusGroup) { return $getStatusGroup($case) === 'closed'; });
@endphp

{{-- CARPETA: SUICIDIO --}}
<div class="folder">
    <div class="folder-header">
        <div class="folder-title">
            <div class="folder-icon">📁</div>
            <div>
                <h2>Casos de Suicidio</h2>
                <div class="folder-count">{{ $suicideCases->count() }} {{ $suicideCases->count() === 1 ? 'caso' : 'casos' }}</div>
            </div>
        </div>
    </div>
    <div class="folder-body">

        {{-- ABIERTOS --}}
        @if($suicideOpen->count() > 0)
        <div class="status-section">
            <button type="button" class="status-header active" onclick="toggleStatus(this)">
                <div class="status-header-left">
                    <span class="status-name">Casos abiertos</span>
                    <span class="status-count">{{ $suicideOpen->count() }}</span>
                </div>
                <span class="arrow">▼</span>
            </button>
            <div class="status-content">
                @foreach($suicideOpen as $case)
                <div class="case-card">
                    <div class="case-header">
                        <div class="case-info">
                            <div class="case-number">{{ $case->case_number }}</div>
                            <div class="case-date">Registrado el {{ optional($case->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="case-status status-open">ABIERTO</div>
                    </div>
                    <div class="case-section">
                        <div class="section-label">Situación reportada</div>
                        <div class="description-box">{{ trim($case->description) }}</div>
                    </div>
                    {{-- OBSERVACIONES --}}
                    <div class="observations">
                        <div class="observations-title"><span>💬</span> Observaciones del equipo de moderación</div>
                        @if($case->comments && $case->comments->count() > 0)
                            @foreach($case->comments as $comment)
                            <div class="comment">
                                <div class="comment-meta">
                                    <span class="comment-author">
                                        @if($comment->type === 'RESPUESTA_USUARIO')
                                            Respuesta del usuario
                                        @elseif($comment->user && $comment->user->role === 'MODERATOR')
                                            Moderador
                                        @elseif($comment->user && $comment->user->role === 'ADMIN')
                                            Administrador
                                        @else
                                            Equipo de moderación
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ optional($comment->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-bubble">{{ trim($comment->comment) }}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-comments">Aún no hay observaciones de seguimiento realizadas por el equipo de moderación.</div>
                        @endif
                    </div>
                    <div class="case-reply-form">
                        <form method="POST" action="{{ route('cases.reply', $case->id) }}">
                            @csrf
                            <label for="reply-{{ $case->id }}">Tu respuesta</label>
                            <textarea id="reply-{{ $case->id }}" name="message" rows="3" maxlength="5000" required placeholder="Escribe aquí tu respuesta...">{{ old('message') }}</textarea>
                            <button type="submit">Enviar respuesta</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- EN SEGUIMIENTO --}}
        @if($suicideFollowing->count() > 0)
        <div class="status-section">
            <button type="button" class="status-header active" onclick="toggleStatus(this)">
                <div class="status-header-left">
                    <span class="status-name">En seguimiento</span>
                    <span class="status-count">{{ $suicideFollowing->count() }}</span>
                </div>
                <span class="arrow">▼</span>
            </button>
            <div class="status-content">
                @foreach($suicideFollowing as $case)
                <div class="case-card">
                    <div class="case-header">
                        <div class="case-info">
                            <div class="case-number">{{ $case->case_number }}</div>
                            <div class="case-date">Registrado el {{ optional($case->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="case-status status-following">EN SEGUIMIENTO</div>
                    </div>
                    <div class="case-section">
                        <div class="section-label">Situación reportada</div>
                        <div class="description-box">{{ trim($case->description) }}</div>
                    </div>
                    <div class="observations">
                        <div class="observations-title"><span>💬</span> Observaciones del equipo de moderación</div>
                        @if($case->comments && $case->comments->count() > 0)
                            @foreach($case->comments as $comment)
                            <div class="comment">
                                <div class="comment-meta">
                                    <span class="comment-author">
                                        @if($comment->type === 'RESPUESTA_USUARIO')
                                            Respuesta del usuario
                                        @elseif($comment->user && $comment->user->role === 'MODERATOR')
                                            Moderador
                                        @elseif($comment->user && $comment->user->role === 'ADMIN')
                                            Administrador
                                        @else
                                            Equipo de moderación
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ optional($comment->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-bubble">{{ trim($comment->comment) }}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-comments">Aún no hay observaciones de seguimiento realizadas por el equipo de moderación.</div>
                        @endif
                    </div>
                    <div class="case-reply-form">
                        <form method="POST" action="{{ route('cases.reply', $case->id) }}">
                            @csrf
                            <label for="reply-{{ $case->id }}">Tu respuesta</label>
                            <textarea id="reply-{{ $case->id }}" name="message" rows="3" maxlength="5000" required placeholder="Escribe aquí tu respuesta...">{{ old('message') }}</textarea>
                            <button type="submit">Enviar respuesta</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- CERRADOS --}}
        @if($suicideClosed->count() > 0)
        <div class="status-section">
            <button type="button" class="status-header" onclick="toggleStatus(this)">
                <div class="status-header-left">
                    <span class="status-name">Casos cerrados</span>
                    <span class="status-count">{{ $suicideClosed->count() }}</span>
                </div>
                <span class="arrow">▼</span>
            </button>
            <div class="status-content collapsed">
                @foreach($suicideClosed as $case)
                <div class="case-card">
                    <div class="case-header">
                        <div class="case-info">
                            <div class="case-number">{{ $case->case_number }}</div>
                            <div class="case-date">Registrado el {{ optional($case->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="case-status status-closed">CERRADO</div>
                    </div>
                    <div class="case-section">
                        <div class="section-label">Situación reportada</div>
                        <div class="description-box">{{ trim($case->description) }}</div>
                    </div>
                    <div class="observations">
                        <div class="observations-title"><span>💬</span> Observaciones del equipo de moderación</div>
                        @if($case->comments && $case->comments->count() > 0)
                            @foreach($case->comments as $comment)
                            <div class="comment">
                                <div class="comment-meta">
                                    <span class="comment-author">
                                        @if($comment->type === 'RESPUESTA_USUARIO')
                                            Respuesta del usuario
                                        @elseif($comment->user && $comment->user->role === 'MODERATOR')
                                            Moderador
                                        @elseif($comment->user && $comment->user->role === 'ADMIN')
                                            Administrador
                                        @else
                                            Equipo de moderación
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ optional($comment->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-bubble">{{ trim($comment->comment) }}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-comments">No hay observaciones registradas para este caso.</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- SIN CASOS DE SUICIDIO --}}
        @if($suicideCases->count() === 0)
        <div class="empty-folder">
            <div class="empty-icon">📂</div>
            <p>No tienes casos de Suicidio registrados.</p>
        </div>
        @endif

    </div>
</div>

{{-- CARPETA: ABUSO SEXUAL --}}
<div class="folder">
    <div class="folder-header">
        <div class="folder-title">
            <div class="folder-icon">📁</div>
            <div>
                <h2>Casos de Abuso sexual</h2>
                <div class="folder-count">{{ $abuseCases->count() }} {{ $abuseCases->count() === 1 ? 'caso' : 'casos' }}</div>
            </div>
        </div>
    </div>
    <div class="folder-body">

        {{-- ABIERTOS --}}
        @if($abuseOpen->count() > 0)
        <div class="status-section">
            <button type="button" class="status-header active" onclick="toggleStatus(this)">
                <div class="status-header-left">
                    <span class="status-name">Casos abiertos</span>
                    <span class="status-count">{{ $abuseOpen->count() }}</span>
                </div>
                <span class="arrow">▼</span>
            </button>
            <div class="status-content">
                @foreach($abuseOpen as $case)
                <div class="case-card">
                    <div class="case-header">
                        <div class="case-info">
                            <div class="case-number">{{ $case->case_number }}</div>
                            <div class="case-date">Registrado el {{ optional($case->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="case-status status-open">ABIERTO</div>
                    </div>
                    <div class="case-section">
                        <div class="section-label">Situación reportada</div>
                        <div class="description-box">{{ trim($case->description) }}</div>
                    </div>
                    <div class="observations">
                        <div class="observations-title"><span>💬</span> Observaciones del equipo de moderación</div>
                        @if($case->comments && $case->comments->count() > 0)
                            @foreach($case->comments as $comment)
                            <div class="comment">
                                <div class="comment-meta">
                                    <span class="comment-author">
                                        @if($comment->type === 'RESPUESTA_USUARIO')
                                            Respuesta del usuario
                                        @elseif($comment->user && $comment->user->role === 'MODERATOR')
                                            Moderador
                                        @elseif($comment->user && $comment->user->role === 'ADMIN')
                                            Administrador
                                        @else
                                            Equipo de moderación
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ optional($comment->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-bubble">{{ trim($comment->comment) }}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-comments">Aún no hay observaciones de seguimiento realizadas por el equipo de moderación.</div>
                        @endif
                    </div>
                    <div class="case-reply-form">
                        <form method="POST" action="{{ route('cases.reply', $case->id) }}">
                            @csrf
                            <label for="reply-{{ $case->id }}">Tu respuesta</label>
                            <textarea id="reply-{{ $case->id }}" name="message" rows="3" maxlength="5000" required placeholder="Escribe aquí tu respuesta...">{{ old('message') }}</textarea>
                            <button type="submit">Enviar respuesta</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- EN SEGUIMIENTO --}}
        @if($abuseFollowing->count() > 0)
        <div class="status-section">
            <button type="button" class="status-header active" onclick="toggleStatus(this)">
                <div class="status-header-left">
                    <span class="status-name">En seguimiento</span>
                    <span class="status-count">{{ $abuseFollowing->count() }}</span>
                </div>
                <span class="arrow">▼</span>
            </button>
            <div class="status-content">
                @foreach($abuseFollowing as $case)
                <div class="case-card">
                    <div class="case-header">
                        <div class="case-info">
                            <div class="case-number">{{ $case->case_number }}</div>
                            <div class="case-date">Registrado el {{ optional($case->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="case-status status-following">EN SEGUIMIENTO</div>
                    </div>
                    <div class="case-section">
                        <div class="section-label">Situación reportada</div>
                        <div class="description-box">{{ trim($case->description) }}</div>
                    </div>
                    <div class="observations">
                        <div class="observations-title"><span>💬</span> Observaciones del equipo de moderación</div>
                        @if($case->comments && $case->comments->count() > 0)
                            @foreach($case->comments as $comment)
                            <div class="comment">
                                <div class="comment-meta">
                                    <span class="comment-author">
                                        @if($comment->type === 'RESPUESTA_USUARIO')
                                            Respuesta del usuario
                                        @elseif($comment->user && $comment->user->role === 'MODERATOR')
                                            Moderador
                                        @elseif($comment->user && $comment->user->role === 'ADMIN')
                                            Administrador
                                        @else
                                            Equipo de moderación
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ optional($comment->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-bubble">{{ trim($comment->comment) }}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-comments">Aún no hay observaciones de seguimiento realizadas por el equipo de moderación.</div>
                        @endif
                    </div>
                    <div class="case-reply-form">
                        <form method="POST" action="{{ route('cases.reply', $case->id) }}">
                            @csrf
                            <label for="reply-{{ $case->id }}">Tu respuesta</label>
                            <textarea id="reply-{{ $case->id }}" name="message" rows="3" maxlength="5000" required placeholder="Escribe aquí tu respuesta...">{{ old('message') }}</textarea>
                            <button type="submit">Enviar respuesta</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- CERRADOS --}}
        @if($abuseClosed->count() > 0)
        <div class="status-section">
            <button type="button" class="status-header" onclick="toggleStatus(this)">
                <div class="status-header-left">
                    <span class="status-name">Casos cerrados</span>
                    <span class="status-count">{{ $abuseClosed->count() }}</span>
                </div>
                <span class="arrow">▼</span>
            </button>
            <div class="status-content collapsed">
                @foreach($abuseClosed as $case)
                <div class="case-card">
                    <div class="case-header">
                        <div class="case-info">
                            <div class="case-number">{{ $case->case_number }}</div>
                            <div class="case-date">Registrado el {{ optional($case->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="case-status status-closed">CERRADO</div>
                    </div>
                    <div class="case-section">
                        <div class="section-label">Situación reportada</div>
                        <div class="description-box">{{ trim($case->description) }}</div>
                    </div>
                    <div class="observations">
                        <div class="observations-title"><span>💬</span> Observaciones del equipo de moderación</div>
                        @if($case->comments && $case->comments->count() > 0)
                            @foreach($case->comments as $comment)
                            <div class="comment">
                                <div class="comment-meta">
                                    <span class="comment-author">
                                        @if($comment->type === 'RESPUESTA_USUARIO')
                                            Respuesta del usuario
                                        @elseif($comment->user && $comment->user->role === 'MODERATOR')
                                            Moderador
                                        @elseif($comment->user && $comment->user->role === 'ADMIN')
                                            Administrador
                                        @else
                                            Equipo de moderación
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ optional($comment->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-bubble">{{ trim($comment->comment) }}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-comments">No hay observaciones registradas para este caso.</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- SIN CASOS DE ABUSO --}}
        @if($abuseCases->count() === 0)
        <div class="empty-folder">
            <div class="empty-icon">📂</div>
            <p>No tienes casos de Abuso sexual registrados.</p>
        </div>
        @endif

    </div>
</div>

{{-- SIN NINGUN CASO --}}
@if($totalCases === 0)
<div class="empty-folder">
    <div class="empty-icon">📂</div>
    <p>Actualmente no tienes casos registrados.</p>
</div>
@endif
</div>{{-- /live-cases --}}
</div>
</div>

<script>
function toggleStatus(button) {
    const content = button.nextElementSibling;
    if (!content) {
        return;
    }
    const isCollapsed = content.classList.contains('collapsed');
    if (isCollapsed) {
        content.classList.remove('collapsed');
        button.classList.add('active');
    } else {
        content.classList.add('collapsed');
        button.classList.remove('active');
    }
}
</script>
@include('partials.live-refresh')
<script>
umgLive.whenEchoReady(function (echo) {
    const userUuid = @json(auth()->user()->uuid);
    const container = document.getElementById('live-cases');

    if (!container) {
        return;
    }

    function sectionKey(header) {
        const folder = header.closest('.folder');
        const title = folder && folder.querySelector('.folder-title h2');
        const name = header.querySelector('.status-name');

        return (title ? title.textContent.trim() : '') + '|' +
               (name ? name.textContent.trim() : '');
    }

    // Guarda lo que el usuario está haciendo para no perderlo al refrescar.
    function takeSnapshot() {
        const drafts = {};
        const open = {};

        container.querySelectorAll('textarea[id^="reply-"]').forEach(function (area) {
            if (area.value) {
                drafts[area.id] = area.value;
            }
        });

        container.querySelectorAll('.status-header').forEach(function (header) {
            open[sectionKey(header)] = header.classList.contains('active');
        });

        const active = document.activeElement;
        const focus = active && active.id && container.contains(active)
            ? { id: active.id, start: active.selectionStart, end: active.selectionEnd }
            : null;

        return { drafts: drafts, open: open, focus: focus, scrollY: window.scrollY };
    }

    function restoreSnapshot(state) {
        container.querySelectorAll('.status-header').forEach(function (header) {
            const key = sectionKey(header);
            const content = header.nextElementSibling;

            if (!(key in state.open) || !content) {
                return;
            }

            header.classList.toggle('active', state.open[key]);
            content.classList.toggle('collapsed', !state.open[key]);
        });

        Object.keys(state.drafts).forEach(function (id) {
            const area = document.getElementById(id);

            if (area) {
                area.value = state.drafts[id];
            }
        });

        if (state.focus) {
            const element = document.getElementById(state.focus.id);

            if (element) {
                element.focus();

                try {
                    element.setSelectionRange(state.focus.start, state.focus.end);
                } catch (error) { /* no aplica */ }
            }
        }

        window.scrollTo(0, state.scrollY);
    }

    const refresher = umgLive.createRefresher({
        apply: function (doc) {
            const fresh = doc.getElementById('live-cases');

            if (!fresh) {
                return;
            }

            const state = takeSnapshot();
            container.innerHTML = fresh.innerHTML;
            restoreSnapshot(state);
        }
    });

    umgLive.listen(echo, 'user.' + userUuid, '.case.activity.updated', refresher.trigger);
    umgLive.onReconnect(echo, refresher.trigger);
});
</script>
</body>
</html>