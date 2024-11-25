<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idprod = $_GET['idprod'];
$tipoOferta = $_GET['tipo_oferta'];


    $sql = "UPDATE Producto SET Validado = 1 WHERE Producto_ID = '$idprod'";
    $stmt = $miConexion->prepare($sql);
    $stmt->execute();
    


$sql1 = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt1 = $miConexion->prepare($sql1);
$stmt1->execute();

foreach($stmt1 as $row1)
{
    $idusuadmin = $row1['Usuario_ID'];

    $sql2 = "INSERT INTO ProdCot_ADMIN(IdProdCot, IdUsuAdmin) VALUES('$idprod', '$idusuadmin')";
    $stmt2 = $miConexion->prepare($sql2);
    $stmt2->execute();
}

header("location: ../HTML/PerfilAdmin.php");
?>