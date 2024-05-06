<?php

require "conexion.php";

session_start();

if ($_POST) {

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, nombre, tipo_usuario FROM usuario WHERE usuario = '$usuario'";
    $resultado = $mysqli->query($sql);
    $num = $resultado->num_rows;

    if ($num > 0) {

        $row = $resultado->fetch_assoc();
        $password_bd = $row['password'];

        $pass_c = sha1($password);

        if ($password_bd == $pass_c) {

            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
            $nombre = $row['nombre'];

            header("Location: main.php");
        } else {
            echo "<script>alert('USUARIO O CONTRASEÑA INVÁLIDO');</script>";
        }
    } else {
        echo "<script>alert('USUARIO O CONTRASEÑA INVÁLIDO');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ingreso SIPER</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="image.png">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body style="background-image: url(image.png); background-size: cover">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadonw-lg border-0 rounded-lg mt-5">
                                <div>
                                    <img class="logo" src="image.png" alt="logo">
                                </div>
                                <div class="card-header">
                                    <h3 class="text-center font-weight-large my-4">INGRESA TUS DATOS</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="usuario" type="text" placeholder="Ingrese nombre de usuario" />
                                            <label for="inputEmail">USUARIO</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword">CONTRASEÑA</label>
                                            <button type="button" class="btn btn-link position-absolute top-0 end-0 m-3" onclick="togglePasswordVisibility()">
                                                <i id="togglePasswordIcon" class="fa fa-eye"></i>
                                            </button>
                                        </div><br>
                                        <div class="btn btn-primary d-flex align-items-center justify-content-center" style="font-size: 30px;">
                                            <button type="submit" class="btn btn-primary"><b>INGRESAR</b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("inputPassword");
            const toggleIcon = document.getElementById("togglePasswordIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>