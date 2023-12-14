<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

$id_producto = $_POST['id_producto'];
$consulta = "SELECT producto.nombre_producto, almacen.nombre_almacen 
              FROM producto 
              INNER JOIN almacen ON producto.id_almacen = almacen.id_almacen 
              WHERE producto.id_producto = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param('i', $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $producto = $resultado->fetch_assoc();
    echo json_encode($producto);
} else {
    echo json_encode([]);
}

$conexion->close();
?>