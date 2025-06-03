<?php
// --- CONFIGURACIÓN DE CONEXIÓN ---
class Conexion {
    private $conexion;

    public function __construct() {
        $host = 'localhost';
        $usuario = 'root';
        $contrasena = '1234'; // ajusta si tienes clave
        $db = 'bdm';
        $this->conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $contrasena);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerConexion() {
        return $this->conexion;
    }
}

$conexion = new Conexion();
$db = $conexion->obtenerConexion();

// --- SI HAY ID, DEVOLVER LA IMAGEN ---
if (isset($_GET['imagen_id'])) {
    $stmt = $db->prepare("SELECT ImagenPerfil FROM Usuario WHERE Usuario_ID = ?");
    $stmt->execute([$_GET['imagen_id']]);
    $imagen = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($imagen && $imagen['ImagenPerfil']) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($imagen['ImagenPerfil']);
        header("Content-Type: $mime");
        echo $imagen['ImagenPerfil'];
    } else {
        http_response_code(404);
        echo "Imagen no encontrada";
    }
    exit;
}

// --- OBTENER LISTA DE USUARIOS ---
$stmt = $db->query("SELECT Usuario_ID, NomUsu, Correo, Rol FROM Usuario");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios Registrados</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: center;
        }
        img {
            max-width: 80px;
            height: auto;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Usuarios Registrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Foto de Perfil</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['Usuario_ID']) ?></td>
                    <td><?= htmlspecialchars($usuario['NomUsu']) ?></td>
                    <td><?= htmlspecialchars($usuario['Correo']) ?></td>
                    <td><?= htmlspecialchars($usuario['Rol']) ?></td>
                    <td>
                        <img src="?imagen_id=<?= $usuario['Usuario_ID'] ?>" alt="Foto">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
