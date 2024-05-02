<?php

require 'controlpanel.php';
require 'conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: tables.php");
}

$tipo_usuario = $_SESSION['tipo_usuario'];
$nombre = $_SESSION['nombre'];
$id = $_SESSION['id'];


if ($tipo_usuario == 1) {
    $where = "";
} else if ($tipo_usuario == 2) {
    $where = "WHERE id='$id'";
}

$sql = "SELECT * FROM usuario $where";
$resultado = $mysqli->query($sql);


?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>

        <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 40px;"><b>LISTADO DE USUARIOS</b></h3>
                    <div class="card-tools" style="display: flex; align-items: center;">

                        <div class="acciones" style="margin-right: 30px;">
                            <a href="generar_reportes.php?formato=pdf"><img src="pdf_icon.png" alt="PDF" style="width: 60px; height: 60px;"></a>
                            <a href="generar_reportes.php?formato=excel"><img src="excel_icon.png" alt="Excel" style="width: 60px; height: 60px;"></a>
                        </div>
                    </div>
                </div>
        </div>

                    <div class="card-body bg-light">
                        <table id="datatablesSimple" style="font-size: 25px;">
                            <thead>
                                <tr>
                                    <th>USUARIO</th>
                                    <th>NOMBRE</th>
                                    <th>TIPO DE USUARIO</th>
                                    <?php if ($tipo_usuario == 1) { ?>
                                        <th>ACCIONES</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>USUARIO</th>
                                    <th>NOMBRE</th>
                                    <th>TIPO DE USUARIO</th>
                                    <?php if ($tipo_usuario == 1) { ?>
                                        <th>ACCIONES</th>
                                    <?php } ?>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php while ($row = $resultado->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['usuario']; ?></td>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><?php echo $row['tipo_usuario']; ?></td>
                                        <?php if ($tipo_usuario == 1) { ?>
                                            <td>
                                                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" style="font-size: 25px;" class="btn btn-primary">Editar</a>
                                                <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" style="font-size: 25px;" class="btn btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar este usuario?')">Eliminar</a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
