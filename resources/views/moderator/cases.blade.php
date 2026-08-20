<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Casos asignados</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(
                    rgba(7,15,35,.95),
                    rgba(7,15,35,.97)
                ),
                url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop');

            background-size: cover;
            background-position: center;

            color: white;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            margin-bottom: 35px;
        }

        .back {
            display: inline-block;
            color: #7dd3fc;
            text-decoration: none;
            font-size: 18px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #cbd5e1;
        }

        .success {
            background: rgba(34,197,94,.15);
            border: 1px solid rgba(34,197,94,.4);
            color: #86efac;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .empty {
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(18px);
            border-radius: 25px;
            padding: 50px;
            text-align: center;
            color: #cbd5e1;
        }

        .empty-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }

        .cases-grid {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(320px, 1fr));

            gap: 25px;
        }

        .case-card {
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(18px);

            border: 1px solid rgba(255,255,255,.1);

            border-radius: 25px;

            padding: 28px;

            transition: .25s;
        }

        .case-card:hover {
            transform: translateY(-4px);
            background: rgba(255,255,255,.11);
        }

        .case-number {
            color: #7dd3fc;
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .info {
            margin-bottom: 12px;
            color: #cbd5e1;
        }

        .info strong {
            color: white;
        }

        .description {
            margin-top: 20px;
            padding: 15px;

            background: rgba(0,0,0,.15);

            border-radius: 15px;

            color: #e2e8f0;

            line-height: 1.6;
        }

        .status {
            display: inline-block;

            margin-top: 15px;

            padding: 7px 14px;

            border-radius: 20px;

            background: rgba(125,211,252,.15);

            color: #7dd3fc;

            font-size: 14px;
        }

        .btn {
            display: block;

            margin-top: 22px;

            text-align: center;

            padding: 13px;

            border-radius: 14px;

            background: #7dd3fc;

            color: #081323;

            text-decoration: none;

            font-weight: 700;
        }

        .btn:hover {
            background: #38bdf8;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <a
            href="{{ route('dashboard') }}"
            class="back">

            ← Volver al dashboard

        </a>

        <h1>
            Casos asignados
        </h1>

        <p class="subtitle">
            Aquí puedes consultar y dar seguimiento a los casos
            que han sido asignados a tu cuenta.
        </p>

    </div>


    @if(session('success'))

        <div class="success">

            {{ session('success') }}

        </div>

    @endif


    @if($cases->isEmpty())

        <div class="empty">

            <div class="empty-icon">
                📂
            </div>

            <h2>
                No tienes casos asignados
            </h2>

            <p style="margin-top:10px;">
                Cuando se te asigne un caso aparecerá
                automáticamente en esta sección.
            </p>

        </div>

    @else

        <div class="cases-grid">

            @foreach($cases as $case)

                <div class="case-card">

                    <div class="case-number">

                        {{ $case->case_number }}

                    </div>


                    <div class="info">

                        <strong>Tipo:</strong>

                        {{ $case->type }}

                    </div>


                    <div class="info">

                        <strong>Fecha:</strong>

                        {{ $case->created_at?->format('d/m/Y H:i') }}

                    </div>


                    <div class="info">

                        <strong>Usuario:</strong>

                        {{ $case->user?->anonymous_nickname ?? 'Usuario' }}

                    </div>


                    <div class="description">

                        {{ $case->description }}

                    </div>


                    <span class="status">

                        {{ $case->status }}

                    </span>


                    <a
                        href="{{ route('moderator.case', $case->id) }}"
                        class="btn">

                        Ver y dar seguimiento

                    </a>

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>

</html>