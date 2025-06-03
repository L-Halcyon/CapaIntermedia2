<?php
session_start();
header('Content-Type: application/json');

require_once "conexion.php";

if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit();
}

$tipo = $_GET['tipo'] ?? '';
$fechaInicio = $_GET['fechaInicio'] ?? null;
$fechaFin = $_GET['fechaFin'] ?? null;
$categoriaID = $_GET['categoriaID'] ?? 'todas';

if (!$tipo) {
    http_response_code(400);
    echo json_encode(["error" => "Tipo de consulta es requerido"]);
    exit();
}

$conexion = new Conexion();
$db = $conexion->obtenerConexion();

// Obtener ID del vendedor
$stmtUsuario = $db->prepare("SELECT Usuario_ID FROM usuario WHERE NomUsu = ?");
$stmtUsuario->execute([$_SESSION['username']]);
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
$vendedorID = $usuario['Usuario_ID'];

if ($tipo === "detallada") {
    $sql = "
        SELECT 
            v.FechaHora,
            c.Nombre AS Categoria,
            p.Nombre AS Producto,
            (
                SELECT ROUND(AVG(cm.Valoracion), 1)
                FROM comentario cm
                WHERE cm.Prod_ID = p.Producto_ID
            ) AS Calificacion,
            v.precioactualP AS Precio,
            p.Disponibilidad AS Existencia
        FROM venta v
        JOIN producto p ON v.Prod_ID = p.Producto_ID
        JOIN categoria c ON p.categ_ID = c.Categoria_ID
        WHERE p.Usu_ID = :vendedorID
    ";

    if ($fechaInicio && $fechaFin) {
        $sql .= " AND v.FechaHora BETWEEN :fechaInicio AND :fechaFin";
    }

    if ($categoriaID !== 'todas') {
        $sql .= " AND c.Categoria_ID = :categoriaID";
    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":vendedorID", $vendedorID);

    if ($fechaInicio && $fechaFin) {
        $stmt->bindParam(":fechaInicio", $fechaInicio);
        $stmt->bindParam(":fechaFin", $fechaFin);
    }

    if ($categoriaID !== 'todas') {
        $stmt->bindParam(":categoriaID", $categoriaID);
    }

    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit();

} elseif ($tipo === "agrupada") {
    $sql = "
        SELECT 
            DATE_FORMAT(v.FechaHora, '%Y-%m') AS Mes,
            c.Nombre AS Categoria,
            SUM(v.cant) AS TotalVentas
        FROM venta v
        JOIN producto p ON v.Prod_ID = p.Producto_ID
        JOIN categoria c ON p.categ_ID = c.Categoria_ID
        WHERE p.Usu_ID = :vendedorID
    ";

    if ($fechaInicio && $fechaFin) {
        $sql .= " AND v.FechaHora BETWEEN :fechaInicio AND :fechaFin";
    }

    if ($categoriaID !== 'todas') {
        $sql .= " AND c.Categoria_ID = :categoriaID";
    }

    $sql .= " GROUP BY Mes, Categoria ORDER BY Mes DESC";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":vendedorID", $vendedorID);

    if ($fechaInicio && $fechaFin) {
        $stmt->bindParam(":fechaInicio", $fechaInicio);
        $stmt->bindParam(":fechaFin", $fechaFin);
    }

    if ($categoriaID !== 'todas') {
        $stmt->bindParam(":categoriaID", $categoriaID);
    }

    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit();

} else {
    http_response_code(400);
    echo json_encode(["error" => "Tipo de consulta no válido"]);
    exit();
}
