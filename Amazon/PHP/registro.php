<?php
require_once "../PHP/conexion.php";

$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();
$Nombre = $_POST['Nombres'];
$Apellido = $_POST['Apellidos'];
$FechaNac = $_POST['FechadeNacimiento'];
$Correo = $_POST['CorreoElectrónico'];
$genero = $_POST['genero'];
$Usuario = $_POST['NombredeUsuario'];
$Contra = $_POST['Contraseña'];
$rol = $_POST['Rol'];
$errores = array();
$errores2 = array();
$contraE = array();
$fechaActual = date('Y-m-d');
//$ImagenPerfil = $_FILES['ImagendePerfil']['tmp_name'];
if (
    strlen($Contra) < 8 ||
    !preg_match('/[A-Z]/', $Contra) ||
    !preg_match('/[a-z]/', $Contra) ||
    !preg_match('/[0-9]/', $Contra) ||
    !preg_match('/[!@#$%^&*]/', $Contra)
) {
    array_push($contraE, "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.");
}
if (!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.com$/', $Correo)) {
    array_push($errores2, "El correo electrónico debe ser de formato @gmail.com o @hotmail.com");
}
if ($FechaNac >= $fechaActual) {
    array_push($errores2, "La fecha de nacimiento debe ser anterior a la fecha actual.");
}
if($Nombre === "")
{
    array_push($errores, "Nombres");
}
if($Apellido === "")
{
    array_push($errores, "Apellidos");
}
if($FechaNac === "")
{
    array_push($errores, "Fecha_Nacimiento");
}
if($Correo === "")
{
    array_push($errores, "Correo");
}
if($genero === "")
{
    array_push($errores, "Genero");
}
if($rol === "" || $Usuario === "")
{
    array_push($errores, "rol");
}
if(count($errores) > 0)
{
    $result = implode(", ", $errores);
    echo '<script>window.location.href="../HTML/InicioSesion.php"; alert("Falta la siguiente informacion: ' . $result . '"); </script>';
}
if(count($contraE) > 0)
{
    $result = implode(", ", $contraE);
    echo '<script>window.location.href="../HTML/RegistroUsuario.php"; alert("' . $result . '"); </script>';
}
if(count($errores2) > 0)
{
    $result = implode(", ", $errores2);
    echo '<script>window.location.href="../HTML/RegistroUsuario.php"; alert("' . $result . '"); </script>';
}
else{
    if (!isset($_FILES['ImagendePerfil']['tmp_name']) || empty($_FILES['ImagendePerfil']['tmp_name'])) {
        echo '<script>window.location.href="../HTML/RegistroUsuario.php"; alert("Falta una imagen"); </script>';
        exit();
    } else {
        $blob = addslashes(file_get_contents($_FILES['ImagendePerfil']['tmp_name']));
    }


if(buscaRepetido($Usuario, $Correo, $miConexion) == 1){
    echo '<script>window.location.href="../HTML/RegistroUsuario.php"; alert("El usuario ' . $Usuario . ' ya existe"); </script>';
   // echo '<script>alert("Este usuario ya existe");</script>';
    //header("Location: ../HTML/RegistroUsuario.php");
    exit();
} 
else {
   
    if($rol == 0) {
        $sql = "INSERT INTO Usuario (Correo, NomUsu, Contrasena, Rol, Nombres, Apellidos, FechaNac, Sexo, FechaIngreso, Eliminado, Privacidad, ImagenPerfil) VALUES (?, ?, ?, 'vendedores', ?, ?, ?, ?, NOW(), 0, 0, '$blob')";
    } elseif($rol == 1) {
        $sql = "INSERT INTO Usuario (Correo, NomUsu, Contrasena, Rol, Nombres, Apellidos, FechaNac, Sexo, FechaIngreso, Eliminado, Privacidad, ImagenPerfil) VALUES (?, ?, ?, 'clientes', ?, ?, ?, ?, NOW(), 0, 1, '$blob')";
    } elseif($rol == 2) {
        $sql = "INSERT INTO Usuario (Correo, NomUsu, Contrasena, Rol, Nombres, Apellidos, FechaNac, Sexo, FechaIngreso, Eliminado, Privacidad, ImagenPerfil) VALUES (?, ?, ?, 'administradores', ?, ?, ?, ?, NOW(), 0, 2, '$blob')";
    }
    
    // Preparar la sentencia SQL
    $stmt = $miConexion->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if (!$stmt) {
        echo 0; // Error en la preparación de la sentencia, devuelve un código de error
    } else {
        // Vincular los parámetros y ejecutar la sentencia SQL
        $stmt->bindParam(1, $Correo);
        $stmt->bindParam(2, $Usuario);
        $stmt->bindParam(3, $Contra);
        $stmt->bindParam(4, $Nombre);
        $stmt->bindParam(5, $Apellido);
        $stmt->bindParam(6, $FechaNac);
        $stmt->bindParam(7, $genero);
   
        if ($stmt->execute()) {
         
          
            header("Location: ../HTML/InicioSesion.php");
            exit(); 
        } else {
            echo 0; 
        }
    }
}

// Cerrar la conexión al finalizar
$miConexion = null;
}
function buscaRepetido($usuario, $correo, $conexion) {
    $sql = "SELECT * FROM Usuario WHERE NomUsu=? OR Correo=?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $correo);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return 1;
        }
    }

    return 0;
}

?>