<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

if (!isset($_SESSION['username'], $_GET['id1'], $_GET['id2'])) {
    exit("Error de parámetros.");
}

$id1 = $_GET['id1']; // Usuario actual
$id2 = $_GET['id2']; // Usuario contacto

// Obtener nombres de ambos usuarios
$sqlNombres = "SELECT Usuario_ID, NomUsu FROM Usuario WHERE Usuario_ID IN (:id1, :id2)";
$stmtNombres = $miConexion->prepare($sqlNombres);
$stmtNombres->bindParam(':id1', $id1);
$stmtNombres->bindParam(':id2', $id2);
$stmtNombres->execute();
$nombres = [];
foreach ($stmtNombres as $row) {
    $nombres[$row['Usuario_ID']] = $row['NomUsu'];
}

// Obtener mensajes
$sql = "SELECT * FROM v5
        WHERE (ID_usuario = :id1 AND ID_usuariorecibidor = :id2) 
            OR (ID_usuario = :id2 AND ID_usuariorecibidor = :id1)
        ORDER BY FechaHora ASC";
$stmt = $miConexion->prepare($sql);
$stmt->bindParam(':id1', $id1);
$stmt->bindParam(':id2', $id2);
$stmt->execute();
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar mensajes con nombre real
foreach ($mensajes as $msg) {
    $remitente = isset($nombres[$msg['ID_usuario']]) ? $nombres[$msg['ID_usuario']] : 'Desconocido';
    $hora = date("H:i", strtotime($msg['FechaHora']));
    $clase = ($msg['ID_usuario'] == $id1) ? 'enviado' : 'recibido';
    $hora = date("H:i", strtotime($msg['FechaHora']));
    echo "<div class='mensaje $clase'>
            <strong>" . htmlspecialchars($remitente) . "</strong>
            <span>" . htmlspecialchars($msg['Mensaje']) . "</span>
            <span class='hora'>$hora</span>
        </div>";


}
?>
