<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idcateg = $_GET['idcateg'];

$sql = "SELECT * FROM Categoria where Nombre = '$nombre'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

if($stmt->rowCount() > 0)
{
    echo '<script>alert("Esta categoria ya existe");</script>';
}
else
{
    $sql2 = "UPDATE Categoria SET Eliminado = 1 WHERE Categoria_ID = '$idcateg'";
    $stmt2 = $miConexion->prepare($sql2);
    $stmt2->execute();

    header("location: ../HTML/Categorias.php");
}

?>