<?php
$sql = $conn->query(
    "SELECT r.id, u.nombre, r.tipo, r.fecha
     FROM registros r
     JOIN usuarios u ON r.usuario_id = u.id
     ORDER BY r.id DESC"
);

echo "<table class='table table-striped'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Movimiento</th><th>Fecha</th></tr>";

foreach ($sql as $row) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['tipo']}</td>
            <td>{$row['fecha']}</td>
         </tr>";
}
echo "</table>";
?>
