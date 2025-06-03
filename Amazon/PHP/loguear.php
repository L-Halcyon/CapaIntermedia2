<?php
require_once "../CapaIntermedia2/Amazon/PHP/conexion.php";
header('Content-Type: application/json');

$conexion = new Conexion();
$db = $conexion->obtenerConexion();

$usuario = $_POST['username'] ?? '';
$contra = $_POST['password'] ?? '';

$errores = [];

if ($usuario === '') $errores[] = "Correo";
if ($contra === '') $errores[] = "Contraseña";

if (count($errores) > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Falta la siguiente información: " . implode(", ", $errores)
    ]);
    exit;
}

// Comparación directa con texto plano
$sql = "SELECT * FROM Usuario WHERE Correo = ? AND Contrasena = ? AND Eliminado = 0";
$stmt = $db->prepare($sql);
$stmt->execute([$usuario, $contra]);
$usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuarioData) {
    session_start();
    $_SESSION['username'] = $usuarioData['NomUsu'];
    $_SESSION['user_id'] = $usuarioData['Usuario_ID'];
    $_SESSION['TipoUsu'] = $usuarioData['Rol'];

    error_log("Sesión iniciada para: " . $_SESSION['user_id']);

    echo json_encode([
        "success" => true,
        "message" => "Inicio de sesión exitoso",
        "usuario" => [
            "NomUsu" => $usuarioData['NomUsu'],
            "Correo" => $usuarioData['Correo'],
            "Rol" => $usuarioData['Rol'], // Aquí va el tipo
            "Usuario_ID" => $usuarioData['Usuario_ID']
        ]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Correo o contraseña incorrectos"
    ]);
}
?>
