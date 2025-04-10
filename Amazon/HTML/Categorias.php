
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

$sql3 = "SELECT * FROM Categoria WHERE Usu_ID = '$usuario'" ;
$stmt3 = $miConexion->prepare($sql3);
$stmt3->execute();

$stmt4 = $miConexion->prepare($q);
$stmt4->execute();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Crear categoria</title>
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
    </header>

    <div class="contenedor">
        <div class="area1">
            <div class="contenido">
            <form action="../PHP/regcateg.php" id="formulario" method="post" enctype="multipart/form-data">
                <!--<form action="../HTML/Categorias.php" id="formulario" method="post" onsubmit="return validarFormulario();" enctype="multipart/form-data">-->
                    <label class="Encabezado" for="n">DESEAS CREAR UNA NUEVA CATEGORIA</label>
                    <br>
                    <label class="Encabezado" for="n">INGRESE LOS DATOS AQUI</label>
                    <br>
                    <br>
                    <label class="Encabezado" for="n">Nombre: </label>
                    <input type="text" id="nombreCategoria" name="nombre">
                    <div id="error-nombreCategoria" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>
                    <label class="Encabezado" for="decri">Descripción:</label>
                    <textarea id="decrip" name="decrip"></textarea>
                    <br>
                    <br>
                    <button type="submit" class="agr">Agregar</button>
                </form>
                <br>
                <br>
                <table border="1">
                    <tr>
                        <td>Codigo</td>
                        <td>Nombre</td>
                        <td>Descripcion</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                    </tr>
                    <?php
                        foreach($stmt4 as $row4)
                        {
                            $idusuario = $row4['Usuario_ID'];

                            foreach($stmt3 as $row3)
                            {
                                $idcateg = $row3['Categoria_ID'];
                                $idusucateg = $row3['Usu_ID'];
                                $eliminado = $row3['Eliminado'];
                                if ($eliminado == 0) { // Verificar si el valor de 'Eliminado' es 0
                                
                    ?>
                                <tr>
                                    <td><?php echo $idcateg; ?></td>
                                    <td><?php echo $row3['Nombre']; ?></td>
                                    <td><?php echo $row3['Descripcion']; ?></td>
                    
                                        <td><?php echo "<a href='EditCateg.php?idcateg=".$idcateg."'>EDITAR</a>" ?></td>
                                        <td><?php echo "<a href='../PHP/ElimCateg.php?idcateg=".$idcateg."'>ELIMINAR</a>" ?></td>
                   
                    <?php
                                    
                                }
                    ?>
                                </tr>
                    <?php
                            }
                        }
                    ?>


                </table>
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
    <script src="../JS/AgregarCategoria.js"></script>
</body>

</html>