<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

if (!isset($_POST['productos_seleccionados']) || !is_array($_POST['productos_seleccionados'])) {
    die('No se recibieron productos para eliminar');
}

$productos_seleccionados = $_POST['productos_seleccionados'];

foreach ($productos_seleccionados as $nombre_producto) {
    $sql = "DELETE FROM producto WHERE nombre_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombre_producto);
    if (!$stmt->execute()) {
        die('Error al eliminar el producto: ' . $stmt->error);
    }
}

header("Location: ../producto.php");

$conexion->close();
?>