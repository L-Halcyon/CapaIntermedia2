<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];
$idrecibidor = $_POST['idusu'];
$idusuario = $_POST['Nomusu'];
$idprod = $_POST['idproducto'];
$idnombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$Cantidad = $_POST['Cantidad'];
$Especificaciones = $_POST['Especificaciones'];

if($precio == "")
{
    echo '<script>alert("No ha ingresado el precio");</script>';
}

if($Cantidad == "")
{
    echo '<script>alert("No ha ingresado cantidad");</script>';
}
if($Especificaciones == "")
{
    echo '<script>alert("No ha ingresado especificaciones");</script>';
}
else
{
    $stmt = $miConexion->prepare("CALL InsertarProductoCotizable('$idprod', '$descripcion', '$idnombre','$precio', '$Cantidad', '$Especificaciones', '$idusuario', '$idrecibidor',0)");
    $stmt->execute();

$sql1 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idrecibidor'";
$stmt1 = $miConexion->prepare($sql1);
$stmt1->execute();

foreach($stmt1 as $row1)
{
    $nombreusuario = $row1['NomUsu'];

    header("location: ../HTML/Cotizar.php?nombusu=".$nombreusuario);
}

}

?>