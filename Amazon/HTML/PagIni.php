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

$usuario = $_SESSION['user_id'];

$q = "SELECT * FROM Usuario WHERE Usuario_ID = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Pagina de inicio</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/estiloPI.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">

</head>

<body>
    <header>
        <a href="PagIni.php" class="logo">
            <h1>F-Store</h1>
        </a>
        <div class="Perfil">
            <nav class="Perfil">
                <i class="fa-solid fa-user-circle" style="font-size: 24px;"></i>
                <a href="../HTML/Perfil.php" class="logo">Perfil</a>
        <?php
                    /*     if ($stmt->rowCount() > 0) {
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $Rol = $row['Privacidad'];
                            if ($Rol == 2) {
                                echo '<a href="../HTML/PerfilAdmin.php" class="logo">Perfil</a>';
                            } else {
                                echo '<a href="../HTML/Perfil.php" class="logo">Perfil</a>';
                            }
                        }
                        */
                    ?>
            </nav>
        </div>
        <div class="Buscador">
            <nav class="Opciones">
                <i class="fa-solid fa-search"></i>
                <a href="Busqueda.php" class="Opc_1">Buscar</a>
            </nav>
        </div>
        <!--  <div class="PerfilUsuario">
            <button onclick="mostrar()">
            </button>
                       
                    </div>-->
        <hr>
        <!--  <a href="../HTML/Perfil.php" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Ver perfil</p>
                        <span></span>
                    </a>-->
        <div class="carrito">
            <nav class="carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                <a href="Carrito.php" class="sub-menu-link">
                    Carrito
                </a>
            </nav>
        </div>
        <div class="cerrar">
            <nav class="cerrrar">
                <i class="fa-solid fa-right-from-bracket"></i>
                <a href="../PHP/cerrar_sesion.php" class="sub-menu-link">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <div class="contenedor">
        <div class="area1">
          
        <div class="c">
                <?php
                    $sql3 = "SELECT * FROM V4";
                    $stmt3 = $miConexion->prepare($sql3);
                    $stmt3->execute();

                    foreach($stmt3 as $row3)
                    {
                        $idcategoria = $row3['Categoria_ID'];
                        $nombrecateg = $row3['Nombre'];
                ?>
                        <div class="c1">
                            <p class="Encabezado"><?php echo $nombrecateg; ?></p>
                        </div>
                <?php
                        $sql4 = "SELECT * FROM Producto WHERE categ_ID = '$idcategoria' AND Eliminado = 0 AND Validado = 1 AND Disponibilidad > 0";
                        $stmt4 = $miConexion->prepare($sql4);
                        $stmt4->execute();

                        foreach($stmt4 as $row4)
                        {
                            $idproducto = $row4['Producto_ID'];
                            $nombreprod = $row4['Nombre'];
                            $descripcionprod = $row4['Descripcion'];
                            $precioproducto = $row4['Precio'];

                            $sql5 = "SELECT MIN(Imagen_ID) FROM Imagen_Prod WHERE Prod_ID = '$idproducto'";
                            $stmt5 = $miConexion->prepare($sql5);
                            $stmt5->execute();

                            foreach($stmt5 as $row5)
                            {
                                $idimagen1 = $row5['MIN(Imagen_ID)'];

                                $sql6 = "SELECT * FROM Imagen_Prod WHERE Imagen_ID = '$idimagen1'";
                                $stmt6 = $miConexion->prepare($sql6);
                                $stmt6->execute();

                                foreach($stmt6 as $row6)
                                {
                                    $imagen = $row6['imagen'];
                                    $Tipo = $row6['tipo'];
                ?>
                                    <div class="c2">
                                        <img src="data:<?php echo $Tipo; ?>;base64,<?php echo base64_encode($imagen); ?>" height="150" width="200"/>
                                        <p><?php echo $nombreprod; ?></p>
                <?php
                                        if($precioproducto == 0)
                                        {
                ?>
                                            <p>Cotizado</p>
                <?php
                                        }
                                        else
                                        {
                ?>
                                            <p><?php echo "$".$precioproducto; ?></p>
                <?php
                                        }
                                        echo "<button><a href='Producto.php?idprod=".$idproducto."'>VER</a></button>";

                ?>
                 
                                    </div>
                <?php
                                }
                            }
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
                <p>Contáctanos y estaremos encantados de ayudarte.</p>
            </div>



            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
            </div>

        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/PagIni.js"></script>
    <script>
        if (performance.navigation.type === 2) {
            location.reload(true);
        }
    </script>

</body>

</html>