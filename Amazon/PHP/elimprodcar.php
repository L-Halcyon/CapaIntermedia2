<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idproducto = $_GET['idprod'];
$idcarrito = $_GET['idcar'];

$sql = "UPDATE Carrito SET Estado = 0 WHERE Prod_ID = '$idproducto' AND Carrito_ID = '$idcarrito'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

header("location: ../HTML/Carrito.php");

?>