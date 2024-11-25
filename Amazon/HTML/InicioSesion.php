<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>F-Store | Iniciar sesion</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\ElementosGenerales.css">
    <link rel="stylesheet" type="text/css" href="..\CSS\InicioSesion.css">
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link type="text/javascript" href="..\JS\InicioSesion.js">
</head>

<body>
    <header>
        <a href="Landing_Page.php" class="logo">
            <!--  <i class="fa-solid fa-hashtag"></i>-->
            <h1>F-Store</h1>
        </a>
        <nav class="Opciones">
            <a href="../HTML/RegistroUsuario.php" class="Opc_1">Registrarse</a>
            <a href="../HTML/InicioSesion.php" class="Opc_2">Iniciar Sesion</a>
        </nav>
    </header>

    <main>
        <div class="cuadro">
            <div class="contenido">
                <form action="../PHP/loguear.php" class="formulario" id="formulario" method="POST">
                <!--<form onsubmit="return validarFormulario();" class="formulario" id="formulario" method="POST">-->
                    <ul class="lista">
                        <li>
                            <h1 class="titulo">Iniciar Sesion</h1>
                        </li>
                        <!--Grupo Nombre de Usuario-->
                        <li>
                            <div class="formulario__grupo" id="grupo__nombre_usuario">
                                <label for="Nombre de Usuario" class="formulario__label">Nombre de Usuario</label>
                                <div class="formulario__grupo-input">
                                    <input name="NombredeUsuario" class="formulario__input" id="Usuario" type="text" placeholder="Nombre de usuario">
                                </div>
                            </div>
                        </li>

                        <!--Grupo Contraseña-->
                        <li>
                            <div class="formulario__grupo" id="grupo__contraseña">
                                <label for="Contraseña" class="formulario__label">Contraseña</label>
                                <div class="formulario__grupo-input">
                                    <input name="Contraseña" class="formulario__input" id="Contraseña" type="password" placeholder="Contraseña">
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="formulario__mensaje" id="formulario__mensaje">
                                <p><i class="fas fa-exclamation-triangle"></i><b>Error: </b>La combinacion de usuario y
                                    contraseña no es válida</p>
                            </div>
                        </li>

                        <li>
                            <div class="formulario__grupo formulario__grupo-btn-iniciar">
                                <button type="submit" class="formulario__btn">Iniciar Sesion</button>
                                <p class="formulario__mensaje-exito" id="formulario__mensaje-exito"></p>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </main>

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
</body>

</html>