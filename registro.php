<?php include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar usuario</title>
<style>
    body { font-family: Poppins, sans-serif; background: #eef1f4; padding: 40px; }
    .card {
        width: 450px; background: white; padding: 25px;
        border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin: auto;
    }
    input {
        width: 100%; padding: 12px; margin-bottom: 15px;
        border: 1px solid #ccc; border-radius: 8px;
    }
    .btn {
        width: 100%; padding: 12px;
        background: #0d6efd; border: none; color: white;
        border-radius: 8px; cursor: pointer; font-size: 16px;
    }
    .btn:hover { background: #0b5ed7; }

    .btn-volver {
        margin-top: 10px;
        width: 100%; padding: 12px;
        background: #6c757d; color: white;
        border-radius: 8px; text-align:center;
        display:block; text-decoration:none;
    }
</style>

<script>
function cargarUID() {
    fetch("get_uid.php")
    .then(res => res.text())
    .then(uid => {
        if (uid.trim() !== "") {
            document.getElementById("uid").value = uid.trim();
        }
    });
}

setInterval(cargarUID, 1000);
</script>

</head>
<body>

<div class="card">
<h2>Registro de Usuario</h2>

<form action="guardar_usuario.php" method="POST" class="formulario">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Apellido:</label>
    <input type="text" name="apellido" required>

    <label>Correo:</label>
    <input type="email" name="correo" required>

    <label>Teléfono:</label>
    <input type="text" name="telefono">

    <label>Dirección:</label>
    <input type="text" name="direccion">

    <label>UID Tarjeta RFID:</label>
    <input type="text" name="uid" id="uid" required>

    <button type="submit" class="btn">Guardar Usuario</button>
</form>

<a href="index.php" class="btn-volver">Volver</a>

</div>

</body>
</html>
