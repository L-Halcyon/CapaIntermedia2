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

$idproducto = $_GET['idprod'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$stmt3 = $miConexion->prepare($q);
$stmt3->execute();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Agregar Producto a Lista</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPP.css">

</head>

<body class="body">
    <header>
        <a href="PagIni.php" class="logo">
            <h1>F-Store</h1>
        </a>
        <a href="../HTML/Perfil.php" class="sub-menu-link">
            <i class="fa-solid fa-user"></i>
            <p>Ver perfil</p>
            <span></span>
        </a>
        <hr>

        <a href="Carrito.php" class="sub-menu-link">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Carrito</p>
            <span></span>
        </a>
        <a href="../HTML/InicioSesion.php" class="sub-menu-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>Cerrar Sesion</p>
            <span></span>
        </a>
    </header>

    <div class="contenedor">
        <div class="area1">
            <div class="contenido">
                <div class="c">
                    <div class="c1">
                        <br>
                        <p class="Encabezado1">SELECCIONE LA LISTA A LA QUE DESEA INREGAR EL PRODUCTO</p>
                        <?php
                            foreach($stmt3 as $row3)
                            {
                                $idusuario = $row3['Usuario_ID'];
                        ?>
                               
                        <?php
                                $sql4 = "SELECT * FROM Lista WHERE Usu_ID = '$idusuario' AND Eliminado = 0 AND Tipo = 'publica'";
                                $stmt4 = $miConexion->prepare($sql4);
                                $stmt4->execute();

                                foreach($stmt4 as $row4)
                                {
                                    $idlista = $row4['Lista_ID'];
                        ?>
                         <p class="Encabezado1"><?php print("PUBLICAS"); ?></p>
                                    <table border="1">
                                        <tr>
                                            <td>Nombre</td>
                                            <td>Descripcion</td>
                                            <td>Agregar prod.</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $row4['Nombre']; ?></td>
                                            <td><?php echo $row4['Descripcion']; ?></td>
                                            <td><?php echo "<button><a href='../PHP/apl.php?idprod=".$idproducto."&idlist=".$idlista."'>Agregar</a></button>" ?></td>
                                        </tr>
                                    </table>
                        <?php
                                }
                        ?>
                           
                        <?php
                                $sql5 = "SELECT * FROM Lista WHERE Usu_ID = '$idusuario' AND Eliminado = 0 AND Tipo = 'privada'";
                                $stmt5 = $miConexion->prepare($sql5);
                                $stmt5->execute();

                                foreach($stmt5 as $row5)
                                {
                                    $idlistapriv = $row5['Lista_ID'];
                        ?>
                             <br>
                                <p class="Encabezado1"><?php print("PRIVADAS"); ?></p>
                                    <table border="1">
                                        <tr>
                                            <td>Nombre</td>
                                            <td>Descripcion</td>
                                            <td>Agregar prod.</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $row5['Nombre']; ?></td>
                                            <td><?php echo $row5['Descripcion']; ?></td>
                                            <td><?php echo "<button><a href='../PHP/apl.php?idprod=".$idproducto."&idlist=".$idlistapriv."'>Agregar</a></button>" ?></td>
                                        </tr>
                                    </table>
                        <?php
                                }
                            }
                        ?>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>