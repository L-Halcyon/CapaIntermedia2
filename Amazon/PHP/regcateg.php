<?php
    require_once "../PHP/conexion.php";

    $conexion = new Conexion();
    $miConexion = $conexion->obtenerConexion();

    session_start();
    $usuario = $_SESSION['username'];

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
        echo '<script>alert("Falta la siguiente informacion: ' . $result . '"); window.location.href="../HTML/Categorias.php"; </script>';

    }
    else
    {
        $sql = "SELECT * FROM Categoria where Nombre = '$nombre'";
        $stmt = $miConexion->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            echo '<script>alert("Esta categoria ya existe"); window.location.href="../HTML/Categorias.php"; </script>';
        }
        else
        {
            $sql2 = "SELECT * FROM Usuario where NomUsu = '$usuario'";
            $stmt2 = $miConexion->prepare($sql2);
            $stmt2->execute();

            foreach($stmt2 as $row2)
            {
                $idusu = $row2['Usuario_ID'];

                $sql1 = "INSERT INTO Categoria(Nombre, Descripcion, Eliminado, Usu_ID) VALUES('$nombre', '$descrip', 0, '$idusu')";
                $stmt1 = $miConexion->prepare($sql1);
                $stmt1->execute();
                sleep(3);
                header("location: ../HTML/Categorias.php");
            }            
        }
    }
?>