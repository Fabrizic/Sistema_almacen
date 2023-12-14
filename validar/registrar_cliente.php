<?php
$conexion = new mysqli('localhost', 'root', '', 'ss');

// Recoger los datos del formulario
$nombre_cliente = $_POST['nombre_cliente'];
$dni = $_POST['dni'];
$telefono = $_POST['telefono'];
$organizacion = $_POST['organizacion'];

$query = "SELECT id_organizacion FROM organizacion WHERE nombre_organizacion= '$organizacion'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);
$id_organizacion = $row['id_organizacion'];

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO cliente (nombre_cliente, dni, telefono, id_organizacion) VALUES ('$nombre_cliente','$dni','$telefono', '$id_organizacion')";

if (mysqli_query($conexion, $sql)) {
    header("Location: ../cliente.php");
} else {
    header("Location: ../error.php");
}
 
mysqli_close($conexion);
?>