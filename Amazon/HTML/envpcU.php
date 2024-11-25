<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$usuariorec = $_GET['nombusurec'];
$idusu = $_GET['idusuario'];

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
    <title>F-Store | Enviar Prod</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    

</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
            <i class="fa-solid fa-hashtag"></i>
            <h1>F-Store</h1>
        </a>


        <?php
            foreach($stmt4 as $row)
            {
                $priv = $row['Privacidad'];

                if($priv === 0)
                {
        ?>
                    <nav class="Opciones">
                        <a href="../HTML/PubProd.php" class="Opc_1">Publicar producto</a>
                        <a href="../HTML/Categorias.php" class="Opc_2">Categorias</a>
                        <a href="../HTML/Listas.php" class="Opc_3">Crear Lista</a>
                        <a href="../HTML/Contactos.php" class="Opc_4">Contactos</a>
                    </nav>
        <?php
                }

                if($priv === 1)
                {
        ?>
                    <a href="../HTML/Contactos.php" class="Opc_1">Contactos</a>
        <?php
                }
            }
        ?>


       
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
                    <a href="../HTML/InicioSesion.php" class="sub-menu-link">
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
                <h1 class="Titulo">Hacer Propuesta</h1>

                <?php
                        $stmt3 = $miConexion->prepare($q);
                        $stmt3->execute();

                        foreach($stmt3 as $row3)
                        {
                            $idusuario = $row3['Usuario_ID'];

                            $sql4 = "SELECT * FROM Producto WHERE Usu_ID = '$usuariorec' AND Tipo_Oferta = 1";
                            $stmt4 = $miConexion->prepare($sql4);
                            $stmt4->execute();
                    ?>
                            <table border="1">
                                <tr>
                                    <td>Codigo</td>
                                    <td>Nombre</td>
                                    <td>Descripcion</td>
                                    <td>Precio</td>
                                    <td>Cantidad</td>
                                    <td>Especificaciones</td>
                                    
                                </tr>
                    <?php
                                foreach($stmt4 as $row4)
                                {
                                    $idproducto = $row4['Producto_ID'];
                                    $nombre = $row4['Nombre'];
                                    $descripcion =$row4['Descripcion'];
                    ?> 
                    <form action="../PHP/envcot.php" method="post">
                    <input type="hidden" name="idusu" id="idusu" value="<?php echo $usuariorec; ?>">
                    <input type="hidden" name="Nomusu" id="Nomusu" value="<?php echo $idusu; ?>">
                    <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $idproducto; ?>">
                    <input type="hidden" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                    <input type="hidden" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>">
                                    <tr>
                                        <td><?php echo $idproducto; ?></td>
                                        <td><?php echo  $nombre; ?></td>
                                        <td><?php echo $descripcion; ?></td>

                                        <td><input class="Input_mensaje" type="number" class="form-control" placeholder="Escribe el precio..." id="precio" name="precio"></td>
                                        <td><input class="Input_mensaje" type="number" class="form-control" placeholder="Escribe la cantidad que desee..." id="Cantidad" name="Cantidad"></td>
                                        <td><input class="Input_mensaje" type="text" class="form-control" placeholder="Escribe las espesificaciones..." id="Especificaciones" name="Especificaciones"></td>
                                    
                                    </tr>
                    <?php
                                }
                    ?>
                            </table>
                          
              
                              <button class="btn" type="submit">Enviar</button>
         
          
                    <?php
                        }
                    ?>
               </form>
              
               

<?php
        $stmt3 = $miConexion->prepare($q);
        $stmt3->execute();

        foreach($stmt3 as $row3)
        {
            $idusuario = $row3['Usuario_ID'];

            $sql5 = "SELECT * FROM Producto_cotizable WHERE ID_usuario = '$idusu'";
            $stmt5 = $miConexion->prepare($sql5);
            $stmt5->execute();
            if ($stmt5->rowCount() > 0) {
    ?>
    <h1 class="Titulo">Ver propuestas</h1>
            <table border="1">
                <tr>
                    <td>Codigo</td>
                    <td>Nombre</td>
                    <td>Descripcion</td>
                    <td>Precio</td>
                    <td>Cantidad</td>
                    <td>Especificaciones</td>
                    <td>Estatus</td>
                </tr>
    <?php
                foreach($stmt5 as $row5)
                {
                    $idproducto = $row5['Producto_ID2'];
                    $nombre = $row5['Nombre'];
                    $descripcion =$row5['Descripcion'];
                    $precio =$row5['Precio'];
                                    $cant =$row5['Cantidad'];
                                    $espesificaciones =$row5['Especificaciones'];
                                    $estatus =$row5['Eliminado'];
    ?> 
   
                    <tr>
                        <td><?php echo $idproducto; ?></td>
                        <td><?php echo  $nombre; ?></td>
                        <td><?php echo $descripcion; ?></td>

                        <td><?php echo $precio; ?></td>
                                        <td><?php echo $cant; ?></td>
                                        <td><?php echo $espesificaciones; ?></td>
                                        <?php
                                         $sql5 = "SELECT * FROM Carrito WHERE Prod_ID = '$idproducto'";
                                         $stmt6 = $miConexion->prepare($sql5);
                                         $stmt6->execute();
                                        
                                         if ($stmt6->rowCount() > 0) {
                                            ?>
                                            <td>Este producto ya se agrego al carrito</td>
                                            <?php
                                        } else{

                                   
                                        if($estatus === 1){
                                            ?>
                                              <form action="../PHP/agcarusv.php" method="post">
                        <input type="hidden" id="idprod" name="idprod" value="<?php echo $idproducto;;?>">
                        <input type="hidden" id="usuc" name="usuc" value="<?php echo $idusu ;?>">
                        <input type="hidden" id="Precio" name="Precio" value="<?php echo $precio;?>">
                        <input type="hidden" id="cant" name="cant" value="<?php echo $cant;?>">

                                            <td><button type="submit" style="background-color: black; color: white; border: none; padding: 
                                                15px 32px; text-align: center; text-decoration: none; display: inline-block; 
                                                font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">Aceptado presiona aqui para pagar
                                            </button></td>
                                            </form>
                                            <?php
                                        }
                                        
                                        else{
                                            ?>
                                            <td>Rechazado</td>
                                            <?php
                                        }
                                    }
                                           ?>
                    </tr>
    <?php
                }
            
    ?>
            </table>


    <?php
            }
        }
    ?>



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
</body>

</html>