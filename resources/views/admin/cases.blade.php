<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Casos</title>
</head>
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

.stat-box{
    background:#334155;
    padding:20px;
    border-radius:12px;
    margin-bottom:15px;
}

.view-btn{
    color:#38bdf8;
    font-size:20px;
}

.edit-btn{
    color:#facc15;
    margin-left:15px;
    font-size:20px;
}

.delete-btn{
    color:#ef4444;
    margin-left:15px;
    font-size:20px;
}

</style>
<body>
<div class="container">

<a href="/admin-panel" class="back-btn">
    <i class="fas fa-arrow-left"></i>
    Regresar
</a>

<div class="card">
<h2>Gestión de Casos</h2>

<table>

<thead>

<tr>
    <th>Número</th>
    <th>Tema</th>
    <th>Moderador</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

</thead>

<tbody>

@foreach($cases as $case)

<tr>

<td>{{ $case->case_number }}</td>

<td>{{ $case->topic }}</td>

<td>{{ $case->moderator_uuid }}</td>

<td>{{ $case->created_at }}</td>

<td>{{ $case->status }}</td>

<td>

<a href="/admin/case/{{ $case->id }}"
class="view-btn">

<i class="fas fa-eye"></i>

</a>

<a href="/admin/case/edit/{{ $case->id }}"
class="edit-btn">
<i class="fas fa-pen"></i>
</a>

<a href="/admin/case/delete/{{ $case->id }}"
class="delete-btn">
<i class="fas fa-trash"></i>
</a>

</td>

</tr>

@endforeach

</tbody>

</table>
</div>
</div>
</body>
</html>