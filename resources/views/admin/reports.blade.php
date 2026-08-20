<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Reportes</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background:#0f172a;
    color:white;
    font-family:Poppins,sans-serif;
    padding:30px;
}

.dashboard{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));

    gap:20px;
}

.card{

    background:#1e293b;

    padding:25px;

    border-radius:20px;

    box-shadow:
    0 5px 20px rgba(0,0,0,.3);

}

.card h2{

    margin:0;

    font-size:18px;

    color:#cbd5e1;
}

.number{

    font-size:40px;

    font-weight:bold;

    margin-top:10px;
}

.chart-container{

    background:#1e293b;

    margin-top:25px;

    padding:20px;

    border-radius:20px;
}

.filter-box{

    background:#1e293b;

    padding:20px;

    border-radius:20px;

    margin-bottom:20px;
}

button{

    background:#2563eb;

    border:none;

    color:white;

    padding:12px 20px;

    border-radius:10px;

    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
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

.export-buttons{
    margin-top:20px;
    display:flex;
    gap:15px;
}

.export-btn{

    background:#2563eb;

    color:white;

    text-decoration:none;

    padding:12px 20px;

    border-radius:10px;

    font-weight:600;

    display:inline-block;

    transition:.3s;
}

.export-btn:hover{

    background:#1d4ed8;

    transform:translateY(-2px);

    text-decoration:none;
}

.back-btn:hover{
    background:#2a3d63;
    transform:translateY(-2px);
}

.back-btn i{
    font-size:14px;
}

.date-input{
    background:#334155;
    color:#fff;

    border:none;

    padding:12px 15px;

    border-radius:10px;

    margin-right:10px;
}

.date-input::-webkit-calendar-picker-indicator{
    filter:brightness(0) invert(1);
    cursor:pointer;
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

<h1>📊 Reportes Administrativos</h1>

<div class="filter-box">

<form>

<input type="date" class="date-input">

<input type="date" class="date-input">

<button>
Filtrar
</button>

</form>

</div>

<div class="dashboard">

<div class="card">
<h2>Casos Abiertos</h2>
<div class="number">
{{ $openCases }}
</div>
</div>

<div class="card">
<h2>Casos Cerrados</h2>
<div class="number">
{{ $closedCases }}
</div>
</div>

<div class="card">
<h2>Pendientes de Aprobación</h2>
<div class="number">
{{ $pendingCases }}
</div>
</div>

<div class="card">
<h2>Usuarios Registrados</h2>
<div class="number">
{{ $usersCount }}
</div>
</div>

<div class="card">
<h2>Moderadores Activos</h2>
<div class="number">
{{ $moderatorsCount }}
</div>
</div>

</div>

<div class="chart-container">

<h2>Casos por Mes</h2>

<canvas id="lineChart"></canvas>

</div>

<div class="export-buttons">

<a href="/admin/reports/pdf" class="export-btn">
    📄 Exportar PDF
</a>

<a href="/admin/reports/excel" class="export-btn">
    📊 Exportar Excel
</a>

</div>

<script>

const lineChart =
new Chart(
document.getElementById('lineChart'),
{
type:'line',
data:{
labels:[
'Ene','Feb','Mar',
'Abr','May','Jun',
'Jul','Ago','Sep',
'Oct','Nov','Dic'
],
datasets:[{
label:'Casos',
data:@json($monthlyCases),
fill:false,
borderWidth:3
}]
}
});

</script>
</div>
</body>
</html>