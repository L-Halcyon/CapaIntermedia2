<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];
$idproducto = $_GET['idprod'];

$sql = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

foreach($stmt as $row)
{
    $idusuario = $row['Usuario_ID'];

    $sql1 = "SELECT * FROM Producto WHERE Producto_ID = '$idproducto'";
    $stmt1 = $miConexion->prepare($sql1);
    $stmt1->execute();

    foreach($stmt1 as $row1)
    {
        $idusuarioproducto = $row1['Usu_ID'];

        $sql2 = "INSERT INTO Contactos(IdUsuario, IdUsuariocon) VALUES('$idusuario', '$idusuarioproducto')";
        $stmt2 = $miConexion->prepare($sql2);
        $stmt2->execute();

        $sql3 = "INSERT INTO Contactos(IdUsuario, IdUsuariocon) VALUES('$idusuarioproducto', '$idusuario')";
        $stmt3 = $miConexion->prepare($sql3);
        $stmt3->execute();

        header("location: ../HTML/Contactos.php");
    }
}
?>