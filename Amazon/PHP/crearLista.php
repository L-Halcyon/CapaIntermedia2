<?php
require_once "../PHP/conexion.php";

$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$nombrelista = $_POST['nombre'];
$descripcionlista = $_POST['decrip'];
$tipolista = $_POST['tipo'];

$sql = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

foreach($stmt as $row)
{
    $idusuario = $row['Usuario_ID'];

    $sql1 = "INSERT INTO Lista(Nombre, Descripcion, Tipo, Eliminado, Usu_ID) VALUES('$nombrelista', '$descripcionlista', '$tipolista', 0, '$idusuario')";
    $stmt1 = $miConexion->prepare($sql1);
    $stmt1->execute();
    
    header("location: ../HTML/Listas.php");
}

?>