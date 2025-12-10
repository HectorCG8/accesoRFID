<?php
require_once "config.php";  // Asegúrate de tener tu archivo de conexión con PDO

if (!isset($_GET['id'])) {
    echo "ID no proporcionado.";
    exit;
}

$id = $_GET['id'];

// Buscar usuario antes de eliminar
$buscar = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$buscar->execute([$id]);
$user = $buscar->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "
    <div style='
        margin: 50px auto;
        width: 400px;
        padding: 20px;
        background: #fce4e4;
        border-left: 6px solid #d32f2f;
        border-radius: 8px;
        font-family: Poppins;
        text-align:center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    '>
        <h2 style='color:#d32f2f;'>Error</h2>
        <p>El usuario no existe.</p>
        <a href='usuarios.php' style='
            display:inline-block;
            margin-top:10px;
            padding:10px 20px;
            background:#d32f2f;
            color:white;
            border-radius:6px;
            text-decoration:none;
        '>Volver</a>
    </div>";
    exit;
}

// Eliminar historial del usuario
$delHistorial = $pdo->prepare("DELETE FROM historico WHERE user_id = ?");
$delHistorial->execute([$id]);

// Eliminar usuario
$eliminar = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$eliminar->execute([$id]);

echo "
<div style='
    margin: 50px auto;
    width: 400px;
    padding: 20px;
    background: #e8f5e9;
    border-left: 6px solid #2e7d32;
    border-radius: 8px;
    font-family: Poppins;
    text-align:center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
'>
    <h2 style='color:#2e7d32;'>Usuario Eliminado</h2>
    <p>El usuario <b>{$user['nombre']} {$user['apellido']}</b> ha sido eliminado correctamente.</p>
    <a href='ver_usuarios.php' style='
        display:inline-block;
        margin-top:10px;
        padding:10px 20px;
        background:#2e7d32;
        color:white;
        border-radius:6px;
        text-decoration:none;
    '>Volver</a>
</div>
";
