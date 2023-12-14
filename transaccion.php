<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href='styles/style_transaccion.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> <!-- Fuente Poppins -->
    <link href='https://fontawesome.com/icons/arrow-right-from-bracket?f=classic&s=solid' rel='stylesheet'>
    <link href='https://fontawesome.com/icons/warehouse?f=classic&s=solid' rel='stylesheet'>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function autofillProducto(id_producto) {
            $.ajax({
                url: 'validar/get_producto.php',
                type: 'POST',
                data: { id_producto: id_producto },
                success: function (data) {
                    var producto = JSON.parse(data);

                    $('#nombre_producto').val(producto.nombre_producto);
                    $('#nombre_almacen').val(producto.nombre_almacen);
                }
            });
        }
    </script>
    <script>
        function autofillCliente(id_cliente) {
            $.ajax({
                url: 'validar/get_cliente.php',
                type: 'POST',
                data: { id_cliente: id_cliente },
                success: function (data) {
                    var cliente = JSON.parse(data);

                    $('#nombre_cliente').val(cliente.nombre_cliente);
                    $('#telefono').val(cliente.telefono);
                    $('#dni').val(cliente.dni);
                    $('#nombre_organizacion').val(cliente.nombre_organizacion);
                    $('#ruc').val(cliente.ruc);
                    $('#direccion').val(cliente.direccion);
                }
            });
        }
    </script>
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
    <form action="validar/enviar_producto.php" method="post">
        <h2>Producto</h2>
        <div class="form-group">
            <label for="id_producto">ID del producto:</label><br>
            <select id="id_producto" name="id_producto" onchange="autofillProducto(this.value)">
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'ss');

                $consulta = "SELECT id_producto FROM producto ORDER BY id_producto ASC";
                $resultado = $conexion->query($consulta);

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<option value='" . $fila['id_producto'] . "'>" . $fila['id_producto'] . "</option>";
                    }
                } else {
                    echo "No hay datos";
                }

                $conexion->close();
                ?>
            </select>
            <label for="nombre_producto">Nombre del producto:</label><br>
            <input type="text" id="nombre_producto" name="nombre_producto">
        </div>
        <div class="form-group">
            <label for="nombre_almacen">Nombre del almacén:</label><br>
            <input type="text" id="nombre_almacen" name="nombre_almacen" readonly>
            <label for="cantidad">Cantidad:</label><br>
            <input type="number" id="cantidad" name="cantidad">
        </div>
        <h2>Cliente</h2>
        <div class="form-group">
            <label for="id_cliente">ID del Cliente:</label><br>
            <select id="id_cliente" name="id_cliente" onchange="autofillCliente(this.value)">
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'ss');

                $consulta = "SELECT id_cliente FROM cliente ORDER BY id_cliente ASC";
                $resultado = $conexion->query($consulta);

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<option value='" . $fila['id_cliente'] . "'>" . $fila['id_cliente'] . "</option>";
                    }
                } else {
                    echo "No hay datos";
                }

                $conexion->close();
                ?>

            </select>
            <label for="nombre_cliente">Nombre del cliente:</label><br>
            <input type="text" id="nombre_cliente" name="nombre_cliente" readonly>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label><br>
            <input type="tel" id="telefono" name="telefono" readonly>
            <label for="dni">DNI:</label><br>
            <input type="text" id="dni" name="dni" readonly>
        </div>

        <h2>Organización</h2>
        <label for="nombre_organizacion">Nombre de la organización:</label><br>
        <input type="text" id="nombre_organizacion" name="nombre_organizacion" readonly><br>
        <label for="ruc">RUC:</label><br>
        <input type="text" id="ruc" name="ruc" readonly><br>
        <label for="direccion">Dirección:</label><br>
        <input type="text" id="direccion" name="direccion" readonly><br>
        <input type="hidden" id="fecha_transaccion" name="fecha_transaccion" value="<?php echo date('Y-m-d'); ?>">
        <div id="submit-container">
            <input type="submit" value="Enviar">
        </div>
    </form>
</body>

</html>