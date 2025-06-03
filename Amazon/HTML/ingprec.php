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

$usucon = $_GET['usucon'];
$idprod = $_GET['idprod'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$stmt4 = $miConexion->prepare($q);
$stmt4->execute();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>U-Shop | Ing. Precio</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
            <i class="fa-solid fa-hashtag"></i>
            <h1>U-Shop</h1>
        </a>

       
                    <hr>
                    <a href="../HTML/Perfil.php" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Ver perfil</p>
                        <span></span>
                    </a>
                    <a href="" class="sub-menu-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Carrito</p>
                        <span></span>
                    </a>
                    <a href="../HTML/salir.php" class="sub-menu-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Cerrar Sesion</p>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>

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
                <h1>U-Shop</h1>
                    <form action="../PHP/agcarusv.php" method="post">
                        <input type="hidden" id="idprod" name="idprod" value="<?php echo $idprod;?>">
                        <input type="hidden" id="usuc" name="usuc" value="<?php echo $usucon;?>">
                        <input type="number" id="precio" name="precio">
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer_container">
            <div class="footer_box">
                <div class="logo">
                    <i class="fa-solid fa-hashtag"></i>
                    <h1>U-Shop</h1>
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

            <div class="footer_box">
                <h3>Contacto</h3>
                <a href="#">A</a>
                <a href="#">B</a>
                <a href="#">C</a>
                <a href="#">D</a>
            </div>

            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2023 <b>U-Shop</b></p>
            </div>

        </div>
    </footer>
</body>
</html>