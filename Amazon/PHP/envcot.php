<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

if (!isset($_SESSION['username'], $_POST['idproducto'], $_POST['descripcion'], $_POST['nombre'],
    $_POST['precio'], $_POST['Cantidad'], $_POST['Especificaciones'], $_POST['idusu'], $_POST['Nomusu'])) {
    die("Datos faltantes");
}

// Usuario logueado (vendedor)
$vendedorNombre = $_SESSION['username'];

// ID del comprador (quien recibirá la propuesta)
$idComprador = $_POST['Nomusu'];            // ✅ comprador (receptor)
$idVendedor = $_POST['idusu'];              // ✅ vendedor (emisor)

// Datos del producto
$idprod = $_POST['idproducto'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = trim($_POST['precio']);
$cantidad = trim($_POST['Cantidad']);
$especificaciones = trim($_POST['Especificaciones']);

// Validaciones
if ($precio === "" || $cantidad === "" || $especificaciones === "") {
    echo '<script>alert("Todos los campos son obligatorios."); history.back();</script>';
    exit();
}

// Inserta propuesta usando parámetros seguros
$stmt = $miConexion->prepare("CALL InsertarProductoCotizable(:idprod, :descripcion, :nombre, :precio, :cantidad, :especificaciones, :comprador, :vendedor, 0)");

$stmt->bindParam(':idprod', $idprod);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':precio', $precio);
$stmt->bindParam(':cantidad', $cantidad);
$stmt->bindParam(':especificaciones', $especificaciones);
$stmt->bindParam(':comprador', $idComprador); // 👈 Este es el ID_usuariorecibidor
$stmt->bindParam(':vendedor', $idVendedor);   // 👈 Este es el que propone

$stmt->execute();

// Obtener nombre de comprador para redirección
$sql1 = "SELECT NomUsu FROM Usuario WHERE Usuario_ID = :idComprador";
$stmt1 = $miConexion->prepare($sql1);
$stmt1->bindParam(':idComprador', $idComprador);
$stmt1->execute();
$nombreComprador = $stmt1->fetchColumn();

// Redirigir al chat con el comprador
if ($nombreComprador) {
    header("Location: ../HTML/Cotizar.php?nombusu=" . urlencode($nombreComprador));
    exit();
} else {
    echo "No se encontró al usuario receptor.";
}
?>
