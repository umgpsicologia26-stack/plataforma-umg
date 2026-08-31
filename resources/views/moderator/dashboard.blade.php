<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel del Moderador</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

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
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            min-height: 100vh;
            color: #1e293b;
        }

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

            box-shadow: 0 10px 30px rgba(0,0,0,.08);
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

            display: flex;
            align-items: center;
            justify-content: center;

            background: #2563eb;
            color: white;

            font-size: 22px;
        }

        .brand h2 {
            font-size: 20px;
            color: #1e3a8a;
        }

        .brand span {
            display: block;
            font-size: 12px;
            color: #64748b;
        }

        .logout-btn {
            border: none;

            background: #ef4444;
            color: white;

            padding: 11px 20px;

            border-radius: 12px;

            font-family: 'Poppins', sans-serif;
            font-weight: 600;

            cursor: pointer;

            transition: .2s;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        .container {
            width: 95%;
            max-width: 1400px;

            margin: 40px auto;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 32px;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #64748b;
        }

        .role-badge {
            display: inline-block;

            margin-top: 12px;

            padding: 7px 14px;

            border-radius: 20px;

            background: #dbeafe;
            color: #1d4ed8;

            font-size: 12px;
            font-weight: 700;
        }

        .cards {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(300px, 1fr));

            gap: 25px;
        }

        .card {
            background: white;

            border-radius: 25px;

            padding: 35px;

            text-decoration: none;

            color: inherit;

            box-shadow:
                0 15px 40px rgba(0,0,0,.08);

            transition: .3s;

            position: relative;

            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-6px);

            box-shadow:
                0 20px 45px rgba(0,0,0,.12);
        }

        .card-icon {
            width: 65px;
            height: 65px;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;
            color: #2563eb;

            font-size: 28px;

            margin-bottom: 22px;
        }

        .card h2 {
            font-size: 22px;

            margin-bottom: 10px;

            color: #0f172a;
        }

        .card p {
            color: #64748b;

            line-height: 1.7;

            font-size: 14px;
        }

        .card-link {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-top: 22px;

            color: #2563eb;

            font-weight: 700;

            font-size: 14px;
        }

        /* CHAT */

        .chat-card .card-icon {
            background: #ecfdf5;
            color: #059669;
        }

        .chat-card .card-link {
            color: #059669;
        }

        /* NOTIFICACIÓN */

        .new-message-badge {
            position: absolute;

            top: 22px;
            right: 22px;

            display: flex;

            align-items: center;

            gap: 6px;

            background: #fee2e2;

            color: #b91c1c;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 800;

            animation: pulse 1.8s infinite;
        }

        .new-message-badge i {
            font-size: 9px;
        }

        @keyframes pulse {

            0% {
                box-shadow: 0 0 0 0 rgba(220,38,38,.35);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(220,38,38,0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220,38,38,0);
            }

        }

        .no-new-message {
            position: absolute;

            top: 22px;
            right: 22px;

            background: #dcfce7;

            color: #166534;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 700;
        }

        @media(max-width: 700px) {

            .navbar {
                width: 92%;
            }

            .container {
                width: 92%;
            }

            .welcome h1 {
                font-size: 26px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


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

    <form
        method="POST"
        action="{{ url('/logout') }}">

        @csrf

        <button
            type="submit"
            class="logout-btn">

            <i class="fas fa-right-from-bracket"></i>

            Cerrar sesión

        </button>

    </form>

</nav>

<main class="container">

    <div class="welcome">

        <h1>

            Bienvenido,
            {{ auth()->user()->full_name }}

        </h1>

        <p>
            Desde este panel puedes gestionar los casos asignados,
            atender conversaciones de usuarios y supervisar
            el contenido del foro.
        </p>

        <span class="role-badge">

            MODERADOR

        </span>

    </div>

    <div class="cards">

    {{-- CHAT --}}

        <a
            href="{{ route('moderator.chats') }}"
            class="card chat-card">

            {{-- NOTIFICACIÓN DE MENSAJES NUEVOS --}}

            @if(isset($newConversationsCount) && $newConversationsCount > 0)

                <div class="new-message-badge">

                    <i class="fas fa-circle"></i>

                    {{ $newConversationsCount }}

                    {{ $newConversationsCount == 1
                        ? 'mensaje nuevo'
                        : 'mensajes nuevos'
                    }}

                </div>

            @else

                <div class="no-new-message">

                    <i class="fas fa-check-circle"></i>

                    Sin mensajes nuevos

                </div>

            @endif

            <div class="card-icon">

                <i class="fas fa-headset"></i>

            </div>

            <h2>
                Chat con usuarios
            </h2>

            <p>
                Atiende las conversaciones de los usuarios
                que han solicitado hablar con una persona.
                Puedes revisar los mensajes enviados y
                responder directamente desde la plataforma.
            </p>


            <div class="card-link">

                Ver conversaciones

                <i class="fas fa-arrow-right"></i>

            </div>


        </a>

        {{-- MIS CASOS --}}

        <a
            href="{{ route('moderator.cases') }}"
            class="card">

            <div class="card-icon">

                <i class="fas fa-folder-open"></i>

            </div>

            <h2>
                Mis casos
            </h2>

            <p>
                Consulta los casos asignados, revisa la
                información proporcionada por el usuario
                y realiza el seguimiento correspondiente.
            </p>


            <div class="card-link">

                Ver mis casos

                <i class="fas fa-arrow-right"></i>

            </div>

        </a>


        {{-- FORO --}}

        <a
            href="{{ route('forum.index') }}"
            class="card">

            <div class="card-icon">

                <i class="fas fa-comments"></i>

            </div>

            <h2>

                Foro

            </h2>

            <p>
                Supervisa las publicaciones del foro y
                restringe contenido ofensivo, delicado,
                inapropiado o que incite a la violencia.
            </p>

            <div class="card-link">

                Ir al foro

                <i class="fas fa-arrow-right"></i>

            </div>

        </a>

    </div>

</main>

</body>

</html>