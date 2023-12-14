<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

$id_cliente = $_POST['id_cliente'];
$consulta = "SELECT cliente.nombre_cliente, cliente.telefono, cliente.dni, 
              organizacion.nombre_organizacion, organizacion.ruc, organizacion.direccion 
              FROM cliente 
              INNER JOIN organizacion ON cliente.id_organizacion = organizacion.id_organizacion 
              WHERE cliente.id_cliente = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $cliente = $resultado->fetch_assoc();
    echo json_encode($cliente);
} else {
    echo json_encode([]);
}

$conexion->close();
?>