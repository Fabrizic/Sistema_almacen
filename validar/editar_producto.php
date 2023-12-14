<?php
$id_producto = $_POST['edit_id_producto'];
$nombre_producto = $_POST['edit_nombre_producto'];
$id_almacen = $_POST['edit_almacen'];
$id_estanteria = $_POST['edit_estanteria'];
$cantidad = $_POST['edit_cantidad'];

$conexion = new mysqli('localhost', 'root', '', 'ss');

if ($conexion->connect_error) {
    die("La conexión ha fallado: " . $conexion->connect_error);
}

$sql = "UPDATE producto SET nombre_producto='$nombre_producto', id_almacen=$id_almacen, id_estanteria=$id_estanteria, cantidad=$cantidad WHERE id_producto=$id_producto";

if ($conexion->query($sql) === TRUE) {
    echo "Producto actualizado con éxito";
} else {
    echo "Error al actualizar el producto: " . $conexion->error;
}

$conexion->close();

header('Location: ../producto.php');
?>