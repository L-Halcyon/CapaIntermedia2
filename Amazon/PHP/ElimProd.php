<?php
    require_once "../PHP/conexion.php";
    $conexion = new Conexion();
    $miConexion = $conexion->obtenerConexion();
    
    session_start();
    
    $usuario = $_SESSION['username'];

    $idproducto = $_GET['idprod'];

    $sql1 = "UPDATE Producto SET Eliminado = 1 WHERE Producto_ID = '$idproducto'";
    $stmt1 = $miConexion->prepare($sql1);
    $stmt1->execute();
    header("location: ../HTML/Perfil.php");
?>