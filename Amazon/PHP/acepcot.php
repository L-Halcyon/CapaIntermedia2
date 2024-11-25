<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];
$idprod = $_GET['idprod'];
$idusu = $_GET['idusu'];

    $stmt = $miConexion->prepare("CALL MarcarProductoCotizableAceptado('$idprod', 1)");
    $stmt->execute();

$sql1 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusu'";
$stmt1 = $miConexion->prepare($sql1);
$stmt1->execute();

foreach($stmt1 as $row1)
{
    $nombreusuario = $row1['NomUsu'];

    header("location: ../HTML/Cotizar.php?nombusu=".$nombreusuario);
}


?>