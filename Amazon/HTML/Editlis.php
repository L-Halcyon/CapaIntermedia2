<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$idlista = $_GET['idlist'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$sql3 = "SELECT * FROM Lista WHERE Lista_ID = '$idlista'";
$stmt3 = $miConexion->prepare($sql3);
$stmt3->execute();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Editar Lista</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloCategoria.css">
    <link type="text/javascript" href="..\JS\editarLista.js">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">

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
            <div class="contenido">
            <form action="../PHP/editarlista.php" id="formulario" method="post" enctype="multipart/form-data">
                <?php
                    foreach($stmt3 as $row3)
                    {
                        $id = $row3['Lista_ID'];
                        $nombre = $row3['Nombre'];
                        $descripcion = $row3['Descripcion'];
                        $tipo = $row3['Tipo'];
                ?>
                        <input type="hidden" id="idlista" name="idlista" value="<?php echo $id; ?>">
                        <label class="Encabezado" for="n">Nombre: </label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                        <br>
                        <br>
                        <label class="Encabezado" for="decri">Descripcion:</label>
                        <textarea id="decrip" name="decrip"><?php echo $descripcion; ?></textarea>
                        <br>
                        <br>
                        <label for="Genero" class="formulario__label">Tipo de lista</label>
                        <br>
                        <input type="radio" name="tipo" value="privada" <?php echo $tipo === 'privada' ? 'checked' : '' ?>> Privada
                        <br>
                        <input type="radio" name="tipo" value="publica" <?php echo $tipo === 'publica' ? 'checked' : '' ?>> Publica
                        <br>
                        <br>
                        <button type="submit" class="agr">Editar</button>
                <?php
                    }
                ?>    
                </form>
                <br>
                <br>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer_container">
            <div class="footer_box">
                <div class="logo">
                    <!-- <i class="fa-solid fa-hashtag"></i>-->
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

    <script src="..\JS\InicioSesion.js"></script>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <script src="../JS/AgregarLista.js"></script>

</body>

</html>