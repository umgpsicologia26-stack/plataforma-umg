<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
</head>
<body>

<h1>Panel de Administración</h1>

<h2>Crear Moderador</h2>

<form method="POST" action="/moderator/create">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required>
    <input type="email" name="email" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Crear</button>
</form>

<hr>

<h2>Moderadores</h2>

@foreach($moderators as $mod)
<div>
    {{ $mod->name }} - {{ $mod->email }}

    <form method="POST" action="/moderator/{{ $mod->id }}">
        @csrf
        @method('DELETE')
        <button>Eliminar</button>
    </form>
</div>
@endforeach

<hr>

<h2>Casos</h2>

@foreach($cases as $case)
<div>
    Caso: {{ $case->case_number }}

    <form method="POST" action="/case/{{ $case->id }}">
        @csrf
        @method('PUT')

        <select name="status">
            <option>En seguimiento</option>
            <option>Terminado</option>
        </select>

        <button>Actualizar</button>
    </form>
</div>
@endforeach

</body>
</html>