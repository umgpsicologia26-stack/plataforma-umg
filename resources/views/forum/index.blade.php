<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro Anónimo</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins', sans-serif;
            background:
                linear-gradient(rgba(8,15,35,0.94), rgba(8,15,35,0.96)),
                url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop');
            background-size:cover;
            background-position:center;
            min-height:100vh;
            color:white;
            padding:40px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .glass-card{
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(18px);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:28px;
            padding:40px;
            box-shadow:0 20px 50px rgba(0,0,0,0.35);
        }

        .title-row{
            display:flex;
            align-items:center;
            gap:15px;
            margin-bottom:12px;
        }

        .back-arrow{
            text-decoration:none;
            color:#7dd3fc;
            font-size:34px;
            font-weight:bold;
            transition:0.3s;
        }

        .back-arrow:hover{
            color:#38bdf8;
            transform:translateX(-5px);
        }

        .title{
            font-size:48px;
            font-weight:700;
            margin:0;
        }

        .subtitle{
            color:#cbd5e1;
            margin-bottom:40px;
            font-size:17px;
            line-height:1.7;
            max-width:800px;
        }

        .forum-form{
            display:flex;
            flex-direction:column;
            gap:20px;
            margin-bottom:50px;
        }

        .forum-form select,
        .forum-form textarea{
            width:100%;
            border:none;
            outline:none;
            border-radius:18px;
            background:rgba(255,255,255,0.07);
            color:white;
            padding:18px;
            font-size:15px;
            border:1px solid rgba(255,255,255,0.08);
        }

        .forum-form textarea{
            min-height:140px;
            resize:none;
        }

        .forum-form select option{
            color:black;
        }

        .publish-btn{
            width:220px;
            border:none;
            background:#7dd3fc;
            color:#081323;
            padding:16px;
            border-radius:18px;
            font-size:16px;
            font-weight:700;
            cursor:pointer;
            transition:0.3s;
        }

        .publish-btn:hover{
            background:#38bdf8;
            transform:translateY(-4px);
        }

        .messages{
            display:flex;
            flex-direction:column;
            gap:25px;
        }

        .message-card{
            background:rgba(255,255,255,0.06);
            border:1px solid rgba(255,255,255,0.08);
            padding:28px;
            border-radius:24px;
            transition:0.3s;
        }

        .message-card:hover{
            transform:translateY(-5px);
            background:rgba(125,211,252,0.08);
        }

        .message-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:18px;
            flex-wrap:wrap;
            gap:10px;
        }

        .anonymous{
            color:#7dd3fc;
            font-weight:700;
            font-size:16px;
        }

        .category{
            background:rgba(125,211,252,0.15);
            color:#7dd3fc;
            padding:8px 14px;
            border-radius:12px;
            font-size:13px;
            font-weight:600;
        }

        .message-content{
            color:#f1f5f9;
            line-height:1.8;
            font-size:15px;
        }

        .empty{
            text-align:center;
            color:#cbd5e1;
            margin-top:30px;
            font-size:16px;
        }

        @media(max-width:768px){

            body{
                padding:20px;
            }

            .title{
                font-size:34px;
            }

            .glass-card{
                padding:25px;
            }

            .publish-btn{
                width:100%;
            }

        }

        .identity-box{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:18px;
    padding:20px;
}

.identity-title{
    font-size:16px;
    font-weight:600;
    margin-bottom:15px;
    color:#f8fafc;
}

.identity-options{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.identity-option{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 16px;
    border-radius:14px;
    background:rgba(255,255,255,0.05);
    cursor:pointer;
    transition:0.3s;
}

.identity-option:hover{
    background:rgba(125,211,252,0.12);
}

.identity-option input{
    accent-color:#7dd3fc;
}

.identity-box small{
    display:block;
    margin-top:12px;
    color:#94a3b8;
    line-height:1.5;
}

.restrict-btn{
    border:none;
    background:rgba(248,113,113,0.15);
    color:#fca5a5;
    padding:8px 14px;
    border-radius:10px;
    cursor:pointer;
    font-size:12px;
    font-weight:600;
}

.restrict-btn:hover{
    background:rgba(248,113,113,0.25);
}

.message-date{
    margin-top:15px;
    color:#64748b;
    font-size:12px;
}

    </style>
</head>
<body>

    <div class="container">

        <div class="glass-card">

            <div class="title-row">

                <a href="/dashboard" class="back-arrow">
                    ←
                </a>

                <h1 class="title">
                    Foro Anónimo
                </h1>

            </div>

            <p class="subtitle">
                Comparte tus pensamientos, emociones y experiencias en un entorno seguro,
                confidencial y libre de juicios. Tu identidad permanece protegida.
            </p>

            <form action="/forum/create" method="POST" class="forum-form">

    @csrf

    <div class="identity-box">

        <div class="identity-title">
            ¿Cómo deseas aparecer en el foro?
        </div>

        <div class="identity-options">

            <label class="identity-option">

                <input
                    type="radio"
                    name="identity_type"
                    value="name"
                    checked
                >

                <span>
                    Usar mi nombre
                </span>

            </label>


            <label class="identity-option">

                <input
                    type="radio"
                    name="identity_type"
                    value="nickname"
                >

                <span>
                    Usar mi nickname
                </span>

            </label>

        </div>

        <small>
            Puedes elegir cómo deseas aparecer públicamente
            en el foro. Tu cuenta seguirá vinculada internamente
            a tu identidad real.
        </small>

    </div>


    <textarea
        name="content"
        placeholder="Escribe aquí lo que deseas compartir..."
        required
    ></textarea>


    <button
        type="submit"
        class="publish-btn"
    >
        Publicar Mensaje
    </button>

</form>

            <div class="messages">

                @forelse($messages as $message)

                    <div class="message-card">

                        <div class="message-header">

                            <div class="anonymous">
                        @if($message->is_anonymous)
                        {{ $message->user->anonymous_nickname ?? 'Usuario Anónimo' }}
    @else
        {{ $message->user->full_name ?? 'Usuario' }}
    @endif

</div>

                            <div class="category">
                                {{ $message->category }}
                            </div>

                        </div>

                        <div class="message-content">
                            {{ $message->content }}
                        </div>

                    </div>

                @empty

                    <div class="empty">
                        Aún no hay publicaciones en el foro.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</body>
</html>