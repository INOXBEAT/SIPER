<?php
require 'controlpanel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $query = "INSERT INTO productos (nombre, descripcion, cantidad, precio) VALUES ('$nombre', '$descripcion', $cantidad, $precio)";

    if (mysqli_query($mysqli, $query)) {
        $alert_message = 'Producto registrado correctamente';
        echo '<script>alert("' . $alert_message . '"); window.location.href = "productos.php";</script>';
        header("Location: productos.php");
        exit();
    } else {
        echo "Error al agregar el producto: " . mysqli_error($mysqli);
    }
}


$sql = "SELECT * FROM productos";
$resultado = mysqli_query($mysqli, $sql);

if (!$resultado) {
    echo "Error al consultar la base de datos: " . mysqli_error($mysqli);
    exit;
}
?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 40px;"><b>LISTADO DE PRODUCTOS</b></h3>
                    <div class="card-tools" style="display: flex; align-items: center;">

                        <div class="acciones" style="margin-right: 30px;">
                            <a href="generar_reportes.php?formato=pdf"><img src="pdf_icon.png" alt="PDF" style="width: 60px; height: 60px;"></a>
                            <a href="generar_reportes.php?formato=excel"><img src="excel_icon.png" alt="Excel" style="width: 60px; height: 60px;"></a>
                        </div>

                        <?php
                        if ($tipo_usuario == 1) { ?>

                            <a class="btn btn-success btn-lg" href="form_agregar.php" role="button" style="font-size: 30px;"><b>AGREGAR NUEVO PRODUCTO</b></a>
                        <?php } ?>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatablesSimple" style="font-size: 25px;">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>DESCRIPCIÓN</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO</th>
                                <?php if ($tipo_usuario == 1) { ?>
                                    <th>ACCIONES</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody style="font-size: 25px;">
                            <?php
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['descripcion']}</td>
                        <td>{$fila['cantidad']}</td>
                        <td>\${$fila['precio']}</td>";
                                if ($tipo_usuario == 1) {
                                    echo "<td>
                            <a href='editar_producto.php?id={$fila['id']}' class='btn btn-primary'>Editar</a>
                            <a href='eliminar_producto.php?id={$fila['id']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de querer eliminar este producto?\")'>Eliminar</a>
                          </td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</div>