<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href='styles/style_home.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> <!-- Fuente Poppins -->
    <link href='https://fontawesome.com/icons/arrow-right-from-bracket?f=classic&s=solid' rel='stylesheet'>
    <link href='https://fontawesome.com/icons/warehouse?f=classic&s=solid' rel='stylesheet'>
    <link href='https://fontawesome.com/icons/basket-shopping?f=classic&s=solid' rel='stylesheet'>
    <link href='https://fontawesome.com/icons/user?f=classic&s=solid' rel='stylesheet'>
    <link href='https://fontawesome.com/icons/warehouse?f=classic&s=solid' rel='stylesheet'>
    <link href='https://fontawesome.com/icons/building?f=classic&s=solid' rel='stylesheet'>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header>
        <h1><a id="icono_marca" href="home.php"><i class="fas fa-warehouse"></i>SafeSave</a></h1>
        <nav>
            <ul>
                <li><a href="producto.php">PRODUCTO</a></li>
                <li><a href="cliente.php">CLIENTE</a></li>
                <li><a href="transaccion.php">TRANSACCIÓN</a></li>
                <li><a href="logout.php" id="boton_salida"><i class="fas fa-arrow-right"></i></a></li>
            </ul>
        </nav>
    </header>
    <h2>Bienvenido al Sistema SafeSave</h2>
    <h3>
    Nos llena de alegría darle la bienvenida nuevamente a SafeSave. 
    Estamos agradecidos por tu continua confianza en nuestro sistema de almacenamiento seguro.

Tu elección de seguir utilizando SafeSave nos motiva a trabajar constantemente para mejorar y brindarte la mejor experiencia posible. Estamos comprometidos a proteger tus datos y facilitar la gestión de tus archivos de manera eficiente.</h3>
    <div class="container">
        <?php
        $conexion = new mysqli('localhost', 'root', '', 'ss');

        if ($conexion->connect_error) {
            die("La conexión ha fallado: " . $conexion->connect_error);
        }

        $sql_productos = "SELECT COUNT(*) AS total_productos FROM producto";
        $sql_clientes = "SELECT COUNT(*) AS total_clientes FROM cliente";
        $sql_almacenes = "SELECT COUNT(*) AS total_almacenes FROM almacen";
        $sql_organizaciones = "SELECT COUNT(*) AS total_organizaciones FROM organizacion";

        $resultado_productos = $conexion->query($sql_productos);
        $resultado_clientes = $conexion->query($sql_clientes);
        $resultado_almacenes = $conexion->query($sql_almacenes);
        $resultado_organizaciones = $conexion->query($sql_organizaciones);

        $total_productos = $resultado_productos->fetch_assoc()['total_productos'];
        $total_clientes = $resultado_clientes->fetch_assoc()['total_clientes'];
        $total_almacenes = $resultado_almacenes->fetch_assoc()['total_almacenes'];
        $total_organizaciones = $resultado_organizaciones->fetch_assoc()['total_organizaciones'];

        echo "<div class='box'><i class='fas fa-shopping-basket'></i><p>Productos: $total_productos</p></div>";
        echo "<div class='box'><i class='fas fa-user'></i><p>Clientes: $total_clientes</p></div>";
        echo "<div class='box'><i class='fas fa-warehouse'></i><p>Almacenes: $total_almacenes</p></div>";
        echo "<div class='box'><i class='fas fa-building'></i><p>Organizaciones: $total_organizaciones</p></div>";

        $conexion->close();
        ?>
    </div>
    <div class="contacto">
        <h2>Contacto</h2>
        <p>Si tienes alguna pregunta o comentario, no dudes en contactarnos:</p>
        <p>Email: fabrizio.leiva@unmsm.edu.pe</p>
        <p>Teléfono: +51 961 256 056</p>
    </div>
</body>
