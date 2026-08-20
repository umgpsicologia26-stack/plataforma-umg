<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Caso</title>
</head>

<body>

<h1>Editar Caso</h1>

<form action="/case/{{ $case->id }}" method="POST">

    @csrf
    @method('PUT')

    <label>Tema</label>
    <input
        type="text"
        name="type"
        value="{{ $case->type }}">

    <br><br>

    <label>Estado</label>

    <select name="status">

        <option value="ABIERTO"
            {{ $case->status == 'ABIERTO' ? 'selected' : '' }}>
            Abierto
        </option>

        <option value="EN_PROCESO"
            {{ $case->status == 'EN_PROCESO' ? 'selected' : '' }}>
            En Proceso
        </option>

        <option value="TERMINADO"
            {{ $case->status == 'TERMINADO' ? 'selected' : '' }}>
            Terminado
        </option>

    </select>

    <br><br>

    <button type="submit">
        Guardar Cambios
    </button>

</form>

</body>
</html>