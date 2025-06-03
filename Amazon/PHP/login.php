<?php
require_once '../PHP/conexion.php';
require_once '../Middleware/middleware.php';

header('Content-Type: application/json');

// Obtener conexión
$conexion = new Conexion();
$db = $conexion->obtenerConexion();

// Validar entrada
$input = validateInput(['username', 'password']);

// Buscar usuario
$stmt = $db->prepare("SELECT * FROM Usuario WHERE NomUsu = ?");
$stmt->execute([$input['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Validar contraseña
if ($user && password_verify($input['password'], $user['Contra'])) {
    echo json_encode([
        "success" => true,
        "message" => "Inicio de sesión exitoso",
        "user" => $user['NomUsu']
    ]);
} else {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Credenciales incorrectas"
    ]);
}
