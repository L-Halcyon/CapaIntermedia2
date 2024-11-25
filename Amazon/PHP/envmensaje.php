<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idusuario = $_POST['idUsu'];
$idusucon = $_POST['idUsucon'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO Mensajes(ID_usuario, Mensaje, ID_usuariorecibidor) VALUES('$idusuario', '$mensaje', '$idusucon')";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

$sql1 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusucon'";
$stmt1 = $miConexion->prepare($sql1);
$stmt1->execute();

foreach($stmt1 as $row1)
{
    $nombreusuario = $row1['NomUsu'];

    header("location: ../HTML/Cotizar.php?nombusu=".$nombreusuario);
}



?>