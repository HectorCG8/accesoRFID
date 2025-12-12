<?php
require_once "conexion.php"; // importa $pdo

// Tomar datos del formulario
$nombre    = trim($_POST['nombre']    ?? '');
$apellido  = trim($_POST['apellido']  ?? '');
$correo    = trim($_POST['correo']    ?? '');
$telefono  = trim($_POST['telefono']  ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$uid       = trim($_POST['uid']       ?? '');

// Validaciones básicas
$errors = [];
if ($nombre === '')   $errors[] = "El nombre es obligatorio.";
if ($apellido === '') $errors[] = "El apellido es obligatorio.";
if ($correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) $errors[] = "Correo inválido.";
if ($uid === '')      $errors[] = "El UID de la tarjeta es obligatorio.";

if (!empty($errors)) {
    echo "<h3>Errores:</h3><ul>";
    foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>";
    echo "</ul><p><a href='registro.php'>Volver</a></p>";
    exit;
}

try {

    // Verificar si el UID ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE uid = ?");
    $stmt->execute([$uid]);

    if ($stmt->fetch()) {
        // UID ya registrado
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Registro</title>";
        echo "<style>
            body{font-family:Arial;background:#f3f6fb;padding:40px}
            .card{max-width:600px;margin:40px auto;background:white;border-radius:12px;padding:24px;box-shadow:0 8px 30px rgba(20,30,70,0.08)}
            .bad{color:#a94442;background:#f2dede;padding:12px;border-radius:8px}
            .link{display:inline-block;margin-top:16px;padding:10px 16px;background:#0d6efd;color:white;border-radius:8px;text-decoration:none}
        </style></head><body>";
        echo "<div class='card'><div class='bad'><strong>La tarjeta UID ya está registrada.</strong><br> Usa otra tarjeta.</div>";
        echo "<a class='link' href='registro.php'>Volver</a> ";
        echo "<a class='link' href='ver_usuarios.php' style='background:#28a745'>Ver usuarios</a>";
        echo "</div></body></html>";
        exit;
    }

    // Insertar nuevo usuario
    $insert = $pdo->prepare("
        INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, uid)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $insert->execute([$nombre, $apellido, $correo, $telefono, $direccion, $uid]);

    // Mensaje final de éxito
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Registro exitoso</title>";
    echo "<style>
        body{font-family:Inter,Arial;background:linear-gradient(180deg,#f6fbff,#eef6ff);padding:40px}
        .card{max-width:700px;margin:40px auto;background:white;border-radius:14px;padding:28px;box-shadow:0 12px 40px rgba(18,38,75,0.08);text-align:center}
        .icon{width:72px;height:72px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#e6f4ea;margin-bottom:14px}
        .icon svg{fill:#16a34a}
        h2{margin:6px 0 0 0}
        p{color:#475569}
        .actions{margin-top:18px}
        .btn{display:inline-block;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600}
        .btn-primary{background:#0d6efd;color:white}
        .btn-secondary{background:#f1f5f9;color:#0f172a;margin-left:10px}
    </style></head><body>";

    echo "<div class='card'>";
    echo "<div class='icon'>
            <svg width='36' height='36' viewBox='0 0 24 24'><path d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/></svg>
          </div>";
    echo "<h2>Usuario registrado</h2>";
    echo "<p>Se guardó correctamente al usuario <strong>" . htmlspecialchars("$nombre $apellido") . "</strong> con UID <strong>" . htmlspecialchars($uid) . "</strong>.</p>";
    echo "<div class='actions'>";
    echo "<a class='btn btn-primary' href='registro.php'>Registrar otro</a>";
    echo "<a class='btn btn-secondary' href='ver_usuarios.php'>Ver usuarios</a>";
    echo "</div></div></body></html>";

} catch (PDOException $ex) {
    echo "Error en la base de datos: " . htmlspecialchars($ex->getMessage());
}
?>
