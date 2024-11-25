<?php
require_once "../PHP/conexion.php";

$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$id = $_POST['idlista'];
$nombrelista = $_POST['nombre'];
$descripcionlista = $_POST['decrip'];
$tipolista = $_POST['tipo'];

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
    echo '<script>alert("Falta la siguiente informacion: ' . $result . '"); window.location.href="../HTML/Editlis.php?idcateg=' . $idcateg . '";</script>';

}
else{

  $sql = "SELECT * FROM Lista where Nombre = '$nombrelista'";
    $stmt = $miConexion->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        echo '<script>alert("Esta liste ya existe"); window.location.href="../HTML/Listas.php";</script>';
    }
    else{
        $stmt = $miConexion->prepare("CALL EditarLista(?, ?, ?, ?)");
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $nombrelista);
        $stmt->bindParam(3, $descripcionlista);
        $stmt->bindParam(4, $tipolista);
        $stmt->execute();

        // Verificar si hubo algún error al ejecutar el procedimiento almacenado
        if (!$stmt) {
            echo "Error al ejecutar el procedimiento almacenado: ";
        } else {
            header("location: ../HTML/Listas.php");
        }
    }
/*
foreach($stmt as $row)
{
    $idusuario = $row['Usuario_ID'];

    $sql1 = "UPDATE Lista SET Nombre = '$nombrelista', Descripcion = '$descripcionlista', Tipo = '$tipolista' WHERE Lista_ID = '$id'";
    $stmt1 = $miConexion->prepare($sql1);
    $stmt1->execute();
    
    header("location: ../HTML/Listas.php");
}*/
}


?>