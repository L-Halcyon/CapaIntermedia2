<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['user_id'];

$q = "SELECT * FROM Usuario WHERE Usuario_ID = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$stmt3 = $miConexion->prepare($q);
$stmt3->execute();

$stmt4 = $miConexion->prepare($q);
$stmt4->execute();

$stmt9 = $miConexion->prepare($q);
$stmt9->execute();

$stmt11 = $miConexion->prepare($q);
$stmt11->execute();
?>

<!DOCTYPE html>
<html>

<head>
    
<meta charset="UTF-8">
    <title>F-Store | Perfil</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    

</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">

            <h1>F-Store</h1>
        </a>
        <nav class="Opciones">
            <a href="../HTML/PubProd.php" class="Opc_1">Publicar producto</a>
            <a href="../HTML/Categorias.php" class="Opc_2">Categorias</a>
            <a href="../HTML/Listas.php" class="Opc_3">Crear Lista</a>
            <a href="../HTML/Contactos.php" class="Opc_4">Contactos y cotizaciones</a>
            
            <a href="../HTML/Ventas.php" class="Opc_5">Mis ventas</a>
            <a href="../HTML/Pedidos.php" class="Opc_1">Pedidos realizados</a>
        </nav>
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
        <script>
            let SubMenu = document.getElementById("SubMenu");

            function mostrar() {
                SubMenu.classList.toggle("open-menu")
            }
        </script>
    </header>
    <main>
    <div class="contenedor">
        <div class="area1">
       
        <?php

