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
            <a href="../HTML/Listas.php" class="Opc_3">Crear Lista</a>
            <a href="../HTML/Contactos.php" class="Opc_4">Contactos y cotizaciones</a>
            
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

    // Mostrar el nombre del usuario
        echo "<p><b>$usu</b><br><br></p>";
        // Obtener la imagen del usuario
        $q5 = "SELECT ImagenPerfil FROM Usuario WHERE Usuario_ID = ?";
        $stmt5 = $miConexion->prepare($q5);
        $stmt5->execute([$id]);

        if ($stmt5->rowCount() > 0) {
            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
            $imageData = base64_encode($row5['ImagenPerfil']);
            echo '<img src="data:image/png;base64,' . $imageData . '" height="200" width="250"/>';
        } else {
            echo "<p>No se encontró la imagen del usuario.</p>";
        }

    // Verificar si la privacidad del usuario es 1
    if ($priv === 3) {
        // Mostrar un mensaje de perfil privado
        echo "<script>alert('Este perfil es privado');</script>";

    }  
    
    else{
        ?>
                            <br>
                            <br>
                            <h4><?php print("LISTAS"); ?></h4>
                            <br>
                            <h5><?php print("Públicas"); ?></h5>
                            <div class="listas-container">
                            <?php
                            foreach($stmt9 as $row9) {
                                $idusu = $row9['Usuario_ID'];

                                $sql10 = "SELECT * FROM Lista WHERE Usu_ID = '$idusu' AND Tipo = 'publica' AND Eliminado = 0";
                                $stmt10 = $miConexion->prepare($sql10);
                                $stmt10->execute();

                                foreach($stmt10 as $row10) {
                                    $idlista = $row10['Lista_ID'];
                                    $nombre = $row10['Nombre'];
                                    $descripcion = $row10['Descripcion'];
                            ?>
                                <div class="card-lista">
                                    <h3><?php echo $nombre; ?></h3>
                                    <p><?php echo $descripcion; ?></p>
                                    <div class="acciones">
                                        <a class="btn-ver" href="verprodlis.php?idlist=<?php echo $idlista; ?>">Ver</a>
                                        <a class="btn-editar" href="Editlis.php?idlist=<?php echo $idlista; ?>">Editar</a>
                                        <a class="btn-eliminar" href="../PHP/Elimlis.php?idLista=<?php echo $idlista; ?>">Eliminar</a>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                            ?>
                            </div>

                             <br>
                           <br>
                            <h5><?php print("Privadas"); ?></h5>
                            <div class="listas-container">
                            <?php
                            foreach($stmt11 as $row11) {
                                $idusu = $row11['Usuario_ID'];

                                $sql12 = "SELECT * FROM Lista WHERE Usu_ID = '$idusu' AND Tipo = 'privada' AND Eliminado = 0";
                                $stmt12 = $miConexion->prepare($sql12);
                                $stmt12->execute();

                                foreach($stmt12 as $row12) {
                                    $idlistapriv = $row12['Lista_ID'];
                                    $nombre = $row12['Nombre'];
                                    $descripcion = $row12['Descripcion'];
                            ?>
                                <div class="card-lista">
                                    <h3><?php echo $nombre; ?></h3>
                                    <p><?php echo $descripcion; ?></p>
                                    <div class="acciones">
                                        <a class="btn-ver" href="verprodlis.php?idlist=<?php echo $idlistapriv; ?>">Ver</a>
                                        <a class="btn-editar" href="Editlis.php?idlist=<?php echo $idlistapriv; ?>">Editar</a>
                                        <a class="btn-eliminar" href="../PHP/Elimlis.php?idlist=<?php echo $idlistapriv; ?>">Eliminar</a>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                            ?>
                            </div>

                                        <br>

                                    
                                <?php } ?>
                                </div>
                                            
                    <?php
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