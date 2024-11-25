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

$sql2 = "SELECT * FROM V4";
$stmt3 = $miConexion->prepare($sql2);
$stmt3->execute();

?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Publicar producto</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPP.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">

</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
            <h1>F-Store</h1>
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
                <!--descomentar para agregar prod-->
               <form action="../PHP/registroPublicacion.php" id="formulario" method="post" enctype="multipart/form-data">
                <!-- <form id="formulario" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario();">-->
                    <label class="Encabezado" for="n">Nombre: </label>
                    <input type="text" id="nombre" name="nombre">
                    <div id="error-nombre" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>

                    <label class="Encabezado" for="decri">Descripción:</label>
                    <textarea id="decrip" name="decrip"></textarea>
                    <div id="error-descripcion" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>

                    <label class="Encabezado">Imagen 1: </label>
                    <input type="file" id="foto1" name="foto1" accept="image/*">
                    <br>
                    <br>

                    <label class="Encabezado">Imagen 2: </label>
                    <input type="file" id="foto2" name="foto2" accept="image/*">
                    <br>
                    <br>

                    <label class="Encabezado">Imagen 3: </label>
                    <input type="file" id="foto3" name="foto3" accept="image/*">
                    <div id="error-imagenes" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>

                    <label class="Encabezado">Video 1: </label>
                    <input type="file" id="video1" name="video1" accept="video/*">
                    <label style="color: white; font-size: 10px;">(EL VIDEO DEBE PESAR MENOS DE 45MB)</label>
                    <div id="error-video" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>

                    <label class="Encabezado">Categorías: </label>
<br>
<select id="categ" name="categ">
    <?php
    foreach ($stmt3 as $row) {
        echo '<option value="' . $row['Categoria_ID'] . '">' . $row['Nombre'] . '</option>';
    }
    ?>
</select>

                  
                    <br>
                    <br>
                  

<!-- Input oculto inicialmente -->
<br>
<br>
<label class="Encabezado" for="prec" name="prec2" id="labelPrec" >Precio: $</label>
<input type="number" id="prec" name="prec" min="0" step="0.01" >      
<input type="checkbox" id="cotizableToggle"  name="cotizable" onchange="toggleInputVisibility()"> Cotizable
                  <!--  <input type="number" id="prec" name="prec" min="0" step="0.01"> -->
                    <label style="color: white; font-size: 10px;">(SI DESEA QUE ESTE PRODUCTO SEA COTIZADO, PRECIONE EL CHECHBOX "COTIZABLE")</label>
                    <div id="error-precio" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>

                    <label class="Encabezado" for="cant">Cantidad:</label>
                    <input type="number" id="cant" name="cant" min="1">
                    <div id="error-cantidad" class="formulario__input-error"></div> <!-- Nuevo elemento para mostrar errores -->

                    <br>
                    <br>

                    <button type="submit" class="arg">Agregar</button>

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
                <p>Contáctanos y estaremos encantados de ayudarte.</p>
            </div>



            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
            </div>

        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/AgregarProducto.js"></script>

</body>


</html>
<script>
     window.onload = function() {
        // Desactivar el checkbox al cargar la página
        document.getElementById('cotizableToggle').checked = false;

        // Llamar a la función toggleInputVisibility para asegurarse de que los elementos estén en el estado correcto al cargar la página
        toggleInputVisibility();
    };
     function toggleInputVisibility() {
        var cotizableToggle = document.getElementById('cotizableToggle');
        var inputPrec = document.getElementById('prec');
        var labelPrec = document.getElementById('labelPrec');
        
        if (cotizableToggle.checked) {
            inputPrec.style.display = 'none'; // Ocultar el input si "Cotizable" está encendido
            labelPrec.style.display = 'none';
        } else {
            inputPrec.style.display = 'block'; 
            labelPrec.style.display = 'block';
        }
    }
</script>