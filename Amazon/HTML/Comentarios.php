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

$usuario = $_SESSION['username'];
$usuarioID = $_SESSION['user_id'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

// Obtener los productos comprados por el usuario desde la tabla Pedido
$sql = "SELECT p.Nombre, p.Producto_ID, pd.Precio, pd.FechaHora
        FROM Pedido pd
        JOIN Producto p ON pd.IDProd = p.Producto_ID
        JOIN (
            SELECT IDProd, MAX(FechaHora) AS FechaReciente
            FROM Pedido
            WHERE Usu_ID = :usuarioID
            GROUP BY IDProd
        ) ultimos ON pd.IDProd = ultimos.IDProd AND pd.FechaHora = ultimos.FechaReciente
        WHERE pd.Usu_ID = :usuarioID
        ORDER BY pd.FechaHora DESC";
$stmt2 = $miConexion->prepare($sql);
$stmt2->bindParam(':usuarioID', $usuarioID);
$stmt2->execute();

$productosComprados = $stmt2->fetchAll(PDO::FETCH_ASSOC);
/*
// Mostrar los productos comprados
if (count($productosComprados) > 0) {
    echo "<h2>Productos Recientemente Comprados</h2>";
    echo "<form action='guardar_comentarios.php' method='post'>";
    foreach ($productosComprados as $producto) {
        echo "<div class='producto-comprado'>";
        echo "<p>Producto: " . $producto['Nombre'] . "</p>";
        echo "<p>Precio: $" . $producto['Precio'] . "</p>";
        echo "<p>Fecha de Compra: " . $producto['FechaHora'] . "</p>";
        echo "<label for='comentario_" . $producto['Producto_ID'] . "'>Deja tu comentario:</label>";
        echo "<textarea id='comentario_" . $producto['Producto_ID'] . "' name='comentario_" . $producto['Producto_ID'] . "' required></textarea>";
        echo "</div>";
    }
    echo "<button type='submit'>Enviar Comentarios</button>";
    echo "</form>";
} else {
    echo "<p>No has comprado productos recientemente.</p>";
}*/
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>U-Shop | Comentarios</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/estilocomen.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
</head>

<body>
<header>

<a href="PagIni.php" class="logo">

    <h1 style="color: #339EFF;">F-Store</h1>
</a>


<hr>


<a href="../HTML/InicioSesion.php" class="sub-menu-link">
    <i class="fa-solid fa-right-from-bracket"></i>
    <p>Cerrar Sesion</p>
    <span></span>
</a>

<script>
    let SubMenu = document.getElementById("SubMenu");

    function mostrar() {
        SubMenu.classList.toggle("open-menu")
    }
</script>
</header>

    <div class="contenedor">
        <div class="area1">
            <div class="c">
                <div class="c1">
                    <h1 class="Titulo">Productos Recientemente Comprados</h1>

                    <?php if (count($productosComprados) > 0): ?>
                        <form action="../PHP/guardar_comentarios.php" method="post">
                            <?php foreach ($productosComprados as $producto): ?>
                                <div class="producto-comprado">
                                    <p>Producto: <?= htmlspecialchars($producto['Nombre']); ?></p>
                                    <p>Precio Unitario: $<?= htmlspecialchars($producto['Precio']); ?></p>
                                    <p>Fecha de Compra: <?= htmlspecialchars($producto['FechaHora']); ?></p>
                                    <label for="comentario_<?= htmlspecialchars($producto['Producto_ID']); ?>">Deja tu comentario:</label>
                                    <textarea id="comentario_<?= htmlspecialchars($producto['Producto_ID']); ?>" 
                                            name="comentario_<?= htmlspecialchars($producto['Producto_ID']); ?>" 
                                            required></textarea>

                                    <label for="calificacion_<?= htmlspecialchars($producto['Producto_ID']); ?>">
                                        Calificación (1-10):
                                    </label>
                                    <select id="calificacion_<?= htmlspecialchars($producto['Producto_ID']); ?>" 
                                            name="calificacion_<?= htmlspecialchars($producto['Producto_ID']); ?>" 
                                            required>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>        
                                </div>
                            <?php endforeach; ?>
                            <button type="submit">Enviar Comentarios</button>
                        </form>
                    <?php else: ?>
                        <p>No has comprado productos recientemente.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer_container">
            <div class="footer_box">
                <div class="logo">

                    <h1>F-Store</h1>
                </div>
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