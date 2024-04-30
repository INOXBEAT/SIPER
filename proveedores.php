<?php
require 'controlpanel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contacto = $_POST['contacto'];
    $direccion = $_POST['direccion'];
    $proveedor = $_POST['proveedor'];
    $estado = 1;
    $telefono = $_POST['telefono'];

    $query = "INSERT INTO proveedor (contacto, direccion, proveedor, estado, telefono)
    VALUES ('$contacto', '$direccion', '$proveedor', '$estado', '$telefono')";

    if (mysqli_query($mysqli, $query)) {
        $alert_message = 'Proveedor registrado correctamente';
        echo '<script>alert("' . $alert_message . '"); window.location.href = "proveedores.php";</script>';
        header("Location: proveedores.php");
        exit();
    } else {
        echo "Error al agregar el proveedor: " . mysqli_error($mysqli);
    }
}


$sql = "SELECT * FROM proveedor";
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
                    <h3 class="card-title" style="font-size: 40px;"><b>LISTADO DE PROVEEDORES</b></h3>
                    <div class="card-tools" style="display: flex; align-items: center;">

                        <div class="acciones" style="margin-right: 30px;">
                            <a href="generar_reportes.php?formato=pdf"><img src="pdf_icon.png" alt="PDF" style="width: 60px; height: 60px;"></a>
                            <a href="generar_reportes.php?formato=excel"><img src="excel_icon.png" alt="Excel" style="width: 60px; height: 60px;"></a>
                        </div>

                        <?php
                        if ($tipo_usuario == 1) { ?>

                            <a class="btn btn-success btn-lg" href="form_agregar_proveedor.php" role="button" style="font-size: 30px;"><b>AGREGAR NUEVO PROVEEDOR</b></a>
                        <?php } ?>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatablesSimple" style="font-size: 20px;">
                        <thead>
                            <tr>
                                <th>CONTACTO</th>
                                <th>DIRECCIÓN</th>
                                <th>EMPRESA</th>
                                <th>TELÉFONO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>
                        <td>{$fila['contacto']}</td>
                        <td>{$fila['direccion']}</td>
                        <td>{$fila['proveedor']}</td>
                        <td>{$fila['telefono']}</td>";
                                if ($tipo_usuario == 1) {
                                    echo "<td>
                            <a href='editar_proveedor.php?id={$fila['id']}' class='btn btn-primary'>Editar</a>
                            <a href='eliminar_proveedor.php?id={$fila['id']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de querer eliminar este producto?\")'>Eliminar</a>
                          </td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </main>
    </div>
</div>