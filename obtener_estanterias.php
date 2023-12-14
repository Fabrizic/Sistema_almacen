<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

if (!isset($_POST['id_almacen'])) {
    die('No se recibió el id del almacén');
}

$id_almacen = $_POST['id_almacen'];

$sql = "SELECT id_estanteria,nombre_estanteria FROM estanteria WHERE id_almacen = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_almacen);
$stmt->execute();
$result = $stmt->get_result();

while ($estanteria = $result->fetch_assoc()) {
    echo "<option value='" . $estanteria['id_estanteria'] . "'>" . $estanteria['nombre_estanteria'] . "</option>";
}

$conexion->close();
?>