<?php
require_once "../Middleware/middleware.php";
redirectIfNotLoggedIn();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

//session_start();

if (!isset($_SESSION['username'], $_GET['nombusurec'], $_GET['idusuario'])) {
    header("Location: PagIni.php");
    exit();
}

$vendedor = $_SESSION['username']; // el usuario logueado es el vendedor
$compradorNombre = $_GET['nombusurec'];
$compradorID = $_GET['idusuario'];

// Obtener datos del vendedor
$stmt = $miConexion->prepare("SELECT * FROM Usuario WHERE NomUsu = :usuario");
$stmt->bindParam(':usuario', $vendedor);
$stmt->execute();
$datosVendedor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$datosVendedor) {
    echo "Usuario no encontrado.";
    exit();
}

$idVendedor = $datosVendedor['Usuario_ID'];
$privacidad = $datosVendedor['Privacidad'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>F-Store | Enviar Propuesta</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
</head>
<body>
<header>
    <a href="PagIni.php" class="logo">
        <i class="fa-solid "></i>
        <h1>F-Store</h1>
    </a>

    <?php if ($privacidad === 0): ?>
        <!-- <nav class="Opciones">
            <a href="../HTML/PubProd.php" class="Opc_1">Publicar producto</a>
            <a href="../HTML/Categorias.php" class="Opc_2">Categorías</a>
            <a href="../HTML/Listas.php" class="Opc_3">Crear Lista</a>
            <a href="../HTML/Contactos.php" class="Opc_4">Contactos</a>
        </nav> -->
    <?php else: ?>
        <!-- <a href="../HTML/Contactos.php" class="Opc_1">Contactos</a> -->
    <?php endif; ?>

    <hr>
    <a href="../HTML/Perfil.php" class="sub-menu-link">
        <i class="fa-solid fa-user"></i><p>Ver perfil</p>
    </a>
    <a href="#" class="sub-menu-link">
        <i class="fa-solid fa-cart-shopping"></i><p>Carrito</p>
    </a>
    <a href="../HTML/InicioSesion.php" class="sub-menu-link">
        <i class="fa-solid fa-right-from-bracket"></i><p>Cerrar Sesión</p>
    </a>
</header>

<div class="contenedor">
    <div class="area1">
        <div class="c">
            <div class="c1">
                <h1 class="Titulo">Hacer Propuesta</h1>

                <?php
                $sqlProductos = "SELECT * FROM Producto WHERE Usu_ID = :vendedor AND Tipo_Oferta = 1";
                $stmtProductos = $miConexion->prepare($sqlProductos);
                $stmtProductos->bindParam(':vendedor', $idVendedor);
                $stmtProductos->execute();
                $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <form action="../PHP/envcot.php" method="post">
                    <table border="1">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Especificaciones</th>
                        </tr>

                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo $producto['Producto_ID']; ?></td>
                                <td><?php echo $producto['Nombre']; ?></td>
                                <td><?php echo $producto['Descripcion']; ?></td>
                                <td><input type="number" name="precio" class="Input_mensaje" required></td>
                                <td><input type="number" name="Cantidad" class="Input_mensaje" required></td>
                                <td><input type="text" name="Especificaciones" class="Input_mensaje" required></td>

                                <!-- Datos ocultos -->
                                <input type="hidden" name="idusu" value="<?php echo $idVendedor; ?>"> <!-- vendedor -->
                                <input type="hidden" name="Nomusu" value="<?php echo $compradorID; ?>"> <!-- comprador -->
                                <input type="hidden" name="idproducto" value="<?php echo $producto['Producto_ID']; ?>">
                                <input type="hidden" name="nombre" value="<?php echo $producto['Nombre']; ?>">
                                <input type="hidden" name="descripcion" value="<?php echo $producto['Descripcion']; ?>">
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <button class="btn" type="submit">Enviar Propuesta</button>
                </form>

                <!-- Ver propuestas enviadas -->
                <h1 class="Titulo">Propuestas Enviadas</h1>
                <?php
                $sqlCot = "SELECT * FROM Producto_cotizable WHERE ID_usuario = :comprador";
                $stmtCot = $miConexion->prepare($sqlCot);
                $stmtCot->bindParam(':comprador', $compradorID);
                $stmtCot->execute();
                $propuestas = $stmtCot->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php if ($propuestas): ?>
                    <table border="1">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Especificaciones</th>
                            <!-- <th>Estatus</th> -->
                        </tr>
                        <?php foreach ($propuestas as $p): ?>
                            <tr>
                                <td><?php echo $p['Producto_ID2']; ?></td>
                                <td><?php echo $p['Nombre']; ?></td>
                                <td><?php echo $p['Descripcion']; ?></td>
                                <td><?php echo $p['Precio']; ?></td>
                                <td><?php echo $p['Cantidad']; ?></td>
                                <td><?php echo $p['Especificaciones']; ?></td>
                                <?php
                                $estatus = $p['Eliminado'];
                                $idprod = $p['Producto_ID2'];

                                $stmtVerCarrito = $miConexion->prepare("SELECT * FROM Carrito WHERE Prod_ID = :prod");
                                $stmtVerCarrito->bindParam(':prod', $idprod);
                                $stmtVerCarrito->execute();

                                /*if ($stmtVerCarrito->rowCount() > 0) {
                                    echo "<td>Este producto ya se agregó al carrito</td>";
                                } else {
                                    if ($estatus == 1) {
                                        ?>
                                        
                                        <?php
                                    } else {
                                        echo "<td>Rechazado</td>";
                                    }
                                }*/
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No hay propuestas enviadas aún.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer_container">
        <div class="footer_box">
            <div class="logo"><h1>F-Store</h1></div>
            <div class="terminos">
                <p>La Empresa En Sí Es Una Empresa Muy Exitosa. ¿A Él El Placer De Las Penas, La Culpa De Los
                        Placeres Fáciles, Resultarán De La Ganancia, Ni Le Explicaré Las Veces Que Quiere Del Odio, O Es
                        Menor En Otras Ocasiones? Ciertamente Así Es.</p>
            </div>
        </div>
        <div class="footer_box">
            <h3>Creadores</h3>
            <br>
            <br>
            <p>Diego Sebastian Cortés Acosta.</p>
            <p>Alejandro Calderón Luna.</p>
        </div>
        <div class="box__copyright">
            <hr>
            <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
        </div>
    </div>
</footer>
</body>
</html>
