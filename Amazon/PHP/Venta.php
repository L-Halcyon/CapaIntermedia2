<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$sql = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($sql);
$stmt->execute();

foreach($stmt as $row)
{
    $idusuario = $row['Usuario_ID'];

    $sql1 = "SELECT * FROM Carrito WHERE Usu_ID = '$idusuario' AND Estado = 1";
    $stmt1 = $miConexion->prepare($sql1);
    $stmt1->execute();

    foreach($stmt1 as $row1)
    {
        $idproductocarr = $row1['Prod_ID'];
        $precio = $row1['Precio_Unitario'];
        $cantcarr = $row1['Cantidad'];

        $sql2 = "SELECT * FROM Producto WHERE Producto_ID = '$idproductocarr'";
        $stmt2 = $miConexion->prepare($sql2);
        $stmt2->execute();

        foreach($stmt2 as $row2)
        {
            $idusuarioprod = $row2['Usu_ID'];
            $cantprod = $row2['Disponibilidad'];

            $sql3 = "INSERT INTO Venta(FechaHora, Prod_ID, precioactualP, cant, Usu_ID) VALUES(NOW(), '$idproductocarr', '$precio', '$cantcarr', '$idusuarioprod')";
            $stmt3 = $miConexion->prepare($sql3);
            $stmt3->execute();

            $sql6 = "SELECT * FROM Producto WHERE Producto_ID = '$idproductocarr'";
            $stmt6 = $miConexion->prepare($sql6);
            $stmt6->execute();

            foreach($stmt6 as $row6)
            {
                $idcateg6 = $row6['categ_ID'];

                $sql5 = "INSERT INTO Pedido(FechaHora, IDCateg, IDProd, Precio, Usu_ID) VALUES(NOW(), '$idcateg6', '$idproductocarr', '$precio', '$idusuario')";
                $stmt5 = $miConexion->prepare($sql5);
                $stmt5->execute();
            }
            
            $cantfinal = $cantprod - $cantcarr;

            $sql4 = "UPDATE Producto SET Disponibilidad = '$cantfinal' WHERE Producto_ID = '$idproductocarr'";
            $stmt4 = $miConexion->prepare($sql4);
            $stmt4->execute();
            $sql10 = "UPDATE Carrito SET Estado = 0 WHERE Prod_ID = '$idproductocarr'";
            $stmt10 = $miConexion->prepare($sql10);
            $stmt10->execute();
        }
    }
}

header("location: ../HTML/PagIni.php");

?>