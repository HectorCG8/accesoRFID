<?php
$host = getenv("DB_HOST") ?: "db";
$dbname = getenv("DB_NAME") ?: "acceso_rfid";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR DB: " . $e->getMessage());
}

?>


