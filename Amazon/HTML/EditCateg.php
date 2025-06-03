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

$idcategoria = $_GET['idcateg'];

$sql3 = "SELECT * FROM Categoria WHERE Categoria_ID = '$idcategoria'";
$stmt3 = $miConexion->prepare($sql3);
$stmt3->execute();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Publicar producto</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloCategoria.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">

</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
          
            <h1>F-Store</h1>
        </a>
                    </div>
                    <hr>
                  
                    <a href="Carrito.php" class="sub-menu-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Carrito</p>
                        <span></span>
                    </a>
                    <a href="../HTML/Categorias.php" class="sub-menu-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Regresar</p>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="contenedor">
        <div class="area1">
            <div class="contenido">
           <!-- <form action="../HTML/Categorias.php" id="formulario" method="post" onsubmit="return validarFormulario();" enctype="multipart/form-data">-->
           <form action="../PHP/editarCategoria.php" id="formulario" method="post" enctype="multipart/form-data">
           <?php
                        foreach($stmt3 as $row3)
                        {
                    ?>
                              <input type="hidden" id="idcateg" name="idcateg" value="<?php echo $row3['Categoria_ID'];?>">
                            <label class="Encabezado" for="n">EDITAR CATEGORIA</label>
                            <br>
                            <br>
                            <label class="Encabezado" for="n">Nombre: </label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo $row3['Nombre']; ?>">
                            <br>
                            <br>
                            <label class="Encabezado" for="decri">Descripcion:</label>
                            <textarea id="decrip" name="decrip"><?php echo $row3['Descripcion']; ?></textarea>
                            <br>
                            <br>
                            <button type="submit" class="agr">Editar</button>
                    <?php
                        }
                    ?>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/AgregarCategoria.js"></script>
</body>
</html>