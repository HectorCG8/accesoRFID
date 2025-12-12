<?php
session_start();
require_once "conexion.php";

// Últimos accesos
$stmt = $pdo->query("SELECT * FROM historico ORDER BY fecha_hora DESC LIMIT 5");
$accesos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total de usuarios
$stmt2 = $pdo->query("SELECT COUNT(*) AS total FROM usuarios");
$totalUsuarios = $stmt2->fetch(PDO::FETCH_ASSOC)['total'];

// Notificación
$mensaje = $_SESSION['notificacion'] ?? "";
unset($_SESSION['notificacion']);
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="refresh" content="2">
<meta charset="UTF-8">
<title>Dashboard de Accesos RFID</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", sans-serif;
        background: #f0f2f5;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 20px;
        color: #333;
    }

    .cards {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        text-align: center;
    }

    .card h3 {
        margin: 0;
        color: #555;
    }

    .card p {
        font-size: 40px;
        font-weight: bold;
        margin-top: 10px;
        color: #4f46e5;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #4f46e5;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: .2s;
        margin-right: 10px;
    }

    .btn:hover {
        background: #372fde;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }

    th {
        background: #4f46e5;
        color: white;
        padding: 12px;
        text-align: left;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    tr:hover {
        background: #f1f5ff;
    }

    .entrada { color: green; font-weight: 600; }
    .salida { color: orange; font-weight: 600; }
    .denegado { color: red; font-weight: 600; }

    .btn-primario {
        display: inline-block;
        padding: 12px 20px;
        background: #4f46e5;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        margin: 10px 0;
        transition: .2s;
    }

    .btn-primario:hover {
        background: #3730a3;
    }

    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #0d6efd;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        opacity: 0;
        transition: .4s;
        font-family: Poppins;
        z-index: 9999;
    }
    .toast.show { opacity: 1; }
</style>
</head>

<body>

<div class="container">

    <h1>Dashboard de Control de Acceso RFID</h1>

    <div class="cards">
        <div class="card">
            <h3>Usuarios Registrados</h3>
            <p><?= $totalUsuarios ?></p>
        </div>

        <div class="card">
            <h3>Último Movimiento</h3>
            <p><?= isset($accesos[0]) ? ucfirst($accesos[0]['tipo_evento']) : "N/A" ?></p>
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="registro.php" class="btn">Registrar Usuario</a>
        <a href="historico.php" class="btn">Ver Histórico</a>
        <a href="ver_usuarios.php" class="btn-primario">Ver Usuarios Registrados</a>
        <a href="promedios.php" class="btn-primario">Ver Promedio de Accesos</a>
    </div>

    <div id="toast" class="toast"><?= $mensaje ?></div>

<script>
let msg = "<?= $mensaje ?>";
if (msg.length > 0) {
    const t = document.getElementById("toast");
    t.classList.add("show");
    setTimeout(() => t.classList.remove("show"), 3500);
}
</script>

<h2>Últimos movimientos</h2>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>UID</th>
            <th>Tipo</th>
            <th>Fecha y Hora</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($accesos as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['nombre']) ?></td>
            <td><?= htmlspecialchars($a['uid']) ?></td>

            <?php
                $tipo = strtolower($a['tipo_evento']);
                $clase = $tipo === 'entrada' ? 'entrada' :
                         ($tipo === 'salida' ? 'salida' : 'denegado');
                $texto = strtoupper($tipo);
            ?>

            <td class="<?= $clase ?>"><?= $texto ?></td>
            <td><?= htmlspecialchars($a['fecha_hora']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</div>

</body>
</html>



