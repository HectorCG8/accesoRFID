<?php
require_once "conexion.php";

if (!isset($_GET['uid'])) {
    echo "ERROR";
    exit;
}

$uid = $_GET['uid'];

/* ==========================
   VALIDAR SI EXISTE USUARIO
   ========================== */
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE uid = ?");
$stmt->execute([$uid]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {

    // Registrar acceso denegado
    $stmt2 = $pdo->prepare("
        INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
        VALUES ('Desconocido', ?, 'denegado', NOW())
    ");
    $stmt2->execute([$uid]);

    echo "DENEGADO";
    exit;
}

/* ==========================
   OBTENER ÚLTIMO MOVIMIENTO
   ========================== */
$stmt = $pdo->prepare("
    SELECT tipo_evento 
    FROM historico 
    WHERE uid = ? 
    ORDER BY fecha_hora DESC 
    LIMIT 1
");
$stmt->execute([$uid]);
$last = $stmt->fetch(PDO::FETCH_ASSOC);

/* Alternar entrada/salida */
$tipo = ($last && $last['tipo_evento'] === "entrada") ? "salida" : "entrada";

/* ==========================
   GUARDAR NUEVO MOVIMIENTO
   ========================== */
$stmt = $pdo->prepare("
    INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
    VALUES (?, ?, ?, NOW())
");
$stmt->execute([$usuario['nombre'], $uid, $tipo]);

echo strtoupper($tipo);
?>
