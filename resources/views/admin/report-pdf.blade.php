<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body{
    font-family:DejaVu Sans;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid black;
    padding:8px;
}

th{
    background:#ddd;
}

</style>

</head>

<body>

<h1>Reporte de Casos</h1>

<table>

<thead>

<tr>
    <th>Número de caso</th>
    <th>Tema</th>
    <th>Estado</th>
</tr>

</thead>

<tbody>

@foreach($cases as $case)

<tr>

<td>{{ $case->case_number }}</td>

<td>{{ $case->type }}</td>

<td>{{ $case->status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>