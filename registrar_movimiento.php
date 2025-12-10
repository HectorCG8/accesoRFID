<?php
require_once "conexion.php";

if (!isset($_GET['uid'])) {
    echo "ERROR";
    exit;
}

$uid = $_GET['uid'];

// ¿Existe usuario?
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE uid = ?");
$stmt->execute([$uid]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {

    // REGISTRAR DENEGADO EN HISTÓRICO
    $stmt2 = $pdo->prepare("
        INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
        VALUES ('Desconocido', ?, 'denegado', NOW())
    ");
    $stmt2->execute([$uid]);

    echo "DENEGADO";
    exit;
}

// Obtener último movimiento
$stmt = $pdo->prepare("SELECT tipo_evento FROM historico WHERE uid = ? ORDER BY fecha_hora DESC LIMIT 1");
$stmt->execute([$uid]);
$last = $stmt->fetch(PDO::FETCH_ASSOC);

$tipo = ($last && $last['tipo_evento'] == "entrada") ? "salida" : "entrada";

// Registrar movimiento normal
$stmt = $pdo->prepare("
    INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
    VALUES (?, ?, ?, NOW())
");
$stmt->execute([$usuario['nombre'], $uid, $tipo]);

echo strtoupper($tipo);
?>
