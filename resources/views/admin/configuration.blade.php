<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Configuración</title>

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
    max-width:1000px;
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

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

input[type="text"]{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#334155;
    color:white;
}

.checkbox-group{
    margin:15px 0;
}

.checkbox-group label{
    display:flex;
    align-items:center;
    gap:10px;
    cursor:pointer;
}

.save-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:14px 24px;
    border-radius:12px;
    cursor:pointer;
    font-weight:600;
}

.save-btn:hover{
    background:#1d4ed8;
}

.alert-success{
    background:#16a34a;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
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

<h1>Configuración del Sistema</h1>

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

<form action="/admin/configuration/save" method="POST">
    @csrf

    <div class="form-group">
        <label>Nombre del Sistema</label>
        <input
            type="text"
            name="system_name"
            value="{{ $settings->system_name }}">
    </div>

    <div class="checkbox-group">
        <label>
            <input
                type="checkbox"
                name="forum_enabled"
                {{ $settings->forum_enabled ? 'checked' : '' }}>
            Habilitar Foro
        </label>
    </div>

    <div class="checkbox-group">
        <label>
            <input
                type="checkbox"
                name="panic_enabled"
                {{ $settings->panic_enabled ? 'checked' : '' }}>
            Habilitar Botón de Pánico
        </label>
    </div>

    <div class="checkbox-group">
        <label>
            <input
                type="checkbox"
                name="registration_enabled"
                {{ $settings->registration_enabled ? 'checked' : '' }}>
            Permitir Registro de Usuarios
        </label>
    </div>

    <button type="submit" class="save-btn">
        Guardar Configuración
    </button>

</form>

</div>
</div>

</body>
</html>