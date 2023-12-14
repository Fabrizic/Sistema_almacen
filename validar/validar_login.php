<?php
session_start();

$conexion = new mysqli('localhost', 'root', '', 'ss');

$usuario = $conexion->real_escape_string($_POST['usuario']);
$contraseña = $conexion->real_escape_string($_POST['contraseña']);

$query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
$resultado = $conexion->query($query) or die($conexion->error);

if ($resultado->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    header('Location: ../home.php');
} else {
    header('Location: ../login.php');
}

$conexion->close();
?>