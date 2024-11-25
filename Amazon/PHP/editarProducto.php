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
        
        $idproducto = $_POST['idprod'];
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
                    $stmt1 = $miConexion->prepare("CALL ModificarProducto($idproducto, '$descrip', '$nombre', 0, 1, '$cant', 0, 0, '$categoria', '$id')");
                    if($stmt1->execute())
                    {  
                        /*$sql2 = "SELECT MAX(Producto_ID) from Producto where Usu_ID = '$id'";
                        $stmt2 = $miConexion->prepare($sql2);
                        $stmt2->execute();*/
                        $sql3 = "SELECT Imagen_ID FROM Imagen_Prod WHERE Prod_ID = '$idproducto'";
                        $stmt3 = $miConexion->prepare($sql3);
                        $stmt3->execute();
                        $imagen_ids = $stmt3->fetchAll(PDO::FETCH_COLUMN);
                        if (!empty($image1["tmp_name"])) {
                            $blob1 = addslashes(file_get_contents($image1["tmp_name"]));
                            if (isset($imagen_ids[0])) {
                                $imagen_id1 = $imagen_ids[0];
                                $sql1 = "UPDATE Imagen_Prod SET nombre = '$name1', imagen = '$blob1', tipo = '$type1' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id1'";
                                $stmt1 = $miConexion->prepare($sql1);
                                $stmt1->execute();
                            } 
                        }
                           /* if (!empty($image1["tmp_name"])) {
                                $blob1 = addslashes(file_get_contents($image1["tmp_name"]));
                                $sql1 = "UPDATE Imagen_Prod SET nombre = '$name1', imagen = '$blob1', tipo = '$type1' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id'";
                                $stmt1 = $miConexion->prepare($sql1);
                                $stmt1->execute();
                            }*/
                            if (!empty($image2["tmp_name"])) {
                                $blob2 = addslashes(file_get_contents($image2["tmp_name"]));
                                if (isset($imagen_ids[1])) {
                                    $imagen_id2 = $imagen_ids[1];
                                    $sql2 = "UPDATE Imagen_Prod SET nombre = '$name2', imagen = '$blob2', tipo = '$type2' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id2'";
                                    $stmt2 = $miConexion->prepare($sql2);
                                    $stmt2->execute();
                                } 
                            }
                           /* if (!empty($image2["tmp_name"])) {
                                $blob2 = addslashes(file_get_contents($image2["tmp_name"]));
                                $sql2 = "UPDATE Imagen_Prod SET nombre = '$name2', imagen = '$blob2', tipo = '$type2' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id'";
                                $stmt2 = $miConexion->prepare($sql2);
                                $stmt2->execute();
                            }*/
                            if (!empty($image3["tmp_name"])) {
                                $blob3 = file_get_contents($image3["tmp_name"]);
                                if (isset($imagen_ids[2])) {
                                    $imagen_id3 = $imagen_ids[2];
                                    $sql3 = "UPDATE Imagen_Prod SET nombre = ?, imagen = ?, tipo = ? WHERE Prod_ID = ? AND Imagen_ID = ?";
                                    $stmt3 = $miConexion->prepare($sql3);
                                    $stmt3->execute([$name3, $blob3, $type3, $idproducto, $imagen_id3]);
                                } else {
                                    $sql3 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES (?, ?, ?, ?)";
                                    $stmt3 = $miConexion->prepare($sql3);
                                    $stmt3->execute([$name3, $blob3, $type3, $idproducto]);
                                }
                            }
                        
                           /* if (!empty($image3["tmp_name"])) {
                                $blob3 = addslashes(file_get_contents($image3["tmp_name"]));
                                $sql3 = "UPDATE Imagen_Prod SET nombre = '$name3', imagen = '$blob3', tipo = '$type3' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id'";
                                $stmt3 = $miConexion->prepare($sql3);
                                $stmt3->execute();
                            }*/
                        }
                            //Voy aca
                            //VIDEO
                            $ruta = "Videos/";
                            $tmpvideo = $_FILES['video1']['tmp_name'];
                            $name = $_FILES['video1']['name'];
                            
                            if (move_uploaded_file($tmpvideo, $ruta.$name)) {
                                $sql6 = "UPDATE Video_Producto SET direccion = '$name', tipo = '".$_FILES['video1']['type']."', tamano = '".$_FILES['video1']['size']."' WHERE Prod_ID = '$idprod'";
                                $stmt6 = $miConexion->prepare($sql6);
                                $stmt6->execute();
                                echo '<script>alert("SUBIDO TODO CON EXITO");</script>';
                                header("location: ../HTML/Perfil.php");
                            }
                        
                    
                }
                else
                {

                    $stmt7 = $miConexion->prepare("CALL ModificarProducto($idproducto, '$descrip', '$nombre', '$precio', 0, '$cant', 0, 0, '$categoria', '$id')");
                    /*$sql7 = "INSERT INTO Producto(Descripcion, Nombre, Precio, Tipo_Oferta, Disponibilidad, Eliminado, Validado, categ_ID, Usu_ID) VALUES ('$descrip', '$nombre', $precio, 0, '$cant', 0, 1, '$categoria', '$id')";
                    $stmt7 = $miConexion->prepare($sql7);*/

                    if($stmt7->execute())
                    {
                        $sql3 = "SELECT Imagen_ID FROM Imagen_Prod WHERE Prod_ID = '$idproducto'";
                        $stmt3 = $miConexion->prepare($sql3);
                        $stmt3->execute();
                        $imagen_ids = $stmt3->fetchAll(PDO::FETCH_COLUMN);
                        if (!empty($image1["tmp_name"])) {
                            $blob1 = addslashes(file_get_contents($image1["tmp_name"]));
                            if (isset($imagen_ids[0])) {
                                $imagen_id1 = $imagen_ids[0];
                                $sql1 = "UPDATE Imagen_Prod SET nombre = '$name1', imagen = '$blob1', tipo = '$type1' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id1'";
                                $stmt1 = $miConexion->prepare($sql1);
                                $stmt1->execute();
                            } 
                        }
                           /* if (!empty($image1["tmp_name"])) {
                                $blob1 = addslashes(file_get_contents($image1["tmp_name"]));
                                $sql1 = "UPDATE Imagen_Prod SET nombre = '$name1', imagen = '$blob1', tipo = '$type1' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id'";
                                $stmt1 = $miConexion->prepare($sql1);
                                $stmt1->execute();
                            }*/
                            if (!empty($image2["tmp_name"])) {
                                $blob2 = addslashes(file_get_contents($image2["tmp_name"]));
                                if (isset($imagen_ids[1])) {
                                    $imagen_id2 = $imagen_ids[1];
                                    $sql2 = "UPDATE Imagen_Prod SET nombre = '$name2', imagen = '$blob2', tipo = '$type2' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id2'";
                                    $stmt2 = $miConexion->prepare($sql2);
                                    $stmt2->execute();
                                } 
                            }
                           /* if (!empty($image2["tmp_name"])) {
                                $blob2 = addslashes(file_get_contents($image2["tmp_name"]));
                                $sql2 = "UPDATE Imagen_Prod SET nombre = '$name2', imagen = '$blob2', tipo = '$type2' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id'";
                                $stmt2 = $miConexion->prepare($sql2);
                                $stmt2->execute();
                            }*/
                            if (!empty($image3["tmp_name"])) {
                                $blob3 = file_get_contents($image3["tmp_name"]);
                                if (isset($imagen_ids[2])) {
                                    $imagen_id3 = $imagen_ids[2];
                                    $sql3 = "UPDATE Imagen_Prod SET nombre = ?, imagen = ?, tipo = ? WHERE Prod_ID = ? AND Imagen_ID = ?";
                                    $stmt3 = $miConexion->prepare($sql3);
                                    $stmt3->execute([$name3, $blob3, $type3, $idproducto, $imagen_id3]);
                                } else {
                                    $sql3 = "INSERT INTO Imagen_Prod(nombre, imagen, tipo, Prod_ID) VALUES (?, ?, ?, ?)";
                                    $stmt3 = $miConexion->prepare($sql3);
                                    $stmt3->execute([$name3, $blob3, $type3, $idproducto]);
                                }
                            }
                        
                           /* if (!empty($image3["tmp_name"])) {
                                $blob3 = addslashes(file_get_contents($image3["tmp_name"]));
                                $sql3 = "UPDATE Imagen_Prod SET nombre = '$name3', imagen = '$blob3', tipo = '$type3' WHERE Prod_ID = '$idproducto' AND Imagen_ID = '$imagen_id'";
                                $stmt3 = $miConexion->prepare($sql3);
                                $stmt3->execute();
                            }*/
                        }
                            //Voy aca
                            //VIDEO
                            $ruta = "Videos/";
                            $tmpvideo = $_FILES['video1']['tmp_name'];
                            $name = $_FILES['video1']['name'];
                            
                            if (move_uploaded_file($tmpvideo, $ruta.$name)) {
                                $sql6 = "UPDATE Video_Producto SET direccion = '$name', tipo = '".$_FILES['video1']['type']."', tamano = '".$_FILES['video1']['size']."' WHERE Prod_ID = '$idprod'";
                                $stmt6 = $miConexion->prepare($sql6);
                                $stmt6->execute();
                                echo '<script>alert("SUBIDO TODO CON EXITO");</script>';
                                header("location: ../HTML/Perfil.php");
                            }
                    }
                }
            }
            $miConexion = null;
           
        // Cerrar la conexión al finalizar
       

    ?>
</body>
</html>