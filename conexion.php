<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "sistema";
$charset = "utf8mb4"; 

$mysqli = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($mysqli->connect_errno) {
    throw new Exception("Error de conexión: " . $mysqli->connect_error);
}

if (!$mysqli->set_charset($charset)) {
    throw new Exception("Error al configurar el conjunto de caracteres: " . $mysqli->error);
}
