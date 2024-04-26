<?php

session_start();
require 'conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

$tipo_usuario = $_SESSION['tipo_usuario'];
$nombre = $_SESSION['nombre'];

$query = "SELECT * FROM productos";
$resultado = mysqli_query($mysqli, $query);

if (!$resultado) {
    die("Error al obtener los productos: " . mysqli_error($mysqli));
}

$productos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
mysqli_free_result($resultado);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIPER Inventarios Papelería el Radar</title>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="image.png">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #clock {
            font-size: 24px;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

        <!-- LOGO & BRAND -->
        <a class="navbar-brand ps-3" href="main.php">
            <img src="image.png" alt="logo" style="height: 30px; margin-left: 40px; font-size: 40px">
            <b>SIPER</b><br>
        </a>

        <!-- SIDEBAR TOGGLE -->
        <button class="btn btn-link btn-lg order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!" style="font-size: 30px;"><i class="fas fa-bars"></i></button>

        <!-- TOP NAVBAR -->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombre; ?><i class="fas fa-user fa-fw" style="padding-left: 12px;"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li style="text-align: center; font-size: 25px;"><?php echo $nombre; ?></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="logout.php" style="text-align: center;">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- LATERAL NAVBAR OPTIONS-->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu" style="font-size: 20px;">
                    <div class="nav">
                        <!-- CLOCK -->
                        <div id="clock"></div>
                        <script>
                            function updateTime() {
                                var now = new Date();
                                var date = now.toLocaleDateString();
                                var time = now.toLocaleTimeString();
                                var dateTimeString = date + ' ' + time;
                                document.getElementById('clock').textContent = dateTimeString;
                            }

                            // Actualizar la hora cada segundo
                            setInterval(updateTime, 1000);

                            // Mostrar la hora al cargar la página
                            updateTime();
                        </script>

                        <div class="sb-sidenav-menu-heading"></div>

                        <a class="nav-link" href="productos.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-list" style="margin-right: 2px;"></i>
                            </div>PRODUCTOS
                        </a>

                        <a class="nav-link btn btn-success" href="venta.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-dollar-sign" style="margin-right: 8px;"></i>
                            </div><b>VENTAS</b>
                        </a>

                        <!-- ACCESO ÚNICAMENTE PARA ADMINISTRADOR -->
                        <?php
                        if ($tipo_usuario == 1) { ?>

                            <a class="nav-link" href="proveedores.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fa-solid fa-truck-field"></i>
                                </div>PROVEEDORES
                            </a>

                            <!-- SYSTEM CONFIGURATION -->
                            <div class="sb-sidenav-menu-heading">CONFIGURACIÓN</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>

                                AVANZADA<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    
                                    <a class="nav-link collapsed" href="usuarios.php">
                                        <i class="fa-solid fa-user" style="margin-right: 10px;"></i> Usuarios
                                    </a>

                                    <a class="nav-link collapsed" href="historial_ventas.php">
                                        <i class="fa-solid fa-circle-info" style="margin-right: 10px;"></i> Historial
                                    </a>
                                </nav>
                            </div>


                        <?php } ?>

                        <br><br>

                        <a class="nav-link btn btn-danger position-relative bottom-0" href="logout.php" style="font-size: 20px">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div><b>CERRAR SESIÓN</b>
                        </a>


                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Sesión iniciada por:</div>
                    <?php
                    if (isset($_SESSION['nombre'])) {
                        echo $_SESSION['nombre'];
                    } ?>
                </div>
            </nav>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
