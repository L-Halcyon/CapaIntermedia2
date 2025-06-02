<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$usucon = $_POST['usuc'];
$idproducto = $_POST['idprod'];
$precio = $_POST['Precio'];
$cant = $_POST['cant'];


    $sql = "SELECT * FROM Usuario WHERE Usuario_ID = '$usucon'";
    $stmt = $miConexion->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $idusuariocon = $row['Usuario_ID'];

       // $sql1 = "INSERT INTO Carrito(Cantidad, Precio_Unitario, Estado, Prod_ID, Usu_ID) VALUES($cant, '$precio', 1, '$idproducto', '$idusuariocon')";
       // $stmt1 = $miConexion->prepare($sql1);
       // $stmt1->execute();
        $stmt1 = $miConexion->prepare("CALL InsertarAlCarrito('$cant', '$precio', '$idproducto', '$idusuariocon')");
        $stmt1->execute();
        header("location: ../HTML/Carrito.php");
    }
    else {
        // Manejar el caso donde no se encontró ningún usuario con el nombre dado
        echo "No se encontró ningún usuario con el nombre '$usucon'";
    }


?>