<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idprod = $_POST['idprod'];
$cantidad = $_POST['cantidad'];

$sql = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

$sql1 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod'";
$stmt1 = $miConexion->prepare($sql1);
$stmt1->execute();

if($cantidad == "")
{
    echo '<script>window.location.href = "../HTML/PagIni.php"; alert("NO HAY NINGUNA CANTIDAD"); </script>';
   /* echo '<script>alert("NO HAY NINGUNA CANTIDAD");</script>';*/
}
if($cantidad == 0)
{
    echo '<script>window.location.href = "../HTML/PagIni.php"; alert("no se puede agregar 0"); </script>';
    /*echo '<script>alert("no se puede agregar 0");</script>';*/
}
else
{
    foreach($stmt1 as $row1)
    {
        $cantidadproducto = $row1['Disponibilidad'];
        $precio = $row1['Precio'];

        if($cantidad > $cantidadproducto)
        {
            echo '<script>alert("Esta cantidad sobrepasa");</script>';
        }
        else
        {
            foreach($stmt as $row)
            {
                $idusuario = $row['Usuario_ID'];
                $stmt1 = $miConexion->prepare("CALL InsertarAlCarrito('$cantidad', '$precio', '$idprod', '$idusuario')");
                $stmt1->execute();
              //  $sql2 = "INSERT INTO Carrito(Cantidad, Precio_Unitario, Estado, Prod_ID, Usu_ID) VALUES('$cantidad', '$precio', 1, '$idprod', '$idusuario')";
                //$stmt2 = $miConexion->prepare($sql2);
                //$stmt2->execute();

                header("location: ../HTML/PagIni.php");
            }
        }
    }
}

?>