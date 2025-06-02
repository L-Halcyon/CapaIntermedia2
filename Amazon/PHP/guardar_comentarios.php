<?php
// Asegúrate de que el usuario esté autenticado
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../HTML/InicioSesion.php");
    exit();
}

// Conectar a la base de datos
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();
/*
// Obtener el ID del usuario
$usuario = $_SESSION['username'];
$q = "SELECT Usuario_ID FROM Usuario WHERE NomUsu = :usuario";
$stmt = $miConexion->prepare($q);
$stmt->bindParam(':usuario', $usuario);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$usuarioID = $user['Usuario_ID'];
auishfdoaihfdlahfdlajk<hfnhgsrgsrfgsdrgsfgsgs*/

$usuarioID = $_SESSION['user_id'];

// Insertar comentarios para cada producto
/*foreach ($_POST as $key => $comentario) {
    if (strpos($key, 'comentario_') === 0) {
        $productoID = str_replace('comentario_', '', $key);

        // Insertar el comentario en la tabla Comentario
        $sql = "INSERT INTO Comentario (Comentario, Prod_ID, Usu_ID) 
                VALUES (:comentario, :productoID, :usuarioID)";
        $stmt2 = $miConexion->prepare($sql);
        $stmt2->bindParam(':comentario', $comentario);
        $stmt2->bindParam(':productoID', $productoID);
        $stmt2->bindParam(':usuarioID', $usuarioID);
        $stmt2->execute();
    }
}*/
// Procesar los comentarios y calificaciones
foreach ($_POST as $key => $value) {
    if (strpos($key, 'comentario_') === 0) {
        $productoID = str_replace('comentario_', '', $key);
        $comentario = htmlspecialchars($value);
        $calificacionKey = "calificacion_$productoID";
        $calificacion = isset($_POST[$calificacionKey]) ? (int) $_POST[$calificacionKey] : null;

        if ($calificacion !== null) {
            $sql = "INSERT INTO Comentario (Comentario, Prod_ID, Usu_ID, Valoracion) 
                    VALUES (:comentario, :productoID, :usuarioID, :calificacion)";
            $stmt = $miConexion->prepare($sql);
            $stmt->bindParam(':comentario', $comentario);
            $stmt->bindParam(':productoID', $productoID);
            $stmt->bindParam(':usuarioID', $usuarioID);
            $stmt->bindParam(':calificacion', $calificacion);
            $stmt->execute();
        }
    }
}

// Redirigir a la página de comentarios con un mensaje de éxito
header("Location: ../HTML/Pedidos.php?success=true");
exit();
?>
