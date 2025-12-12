<?php
include "conexion.php";

$uid = $_POST['uid'] ?? '';

// Buscar si el usuario está registrado
$sql = $pdo->prepare("SELECT * FROM usuarios WHERE uid = ?");
$sql->execute([$uid]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

// SI NO EXISTE → DENEGADO
if (!$user) {

    // Registrar en historico
    $sqlDen = $pdo->prepare("
        INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
        VALUES ('DESCONOCIDO', ?, 'denegado', CURRENT_TIMESTAMP)
    ");
    $sqlDen->execute([$uid]);

    echo "NO_REGISTRADO";
    exit;
}

// SI EXISTE → Revisar último registro
$sql2 = $pdo->prepare("SELECT tipo FROM registros WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
$sql2->execute([$user['id']]);
$last = $sql2->fetch(PDO::FETCH_ASSOC);

// Alternar entrada/salida
$tipo = ($last && $last['tipo'] == "entrada") ? "salida" : "entrada";

// Guardar en tabla registros
$sql3 = $pdo->prepare("INSERT INTO registros (usuario_id, tipo) VALUES (?, ?)");
$sql3->execute([$user['id'], $tipo]);

// Guardar también en historico
$sql4 = $pdo->prepare("
    INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
    VALUES (?, ?, ?, CURRENT_TIMESTAMP)
");
$sql4->execute([$user['nombre'], $uid, $tipo]);

echo "OK_" . $tipo . "_" . $user['nombre'];
?>
