<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Moderadores</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    font-family:Poppins,sans-serif;
    background:#0f172a;
    color:white;
    margin:0;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:white;
    text-decoration:none;
    margin-bottom:25px;
    background:#1e293b;
    padding:12px 20px;
    border-radius:12px;
}

.card{
    background:#1e293b;
    padding:30px;
    border-radius:20px;
}

h1{
    margin-bottom:25px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:15px;
    text-align:left;
}

th{
    background:#334155;
}

tr:nth-child(even){
    background:#263449;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    margin-top:20px;
}

.form-grid input{
    padding:14px;
    border:none;
    border-radius:10px;
    background:#334155;
    color:white;
}

.form-grid button{
    background:#2563eb;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.form-grid button:hover{
    background:#1d4ed8;
}

</style>

</head>
<body>

<div class="container">

<a href="/admin-panel" class="back-btn">
    <i class="fas fa-arrow-left"></i>
    Regresar
</a>

<div class="card">

<h2>
<i class="fas fa-user-shield"></i>
Agregar Moderador
</h2>

<form action="/moderator/create" method="POST">

@csrf

<div class="form-grid">

<input
type="text"
name="first_name"
placeholder="Nombre"
required>

<input
type="text"
name="last_name"
placeholder="Apellido"
required>

<input
type="email"
name="email"
placeholder="Correo"
required>

<input
type="password"
name="password"
placeholder="Contraseña"
required>

<input
type="text"
name="phone"
placeholder="Celular"
required>

<button type="submit">
Crear
</button>

</div>

</form>

</div>

<h1>Moderadores</h1>

<table>

<thead>
<tr>
    <th>Código Único</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Email</th>
    <th>Celular</th>
    </tr>
</thead>

<tbody>

@foreach($moderators as $moderator)

<tr>

    <td>
        {{ $moderator->anonymous_nickname }}
    </td>

    <td>
        {{ $moderator->first_name }}
    </td>

    <td>
        {{ $moderator->last_name }}
    </td>

    <td>
        {{ $moderator->email }}
    </td>

    <td>
        {{ $moderator->phone }}
    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</body>
</html>