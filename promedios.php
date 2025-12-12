<?php
require_once "conexion.php";

/* ==========================
   PROMEDIOS POR USUARIO
   ========================== */

// Convertido de MySQL → PostgreSQL
$sqlProm = $pdo->query("
    SELECT 
        nombre,
        
        -- PROMEDIO DE HORA DE ENTRADA (PostgreSQL)
        TO_CHAR(
            AVG(
                CASE 
                    WHEN tipo_evento = 'entrada' 
                    THEN fecha_hora::time 
                END
            ),
            'HH24:MI:SS'
        ) AS promedio_entrada,

        -- PROMEDIO DE HORA DE SALIDA (PostgreSQL)
        TO_CHAR(
            AVG(
                CASE 
                    WHEN tipo_evento = 'salida' 
                    THEN fecha_hora::time 
                END
            ),
            'HH24:MI:SS'
        ) AS promedio_salida,

        COUNT(*) AS total_accesos

    FROM historico
    GROUP BY nombre
");

/* ==========================
   DIAS CON MÁS ACCESOS
   ========================== */

// DATE(fecha_hora) → fecha_hora::date
$sqlDias = $pdo->query("
    SELECT 
        fecha_hora::date AS dia,
        COUNT(*) AS accesos
    FROM historico
    GROUP BY fecha_hora::date
    ORDER BY accesos DESC
    LIMIT 10
");
?>
<!DOCTYPE html>
<html lang=\"es\">
<head>
<meta charset=\"UTF-8\">
<title>Promedios de Acceso</title>

<style>
body {
    font-family: Arial;
    background: #eef1f4;
    padding: 40px;
}
table {
    width: 80%;
    margin: auto;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}
th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}
th {
    background: #0d6efd;
    color: white;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
.btn-volver {
    display: block;
    width: 200px;
    margin: 25px auto;
    padding: 10px;
    text-align: center;
    background: #0d6efd;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}
</style>

</head>
<body>

<h2>Promedios de Hora por Usuario</h2>

<table>
    <tr>
        <th>Nombre</th>
        <th>Promedio de Entrada</th>
        <th>Promedio de Salida</th>
        <th>Total de Accesos</th>
    </tr>

    <?php while ($row = $sqlProm->fetch(PDO::FETCH_ASSOC)): ?>
    <tr>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['promedio_entrada'] ?: 'N/A' ?></td>
        <td><?= $row['promedio_salida'] ?: 'N/A' ?></td>
        <td><?= $row['total_accesos'] ?></td>
    </tr>
    <?php endwhile; ?>

</table>



<h2>Días con Más Accesos</h2>

<table>
    <tr>
        <th>Día</th>
        <th>Total de Accesos</th>
    </tr>

    <?php while ($row = $sqlDias->fetch(PDO::FETCH_ASSOC)): ?>
    <tr>
        <td><?= $row['dia'] ?></td>
        <td><?= $row['accesos'] ?></td>
    </tr>
    <?php endwhile; ?>

</table>

<a href=\index.php class="btn-volver">Volver</a>

</body>
</html>

