<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

$id_producto = $_POST['id_producto'];
$id_cliente = $_POST['id_cliente'];
$cantidad = $_POST['cantidad'];
$fecha_transaccion = $_POST['fecha_transaccion'];
$nombre_producto = $_POST['nombre_producto'];
$nombre_almacen = $_POST['nombre_almacen'];
$nombre_cliente = $_POST['nombre_cliente'];
$telefono = $_POST['telefono'];
$dni = $_POST['dni'];
$nombre_organizacion = $_POST['nombre_organizacion'];
$ruc = $_POST['ruc'];
$direccion = $_POST['direccion'];

// Obtén el id_organizacion basado en el id_cliente
$consulta = "SELECT id_organizacion FROM cliente WHERE id_cliente = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();
$id_organizacion = $fila['id_organizacion'];

// Inserta los datos en la tabla de transacciones
$consulta = "INSERT INTO transaccion (id_producto, id_cliente, id_organizacion, cantidad, fecha_transaccion) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param('iiiss', $id_producto, $id_cliente, $id_organizacion, $cantidad, $fecha_transaccion);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $consulta = "UPDATE producto SET cantidad = cantidad - ? WHERE id_producto = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param('ii', $cantidad, $id_producto);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: ../home.php');
    } else {
        echo "Error al actualizar la cantidad del producto.";
    }
} else {
    echo "Error al realizar la transacción.";
}

$conexion->close();
?>