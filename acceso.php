<?php
include "conexion.php";

$uid = $_POST['uid'] ?? '';

// Buscamos si el usuario está registrado
$sql = $conn->prepare("SELECT * FROM usuarios WHERE tarjeta_uid=?");
$sql->execute([$uid]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

// SI NO EXISTE → Registrar como "DENEGADO"
if (!$user) {

    // Guardamos en historico también
    $sqlDen = $conn->prepare("
        INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
        VALUES ('DESCONOCIDO', ?, 'denegado', NOW())
    ");
    $sqlDen->execute([$uid]);

    echo "NO_REGISTRADO";
    exit;
}

// SI EXISTE → Procedemos normal
$sql2 = $conn->prepare("SELECT tipo FROM registros WHERE usuario_id=? ORDER BY id DESC LIMIT 1");
$sql2->execute([$user['id']]);
$last = $sql2->fetch(PDO::FETCH_ASSOC);

// Alternar entrada/salida
$tipo = ($last && $last['tipo'] == "entrada") ? "salida" : "entrada";

// Guardar en registros
$sql3 = $conn->prepare("INSERT INTO registros(usuario_id, tipo) VALUES (?,?)");
$sql3->execute([$user['id'], $tipo]);

// Guardar en historico
$sql4 = $conn->prepare("
    INSERT INTO historico (nombre, uid, tipo_evento, fecha_hora)
    VALUES (?, ?, ?, NOW())
");
$sql4->execute([$user['nombre'], $uid, $tipo]);

echo "OK_" . $tipo . "_" . $user['nombre'];
?>
