<?php
file_put_contents('debug_post.txt', print_r($_POST, true));
file_put_contents('debug_files.txt', print_r($_FILES, true));

require_once "../CapaIntermedia2/Amazon/PHP/conexion.php";

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexion = new Conexion();
$db = $conexion->obtenerConexion();

$input = $_POST;

// Validaciones básicas
$errores = [];
$contraErrores = [];
$fechaActual = date('Y-m-d');

// Campos esperados
$Nombre   = trim($input['Nombres'] ?? '');
$Apellido = trim($input['Apellidos'] ?? '');
$FechaNac = trim($input['FechadeNacimiento'] ?? '');
$Correo   = trim($input['CorreoElectrónico'] ?? '');
$genero   = trim($input['genero'] ?? '');
$Usuario  = trim($input['NombredeUsuario'] ?? '');
$Contra   = trim($input['Contraseña'] ?? '');
$Rol      = trim($input['Rol'] ?? '');

file_put_contents('debug_vars.txt', print_r([
    'Nombres' => $Nombre,
    'Apellidos' => $Apellido,
    'FechaNac' => $FechaNac,
    'Correo' => $Correo,
    'genero' => $genero,
    'Usuario' => $Usuario,
    'Contra' => $Contra,
    'Rol (raw)' => $input['Rol'] ?? null,
    'Rol (procesado)' => $Rol
], true));


if (!$Nombre) $errores[] = "Nombres";
if (!$Apellido) $errores[] = "Apellidos";
if (!$FechaNac || $FechaNac >= $fechaActual) $errores[] = "Fecha de nacimiento inválida";
if (!$Correo || !preg_match('/^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.com$/', $Correo)) $errores[] = "Correo inválido";
if (!$genero) $errores[] = "Género";
if (!$Usuario) $errores[] = "Nombre de usuario";
if ($Rol === '') $errores[] = "Rol";

// Validación de contraseña
if (strlen($Contra) < 8 ||
    !preg_match('/[A-Z]/', $Contra) ||
    !preg_match('/[a-z]/', $Contra) ||
    !preg_match('/[0-9]/', $Contra) ||
    !preg_match('/[!@#$%^&*()\[\]{}\-_+=:;"\'<>,.?\/]/', $Contra)) {
    $contraErrores[] = "Contraseña insegura. Requiere mínimo 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.";
}

// Validación de imagen
if (!isset($_FILES['ImagendePerfil']['tmp_name']) || empty($_FILES['ImagendePerfil']['tmp_name'])) {
    $errores[] = "Imagen de perfil faltante";
}

if (!empty($errores) || !empty($contraErrores)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => implode("; ", array_merge($errores, $contraErrores))
    ]);
    exit;
}

// Validar usuario/correo duplicado
$stmtCheck = $db->prepare("SELECT * FROM Usuario WHERE NomUsu=? OR Correo=?");
$stmtCheck->execute([$Usuario, $Correo]);
if ($stmtCheck->rowCount() > 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Usuario o correo ya existen"]);
    exit;
}

// Preparar datos
$imagenBlob = file_get_contents($_FILES['ImagendePerfil']['tmp_name']);
$contraHash = password_hash($Contra, PASSWORD_BCRYPT);
$rolTexto = $Rol == 0 ? 'vendedores' : ($Rol == 1 ? 'clientes' : 'administradores');
$privacidad = $Rol == 0 ? 0 : ($Rol == 1 ? 1 : 2);

// Insertar en BD
$stmt = $db->prepare("INSERT INTO Usuario (Correo, NomUsu, Contrasena, Rol, Nombres, Apellidos, FechaNac, Sexo, FechaIngreso, Eliminado, Privacidad, ImagenPerfil)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 0, ?, ?)");

if ($stmt->execute([$Correo, $Usuario, $Contra, $rolTexto, $Nombre, $Apellido, $FechaNac, $genero, $privacidad, $imagenBlob])) {
    echo json_encode(["success" => true, "message" => "Usuario registrado exitosamente"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al registrar usuario"]);
}
?>
