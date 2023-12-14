<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

$clientes_seleccionados = $_POST['clientes_seleccionados'];

foreach ($clientes_seleccionados as $nombre_cliente) {
    $sql = "DELETE FROM cliente WHERE nombre_cliente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombre_cliente);
    $stmt->execute();
}

header("Location: ../cliente.php");

$conexion->close();
?>