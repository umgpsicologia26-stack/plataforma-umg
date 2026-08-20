<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detalle del Caso</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background:#0f172a;
    color:white;
    font-family:Poppins,sans-serif;
    margin:0;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

.card{
    background:#1e293b;
    border-radius:20px;
    padding:30px;
    margin-bottom:25px;
}

.section-title{
    margin-top:0;
    margin-bottom:20px;
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:15px;
}

.info-box{
    background:#334155;
    padding:15px;
    border-radius:12px;
}

.description{
    background:#334155;
    padding:20px;
    border-radius:12px;
    margin-top:15px;
    line-height:1.8;
}

.timeline{
    margin-top:20px;
}

.timeline-item{
    background:#334155;
    padding:15px;
    border-radius:12px;
    margin-bottom:12px;
}

.timeline-item i{
    margin-right:10px;
}

.colors{
    display:flex;
    gap:15px;
    margin-top:15px;
}

.color{
    width:40px;
    height:40px;
    border-radius:50%;
    border:none;
    cursor:pointer;
}

.red{
    background:#ef4444;
}

.yellow{
    background:#facc15;
}

.green{
    background:#22c55e;
}

.blue{
    background:#3b82f6;
}

textarea{
    width:100%;
    min-height:120px;
    background:#334155;
    color:white;
    border:none;
    border-radius:12px;
    padding:15px;
    margin-top:10px;
}

select{
    width:100%;
    margin-top:15px;
    padding:12px;
    border:none;
    border-radius:10px;
}

.btn{
    display:inline-block;
    margin-top:15px;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    border:none;
    cursor:pointer;
}

.btn-save{
    background:#2563eb;
}

.btn-finish{
    background:#f59e0b;
}

.btn-approve{
    background:#16a34a;
}

.comment-card{
    background:#334155;
    padding:15px;
    border-radius:12px;
    margin-bottom:15px;
}

.badge{
    width:15px;
    height:15px;
    display:inline-block;
    border-radius:50%;
    margin-right:8px;
}

.approved-stamp{

    border:4px solid #22c55e;
    color:#22c55e;
    font-size:32px;
    font-weight:bold;
    width:260px;
    padding:20px;
    text-align:center;
    transform:rotate(-8deg);
    margin-top:30px;
}

.notifications{
    margin-top:20px;
}

.notification{
    background:#334155;
    padding:15px;
    border-radius:12px;
    margin-bottom:10px;
}

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.7);
}

.modal-content{
    background:#1e293b;
    width:600px;
    max-width:90%;
    margin:100px auto;
    padding:25px;
    border-radius:15px;
}

.close{
    float:right;
    cursor:pointer;
    font-size:22px;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h1>{{ $case->topic }}</h1>

<div class="info-grid">

<div class="info-box">
<strong>Número:</strong><br>
{{ $case->case_number }}
</div>

<div class="info-box">
<strong>Estado:</strong><br>

@if($case->status == 'ABIERTO')
<span style="color:#f59e0b;">ABIERTO</span>
@endif

@if($case->status == 'EN_REVISION')
<span style="color:#38bdf8;">EN REVISIÓN</span>
@endif

@if($case->status == 'CORREGIDO')
<span style="color:#22c55e;">CORREGIDO</span>
@endif

@if($case->status == 'PENDIENTE_APROBACION')
<span style="color:#facc15;">PENDIENTE APROBACIÓN</span>
@endif

@if($case->status == 'CERRADO')
<span style="color:#22c55e;">CERRADO</span>
@endif

</div>

<div class="info-box">
<strong>Prioridad:</strong><br>
{{ $case->priority }}
</div>

<div class="info-box">
<strong>Moderador:</strong><br>
{{ $case->moderator_uuid }}
</div>

</div>

</div>

<div class="card">

<h2 class="section-title">
<i class="fas fa-align-left"></i>
Descripción del Caso
</h2>

<div class="description">
{{ $case->description }}
</div>

</div>

<div class="card">

<h2>
<i class="fas fa-clock"></i>
Línea de Tiempo
</h2>

<div class="timeline">

<div class="timeline-item">
<i class="fas fa-file-circle-plus"></i>
Caso creado
<br>
{{ $case->created_at }}
</div>

<div class="timeline-item">
<i class="fas fa-pen"></i>
Última actualización
<br>
{{ $case->updated_at }}
</div>

</div>

</div>

<div class="card">

<h2>Observaciones del Administrador</h2>

<form action="/admin/case/comment/{{ $case->id }}"
method="POST">

@csrf

<textarea
name="comment"
placeholder="Escribir observación..."
required></textarea>

<select name="color">

<option value="red">
Error crítico
</option>

<option value="yellow">
Revisar
</option>

<option value="green">
Correcto
</option>

<option value="blue">
Observación
</option>

</select>

<button
class="btn btn-save"
type="submit">

Guardar Observación

</button>

</form>

</div>

<div class="card">

<h2>Corrección del Moderador</h2>

<div class="colors">

<button class="color red" title="Error"></button>

<button class="color yellow" title="Revisar"></button>

<button class="color green" title="Correcto"></button>

<button class="color blue" title="Información"></button>

</div>

<br>

<a
href="/admin/case/{{ $case->id }}/finish"
class="btn btn-finish">

Marcar como Terminado

</a>

</div>

<div class="card">

<h2>Historial de Correcciones</h2>

@forelse($comments as $comment)

<div class="comment-card">

<span class="badge {{ $comment->color }}"></span>

<strong>
{{ $comment->user->first_name ?? 'Administrador' }}
</strong>

<p>
{{ $comment->comment }}
</p>

<small>
{{ $comment->created_at }}
</small>

</div>

@empty

<p>No hay correcciones registradas.</p>

@endforelse

</div>

<div class="card">

<h2>Notificaciones</h2>

<div class="notifications">

@foreach($notifications as $notification)

<div class="notification">

{{ $notification->message }}

</div>

@endforeach

</div>

</div>

<div class="card">

<a
href="/admin/case/{{ $case->id }}/approve"
class="btn btn-approve">

<i class="fas fa-check"></i>

Confirmar Caso

</a>

@if($case->admin_approved)

<div class="approved-stamp">

APROBADO

</div>

@endif

</div>

</div>

<!-- MODAL -->

<div id="reviewModal" class="modal">

<div class="modal-content">

<span class="close"
onclick="closeModal()">

&times;

</span>

<h2>Revisión del Caso</h2>

<p>

Revise cuidadosamente la información antes de aprobar el caso.

</p>

</div>

</div>

<script>

function openModal()
{
    document.getElementById('reviewModal').style.display='block';
}

function closeModal()
{
    document.getElementById('reviewModal').style.display='none';
}

</script>

</body>
</html>