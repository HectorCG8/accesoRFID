<?php
$sql = $conn->query(
    "SELECT r.tipo, r.fecha, u.nombre
     FROM registros r
     JOIN usuarios u ON r.usuario_id = u.id
     ORDER BY r.id DESC LIMIT 10"
);

echo "<table class='table table-striped'>";
echo "<tr><th>Nombre</th><th>Movimiento</th><th>Hora</th></tr>";

foreach ($sql as $row) {
    echo "<tr>
            <td>{$row['nombre']}</td>
            <td>{$row['tipo']}</td>
            <td>{$row['fecha']}</td>
          </tr>";
}
echo "</table>";
?>
