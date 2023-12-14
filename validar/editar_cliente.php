<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

$id_cliente = $_POST['edit_id_cliente'];
$nombre_cliente = $_POST['edit_nombre_cliente'];
$dni = $_POST['edit_dni'];
$telefono = $_POST['edit_telefono'];
$nombre_organizacion = $_POST['edit_organizacion'];

$query = "SELECT id_organizacion FROM organizacion WHERE nombre_organizacion = '$nombre_organizacion'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_array($result);
$id_organizacion = $row['id_organizacion'];


$sql = "UPDATE cliente SET nombre_cliente = '$nombre_cliente', dni = '$dni', telefono = '$telefono', id_organizacion = '$id_organizacion' WHERE id_cliente = '$id_cliente'";

if (mysqli_query($conexion, $sql)) {
    header("Location: ../cliente.php");
} else {
    header("Location: ../error.php");
}

mysqli_close($conexion);
?>
