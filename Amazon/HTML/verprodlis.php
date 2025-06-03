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

$idlista = $_GET['idlist'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$sql3 = "SELECT * FROM Producto_Lista WHERE Lis_ID = '$idlista'";
$stmt3 = $miConexion->prepare($sql3);
$stmt3->execute();

$stmt4 = $miConexion->prepare($q);
$stmt4->execute();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>U-Shop | Productos lista</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
</head>

<body>
    <header>

    <a href="PagIni.php" class="logo">

<h1>F-Store</h1>
</a>
        <?php
            foreach($stmt4 as $row)
            {
                $priv = $row['Privacidad'];

                if($priv === 0)
                {
        ?>
                    <!-- <nav class="Opciones">
                        <a href="../HTML/PubProd.php" class="Opc_1">Publicar producto</a>
                        <a href="../HTML/Categorias.php" class="Opc_2">Categorias</a>
                        <a href="../HTML/Listas.php" class="Opc_3">Crear Lista</a>
                    </nav> -->
        <?php
                }
            }
        ?>

                    
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
                <b><label class="Encabezado">Productos</label></b>
                <div class="productos-container">
                    <?php
                    foreach($stmt3 as $row3) {
                        $idproducto = $row3['Prod_ID'];

                        $sql5 = "SELECT * FROM Producto WHERE Producto_ID = '$idproducto' AND Eliminado = 0 AND Validado = 1";
                        $stmt5 = $miConexion->prepare($sql5);
                        $stmt5->execute();

                        foreach($stmt5 as $row5) {
                            $idproductoselec = $row5['Producto_ID'];
                            $nombre = $row5['Nombre'];
                            $descripcion = $row5['Descripcion'];
                            $precio = $row5['Precio'];
                            $tipooferta = $row5['Tipo_Oferta'];
                            $imagenHTML = "";

                            // Obtener la primera imagen del producto
                            $q7 = "SELECT MIN(Imagen_ID) FROM Imagen_Prod WHERE Prod_ID = '$idproductoselec'";
                            $stmt7 = $miConexion->prepare($q7);
                            $stmt7->execute();

                            foreach($stmt7 as $row7) {
                                $idfoto = $row7['MIN(Imagen_ID)'];
                                $q8 = "SELECT * FROM Imagen_Prod WHERE Imagen_ID = '$idfoto'";
                                $stmt8 = $miConexion->prepare($q8);
                                $stmt8->execute();

                                foreach($stmt8 as $row8) {
                                    $tipofoto = $row8['tipo'];
                                    $imagfoto = $row8['imagen'];
                                    $imagenHTML = '<img src="data:' . $tipofoto . ';base64,' . base64_encode($imagfoto) . '" alt="Imagen producto">';
                                }
                            }
                    ?>
                            <div class="card-producto">
                                <?php echo $imagenHTML; ?>
                                <h3><?php echo $nombre; ?></h3>
                                <p><?php echo $descripcion; ?></p>
                                <p><strong>Precio:</strong> 
                                    <?php
                                        if($tipooferta == 0) {
                                            echo "$".$precio;
                                        } else {
                                            echo "Cotizado";
                                        }
                                    ?>
                                </p>
                                <div class="acciones">
                                    <a class="btn-ver" href="Producto.php?idprod=<?php echo $idproductoselec; ?> ">Ver producto</a>
                                    <?php echo "<a class='btn-eliminar' href='../PHP/elimProdlis.php?idprod=".$idproducto."&idlist=".$idlista."'>Quitar</a>"; ?>
                                </div>
                            </div>
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
</body>
</html>