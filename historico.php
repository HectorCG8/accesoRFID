<?php
require_once "config.php";

// Número de registros por página
$porPagina = 10;

// ¿Qué página estás viendo?
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
if ($pagina < 1) $pagina = 1;

// Calcular desde qué registro iniciar
$inicio = ($pagina - 1) * $porPagina;

// Obtener total de registros
$totalQuery = $pdo->query("SELECT COUNT(*) FROM historico");
$totalRegistros = $totalQuery->fetchColumn();

$totalPaginas = ceil($totalRegistros / $porPagina);

// Obtener solo los registros de esta página
$stmt = $pdo->prepare("SELECT * FROM historico ORDER BY fecha_hora DESC LIMIT :ini, :pp");
$stmt->bindValue(':ini', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':pp', $porPagina, PDO::PARAM_INT);
$stmt->execute();
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Histórico de Accesos</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .tabla-moderna {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        }

        .tabla-moderna thead {
            background: #4f46e5;
            color: white;
        }

        .tabla-moderna th,
        .tabla-moderna td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .tabla-moderna tr:hover {
            background: #f1f5f9;
        }

        .verde { color: #16a34a; font-weight: bold; }
        .amarillo { color: #ca8a04; font-weight: bold; }

        /* Botón volver */
        .btn-volver {
            display: block;
            width: 180px;
            margin: 30px auto;
            padding: 12px;
            text-align: center;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-volver:hover { background: #4338ca; }

        /* Paginación */
        .paginacion {
            text-align: center;
            margin-top: 20px;
        }
        .paginacion a {
            display: inline-block;
            padding: 10px 16px;
            margin: 5px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .paginacion a:hover {
            background: #4338ca;
        }
        .paginacion .disabled {
            background: #a5b4fc;
            pointer-events: none;
        }
        .rojo { 
        color: red; 
        font-weight: bold; 
        }
    </style>
</head>
<body>

<h2>Histórico de Accesos</h2>

<table class="tabla-moderna">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>UID</th>
            <th>Tipo</th>
            <th>Fecha y Hora</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($registros as $r): ?>
        <tr>
            <td><?= $r['nombre'] ?></td>
            <td><?= $r['uid'] ?></td>
            <td class="<?= 
            $r['tipo_evento'] == 'entrada' ? 'verde' : 
            ($r['tipo_evento'] == 'salida' ? 'amarillo' : 'rojo') 
            ?>">
            <?= strtoupper($r['tipo_evento']) ?>
            </td>
            <td><?= $r['fecha_hora'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- PAGINACIÓN -->
<div class="paginacion">
    <!-- Botón anterior -->
    <?php if ($pagina > 1): ?>
        <a href="?pagina=<?= $pagina - 1 ?>">◀ Anterior</a>
    <?php else: ?>
        <a class="disabled">◀ Anterior</a>
    <?php endif; ?>

    <!-- Botón siguiente -->
    <?php if ($pagina < $totalPaginas): ?>
        <a href="?pagina=<?= $pagina + 1 ?>">Siguiente ▶</a>
    <?php else: ?>
        <a class="disabled">Siguiente ▶</a>
    <?php endif; ?>
</div>

<a href="index.php" class="btn-volver">Volver</a>

</body>
</html>
