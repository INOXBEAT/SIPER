<?php

require 'controlpanel.php';
require 'conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

$tipo_usuario = $_SESSION['tipo_usuario'];
$nombre = $_SESSION['nombre'];
$id = $_SESSION['id'];

if ($tipo_usuario == 1) {
    $where = "";
} else if ($tipo_usuario == 2) {
    $where = "WHERE id='$id'";
}

$sql = "SELECT nombre, cantidad FROM productos $where";
$resultado = $mysqli->query($sql);

$sql_excedentes = "SELECT nombre, cantidad FROM productos ORDER BY cantidad DESC LIMIT 5";
$resultado_excedentes = $mysqli->query($sql_excedentes);

$sql_acabandose = "SELECT nombre, cantidad FROM productos ORDER BY cantidad ASC LIMIT 5";
$resultado_acabandose = $mysqli->query($sql_acabandose);

$productos_excedentes = array();
while ($row = $resultado_excedentes->fetch_assoc()) {
    $productos_excedentes[$row['nombre']] = $row['cantidad'];
}

$productos_acabandose = array();
while ($row = $resultado_acabandose->fetch_assoc()) {
    $productos_acabandose[$row['nombre']] = $row['cantidad'];
}
?>


<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="card text-white bg-danger" style=" margin-left: 10px; margin-right: 10px;">
                <div class="card-header" style="font-size: 40px;"><b>POR ACABAR</b></div>
                <div class="card-body">
                    <div class="container bg-white">
                        <table id="productos_acabandose" class="table table-bordered table-hover" style="font-size: 25px;">
                            <thead>
                                <tr>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos_acabandose as $producto => $cantidad) : ?>
                                    <tr>
                                        <td><?php echo $producto; ?></td>
                                        <td><?php echo $cantidad; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card text-white bg-success" style=" margin-left: 10px; margin-right: 10px;">
                <div class="card-header" style="font-size: 40px;"><b>EXCEDENTES</b></div>
                <div class="card-body">
                    <div class="container bg-white">
                        <table id="productos_excedentes" class="table table-bordered table-hover" style="font-size: 25px;">
                            <thead>
                                <tr>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos_excedentes as $producto => $cantidad) : ?>
                                    <tr>
                                        <td><?php echo $producto; ?></td>
                                        <td><?php echo $cantidad; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>