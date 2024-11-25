<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idlista = $_GET['idlist'];
$idproducto = $_GET['idprod'];

$sql = "DELETE FROM Producto_Lista WHERE Prod_ID = '$idproducto' AND Lis_ID = '$idlista'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

header("location: ../HTML/Perfil.php");

?>