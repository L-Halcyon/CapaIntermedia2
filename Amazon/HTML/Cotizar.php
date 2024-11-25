<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$usuarioconta = $_GET['nombusu'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$stmt3 = $miConexion->prepare($q);
$stmt3->execute();

$stmt5 = $miConexion->prepare($q);
$stmt5->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>F-Store | Cotizacion</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Mensajes.css">
</head>

<body>
    <header>
        <a href="PagIni.php" class="logo">
        <h1 style="color:  #339EFF;">F-Store</h1>
        </a>

       
                    <hr>
                 
                    <a href="" class="sub-menu-link">
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
        <h1 class="Titulo"><?php echo $usuarioconta; ?></h1>

            <div class="card">
                <div class="card-body">
                    <?php
                        $sql6 = "SELECT * FROM Usuario WHERE NomUsu = '$usuarioconta'";
                        $stmt6 = $miConexion->prepare($sql6);
                        $stmt6->execute();

                        foreach($stmt5 as $row5)
                        {
                            $idusuario1 = $row5['Usuario_ID'];
                            $usu1 = $row5['NomUsu'];

                            foreach($stmt6 as $row6)
                            {
                                $idusuario2 = $row6['Usuario_ID'];
                                $usu2 = $row6['NomUsu'];

                                $sql7 = "SELECT * FROM V5";
                                $stmt7 = $miConexion->prepare($sql7);
                                $stmt7->execute();

                                foreach($stmt7 as $row7)
                                {
                                    $idenv = $row7['ID_usuario'];
                                    $idrec = $row7['ID_usuariorecibidor'];
                                    $mensaje = $row7['Mensaje'];

                                    if($idusuario1 == $idenv)
                                    {
                                        if($idusuario2 == $idrec)
                                        {
                                            echo $usu1.": ".$mensaje;
                                            echo "<br>";
                                        }
                                    }

                                    if($idusuario2 == $idenv)
                                    {
                                        if($idusuario1 == $idrec)
                                        {
                                            echo $usu2.": ".$mensaje;
                                            echo "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <form action="../PHP/envmensaje.php" method="post">
                            <?php
                                foreach($stmt3 as $row3)
                                {
                                    $idusuario = $row3['Usuario_ID'];

                                    $sql4 = "SELECT * FROM Usuario WHERE NomUsu = '$usuarioconta'";
                                    $stmt4 = $miConexion->prepare($sql4);
                                    $stmt4->execute();

                                    foreach($stmt4 as $row4)
                                    {
                                        $idusuariocon = $row4['Usuario_ID'];
                            ?>
                                        <input type="hidden" id="idUsu" name="idUsu" value="<?php echo $idusuario;?>">
                                        <input type="hidden" id="idUsucon" name="idUsucon" value="<?php echo $idusuariocon;?>">
                                        <input class="Input_mensaje" type="text" class="form-control" placeholder="Escribe tu mensaje..." id="mensaje" name="mensaje">
                                        <button class="btn" type="submit">Enviar</button>
                            <?php
                                    }
                                }
                            ?>
                        </form>
                        <?php
                            $stmt8 = $miConexion->prepare($q);
                            $stmt8->execute();

                            foreach($stmt8 as $row8)
                            {
                                $idusu = $row8['Usuario_ID'];

                                $sql9 = "SELECT * FROM Producto WHERE Usu_ID = '$idusu' AND Tipo_Oferta = 1 AND Eliminado = 0";
                                $stmt9 = $miConexion->prepare($sql9);
                                $stmt9->execute();

                                if($stmt9->rowCount() > 0)
                                {
                                    ?>
                                
                                <div class="boton-derecha">
<form action="../HTML/Recibircot.php" method="get">
    <input type="hidden" name="nombusurec" value="<?php echo htmlspecialchars($idusuariocon); ?>">
    <input type="hidden" name="idusuario" value="<?php echo htmlspecialchars($idusuario); ?>">
    <button type="submit" class="btn">Ver Propuesta</button>
</form>
</div>

                                      <?php
                                    /*echo "<button ><a href='../HTML/envpcU.php?nombusu=".$usuarioconta."'>Propuesta de Poducto</a></button>";*/
                                   
                                }
                                else{
                                    ?>

<div class="boton-derecha">
<form action="../HTML/envpcU.php" method="get">
    <input type="hidden" name="nombusurec" value="<?php echo htmlspecialchars($idusuariocon); ?>">
    <input type="hidden" name="idusuario" value="<?php echo htmlspecialchars($idusuario); ?>">
    <button type="submit" class="btn">Propuesta de Producto</button>
</form>
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