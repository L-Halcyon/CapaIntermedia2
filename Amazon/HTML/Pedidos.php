<?php
require_once "../Middleware/middleware.php";
redirectIfNotLoggedIn();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

$usuario = $_SESSION['username'];

$q = "SELECT * FROM Usuario WHERE NomUsu = ?";
$stmt = $miConexion->prepare($q);
$stmt->execute([$usuario]);
$usuarioData = $stmt->fetch();
$idusuario = $usuarioData['Usuario_ID'];

$stmtPedidos = $miConexion->prepare("CALL sp_consultar_pedidos(?)");
$stmtPedidos->execute([$idusuario]);
$pedidos = $stmtPedidos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>U-Shop | Tus pedidos</title>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" href="../CSS/PedidosRealizados.css">
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <a class="navbar-brand text-primary" href="PagIni.php"><h1>F-Store</h1></a>
        <div class="ms-auto d-flex align-items-center gap-3">            
            <a href="../HTML/Carrito.php" class="btn btn-link text-decoration-none">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
            </a>
            <a href="../HTML/salir.php" class="btn btn-link text-decoration-none">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
            </a>
        </div>
    </nav>

    <div class="contenedor">
        <div class="row area1">
            <h1 class="Titulo">Sección de Pedidos</h1>
            <div class="col-md-12">
                <div class="area1_1">
                    <div class="Encabezado"><h3>Pedidos Realizados</h3></div>
                    <div class="Cuerpo1">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha y Hora</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Calificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $vistos = []; // array para guardar claves únicas
                                        foreach ($pedidos as $pedido):
                                            $clave = $pedido['FechaHora'] . '|' . $pedido['Prod_ID'];
                                            if (in_array($clave, $vistos)) continue;
                                            $vistos[] = $clave;
                                        ?>
                                            <tr>
                                                <td><?= $pedido['FechaHora'] ?></td>
                                                <td><?= $pedido['NombreProducto'] ?></td>
                                                <td><?= $pedido['NombreCategoria'] ?></td>
                                                <td>$<?= $pedido['PrecioProducto'] ?></td>
                                                <td><?= $pedido['Cantidad'] ?></td>
                                                <td><?= $pedido['Calificacion'] ?? 'N/A' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer_container">
            <div class="footer_box">
                <div class="logo"><h1>F-Store</h1></div>
                <div class="terminos">
                    <p>Texto de términos de ejemplo.</p>
                </div>
            </div>
            <div class="footer_box">
                <h3>Creadores</h3><br><br>
                <p>Diego Sebastian Cortés Acosta.</p>
                <p>Alejandro Calderón Luna.</p>
            </div>
            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
            </div>
        </div>
    </footer>
    <script src="../Librerias/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
</body>
</html>