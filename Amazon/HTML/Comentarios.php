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
<html>

<head>
    <meta charset="UTF-8">
    <title>U-Shop | Comentarios & Valoracion</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estilocomen.css">
</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
            <i class="fa-solid fa-hashtag"></i>
            <h1>U-Shop</h1>
        </a>

        <div class="PerfilUsuario">
            <button onclick="mostrar()">
                <?php
                    foreach($stmt as $row)
                    {
                        $id = $row['Usuario_ID'];
                        
                        $q1 = "SELECT * FROM Usuario_Foto WHERE Usu_ID = '$id'";
                        $stmt1 = $miConexion->prepare($q1);
                        $stmt1->execute();

                        foreach($stmt1 as $row1)
                        {
                            $tipo = $row1['tipo'];
                            $imag = $row1['imagen'];
                ?>
                            <img src="data:<?php echo $tipo; ?>;base64,<?php echo base64_encode($imag); ?>" height="40" width="40"/>
            </button>

            <div class="sub-menu-wrap" id="SubMenu">
                <div class="sub-menu">
                    <div class="user-info">
                            <img src="data:<?php echo $tipo; ?>;base64,<?php echo base64_encode($imag); ?>" height="50" width="50"/>
                        
                        <?php
                        }
                    }
                        ?>
                        <?php
                            foreach($stmt2 as $row2)
                            {
                        ?>
                        <h2><?php echo $row2['NomUsu']; ?></h2>
                        <?php
                            }
                        ?>
                    </div>
                    <hr>
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
                    <?php
                        $stmt3 = $miConexion->prepare($q);
                        $stmt3->execute();

                        foreach($stmt3 as $row3)
                        {
                            $idusuario = $row3['Usuario_ID'];

                            $sql4 = "SELECT * FROM Carrito WHERE Usu_ID = '$idusuario' AND Estado = 1";
                            $stmt4 = $miConexion->prepare($sql4);
                            $stmt4->execute();

                            foreach($stmt4 as $row4)
                            {
                                $idcarrito = $row4['Carrito_ID'];
                                $idproducto = $row4['Prod_ID'];

                                $sql5 = "SELECT * FROM Producto WHERE Producto_ID = '$idproducto'";
                                $stmt5 = $miConexion->prepare($sql5);
                                $stmt5->execute();

                                foreach($stmt5 as $row5)
                                {
                                    $nombreproducto = $row5['Nombre'];
                    ?>
                                    <form action="../PHP/agcom.php" method="post">
                                        <b><?php echo $nombreproducto; ?></b>
                                        <br>
                                        <input type="hidden" id="idprod" name="idprod" value="<?php echo $idproducto;?>">
                                        <input type="hidden" id="idcarr" name="idcarr" value="<?php echo $idcarrito;?>">
                                        <b><label>Comentario</label></b>
                                        <br>
                                        <textarea id="com" name="com"></textarea>
                                        <br>
                                        <br>
                                        <b><label>Puntaje (1 - 10)</label></b>
                                        <br>
                                        <input type="number" id="punt" name="punt">
                                        <button type="submit">Enviar</button>
                                        <br>
                                        <br>
                                        <hr>
                                    </form>
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
                    <i class="fa-solid fa-hashtag"></i>
                    <h1>U-Shop</h1>
                </div>
                <div class="terminos">
                    <p>La Empresa En Sí Es Una Empresa Muy Exitosa. ¿A Él El Placer De Las Penas, La Culpa De Los
                        Placeres Fáciles, Resultarán De La Ganancia, Ni Le Explicaré Las Veces Que Quiere Del Odio, O Es
                        Menor En Otras Ocasiones? Ciertamente Así Es.</p>
                </div>
            </div>

            <div class="footer_box">
                <h3>Creadores</h3>
                <a href="#">A</a>
                <a href="#">B</a>
                <a href="#">C</a>
                <a href="#">D</a>
            </div>

            <div class="footer_box">
                <h3>Contacto</h3>
                <a href="#">A</a>
                <a href="#">B</a>
                <a href="#">C</a>
                <a href="#">D</a>
            </div>

            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2023 <b>U-Shop</b></p>
            </div>

        </div>
    </footer>
</body>
</html>