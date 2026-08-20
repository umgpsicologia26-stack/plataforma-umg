<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Seguimiento de Casos</title>

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
padding:40px;
color:white;
}

.container{
max-width:900px;
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
font-size:42px;
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
margin-bottom:25px;
}

input{
width:100%;
padding:16px;

border:none;
border-radius:16px;

background:rgba(255,255,255,.06);

color:white;
font-size:16px;
outline:none;
}

input::placeholder{
color:#cbd5e1;
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
transition:.3s;
}

button:hover{
background:#38bdf8;
transform:translateY(-2px);
}

@media(max-width:800px){

.form-grid{
grid-template-columns:1fr;
}

.title{
font-size:34px;
}

}

</style>
</head>

<body>

<div class="container">

<div class="card">

<div class="title-row">

<a href="/dashboard" class="back">←</a>

<h1 class="title">
Seguimiento de Casos
</h1>

</div>

<p class="subtitle">
Ingresa tu nombre de usuario y número de caso para consultar el estado y seguimiento.
</p>

<form>

<div class="form-grid">

<input type="text"
placeholder="Nombre del usuario">
<input type="text"
placeholder="Numero de caso">

</div>

<button type="submit">
Ver Seguimiento
</button>

</form>

</div>

</div>

</body>
</html>