<?php

require_once "conexion.php";
$conexion = new Conexion(); // Crear una instancia de la clase Conexion
$miConexion = $conexion->obtenerConexion(); // Obtener la conexión

$usuario = $_POST['NombredeUsuario'];
$contra = $_POST['Contraseña'];
$errores = array();
$contraE = array();
if (
    strlen($contra) < 8 ||
    !preg_match('/[A-Z]/', $contra) ||
    !preg_match('/[a-z]/', $contra) ||
    !preg_match('/[0-9]/', $contra) ||
    !preg_match('/[!@#$%^&*]/', $contra)
) {
    array_push($contraE, "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.");
}
if($usuario === "")
{
    array_push($errores, "Nombre_de_usuario");
}
if($contra === "")
{
    array_push($errores, "Contraseña");
}
if(count($errores) > 0)
{
    $result = implode(", ", $errores);
    echo '<script>window.location.href="../HTML/InicioSesion.php"; alert("Falta la siguiente informacion: ' . $result . '"); </script>';
}/*
if(count($contraE) > 0)
{
    $result = implode(", ", $contraE);
    echo '<script>window.location.href="../HTML/InicioSesion.php"; alert("' . $result . '"); </script>';
}*/
else{
    $sql = "SELECT * FROM Usuario WHERE Correo=? and Contrasena=? AND Eliminado=0";
    $stmt = $miConexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $contra);
        $stmt->execute();
    
        if($stmt->rowCount() > 0) {
            
            session_start();
            //$_SESSION['username'] = $usuario;
           
            foreach($stmt as $row)
            {
                $priv = $row['Privacidad'];
                $usuarioID = $row['Usuario_ID'];
                $user = $row['NomUsu'];
                $_SESSION['username'] = $user;
                $_SESSION['user_id'] = $usuarioID;
                $_SESSION['TipoUsu'] =  $priv;
                if($priv == 0 || $priv == 1)
                {
                    header("location: ../HTML/PagIni.php");
                }
                else
                {
                    header("location: ../HTML/PerfilAdmin.php");
                }
            }
        }
        else{
            echo '<script>window.location.href="../HTML/InicioSesion.php"; alert("El usuario no existe"); </script>';
        }
    }
}


?>