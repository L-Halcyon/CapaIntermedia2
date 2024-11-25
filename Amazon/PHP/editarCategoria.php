<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idcateg = $_POST['idcateg'];
$nombre = $_POST['nombre'];
$descrip = $_POST['decrip'];

$errores = array();

if($nombre === "")
{
    array_push($errores, "Nombre");
}

if($descrip === "")
{
    array_push($errores, "Descripcion");
}

if(count($errores) > 0)
{
    $result = implode(", ", $errores);
    echo '<script>alert("Falta la siguiente informacion: ' . $result . '"); window.location.href="../HTML/EditCateg.php?idcateg=' . $idcateg . '";</script>';

}
else
{
    $sql = "SELECT * FROM Categoria where Nombre = '$nombre'";
    $stmt = $miConexion->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        echo '<script>alert("Esta categoria ya existe"); window.location.href="../HTML/Categorias.php";</script>';
    }
    else
    {
        $stmt = $miConexion->prepare("CALL EditarCategoria(?, ?, ?)");
        $stmt->bindParam(1, $idcateg);
        $stmt->bindParam(2, $nombre);
        $stmt->bindParam(3, $descrip);
        $stmt->execute();

        // Verificar si hubo algún error al ejecutar el procedimiento almacenado
        if (!$stmt) {
            echo "Error al ejecutar el procedimiento almacenado: ";
        } else {
            header("location: ../HTML/Categorias.php");
        }
        /*$sql2 = "UPDATE Categoria SET Nombre = '$nombre', Descripcion = '$descrip' WHERE Categoria_ID = '$idcateg'";
        $stmt2 = $miConexion->prepare($sql2);
        $stmt2->execute();

        header("location: ../HTML/Categorias.php");*/
    }
}

?>