<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idproducto = $_GET['idprod'];
/*$idproducto = $_SESSION['id_producto'];*/
$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$sql3 = "SELECT * FROM Producto WHERE Producto_ID = '$idproducto'";
$stmt3 = $miConexion->prepare($sql3);
$stmt3->execute();

$stmt4 = $miConexion->prepare($q);
$stmt4->execute();

$stmt8 = $miConexion->prepare($q);
$stmt8->execute();

?>
<!DOCTYPE html>
<html>          

<head>
    <meta charset="UTF-8">
    <title>F-Store | Producto</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPP.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">


</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">

            <h1>F-Store</h1>
        </a>

        <nav class="Opciones">
            <?php echo "<a href='AgregarProdList.php?idprod=".$idproducto."'>Agregar a una lista</a>"?>
        </nav>


        <a href="../HTML/Perfil.php" class="sub-menu-link">
            <i class="fa-solid fa-user"></i>
            <p>Ver perfil</p>
            <span></span>
        </a>
        <a href="Carrito.php" class="sub-menu-link">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Carrito</p>
            <span></span>
        </a>
        <a href="../HTML/PagIni.php" class="sub-menu-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>Regresar</p>
            <span></span>
        </a>
    </header>

    <div class="contenedor">
        <div class="area1">
            <div class="contenido">
            <?php
                    foreach($stmt4 as $row4)
                    {
                        $idusuario = $row4['Usuario_ID'];

                        foreach($stmt3 as $row3)
                        {
                            $idprod = $row3['Producto_ID'];
                            $nombre = $row3['Nombre'];
                            $descrip = $row3['Descripcion'];
                            $precio = $row3['Precio'];
                            $idusuarioprod = $row3['Usu_ID'];
                            $cantidad = $row3['Disponibilidad'];
                            $tipooferta = $row3['Tipo_Oferta'];

                           
                           
                ?>
                                <p class="Encabezado"><?php echo $nombre; ?></p>
                                <br>
                                <p class="Encabezado"><?php echo $descrip; ?></p>
                                <br>
                                <p class="Encabezado"><?php echo "Cantidad disponible: ".$cantidad; ?></p>
                                <br>
                <?php
                                if($precio == 0)
                                {
                ?>
                                    <p class="Encabezado">PRODUCTO COTIZADO</p>
                                    <p class="Encabezado">contacte con el usuario para acordar su precio</p>
                                    <br>
                <?php
                                }
                                else
                                {
                ?>
                                    <p class="Encabezado"><?php echo "$".$precio; ?></p>
                                    <br>
                <?php
                                }

                                $sql7 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusuarioprod'";
                                $stmt7 = $miConexion->prepare($sql7);
                                $stmt7->execute();

                                foreach($stmt7 as $row7)
                                {
                                    $nombreusuario = $row7['NomUsu'];
                ?>
                                    <p class="Encabezado"><?php echo "Vendedor: ".$nombreusuario; ?></p>
                                    <br>
                <?php
                                }

                                $sql5 = "SELECT * FROM Imagen_Prod WHERE Prod_ID = '$idprod'";
                                $stmt5 = $miConexion->prepare($sql5);
                                $stmt5->execute();

                                foreach($stmt5 as $row5)
                                {
                                    $tipoimagen = $row5['tipo'];
                                    $imagen = $row5['imagen'];
                ?>
                                    <img src="data:<?php echo $tipoimagen; ?>;base64,<?php echo base64_encode($imagen); ?>" height="150" width="150"/>
                <?php
                                }

                                $sql6 = "SELECT * FROM Video_Producto WHERE Prod_ID = '$idprod'";
                                $stmt6 = $miConexion->prepare($sql6);
                                $stmt6->execute();

                                foreach($stmt6 as $row6)
                                {
                                    $nombrevideo = $row6['direccion'];
                ?>
                                    <video src="../PHP/Videos/<?php echo $nombrevideo; ?>" controls="controls" width="150" height="150"></video>
                                    <br>
                <?php
                                }
                                if($idusuario == $idusuarioprod)
                                {
                                    echo '<script>alert("Este producto fue subido por usted mismo");</script>';
                                }else{
                                    foreach($stmt8 as $row8)
                                    {
                                        $privacidad = $row8['Privacidad'];
    
                                        if($privacidad < 2 && $tipooferta == 0)
                                        {
                                           /* echo "<button class='agr'><a href='../HTML/Cantidad.php?idprod=".$idprod."'>Agregar a carrito</a></button>";*/
                                            ?>
                                             <form method="post" action="../PHP/AgCarrit.php">
                            <label class="Encabezado">Agregar al Carrito</label>
                            <input type="hidden" id="idprod" name="idprod" value="<?php echo $idprod;?>">
                            <input type="number" id="cantidad" name="cantidad">
                            <br>
                            <button type="submit" class="boton">Agregar</button>
                        </form>
                                             <?php
                                         
                                        }
    
                                        if($privacidad < 2 && $tipooferta == 1)
                                        {
                                            echo "<button class='agr'><a href='../PHP/AgContacto.php?idprod=".$idprod."'>Contactar con vendedor</a></button>";
                                        }
                                    }
                                }
                             
                            
                        }
                    }
                ?>
            </div>
        </div>
       <div class="comentarios">
            <h3>Comentarios</h3>
            <?php
            $sql9 = "SELECT * FROM Comentario WHERE Prod_ID = '$idproducto'";
            $stmt9 = $miConexion->prepare($sql9);
            $stmt9->execute();

            foreach($stmt9 as $row9) {
                $idusuariocom = $row9['Usu_ID'];
                $comen = $row9['Comentario'];
                $puntaje = $row9['Valoracion'];

                $sql10 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusuariocom'";
                $stmt10 = $miConexion->prepare($sql10);
                $stmt10->execute();

                foreach($stmt10 as $row10) {
                    $nombreusucom = $row10['NomUsu'];
                    
                    echo '<div class="comentario-item">';
                    echo '<div class="comentario-usuario">' . $nombreusucom . '</div>';
                    echo '<div class="comentario-texto">' . $comen . '</div>';
                    echo '<div class="comentario-valoracion">Valoración: ' . $puntaje . '</div>';
                    echo '</div>';
                    echo '<hr>';
                }
            }
            ?>
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
</body>

</html>