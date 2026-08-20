<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
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

.action-btn{
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-size:13px;
    margin-right:5px;
    display:inline-block;
}

.activate{
    background:#16a34a;
}

.suspend{
    background:#ea580c;
}

.delete{
    background:#dc2626;
}

.activate:hover{
    background:#15803d;
}

.suspend:hover{
    background:#c2410c;
}

.delete:hover{
    background:#b91c1c;
}

.restore{
    background:#2563eb;
}

.restore:hover{
    background:#1d4ed8;
}

td:last-child{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
}

</style>
<body>
<div class="container">

<a href="/admin-panel" class="back-btn">
    <i class="fas fa-arrow-left"></i>
    Regresar
</a>

<div class="card">

<h2>Usuarios Registrados</h2>

<table>

<thead>
<tr>
    <th>Código Único</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Correo</th>
    <th>Teléfono</th>
    <th>Estado</th>
    <th>Fecha Registro</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>

@foreach($users as $user)

<tr>

    <td>{{ $user->uuid }}</td>

    <td>{{ $user->first_name }}</td>

    <td>{{ $user->last_name }}</td>

    <td>{{ $user->email }}</td>

    <td>{{ $user->phone }}</td>

    <td>
    @if($user->status == 'ACTIVO')
        
    @elseif($user->status == 'SUSPENDIDO')
        

    @elseif($user->status == 'INACTIVO')
        

    @else
        {{ $user->status }}
    @endif
</td>

    <td>{{ $user->created_at }}</td>

    <td>

        <a href="/admin/user/{{$user->id}}/activate"
        class="action-btn activate">
        Activar
        </a>

        <a href="/admin/user/{{$user->id}}/suspend"
        class="action-btn suspend">
        Suspender
        </a>

        <a href="/admin/user/{{$user->id}}/delete"
        class="action-btn delete">
        Eliminar
        </a>

        <a href="/admin/user/{{$user->id}}/restore"
        class="action-btn restore">
        Restaurar
        </a>

    </td>

</tr>

@endforeach
</tbody>

</table>
