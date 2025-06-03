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
    <title>U-Shop | Ventas Realizadas</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" href="../CSS/VentasRealizadas.css">
</head>

<body>
    <header>
        <a href="PagIni.php" class="logo">
          
            <h1>F-Store</h1>
        </a>

     
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

        <script>
            let SubMenu = document.getElementById("SubMenu");
            function mostrar() {
                SubMenu.classList.toggle("open-menu")
            }
        </script>
    </header>

    <div class="contenedor">
        <div class="area1">
           
       
        <div class="area2">
            <h1 class="Titulo">Listado de Productos</h1>

            <div class="row">
               <!-- Filtros -->
                <div class="col-md-3">
                    <div>
                        <div class="Encabezado_Tabla">Filtros</div>
                        <div class="Fitros_Cuerpo">
                            <form action="Ventas.php" method="post">
                                <div class="form-group">
                                    <label for="categoriaProductos">Categoría</label>
                                    <br>
                                    <input type="radio" id="categ1" name="categ1" value=0 checked>Todas
                                    <br>
                                    <?php
                                        $sql15 = "SELECT * FROM V4";
                                        $stmt15 = $miConexion->prepare($sql15);
                                        $stmt15->execute();

                                        foreach($stmt15 as $row15)
                                        {
                                            $idcateg15 = $row15['Categoria_ID'];
                                            $nombre15 = $row15['Nombre'];
                                    ?>
                                            <input type="radio" id="categ1" name="categ1" value=<?php echo $idcateg15;?>><?php echo $nombre15;?>
                                            <br>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <button type="submit" class="boton" id="boton1" name="boton1">Filtrar</button>
                            </form>
                        </div>
                    </div>
                </div>
                 <!-- Listado de Productos -->
                <div class="col-md-9">
                    <div class="row Encabezado_Tabla">
                        <table>
                            <tr>
                                <td><h6>Categoria</h6></td>
                                <td><h6>Producto</h6></td>
                                <td><h6>Existencia</h6></td>
                            </tr>
                            <div class="row Registro_Tabla">
                                <?php
                                    if(isset($_POST['boton1']))
                                    {
                                        $categoria = $_POST['categ1'];

                                        if($categoria == 0)
                                        {
                                            $stmt33 = $miConexion->prepare($q);
                                            $stmt33->execute();

                                            foreach($stmt33 as $row33)
                                            {
                                                $idusuario33 = $row33['Usuario_ID'];

                                                $sql34 = "SELECT * FROM V4";
                                                $stmt34 = $miConexion->prepare($sql34);
                                                $stmt34->execute();

                                                foreach($stmt34 as $row34)
                                                {
                                                    $idcateg34 = $row34['Categoria_ID'];
                                                    $nombcateg34 = $row34['Nombre'];

                                                    $sql35 = "SELECT * FROM Producto WHERE categ_ID = '$idcateg34' AND Eliminado = 0";
                                                    $stmt35 = $miConexion->prepare($sql35);
                                                    $stmt35->execute();

                                                    foreach($stmt35 as $row35)
                                                    {
                                                        $nombprod35 = $row35['Nombre'];
                                                        $existencia35 = $row35['Disponibilidad'];
                                ?>
                                                    <tr>
                                                        <td><?php echo $nombcateg34; ?></td>
                                                        <td><?php echo $nombprod35; ?></td>
                                                        <td><?php echo $existencia35; ?></td>
                                                    </tr>
                                <?php
                                                    }
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $stmt36 = $miConexion->prepare($q);
                                            $stmt36->execute();

                                            foreach($stmt36 as $row36)
                                            {
                                                $idusuario36 = $row36['Usuario_ID'];

                                                $sql37 = "SELECT * FROM Categoria WHERE Categoria_ID = '$categoria'";
                                                $stmt37 = $miConexion->prepare($sql37);
                                                $stmt37->execute();

                                                foreach($stmt37 as $row37)
                                                {
                                                    $idcateg37 = $row37['Categoria_ID'];
                                                    $nombcateg37 = $row37['Nombre'];

                                                    $sql38 = "SELECT * FROM Producto WHERE categ_ID = '$idcateg37' AND Eliminado = 0";
                                                    $stmt38 = $miConexion->prepare($sql38);
                                                    $stmt38->execute();

                                                    foreach($stmt38 as $row38)
                                                    {
                                                        $nombprod38 = $row38['Nombre'];
                                                        $existencia38 = $row38['Disponibilidad'];
                                ?>
                                                        <tr>
                                                            <td><?php echo $nombcateg37; ?></td>
                                                            <td><?php echo $nombprod38; ?></td>
                                                            <td><?php echo $existencia38; ?></td>
                                                        </tr>
                                <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $stmt30 = $miConexion->prepare($q);
                                        $stmt30->execute();

                                        foreach($stmt30 as $row30)
                                        {
                                            $idusuario30 = $row30['Usuario_ID'];

                                            $sql31 = "SELECT * FROM V4";
                                            $stmt31 = $miConexion->prepare($sql31);
                                            $stmt31->execute();

                                            foreach($stmt31 as $row31)
                                            {
                                                $idcateg31 = $row31['Categoria_ID'];
                                                $nombcateg31 = $row31['Nombre'];

                                                $sql32 = "SELECT * FROM Producto WHERE categ_ID = '$idcateg31' AND Eliminado = 0";
                                                $stmt32 = $miConexion->prepare($sql32);
                                                $stmt32->execute();

                                                foreach($stmt32 as $row32)
                                                {
                                                    $nombprod32 = $row32['Nombre'];
                                                    $existencia32 = $row32['Disponibilidad'];
                                ?>
                                                    <tr>
                                                        <td><?php echo $nombcateg31; ?></td>
                                                        <td><?php echo $nombprod32; ?></td>
                                                        <td><?php echo $existencia32; ?></td>
                                                    </tr>
                                <?php
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </div>
                        </table>
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

    <script src="../Librerias/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
</body>

</html>