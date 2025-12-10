<?php
include "conexion.php";

$nombre    = $_POST['nombre'];
$apellido  = $_POST['apellido'];
$correo    = $_POST['correo'];
$telefono  = $_POST['telefono'];
$direccion = $_POST['direccion'];
$uid       = $_POST['uid']; // tarjeta_uid

if ($uid == "") {
    echo "<script>alert('ERROR: No se detectó una tarjeta RFID.'); window.location='registro.php';</script>";
    exit;
}

$sql = $conn->prepare("INSERT INTO tabla_usuarios (nombre, apellido, correo, telefono, direccion, tarjeta_uid)
VALUES (?, ?, ?, ?, ?, ?)");
$sql->execute([$nombre, $apellido, $correo, $telefono, $direccion, $uid]);

echo "<script>
alert('Usuario registrado correctamente');
window.location='index.php';
</script>";
?>
