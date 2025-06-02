<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

if (!isset($_SESSION['username'], $_POST['idUsu'], $_POST['idUsucon'], $_POST['mensaje'])) {
    // Redirige si faltan datos esenciales
    header("Location: ../HTML/PagIni.php");
    exit();
}

$usuario = $_SESSION['username'];
$idusuario = $_POST['idUsu'];
$idusucon = $_POST['idUsucon'];
$mensaje = trim($_POST['mensaje']);

// Validar mensaje no vacío
if (empty($mensaje)) {
    header("Location: ../HTML/PagIni.php?error=MensajeVacio");
    exit();
}

// Insertar mensaje con parámetros seguros
$sqlInsert = "INSERT INTO Mensajes(ID_usuario, Mensaje, ID_usuariorecibidor) VALUES(:idusuario, :mensaje, :idusucon)";
$stmtInsert = $miConexion->prepare($sqlInsert);
$stmtInsert->bindParam(':idusuario', $idusuario);
$stmtInsert->bindParam(':mensaje', $mensaje);
$stmtInsert->bindParam(':idusucon', $idusucon);
$stmtInsert->execute();

// Obtener nombre de usuario receptor para redirección
$sqlNombre = "SELECT NomUsu FROM Usuario WHERE Usuario_ID = :idusucon";
$stmtNombre = $miConexion->prepare($sqlNombre);
$stmtNombre->bindParam(':idusucon', $idusucon);
$stmtNombre->execute();

$nombreusuario = $stmtNombre->fetchColumn();

// Redirigir a la conversación con el usuario
if ($nombreusuario) {
    header("Location: ../HTML/Cotizar.php?nombusu=" . urlencode($nombreusuario));
    exit();
} else {
    header("Location: ../HTML/PagIni.php?error=UsuarioNoEncontrado");
    exit();
}
?>
