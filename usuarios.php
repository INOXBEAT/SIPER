<?php

require 'controlpanel.php';

session_start();
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
            <div class="container-fluid">
                <h1 class="mt-4">USUARIOS</h1>
                
                <!-- Botón para agregar nuevo usuario (solo visible para administradores) -->
                <?php if ($tipo_usuario == 1) { ?>
                    <a href="form_agregar_usuario.php" class="btn btn-success btn-lg mb-3">Agregar Nuevo Usuario</a>
                <?php } ?>

                <div class="card bg-success">
                    <div class="card-body bg-light">
                        <table id="datatablesSimple" style="font-size: 20px;">
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
                                                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                                                <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar este usuario?')">Eliminar</a>
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