foreach ($stmt3 as $row) {
    $id = $row['Usuario_ID'];
    $usu = $row['NomUsu'];
    $priv = $row['Privacidad'];

    // Verificar si la privacidad del usuario es 1
    if ($priv === 1) {
        // Mostrar un mensaje de perfil privado
        echo "<script>alert('Este perfil es privado');</script>";
        // Mostrar el nombre del usuario
        echo "<p><b>$usu</b><br><br></p>";

        // Obtener la imagen del usuario si está disponible
        $q5 = "SELECT ImagenPerfil FROM Usuario WHERE Usuario_ID = ?";
        $stmt5 = $miConexion->prepare($q5);
        $stmt5->execute([$id]);

        // Verificar si se encontró la imagen del usuario
        if ($stmt5->rowCount() > 0) {
            // Obtener la fila de resultados
            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
            // Decodificar los datos de la imagen y mostrar la imagen
            $imageData = base64_encode($row5['ImagenPerfil']);
            echo '<img src="data:image/png;base64,'. $imageData .'" height="200" width="250"/>';
        } else {
            // Mostrar un mensaje si no se encuentra la imagen del usuario
            echo "<p>No se encontró la imagen del usuario.</p>";
        }
       
    }
    
    else{
        ?>
                            <br>
                            <br>
                            <h4><?php print("LISTAS"); ?></h4>
                            <br>
                            <h5><?php print("Publicas"); ?></h5>
                          
                            <table border="1">
                                <tr>
                                    <td>Codigo</td>
                                    <td>Nombre</td>
                                    <td>Descripcion</td>
                                    <td>Ver productos</td>
                                    <td>Editar</td>
                                    <td>Eliminar</td>
                                </tr>
                                
                                <?php
                                  foreach($stmt9 as $row9)
                                  {
                                      $idusu = $row9['Usuario_ID'];
  
                                      $sql10 = "SELECT * FROM Lista WHERE Usu_ID = '$idusu' AND Tipo = 'publica' AND Eliminado = 0";
                                      $stmt10 = $miConexion->prepare($sql10);
                                      $stmt10->execute();
  
                                      foreach($stmt10 as $row10)
                                      {
                                          $idlista = $row10['Lista_ID'];
                      ?>
                                         <tr>
                                            <td><?php echo $idlista; ?></td>
                                            <td><?php echo $row10['Nombre']; ?></td>
                                            <td><?php echo $row10['Descripcion']; ?></td>
                                            <td><?php echo "<a href='verprodlis.php?idlist=".$idlista."'>VER</a>" ?></td>
                                            <td><?php echo "<a href='Editlis.php?idlist=".$idlista."'>EDITAR</a>" ?></td>
                                            <td><?php echo "<a href='../PHP/Elimlis.php?idLista=".$idlista."'>ELIMINAR</a>" ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                    ?>
                             </table>
                             <br>
                            <h5><?php print("Privadas"); ?></h4>
                            <table border="1">
                                <tr>
                                    <td>Codigo</td>
                                    <td>Nombre</td>
                                    <td>Descripcion</td>
                                    <td>Ver productos</td>
                                    <td>Editar</td>
                                    <td>Eliminar</td>
                                </tr>
                    <?php
                                foreach($stmt11 as $row11)
                                {
                                    $idusu = $row11['Usuario_ID'];

                                    $sql12 = "SELECT * FROM Lista WHERE Usu_ID = '$idusu' AND Tipo = 'privada' AND Eliminado = 0";
                                    $stmt12 = $miConexion->prepare($sql12);
                                    $stmt12->execute();

                                    foreach($stmt12 as $row12)
                                    {
                                        $idlistapriv = $row12['Lista_ID'];
                    ?>
                                        <tr>
                                            <td><?php echo $idlistapriv; ?></td>
                                            <td><?php echo $row12['Nombre']; ?></td>
                                            <td><?php echo $row12['Descripcion']; ?></td>
                                            <td><?php echo "<a href='verprodlis.php?idlist=".$idlistapriv."'>VER</a>" ?></td>
                                            <td><?php echo "<a href='Editlis.php?idlist=".$idlistapriv."'>EDITAR</a>" ?></td>
                                            <td><?php echo "<a href='../PHP/Elimlis.php?idlist=".$idlistapriv."'>ELIMINAR</a>" ?></td>
                                        </tr>
                    <?php
                                    }
                                }
                    ?>
                                </table>
                                        <br>
                                <h4><?php print("PRODUCTOS"); ?></h4>
                                <table border="1">
                                    <tr>
                                        <td>Codigo Producto</td>
                                        <td>Nombre</td>
                                        <td>Foto</td>
                                        <td>Precio</td>
                                        <td>Editar</td>
                                        <td>Eliminar</td>
                                    </tr>
                                    <?php
                                    $q6 = "SELECT * FROM Producto WHERE Usu_ID = '$id' AND Eliminado = 0 AND Validado = 1 AND Tipo_Oferta = 0";
                                    $stmt6 = $miConexion->prepare($q6);
                                    $stmt6->execute();

                                    foreach($stmt6 as $row6)
                                    {
                                        $idprod = $row6['Producto_ID'];
                                        $precio = $row6['Precio'];
                    ?>
                                        <tr>
                                            <td><?php echo $row6['Producto_ID']; ?></td>
                                            <td><?php echo $row6['Nombre']; ?></td>
                                            <td>
                                                <?php
                                                    $q7 = "SELECT MIN(Imagen_ID) FROM Imagen_Prod WHERE Prod_ID = '$idprod'";
                                                    $stmt7 = $miConexion->prepare($q7);
                                                    $stmt7->execute();
                                                    
                                                    foreach($stmt7 as $row7)
                                                    {
                                                        $idfoto = $row7['MIN(Imagen_ID)'];

                                                        $q8 = "SELECT * FROM Imagen_Prod WHERE Imagen_ID = '$idfoto'";
                                                        $stmt8 = $miConexion->prepare($q8);
                                                        $stmt8->execute();

                                                        foreach($stmt8 as $row8)
                                                        {
                                                            $tipofoto = $row8['tipo'];
                                                            $imagfoto = $row8['imagen'];
                                                ?>
                                                            <img src="data:<?php echo $tipofoto; ?>;base64,<?php echo base64_encode($imagfoto); ?>" height="70" width="70"/>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo "$".$precio; ?> </td>
                                            <td><?php echo "<a href='EditProd.php?idprod=".$idprod."'>EDITAR</a>" ?></td>
                                            <td><?php echo "<a href='../PHP/ElimProd.php?idprod=".$idprod."'>ELIMINAR</a>" ?></td>
                                        </tr>
                    <?php
                                    }
                                    $sql13 = "SELECT * FROM Producto WHERE Usu_ID = '$id' AND Eliminado = 0 AND Validado = 1 AND Tipo_Oferta = 1";
                                    $stmt13 = $miConexion->prepare($sql13);
                                    $stmt13->execute();

                                    foreach($stmt13 as $row13)
                                    {
                                        $idprodcot = $row13['Producto_ID'];
                    ?>
                                        <tr>
                                            <td><?php echo $row13['Producto_ID']; ?></td>
                                            <td><?php echo $row13['Nombre']; ?></td>
                                            <td>
                                                <?php
                                                    $sql14 = "SELECT MIN(Imagen_ID) FROM Imagen_Prod WHERE Prod_ID = '$idprodcot'";
                                                    $stmt14 = $miConexion->prepare($sql14);
                                                    $stmt14->execute();
                                                    
                                                    foreach($stmt14 as $row14)
                                                    {
                                                        $idfotocot = $row14['MIN(Imagen_ID)'];

                                                        $sql15 = "SELECT * FROM Imagen_Prod WHERE Imagen_ID = '$idfotocot'";
                                                        $stmt15 = $miConexion->prepare($sql15);
                                                        $stmt15->execute();

                                                        foreach($stmt15 as $row15)
                                                        {
                                                            $tipofotocot = $row15['tipo'];
                                                            $imagfotocot = $row15['imagen'];
                                                ?>
                                                            <img src="data:<?php echo $tipofotocot; ?>;base64,<?php echo base64_encode($imagfotocot); ?>" height="70" width="70"/>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo "Este producto es cotizable";?></td>
                                            <td><?php echo "<a href='EditProd.php?idprod=".$idprodcot."'>EDITAR</a>" ?></td>
                                            <td><?php echo "<a href='../PHP/ElimProd.php?idprod=".$idprodcot."'>ELIMINAR</a>" ?></td>
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
      
    <div class="botones">
        <div class="area2">
            <a href="EditUsu.php"><button type="submit" class="botModUsu">Editar Usuario</button></a>
        </div>
        <div class="area3">
            <!--<a href="../PHP/ElimUsu.php"><button type="submit" class="botElimUsu">Eliminar cuenta</button></a>-->
            <a href="../PHP/ElimUsu.php"><button type="submit" class="botElimUsu">Eliminar cuenta</button></a>
        </div>
    </div>

</main>
<footer>
        <div class="footer_container">
            <div class="footer_box">
                <div class="logo">
                    <i class="fa-solid fa-hashtag"></i>
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