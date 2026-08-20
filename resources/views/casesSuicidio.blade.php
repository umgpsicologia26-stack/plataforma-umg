<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Casos</title>

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
linear-gradient(rgba(7,15,35,.94),rgba(7,15,35,.96)),
url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop');

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

.card{
background:rgba(255,255,255,.08);
backdrop-filter:blur(18px);
padding:40px;
border-radius:30px;
}

.title-row{
display:flex;
align-items:center;
gap:15px;
margin-bottom:20px;
}

.back{
font-size:34px;
text-decoration:none;
color:#7dd3fc;
}

.title{
font-size:46px;
font-weight:700;
}

.subtitle{
color:#cbd5e1;
line-height:1.8;
margin-bottom:35px;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
margin-bottom:20px;
}

input,
select,
textarea{
width:100%;
padding:16px;
border:none;
border-radius:16px;
background:rgba(255,255,255,.06);
color:white;
}

textarea{
height:140px;
resize:none;
}

button{
width:100%;
padding:18px;
border:none;
border-radius:18px;
background:#7dd3fc;
color:#081323;
font-weight:700;
font-size:18px;
cursor:pointer;
}

button:hover{
background:#38bdf8;
}

.case-card{
margin-top:30px;
padding:25px;
background:rgba(255,255,255,.05);
border-radius:20px;
}

.case-number{
color:#7dd3fc;
font-size:22px;
font-weight:700;
margin-bottom:10px;
}

</style>
</head>
<body>

<div class="container">

<div class="card">

<div class="title-row">

<a href="/dashboard" class="back">←</a>

<h1 class="title">
Creación de Caso
</h1>

</div>

<p class="subtitle">
Comentanos tu caso y obtén un seguimiento mediante número de caso.
</p>

<form method="POST" action="{{ url('/cases/suicide') }}">
    @csrf

<textarea
name="description"
placeholder="Describe tu situación">
</textarea>

<button type="submit">
Crear Caso
</button>

</form>

</div>

</div>

</div>

</body>
</html>