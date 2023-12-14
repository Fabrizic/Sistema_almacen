<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href='styles/style_cliente.css' rel='stylesheet'>
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
        var editQueue = [];
        $(document).ready(function () {
            var table = $('#tabla_clientes').DataTable();

            $('#register-button').click(function () { 
                $('#register-form').show();
            });

            $('#register-form span').click(function () {
                $('#register-form').hide();
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

            $('#confirm-delete').click(function () {
                var selectedRows = table.rows('.selected').data();
                var clientes_seleccionados = [];
                selectedRows.each(function (rowData) {
                    clientes_seleccionados.push(rowData[2]); // Asume que el nombre del cliente es la segunda columna
                });

                $.ajax({
                    url: 'validar/eliminar_cliente.php',
                    method: 'POST',
                    data: { clientes_seleccionados: clientes_seleccionados },
                    success: function () {
                        location.reload(); // Recargar la página para mostrar los cambios
                    }
                });
            });

            $('#edit-button').click(function () {
                var row = $('.select-row:checked').closest('tr');
                var id_cliente = row.find('td:eq(1)').text();
                var nombre_cliente = row.find('td:eq(2)').text();
                var dni = row.find('td:eq(3)').text();
                var telefono = row.find('td:eq(4)').text();
                var organizacion = row.find('td:eq(5)').text();

                $('#edit_id_cliente').val(id_cliente);
                $('#edit_nombre_cliente').val(nombre_cliente);
                $('#edit_dni').val(dni);
                $('#edit_telefono').val(telefono);
                $('#edit_organizacion').val(organizacion);

                $('#edit-form').show();
            });

            $('#edit-form form').submit(function () {

                if (editQueue.length > 0) {
                    var rowData = editQueue.shift();
                    $('#edit_id_cliente').val(rowData[0]); // Asume que el ID del cliente es la primera columna
                    $('#edit_nombre_cliente').val(rowData[1]); // Asume que el nombre del cliente es la segunda columna
                    $('#edit_dni').val(rowData[2]); // Asume que el DNI es la tercera columna
                    $('#edit_telefono').val(rowData[3]); // Asume que el teléfono es la tercera columna
                    $('#edit_organizacion').val(rowData[4]); // Asume que la organización es la cuarta columna

                    $('#edit_organizacion option').each(function () {
                        if ($(this).val() == rowData[3]) {
                            $(this).prop('selected', true);
                        } else {
                            $(this).prop('selected', false);
                        }
                    });

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
    <h2 style="text-align: center; margin-bottom: 20px;">Registro de clientes</h2>
    <div style="text-align: center; margin-bottom: 20px;">
        <button id="register-button">Registrar cliente</button>
    </div>
    <table id="tabla_clientes" class="display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Organización</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conexion = new mysqli('localhost', 'root', '', 'SS');

            $query = "SELECT cliente.id_cliente, cliente.nombre_cliente, cliente.dni, cliente.telefono, organizacion.nombre_organizacion 
                    FROM cliente 
                    INNER JOIN organizacion ON cliente.id_organizacion = organizacion.id_organizacion
                    ORDER BY cliente.id_cliente";
            $resultado = $conexion->query($query);

            $contador = 1;
            while ($cliente = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='checkbox' class='select-row'></td>"; // Checkbox
                echo "<td>" . $cliente['id_cliente']. "</td>"; // Aca podemos cambiar por contador
                echo "<td>" . $cliente['nombre_cliente'] . "</td>";
                echo "<td>" . $cliente['dni'] . "</td>";
                echo "<td>" . $cliente['telefono'] . "</td>";
                echo "<td>" . $cliente['nombre_organizacion'] . "</td>";
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
            <p style="font-weight: bold; text-align: center;">Registrar cliente</p>
            <form action="validar/registrar_cliente.php" method="post">
                <label for="nombre_cliente">Nombre:</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono">
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'ss');

                // Ejecutar la consulta SQL para obtener los nombres de las organizaciones
                $sql = "SELECT nombre_organizacion FROM organizacion";
                $resultado = $conexion->query($sql);
                ?>

                <label for="organizacion">Organización:</label>
                <select id="organizacion" name="organizacion">
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <option value="<?php echo $row['nombre_organizacion']; ?>">
                            <?php echo $row['nombre_organizacion']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
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
            <p style="font-weight: bold; text-align: center;">Editar cliente</p>
            <form action="validar/editar_cliente.php" method="post">
                <label for="edit_id_cliente">ID:</label>
                <input type="text" id="edit_id_cliente" name="edit_id_cliente" readonly> <!-- readonly="readonly" significa que el campo no se puede editar -->
                <label for="edit_nombre_cliente">Nombre:</label>
                <input type="text" id="edit_nombre_cliente" name="edit_nombre_cliente">
                <label for="edit_dni">DNI:</label>
                <input type="text" id="edit_dni" name="edit_dni">
                <label for="edit_telefono">Teléfono:</label>
                <input type="text" id="edit_telefono" name="edit_telefono">
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'ss');

                // Ejecutar la consulta SQL para obtener los nombres de las organizaciones
                $sql = "SELECT nombre_organizacion FROM organizacion";
                $resultado = $conexion->query($sql);
                ?>

                <label for="edit_organizacion">Organización:</label>
                <select id="edit_organizacion" name="edit_organizacion">
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <option value="<?php echo $row['nombre_organizacion']; ?>">
                            <?php echo $row['nombre_organizacion']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
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
            <button action="validar/eliminar_cliente.php" id="confirm-delete">Eliminar</button>
            <button id="cancel-delete">Cancelar</button>
        </div>
    </div>
</body>
</html>