<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Evaluación Emocional</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:
    linear-gradient(rgba(8,15,35,.94),rgba(8,15,35,.96)),
    url('https://images.unsplash.com/photo-1493836512294-502baa1986e2?q=80&w=2070&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
    min-height:100vh;
    color:white;
    padding:40px;
}

.container{
    max-width:1000px;
    margin:auto;
}

.card{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    border-radius:30px;
    padding:40px;
    border:1px solid rgba(255,255,255,.08);
}

.title-row{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:20px;
}

.back{
    color:#7dd3fc;
    text-decoration:none;
    font-size:34px;
}

.title{
    font-size:46px;
    font-weight:700;
}

.subtitle{
    color:#cbd5e1;
    margin-bottom:35px;
    line-height:1.8;
}

.question{
    margin-bottom:30px;
}

.question h3{
    margin-bottom:15px;
}

.options{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.option{
    background:rgba(255,255,255,.05);
    padding:16px;
    border-radius:15px;
}

button{
    width:100%;
    border:none;
    background:#7dd3fc;
    color:#081323;
    padding:18px;
    border-radius:18px;
    font-size:18px;
    font-weight:700;
    cursor:pointer;
    margin-top:20px;
}

button:hover{
    background:#38bdf8;
}

</style>
</head>
<body>

<div class="container">

<div class="card">

<div class="title-row">

<a href="/dashboard" class="back">←</a>

<h1 class="title">
Evaluación Emocional
</h1>

</div>

<p class="subtitle">
Responde esta evaluación emocional para identificar posibles señales de ansiedad,
estrés o depresión.
</p>

<form>

<div class="question">

<h3>1. ¿Cómo te has sentido esta semana?</h3>

<div class="options">
<label class="option"><input type="radio" name="q1"> Muy bien</label>
<label class="option"><input type="radio" name="q1"> Normal</label>
<label class="option"><input type="radio" name="q1"> Triste</label>
<label class="option"><input type="radio" name="q1"> Muy mal</label>
</div>

</div>

<div class="question">

<h3>2. ¿Has sentido ansiedad o miedo constante?</h3>

<div class="options">
<label class="option"><input type="radio" name="q2"> Nunca</label>
<label class="option"><input type="radio" name="q2"> Algunas veces</label>
<label class="option"><input type="radio" name="q2"> Frecuentemente</label>
</div>

</div>

<div class="question">

<h3>3. ¿Has pensado en hacerte daño?</h3>

<div class="options">
<label class="option"><input type="radio" name="q3"> No</label>
<label class="option"><input type="radio" name="q3"> Algunas veces</label>
<label class="option"><input type="radio" name="q3"> Sí</label>
</div>

</div>

<button type="submit">
Finalizar Evaluación
</button>

</form>

</div>

</div>

</body>
</html>