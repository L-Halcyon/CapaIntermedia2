<?php
    require_once "../PHP/conexion.php";
    $conexion = new Conexion();
    $miConexion = $conexion->obtenerConexion();
    
    session_start();
    
    $usuario = $_SESSION['username'];

    $idLista = $_GET['idLista'];

    $sql1 = "UPDATE Lista SET Eliminado = 1 WHERE Lista_ID = '$idLista'";
    $stmt1 = $miConexion->prepare($sql1);
    $stmt1->execute();
    header("location: ../HTML/Listas.php");
?>