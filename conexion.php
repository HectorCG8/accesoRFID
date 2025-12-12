<?php

$host = getenv("DB_HOST") ?: "db";
$port = getenv("DB_PORT") ?: "5432";
$dbname = getenv("DB_NAME") ?: "acceso_rfid";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASSWORD") ?: "123456789";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("ERROR DB: " . $e->getMessage());
}

?>
