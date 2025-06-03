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

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>U-Shop | Tus pedidos</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" href="../CSS/PedidosRealizados.css">
</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
           
            <h1>F-Store</h1>
        </a>

        <div class="PerfilUsuario">
        
              
                    </div>
                    <hr>
                    <a href="../HTML/Perfil.php" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Ver perfil</p>
                        <span></span>
                    </a>
                    <a href="../HTML/Carrito.php" class="sub-menu-link">
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

      
    </header>

    <div class="contenedor">
        <div class="row area1">
            <h1 class="Titulo">Sección de Pedidos</h1>
            <div class="col-md-3">
                <div class="area1_1">
                    <div class="Encabezado"><h3>Filtros</h3></div>
                    <div class="Cuerpo1">
                        <form action="Pedidos.php" method="post">
                            <div class="form-group">
                                <label for="fechaDesde">Fecha Desde</label>
                                <input type="date" class="form-control" id="fechaDesde" name="fechaDesde">
                            </div>
                            <div class="form-group">
                                <label for="fechaHasta">Fecha Hasta</label>
                                <input type="date" class="form-control" id="fechaHasta" name="fechaHasta">
                            </div>
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <br>
                                    <input type="radio" id="categ" name="categ" value=0 checked>Todas
                                    <br>
                                    <?php
                                        $sql3 = "SELECT * FROM V4";
                                        $stmt3 = $miConexion->prepare($sql3);
                                        $stmt3->execute();

                                        foreach($stmt3 as $row3)
                                        {
                                            $idcateg = $row3['Categoria_ID'];
                                            $nombre = $row3['Nombre'];
                                    ?>
                                            <input type="radio" id="categ" name="categ" value=<?php echo $idcateg;?>><?php echo $nombre;?>
                                            <br>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <button type="submit" class="boton" id="boton" name="boton">Filtrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row m-12 Encabezado area1_1">
                    <table>
                        <tr>
                            <td><h4>Fecha y Hora</h4></td>
                            <td><h4>Categoria</h4></td>
                            <td><h4>Producto</h4></td>
                            <td><h4>Calificacion</h4></td>                            
                            <td><h4>Precio</h4></td>
                            <td><h4>Cantidad</h4></td>
                        </tr>
                        <?php
                            if(isset($_POST['boton']))
                            {
                                $fecha1 = $_POST['fechaDesde'];
                                $fecha2 = $_POST['fechaHasta'];
                                $categoria = $_POST['categ'];

                                if($fecha1 == "" || $fecha2 == "")
                                {
                                    if($categoria == 0)
                                    {
                                        $stmt4 = $miConexion->prepare($q);
                                        $stmt4->execute();

                                        foreach($stmt4 as $row4)
                                        {
                                            $idusuario4 = $row4['Usuario_ID'];

                                            $sql5 = "SELECT * FROM Pedido WHERE Usu_ID = '$idusuario4'";
                                            $stmt5 = $miConexion->prepare($sql5);
                                            $stmt5->execute();

                                            foreach($stmt5 as $row5)
                                            {
                                                $idcategoria5 = $row5['IDCateg'];
                                                $idprod5 = $row5['IDProd'];
                                                $prec5 = $row5['Precio'];
                        ?>
                                                <tr>
                                                    <td><?php echo $row5['FechaHora']; ?></td>
                                                    <td>
                                                        <?php
                                                            $sql6 = "SELECT * FROM Categoria WHERE Categoria_ID = '$idcategoria5'";
                                                            $stmt6 = $miConexion->prepare($sql6);
                                                            $stmt6->execute();

                                                            foreach($stmt6 as $row6)
                                                            {
                                                                echo $row6['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql7 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod5'";
                                                            $stmt7 = $miConexion->prepare($sql7);
                                                            $stmt7->execute();

                                                            foreach($stmt7 as $row7)
                                                            {
                                                                echo $row7['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql8 = "SELECT MAX(Valoracion) as Calificacion FROM Comentario WHERE Prod_ID = '$idprod5' AND Usu_ID = '$idusuario4'";
                                                            $stmt8 = $miConexion->prepare($sql8);
                                                            $stmt8->execute();

                                                            foreach($stmt8 as $row8)
                                                            {
                                                                echo $row8['Calificacion'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo "$".$prec5; ?></td>
                                                </tr>
                        <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $stmt9 = $miConexion->prepare($q);
                                        $stmt9->execute();

                                        foreach($stmt9 as $row9)
                                        {
                                            $idusuario9 = $row9['Usuario_ID'];

                                            $sql10 = "SELECT * FROM Pedido WHERE Usu_ID = '$idusuario9' AND IDCateg = '$categoria'";
                                            $stmt10 = $miConexion->prepare($sql10);
                                            $stmt10->execute();

                                            foreach($stmt10 as $row10)
                                            {
                                                $idcategoria10 = $row10['IDCateg'];
                                                $idprod10 = $row10['IDProd'];
                                                $prec10 = $row10['Precio'];
                        ?>
                                                <tr>
                                                    <td><?php echo $row10['FechaHora']; ?></td>
                                                    <td>
                                                        <?php
                                                            $sql11 = "SELECT * FROM Categoria WHERE Categoria_ID = '$idcategoria10'";
                                                            $stmt11 = $miConexion->prepare($sql11);
                                                            $stmt11->execute();

                                                            foreach($stmt11 as $row11)
                                                            {
                                                                echo $row11['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql12 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod10'";
                                                            $stmt12 = $miConexion->prepare($sql12);
                                                            $stmt12->execute();

                                                            foreach($stmt12 as $row12)
                                                            {
                                                                echo $row12['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql13 = "SELECT MAX(Valoracion) as Calificacion FROM Comentario WHERE Prod_ID = '$idprod10' AND Usu_ID = '$idusuario9'";
                                                            $stmt13 = $miConexion->prepare($sql13);
                                                            $stmt13->execute();

                                                            foreach($stmt13 as $row13)
                                                            {
                                                                echo $row13['Calificacion'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo "$".$prec10; ?></td>
                                                </tr>
                        <?php
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if($categoria == 0)
                                    {
                                        $stmt14 = $miConexion->prepare($q);
                                        $stmt14->execute();

                                        foreach($stmt14 as $row14)
                                        {
                                            $idusuario14 = $row14['Usuario_ID'];

                                            $sql15 = "SELECT * FROM Pedido WHERE FechaHora BETWEEN '$fecha1' AND '$fecha2' AND (Usu_ID = '$idusuario14')";
                                            $stmt15 = $miConexion->prepare($sql15);
                                            $stmt15->execute();

                                            foreach($stmt15 as $row15)
                                            {
                                                $idcategoria15 = $row15['IDCateg'];
                                                $idprod15 = $row15['IDProd'];
                                                $prec15 = $row15['Precio'];
                        ?>
                                                <tr>
                                                    <td><?php echo $row15['FechaHora']; ?></td>
                                                    <td>
                                                        <?php
                                                            $sql16 = "SELECT * FROM Categoria WHERE Categoria_ID = '$idcategoria15'";
                                                            $stmt16 = $miConexion->prepare($sql16);
                                                            $stmt16->execute();

                                                            foreach($stmt16 as $row16)
                                                            {
                                                                echo $row16['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql17 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod15'";
                                                            $stmt17 = $miConexion->prepare($sql17);
                                                            $stmt17->execute();

                                                            foreach($stmt17 as $row17)
                                                            {
                                                                echo $row17['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql18 = "SELECT MAX(Valoracion) as Calificacion FROM Comentario WHERE Prod_ID = '$idprod15' AND Usu_ID = '$idusuario14'";
                                                            $stmt18 = $miConexion->prepare($sql18);
                                                            $stmt18->execute();

                                                            foreach($stmt18 as $row18)
                                                            {
                                                                echo $row18['Calificacion'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo "$".$prec15; ?></td>
                                                </tr>
                        <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $stmt19 = $miConexion->prepare($q);
                                        $stmt19->execute();

                                        foreach($stmt19 as $row19)
                                        {
                                            $idusuario19 = $row19['Usuario_ID'];

                                            $sql20 = "SELECT * FROM Pedido WHERE FechaHora BETWEEN '$fecha1' AND '$fecha2' AND (Usu_ID = '$idusuario19') AND (IDCateg = '$categoria')";
                                            $stmt20 = $miConexion->prepare($sql20);
                                            $stmt20->execute();

                                            foreach($stmt20 as $row20)
                                            {
                                                $idcategoria20 = $row20['IDCateg'];
                                                $idprod20 = $row20['IDProd'];
                                                $prec20 = $row20['Precio'];
                        ?>
                                                <tr>
                                                    <td><?php echo $row20['FechaHora']; ?></td>
                                                    <td>
                                                        <?php
                                                            $sql21 = "SELECT * FROM Categoria WHERE Categoria_ID = '$idcategoria20'";
                                                            $stmt21 = $miConexion->prepare($sql21);
                                                            $stmt21->execute();

                                                            foreach($stmt21 as $row21)
                                                            {
                                                                echo $row21['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql22 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod20'";
                                                            $stmt22 = $miConexion->prepare($sql22);
                                                            $stmt22->execute();

                                                            foreach($stmt22 as $row22)
                                                            {
                                                                echo $row22['Nombre'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $sql23 = "SELECT MAX(Valoracion) as Calificacion FROM Comentario WHERE Prod_ID = '$idprod20' AND Usu_ID = '$idusuario19'";
                                                            $stmt23 = $miConexion->prepare($sql23);
                                                            $stmt23->execute();

                                                            foreach($stmt23 as $row23)
                                                            {
                                                                echo $row23['Calificacion'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo "$".$prec20; ?></td>
                                                </tr>
                        <?php
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $stmt24 = $miConexion->prepare($q);
                                $stmt24->execute();

                                foreach($stmt24 as $row24)
                                {
                                    $idusuario24 = $row24['Usuario_ID'];

                                    $sql25 = "SELECT * FROM Pedido WHERE Usu_ID = '$idusuario24'";
                                    $stmt25 = $miConexion->prepare($sql25);
                                    $stmt25->execute();

                                    foreach($stmt25 as $row25)
                                    {
                                        $idcategoria25 = $row25['IDCateg'];
                                        $idprod25 = $row25['IDProd'];
                                        $prec25 = $row25['Precio'];
                ?>
                                        <tr>
                                            <td><?php echo $row25['FechaHora']; ?></td>
                                            <td>
                                                <?php
                                                    $sql26 = "SELECT * FROM Categoria WHERE Categoria_ID = '$idcategoria25'";
                                                    $stmt26 = $miConexion->prepare($sql26);
                                                    $stmt26->execute();

                                                    foreach($stmt26 as $row26)
                                                    {
                                                        echo $row26['Nombre'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $sql27 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod25'";
                                                    $stmt27 = $miConexion->prepare($sql27);
                                                    $stmt27->execute();

                                                    foreach($stmt27 as $row27)
                                                    {
                                                        echo $row27['Nombre'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $sql28 = "SELECT MAX(Valoracion) as Calificacion FROM Comentario WHERE Prod_ID = '$idprod25' AND Usu_ID = '$idusuario24'";
                                                    $stmt28 = $miConexion->prepare($sql28);
                                                    $stmt28->execute();

                                                    foreach($stmt28 as $row28)
                                                    {
                                                        echo $row28['Calificacion'];
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo "$".$prec25; ?></td>
                                        </tr>
                <?php
                                    }
                                }
                            }
                        ?>
                    </table>
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
    <script src="../Librerias/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>

</body>

</html>