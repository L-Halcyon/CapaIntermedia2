<?php
require_once "../PHP/conexion.php";

$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

$usuarioID = $_POST['ID']; // Suponiendo que tengas un campo oculto en tu formulario que contenga el ID del usuario que deseas modificar
$Nombre = $_POST['Nombres'];
$Apellido = $_POST['Apellidos'];
$FechaNac = $_POST['FechadeNacimiento'];
$Correo = $_POST['CorreoElectrónico'];
$genero = $_POST['genero'];
$Usuario = $_POST['NombredeUsuario'];
$Contra = $_POST['Contraseña'];
$priv = $_POST['privacidad'];

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
    echo '<script>window.location.href="../HTML/EditUsu.php"; alert("Falta la siguiente informacion: ' . $result . '"); </script>';
}
/*if(count($contraE) > 0)
{
    $result = implode(", ", $contraE);
    echo '<script>window.location.href="../HTML/EditUsu.php"; alert("' . $result . '"); </script>';
}*/
if(count($errores2) > 0)
{
    $result = implode(", ", $errores2);
    echo '<script>window.location.href="../HTML/EditUsu.php"; alert("' . $result . '"); </script>';
}
else{
   
    if (!isset($_FILES['ImagendePerfil']['tmp_name']) || empty($_FILES['ImagendePerfil']['tmp_name'])) {
        echo '<script>window.location.href="../HTML/EditUsu.php"; alert("Falta una imagen"); </script>';
        exit();
    } else {
        $blob = addslashes(file_get_contents($_FILES['ImagendePerfil']['tmp_name']));
    }
   

if(buscaRepetido($Usuario, $Correo, $miConexion) == 1){
    echo '<script>window.location.href="../HTML/EditUsu.php"; alert("El usuario ' . $Usuario . ' ya existe"); </script>';
    exit();
} else {
    // Si no hay datos duplicados, proceder con la modificación del usuario
    // Preparar la llamada al procedimiento almacenado
    $stmt = $miConexion->prepare("CALL ModificarUsuario(?, ?, ?, ?, ?, ?, ?, ?,'$priv', '$blob')");
    
    // Verificar si la preparación de la sentencia fue exitosa
    if (!$stmt) {
        echo 0; // Error en la preparación de la sentencia, devuelve un código de error
    } else {
        // Vincular los parámetros y ejecutar la sentencia SQL
       // Vincular los parámetros y ejecutar la sentencia SQL
$stmt->bindParam(1, $usuarioID);
$stmt->bindParam(2, $Correo);
$stmt->bindParam(3, $Usuario);
$stmt->bindParam(4, $Contra);
$stmt->bindParam(5, $Nombre); // Corregido a 5 en lugar de 6
$stmt->bindParam(6, $Apellido); // Corregido a 6 en lugar de 7
$stmt->bindParam(7, $FechaNac); // Corregido a 7 en lugar de 8
$stmt->bindParam(8, $genero); // Corregido a 8 en lugar de 9

       
    
        
        if ($stmt->execute()) {
            // Si la modificación fue exitosa, redirigir al usuario a la página de inicio
            header("Location: ../HTML/Perfil.php");
            exit(); // Terminar el script para asegurar que la redirección se ejecute correctamente
        } else {
            echo "Error al ejecutar la sentencia SQL: " . $stmt->errorInfo()[2];
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
