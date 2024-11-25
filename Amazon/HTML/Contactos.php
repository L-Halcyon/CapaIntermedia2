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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>F-Store | Contactos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Mensajes.css">

</head>

<body>
    <header>
        <a href="../HTML/PagIni.php" class="logo">

            <h1 style="color:  #339EFF;">F-Store</h1>
        </a>


        <hr>

        <a href="Carrito.php" class="sub-menu-link">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Carrito</p>
            <span></span>
        </a>
        <a href="../HTML/Perfil.php" class="sub-menu-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>Regresar</p>
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
            <h1 class="Titulo">Contactos</h1>

            <div class="card">
                <div class="card-body">
                    <?php
                        $stmt3 = $miConexion->prepare($q);
                        $stmt3->execute();
                        
                        foreach($stmt3 as $row3)
                        {
                            $idusuario = $row3['Usuario_ID'];

                            $sql4 = "SELECT * FROM Contactos WHERE IdUsuario = '$idusuario'";
                            $stmt4 = $miConexion->prepare($sql4);
                            $stmt4->execute();

                            foreach($stmt4 as $row4)
                            {
                                $idusuariocont = $row4['IdUsuariocon'];

                                $sql5 = "SELECT * FROM Usuario WHERE Usuario_ID = '$idusuariocont'";
                                $stmt5 = $miConexion->prepare($sql5);
                                $stmt5->execute();

                                foreach($stmt5 as $row5)
                                {
                                    
                                    $nombusuario = $row5['NomUsu'];
                                    ?>
                                    <div class="usuario-info">
    <div class="izquierda"><?php echo $nombusuario; ?></div>
    <div class="derecha"><a href='Cotizar.php?nombusu=<?php echo $nombusuario; ?>' class="boton">Chatear</a></div>
</div>
                                    <?php
                                  /*  echo $nombusuario;
                                    echo "<a href='Cotizar.php?nombusu=".$nombusuario."'>Chatear</a>";*/
                                    
                    ?>
                                    <br>
                    <?php
                                }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>