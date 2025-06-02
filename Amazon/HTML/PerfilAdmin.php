<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

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
    <title>U-Shop | Perfil Administrador</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
</head>

<body>
    <header>

        <a href="" class="logo">
          
            <h1>F-Store</h1>
        </a>

       
                    </div>
                    <hr>
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
         
        <?php

foreach ($stmt3 as $row) {
    $id = $row['Usuario_ID'];
    $usu = $row['NomUsu'];
    $priv = $row['Privacidad'];

 
        echo "<p><b>$usu</b></p>";

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
            echo '<img src="data:image/png;base64,'. $imageData .'" height="150" width="200"/>';
        } else {
            // Mostrar un mensaje si no se encuentra la imagen del usuario
            echo "<p>No se encontró la imagen del usuario.</p>";
        }
       
    }
            ?>
            <div class="c">
                <div class="c1">
                    <br>
                    <h4>Productos pendientes de aprobar</h4>
                    <?php
                        $sql13 = "SELECT * FROM V1";
                        $stmt13 = $miConexion->prepare($sql13);
                        $stmt13->execute();
                    ?>

                        <table>
                            <tr>
                                <td>Codigo</td>
                                <td>Nombre</td>
                                <td>Descripcion</td>
                                <td>Dueño</td>
                                <td>Motivo</td>
                                <td>Validar</td>
                                
                            </tr>
                    <?php

                            foreach($stmt13 as $row13)
                            {
                                $idprodadmin = $row13['Producto_ID'];
                                $idusudueno = $row13['Usu_ID'];
                                $tipoOferta = $row13['Tipo_Oferta']
                    ?>
                                <tr>
                                    <td><?php echo $idprodadmin; ?></td>
                                    <td><?php echo $row13['Nombre']; ?></td>
                                    <td><?php echo $row13['Descripcion']; ?></td>
                                    <td>
                                        <?php
                                            $sql4 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusudueno'";
                                            $stmt4 = $miConexion->prepare($sql4);
                                            $stmt4->execute();

                                            foreach($stmt4 as $row4)
                                            {
                                                echo $row4['NomUsu'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($row13['Tipo_Oferta'] == 1) {
                                                echo "El producto quiere ser cotizable<br>";
                                            }
                                            if ($row13['Validado'] == 0) {
                                                echo "El producto quiere ser validado";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo "<a href='../PHP/validarproducto.php?idprod=".$idprodadmin."&tipo_oferta=".$tipoOferta."'>VALIDAR</a>" ?></td>
                                </tr>
                    <?php
                            }
                    ?>
                        </table>
                        
                        <br>
                        <br>
                      
                        <h4>Todos los productos validados por usted
                        </h4>
                        <table>
                            <tr>
                                <td>Codigo</td>
                                <td>Nombre</td>
                                <td>Descripcion</td>
                                <td>Dueño</td>
                            </tr>
                            <?php
                                    $stmt6 = $miConexion->prepare($q);
                                    $stmt6->execute();

                                    foreach($stmt6 as $row6)
                                    {
                                        $idusu = $row6['Usuario_ID'];

                                        $sql7 = "SELECT * FROM ProdCot_ADMIN WHERE IdUsuAdmin = '$idusu'";
                                        $stmt7 = $miConexion->prepare($sql7);
                                        $stmt7->execute();

                                        foreach($stmt7 as $row7)
                                        {
                                            $idprod = $row7['IdProdCot'];

                                            $sql8 = "SELECT * FROM Producto WHERE Producto_ID = '$idprod'";
                                            $stmt8 = $miConexion->prepare($sql8);
                                            $stmt8->execute();

                                            foreach($stmt8 as $row8)
                                            {
                                                $idusudeno1 = $row8['Usu_ID'];
                                ?>
                                                <tr>
                                                    <td><?php echo $row8['Producto_ID']; ?></td>
                                                    <td><?php echo $row8['Nombre']; ?></td>
                                                    <td><?php echo $row8['Descripcion']; ?></td>
                                                    <td>
                                                        <?php
                                                            $sql9 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusudeno1'";
                                                            $stmt9 = $miConexion->prepare($sql9);
                                                            $stmt9->execute();

                                                            foreach($stmt9 as $row9)
                                                            {
                                                                echo $row9['NomUsu'];
                                                            }
                                                        ?>
                                                    </td>
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
    <div class="botones">
        <!--<div class="area3">
            <a href="../PHP/ElimUsu.php"><button type="submit" class="botElimUsu">Eliminar Cuenta</button></a>
        </div>-->
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