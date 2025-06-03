<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$db = $conexion->obtenerConexion();

header('Content-Type: application/json');

$termino = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

if (empty($termino)) {
    echo json_encode(["success" => false, "message" => "No se recibió un término de búsqueda"]);
    exit;
}

// Búsqueda de productos con imagen, calificación y ventas acumuladas
$sqlProductos = "
SELECT 
    p.Producto_ID, 
    p.Nombre, 
    p.Precio, 
    p.Tipo_Oferta, 
    p.Disponibilidad,
    i.imagen,
    -- Calificación promedio
    (SELECT AVG(c.Valoracion) 
     FROM comentario c 
     WHERE c.Prod_ID = p.Producto_ID) AS Calificacion,
    -- Total de unidades vendidas
    (SELECT SUM(v.cant)
     FROM venta v
     WHERE v.Prod_ID = p.Producto_ID) AS TotalVendidas
FROM producto p
LEFT JOIN imagen_prod i ON i.Imagen_ID = (
    SELECT MIN(Imagen_ID) 
    FROM imagen_prod 
    WHERE Prod_ID = p.Producto_ID
)
WHERE p.Eliminado = 0 
  AND p.Disponibilidad > 0
  AND p.Nombre LIKE :termino
";

// Agregar orden según filtro
switch ($filtro) {
    case 'precio_asc':
        $sqlProductos .= " ORDER BY p.Precio ASC";
        break;
    case 'precio_desc':
        $sqlProductos .= " ORDER BY p.Precio DESC";
        break;
    case 'mejor_calificados':
        $sqlProductos .= " ORDER BY Calificacion DESC";
        break;
    case 'mas_vendidos':
        $sqlProductos .= " ORDER BY TotalVendidas DESC";
        break;
    case 'menos_vendidos':
        $sqlProductos .= " ORDER BY TotalVendidas ASC";
        break;
}

$stmtProd = $db->prepare($sqlProductos);
$stmtProd->execute([':termino' => "%$termino%"]);

$resultados = [];

while ($producto = $stmtProd->fetch(PDO::FETCH_ASSOC)) {
    $precioMostrado = ($producto['Tipo_Oferta'] == 1) ? "Cotizable" : "$" . $producto['Precio'];

    $resultados[] = [
        "tipo" => "producto",
        "id" => $producto['Producto_ID'],
        "nombre" => $producto['Nombre'],
        "precio" => $precioMostrado,
        "imagen" => base64_encode($producto['imagen']),
        "calificacion" => round($producto['Calificacion'], 1),
        "vendidos" => (int)$producto['TotalVendidas']
    ];
}


// Búsqueda de usuarios (sin filtro)
$sqlUsuarios = "SELECT Usuario_ID, NomUsu, ImagenPerfil 
                FROM usuario 
                WHERE Eliminado = 0 
                  AND Rol != 'administrador' 
                  AND (NomUsu LIKE :termino /*OR Nombres LIKE :termino OR Apellidos LIKE :termino*/)";
$stmtUser = $db->prepare($sqlUsuarios);
$stmtUser->execute([':termino' => "%$termino%"]);

while ($usuario = $stmtUser->fetch(PDO::FETCH_ASSOC)) {
    $resultados[] = [
        "tipo" => "usuario",
        "id" => $usuario['Usuario_ID'],
        "nombre" => $usuario['NomUsu'],
        "imagen" => base64_encode($usuario['ImagenPerfil'])
    ];
}

echo json_encode([
    "success" => true,
    "resultados" => $resultados
]);
