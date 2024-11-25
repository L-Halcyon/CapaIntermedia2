<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idproducto = $_GET['idprod'];
$idlista = $_GET['idlist'];

$q = "INSERT INTO Producto_Lista(Prod_ID, Lis_ID) VALUES('$idproducto', '$idlista')";
$stmt = $miConexion->prepare($q);
$stmt->execute();

header("location: ../HTML/PagIni.php");

?>