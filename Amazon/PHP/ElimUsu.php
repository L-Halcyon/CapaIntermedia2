<?php

require_once "conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$sql = "UPDATE Usuario set Eliminado=1 where NomUsu='$usuario'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

session_destroy();
header("location: ../HTML/InicioSesion.php");

?>