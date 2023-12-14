<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href='styles/style_producto.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> <!-- Fuente Poppins -->
    <link href='https://fontawesome.com/icons/arrow-right-from-bracket?f=classic&s=solid' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#tabla_productos').DataTable();

            $('#register-button').click(function () {
                $('#register-form').show();
            });

            $('#register-form span').click(function () {
                $('#register-form').hide();
            });

            $('#almacen').change(function () {
                var id_almacen = $(this).val();

                $.ajax({
                    url: 'obtener_estanterias.php',
                    method: 'POST',
                    data: {
                        id_almacen: id_almacen
                    },
                    success: function (data) {
                        $('#estanteria').html(data);
                    }
                });
            });

            $('#edit_almacen').change(function () {
                var id_almacen = $(this).val();

                $.ajax({
                    url: 'obtener_estanterias.php',
                    method: 'POST',
                    data: {
                        id_almacen: id_almacen
                    },
                    success: function (data) {
                        $('#edit_estanteria').html(data);
                    }
                });
            });

            table.on('click', '.select-row', function () {
                var row = $(this).parents('tr');
                row.toggleClass('selected');

                if ($('.select-row:checked').length > 0) {
                    $('#edit-button, #delete-button').show();
                } else {
                    $('#edit-button, #delete-button').hide();
                }
            });

            $('#delete-button').click(function () {
                $('#delete-confirm').show();
            });

            $('#delete-confirm span, #cancel-delete').click(function () {
                $('#delete-confirm').hide();
            });

            $('#delete-confirm-button').click(function () {
                var selectedRows = table.rows('.selected').data();
                var productos_seleccionados = [];
                selectedRows.each(function (rowData) {
                    productos_seleccionados.push(rowData[2]);
                });

                $.ajax({
                    url: 'validar/eliminar_producto.php',
                    method: 'POST',
                    data: {
                        productos_seleccionados: productos_seleccionados
                    },
                    success: function () {
                        location.reload();
                    }
                });
            });

            $('#edit-button').click(function () {
                var row = $('.select-row:checked').closest('tr');
                var id_producto = row.find('td:eq(1)').text();
                var nombre_producto = row.find('td:eq(2)').text();
                var nombre_almacen = row.find('td:eq(3)').text();
                var nombre_estanteria = row.find('td:eq(4)').text();
                var cantidad = row.find('td:eq(5)').text();

                $('#edit_id_producto').val(id_producto);
                $('#edit_nombre_producto').val(nombre_producto);
                $('#edit_almacen').val(nombre_almacen);
                $('#edit_estanteria').val(nombre_estanteria);
                $('#edit_cantidad').val(cantidad);

                $('#edit_almacen option').each(function () {
                    if ($(this).text() == nombre_almacen) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });

                $('#edit_estanteria option').each(function () {
                    if ($(this).text() == nombre_estanteria) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });

                $('#edit-form').show();
            });

            $('#edit-form form').submit(function () {

                if (editQueue.length > 0) {
                    var rowData = editQueue.shift();
                    $('#edit_id_producto').val(rowData[0]); // Asume que el ID del cliente es la primera columna
                    $('#edit_nombre_producto').val(rowData[1]); // Asume que el nombre del cliente es la segunda columna
                    $('#edit_almacen').val(rowData[2]); // Asume que el DNI es la tercera columna
                    $('#edit_estanteria').val(rowData[3]); // Asume que el teléfono es la tercera columna
                    $('#edit_cantidad').val(rowData[4]); // Asume que la organización es la cuarta columna

                } else {
                    $('#edit-form').hide();
                }
            });

            $('#edit-form span').click(function () {
                $('#edit-form').hide();
            });
        });
    </script>
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-left: 10%;
            margin-right: 10%;
        }
    </style>
    <title>Producto</title>
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
    <h2 style="text-align: center; margin-bottom: 20px;">Registro de productos</h2>
    <div style="text-align: center; margin-bottom: 20px;">
        <button id="register-button">Registrar producto</button>
    </div>
    <table id="tabla_productos" class="display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Almacén</th>
                <th>Estantería</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conexion = new mysqli('localhost', 'root', '', 'ss');

            $consulta = "SELECT producto.id_producto, producto.nombre_producto, producto.cantidad, almacen.id_almacen, almacen.nombre_almacen, estanteria.id_estanteria, estanteria.nombre_estanteria
            FROM producto
            INNER JOIN almacen ON producto.id_almacen = almacen.id_almacen
            INNER JOIN estanteria ON producto.id_estanteria = estanteria.id_estanteria
            ORDER BY producto.id_producto";

            $resultado = $conexion->query($consulta);

            $contador = 1;
            while ($producto = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='checkbox' class='select-row'></td>";
                echo "<td>" . $producto['id_producto'] . "</td>";
                echo "<td>" . $producto['nombre_producto'] . "</td>";
                echo "<td>" . $producto['nombre_almacen'] . "</td>";
                echo "<td>" . $producto['nombre_estanteria'] . "</td>";
                echo "<td>" . $producto['cantidad'] . "</td>";
                echo "</tr>";
                $contador++;
            }

            $conexion->close();
            ?>
        </tbody>
    </table>
    <div style="text-align: center;">
        <button id="edit-button" style="display: none;">Modificar</button>
        <button id="delete-button" style="display: none;">Eliminar</button>
    </div>
    <div id="register-form"
        style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div
            style="background-color: #fefefe; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; border: 1px solid #888; width: 50%;">
            <span style="color: #aaaaaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <p style="font-weight: bold; text-align: center;">Registrar producto</p>
            <form action="validar/registrar_producto.php" method="post">
                <label for="nombre_producto">Nombre del producto:</label>
                <input type="text" name="nombre_producto" id="nombre_producto" required>
                <label for="almacen">Almacén:</label>
                <select id="almacen" name="almacen">
                    <?php
                    $conexion = new mysqli("localhost", "root", "", "ss");
                    $consulta = "SELECT id_almacen,nombre_almacen FROM almacen";
                    $resultado = $conexion->query($consulta);
                    while ($almacen = $resultado->fetch_assoc()) {
                        echo "<option value='" . $almacen['id_almacen'] . "'>" . $almacen['nombre_almacen'] . "</option>";
                    }
                    $conexion->close();
                    ?>
                </select>
                <label for="estanteria">Estantería:</label>
                <select id="estanteria" name="estanteria">
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" required>
                <br>
                <input type="submit" value="Registrar">
            </form>
        </div>
    </div>
    <div id="edit-form"
        style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div
            style="background-color: #fefefe; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; border: 1px solid #888; width: 50%;">
            <span style="color: #aaaaaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <p style="font-weight: bold; text-align: center;">Editar producto</p>
            <form action="validar/editar_producto.php" method="post">
                <label for="edit_id_producto">ID del producto:</label>
                <input type="text" name="edit_id_producto" id="edit_id_producto" readonly>
                <label for="edit_nombre_producto">Nombre del producto:</label>
                <input type="text" name="edit_nombre_producto" id="edit_nombre_producto">
                <label for="edit_almacen">Almacén:</label>
                <select id="edit_almacen" name="edit_almacen">
                    <?php
                    $conexion = new mysqli("localhost", "root", "", "ss");
                    $consulta = "SELECT id_almacen,nombre_almacen FROM almacen";
                    $resultado = $conexion->query($consulta);
                    while ($almacen = $resultado->fetch_assoc()) {
                        echo "<option value='" . $almacen['id_almacen'] . "'>" . $almacen['nombre_almacen'] . "</option>";
                    }
                    $conexion->close();
                    ?>
                </select>
                <label for="edit_estanteria">Estantería:</label>
                <select id="edit_estanteria" name="edit_estanteria">
                </select>
                <label for="edit_cantidad">Cantidad:</label>
                <input type="number" name="edit_cantidad" id="edit_cantidad">
                <br>
                <input type="submit" value="Editar">
            </form>
        </div>
    </div>
    <div id="delete-confirm"
        style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%;">
            <span style="color: #aaaaaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <p>¿Estás seguro de que quieres eliminar las filas seleccionadas?</p>
            <button action="validar/eliminar_producto.php" id="delete-confirm-button">Eliminar</button>
            <button id="delete-cancel-button">Cancelar</button>
        </div>
    </div>
</body>

</html>