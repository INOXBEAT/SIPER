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
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 40px;"><b>LISTADO DE PROVEEDORES</b></h3>
                    <div class="card-tools">
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
                                <th>Contacto</th>
                                <th>Dirección</th>
                                <th>Empresa</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
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