<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "../PHP/conexion.php";

        $conexion = new Conexion();
        $miConexion = $conexion->obtenerConexion();

        session_start();
        $usuario = $_SESSION['username'];
        
        $nombre = $_POST['nombre'];
        $descrip = $_POST['decrip'];
        $precio = $_POST['prec'];
        $cant = $_POST['cant'];
      
        $image1 = $_FILES["foto1"];
        $name1 = $image1["name"];
        $type1 = $image1["type"];

        $image2 = $_FILES["foto2"];
        $name2 = $image2["name"];
        $type2 = $image2["type"];

        $image3 = $_FILES["foto3"];
        $name3 = $image3["name"];
        $type3 = $image3["type"];

        $video1 = $_FILES["video1"];
        $namev1 = $video1["name"];
        $typev1 = $video1["type"];

        $errores = array();

        if($nombre === "")
        {
            array_push($errores, "Nombre");
        }

        if($descrip === "")
        {
            array_push($errores, "Descripcion");
        }

        if(isset($_POST['categ']))
        {
            $categoria = $_POST['categ'];
        }
        else
        {
            array_push($errores, "Categoria");
        }

        if($cant === "")
        {
            array_push($errores, "Cantidad");
        }

        if($name1 === "")
        {
            array_push($errores, "Foto 1");
        }

        if($name2 === "")
        {
            array_push($errores, "Foto 2");
        }

        if($name3 === "")
        {
            array_push($errores, "Foto 3");
        }

        if($namev1 === "")
        {
            array_push($errores, "Video");
        }
      // Verificar si el producto está marcado como "cotizable"
$cotizable = isset($_POST['cotizable']);

// Si el producto no está marcado como "cotizable", aplicar la validación del precio
if (!$cotizable && $precio === "")
{
    array_push($errores, "Precio");
}

        if(count($errores) > 0)
        {
            $result = implode(", ", $errores);
            echo '<script>alert("Falta la siguiente informacion: ' . $result . '");window.location.href="../HTML/PubProd.php"; </script>';
        }
      
        else
        {
            $sql = "SELECT * FROM Usuario where NomUsu = '$usuario'";
            $stmt = $miConexion->prepare($sql);
            $stmt->execute();

            foreach($stmt as $row)
            {
                $id = $row['Usuario_ID'];

                if($cotizable && $precio === "")
                {
                    $sql1 = "INSERT INTO Producto(Descripcion, Nombre, Precio, Tipo_Oferta, Disponibilidad, Eliminado, Validado, categ_ID, Usu_ID) VALUES ('$descrip', '$nombre', 0, 1, '$cant', 0, 0, '$categoria', '$id')";
                    $stmt1 = $miConexion->prepare($sql1);

                    if($stmt1->execute())
                    {
                        $sql2 = "SELECT MAX(Producto_ID) from Producto where Usu_ID = '$id'";
                        $stmt2 = $miConexion->prepare($sql2);
                        $stmt2->execute();

                        foreach($stmt2 as $row)
                        {
                            $idprod = $row['MAX(Producto_ID)'];

                            $blob1 = addslashes(file_get_contents($image1["tmp_name"]));
                            $blob2 = addslashes(file_get_contents($image2["tmp_name"]));
                            $blob3 = addslashes(file_get_contents($image3["tmp_name"]));
                            
                            //IMAGEN 1
                            $sql3 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES('$name1', '$blob1', '$type1', '$idprod')";
                            $stmt3 = $miConexion->prepare($sql3);
                            $stmt3->execute();

                            //IMAGEN 2
                            $sql4 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES('$name2', '$blob2', '$type2', '$idprod')";
                            $stmt4 = $miConexion->prepare($sql4);
                            $stmt4->execute();

                            //IMAGEN 3
                            $sql5 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES('$name3', '$blob3', '$type3', '$idprod')";
                            $stmt5 = $miConexion->prepare($sql5);
                            $stmt5->execute();

                            //VIDEO
                            $ruta = "Videos/";
                            $tmpvideo = $_FILES['video1']['tmp_name'];
                            $name = $_FILES['video1']['name'];

                            if(move_uploaded_file($tmpvideo, $ruta.$name))
                            {
                                $sql6 = "INSERT INTO Video_Producto(direccion, tipo, tamano, Prod_ID) VALUES('".$_FILES['video1']['name']."','".$_FILES['video1']['type']."','".$_FILES['video1']['size']."', '$idprod')";
                                $stmt6 = $miConexion->prepare($sql6);
                                $stmt6->execute();
                                echo '<script>alert("SUBIDO TODO CON EXITO");</script>';
                                header("location: ../HTML/PagIni.php");
                            }
                        }
                    }
                }
                else
                {
                    $sql7 = "INSERT INTO Producto(Descripcion, Nombre, Precio, Tipo_Oferta, Disponibilidad, Eliminado, Validado, categ_ID, Usu_ID) VALUES ('$descrip', '$nombre', $precio, 0, '$cant', 0, 0, '$categoria', '$id')";
                    $stmt7 = $miConexion->prepare($sql7);

                    if($stmt7->execute())
                    {
                        $sql8 = "SELECT MAX(Producto_ID) from Producto where Usu_ID = '$id'";
                        $stmt8 = $miConexion->prepare($sql8);
                        $stmt8->execute();

                        foreach($stmt8 as $row)
                        {
                            $idprod = $row['MAX(Producto_ID)'];

                            $blob11 = addslashes(file_get_contents($image1["tmp_name"]));
                            $blob22 = addslashes(file_get_contents($image2["tmp_name"]));
                            $blob33 = addslashes(file_get_contents($image3["tmp_name"]));
                            
                            //IMAGEN 1
                            $sql9 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES('$name1', '$blob11', '$type1', '$idprod')";
                            $stmt9 = $miConexion->prepare($sql9);
                            $stmt9->execute();

                            //IMAGEN 2
                            $sql10 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES('$name2', '$blob22', '$type2', '$idprod')";
                            $stmt10 = $miConexion->prepare($sql10);
                            $stmt10->execute();

                            //IMAGEN 3
                            $sql11 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES('$name3', '$blob33', '$type3', '$idprod')";
                            $stmt11 = $miConexion->prepare($sql11);
                            $stmt11->execute();

                            //VIDEO
                            $ruta = "Videos/";
                            $tmpvideo = $_FILES['video1']['tmp_name'];
                            $name = $_FILES['video1']['name'];

                            if(move_uploaded_file($tmpvideo, $ruta.$name))
                            {
                                $sql12 = "INSERT INTO Video_Producto(direccion, tipo, tamano, Prod_ID) VALUES('".$_FILES['video1']['name']."','".$_FILES['video1']['type']."','".$_FILES['video1']['size']."', '$idprod')";
                                $stmt12 = $miConexion->prepare($sql12);
                                $stmt12->execute();
                                echo '<script>alert("SUBIDO TODO CON EXITO");</script>';
                                header("location: ../HTML/PagIni.php");
                            }
                        }
                    }
                }
            }
        }

        // Cerrar la conexión al finalizar
        $miConexion = null;

    ?>
</body>
</html>