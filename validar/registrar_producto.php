<?php
$conexion = new mysqli("localhost", "root", "", "ss");

if (!isset($_POST['nombre_producto'], $_POST['almacen'], $_POST['estanteria'], $_POST['cantidad'])) {
    die('Faltan datos del producto');
}

$nombre_producto = $_POST['nombre_producto'];
$id_almacen = $_POST['almacen'];
$id_estanteria = $_POST['estanteria'];
$cantidad = $_POST['cantidad'];

$sql = "INSERT INTO producto (nombre_producto, id_almacen, id_estanteria, cantidad) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("siii", $nombre_producto, $id_almacen, $id_estanteria, $cantidad);

if ($stmt->execute()) {
    header("Location: ../producto.php");
} else {
    echo "Error al registrar el producto: " . $conexion->error;
}

$conexion->close();
?>

