<?php
require_once "conexion.php"; // IMPORTANTE — CREA $conn

$sql = $pdo->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios Registrados</title>

<style>
    body { font-family: Arial; background: #eef1f4; padding: 40px; }
    table {
        width: 80%; margin: auto; border-collapse: collapse; 
        background: white; box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    }
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
    th { background: #0d6efd; color: white; }
    tr:hover { background: #f2f2f2; }
    .btn-delete {
        padding: 6px 12px; background: #d9534f; color: white;
        border-radius: 5px; text-decoration: none;
    }
    .btn-delete:hover { background: #c9302c; }
    .btn-volver {
        display: block; width: 200px; margin: 25px auto;
        padding: 10px; text-align: center;
        background: #0d6efd; color: white;
        text-decoration: none; border-radius: 8px;
    }
</style>
</head>
<body>

<h2 style="text-align:center;">Usuarios Registrados</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>UID</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($sql as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['uid'] ?></td>
        <td>
            <a href="eliminar_usuario.php?id=<?= $row['id'] ?>" class="btn-delete"
            onclick="return confirm('¿Eliminar este usuario?');">
                Eliminar
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<a href="index.php" class="btn-volver">Volver</a>

</body>
</html>
