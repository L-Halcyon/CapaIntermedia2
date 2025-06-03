<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>F-Store | Registrarse</title>
    <link rel="stylesheet" type="text/css" href="..\CSS\ElementosGenerales.css">
    <link rel="stylesheet" type="text/css" href="..\CSS\RegistroUsuario.css">
    <!-- <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script> -->
    //<link type="text/javascript" href="..\JS\RegistroUsuario.js">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">


</head>

<body>
    <header>
        <a href="../HTML/Landing_Page.php" class="logo">
            <!--<i class="fa-solid fa-hashtag"></i>-->
            <h1>F-Store</h1>
        </a>

        <nav class="Opciones">
            <a href="../HTML/RegistroUsuario.php" class="Opc_1">Registrarse</a>
            <a href="../HTML/InicioSesion.php" class="Opc_2">Iniciar Sesion</a>
        </nav>
    </header>

    <main>
        <div class="cuadro">
            <!-- <form action="../PHP/registro.php" onsubmit=" return validarFormulario();" class="formulario" id="formulario" method="post" enctype="multipart/form-data">-->
            <form class="formulario" id="formulario" enctype="multipart/form-data">
                <ul class="lista">

                    <li>
                        <h1 class="Titulo">Registrarse</h1>
                    </li>
                    <!--Grupo Nombre-->
                    <li>
                        <div class="formulario__grupo" id="grupo__nombre">
                            <label for="Nombres" class="formulario__label">Nombre(s)</label>
                            <div class="formulario__grupo-input">
                                <input name="Nombres" id="Nombres" class="formulario__input" type="text" placeholder="Nombre completo">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">El nombre solo puede contener letras y espacios en
                                    blanco.
                                </p>
                            </div>
                        </div>

                        <!--Grupo Apellidos-->
                        <div class="formulario__grupo" id="grupo__apellido">
                            <label for="Apellidos" class="formulario__label">Apellidos</label>
                            <div class="formulario__grupo-input">
                                <input name="Apellidos" id="Apellidos" class="formulario__input" type="text" placeholder="Apellidos ">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">Los apellidos solo pueden contener letras y espacios
                                    en
                                    blanco.
                                </p>
                            </div>
                        </div>
                    </li>

                    <!--Grupo Fecha de Nacimiento-->
                    <li>
                        <div class="formulario__grupo" id="grupo__Fecha_Nacimiento">
                            <label for="FechadeNacimiento" class="formulario__label">Fecha de Nacimiento</label>
                            <div class="formulario__grupo-input">
                                <input name="FechadeNacimiento" id="FechadeNacimiento" class="formulario__input" type="date" >
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">La fecha de nacimiento no puede ser despues del dia
                                    actual.
                                </p>
                            </div>
                        </div>

                        <!--Grupo Correo-->
                        <div class="formulario__grupo" id="grupo__correo">
                            <label for="CorreoElectrónico" class="formulario__label">Correo Electrónico</label>
                            <div class="formulario__grupo-input">
                                <input name="CorreoElectrónico" id="CorreoElectronico" class="formulario__input" type="text" placeholder="ejemplo@gmail.com">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">El correo electrónico debe tener un formato como el
                                    del
                                    ejemplo:
                                    ejemplo@gmail.com</p>
                            </div>
                        </div>
                    </li>

                    <!--Grupo Genero-->
                    <li>
                        <div class="formulario__grupo" id="grupo__Genero">
                            <label for="Genero" class="formulario__label">Género</label>
                            <div class="formulario__grupo-input">
                                <input type="radio" name="genero" value="M"> Masculino
                                <input type="radio" name="genero" value="F"> Femenino
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">No se ha escogido un género.
                                </p>
                            </div>
                        </div>
                    </li>

                    <!--Grupo Imagen de Perfil-->
                    <li>
                        <div class="formulario__grupo" id="grupo__Imagen_perfil">
                            <label for="ImagendePerfil" class="formulario__label">Imagen de Perfil</label>
                            <div class="formulario__grupo-input">
                                <input name="ImagendePerfil" id="ImagendePerfil" class="formulario__input" type="file" accept="image/png,image/jpeg">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">Extensión no permitida. Utiliza: .jpeg/.jpg/.png/.
                                </p>
                            </div>
                        </div>

                        <!--Grupo Nombre de Usuario-->
                        <div class="formulario__grupo" id="grupo__nombre_usuario">
                            <label for="NombredeUsuario" class="formulario__label">Nombre de Usuario</label>
                            <div class="formulario__grupo-input">
                                <input name="NombredeUsuario" id="NombredeUsuario" class="formulario__input" type="text" placeholder="Nombre de Usuario">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">El nombre de usuario ya existe.</p>
                            </div>
                        </div>
                    </li>

                    <!--Grupo Contraseña-->
                    <li>
                        <div class="formulario__grupo" id="grupo__contraseña">
                            <label for="Contraseña" class="formulario__label">Contraseña</label>
                            <div class="formulario__grupo-input">
                                <input name="Contraseña" id="Contraseña" class="formulario__input" type="password" placeholder="Contraseña">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">
                                    La contraseña debe tener:<br>
                                    • Por lo menos 8 caracteres<br>
                                    • Una letra mayúscula<br>
                                    • Una letra minúscula<br>
                                    • Un número<br>
                                    • Un signo de puntuación
                                </p>
                            </div>
                        </div>

                        <!--Grupo Confirmar Contraseña-->
                        <div class="formulario__grupo" id="grupo__confirmar_contraseña">
                            <label for="ConfirmarContraseña" class="formulario__label">Confirmar Contraseña</label>
                            <div class="formulario__grupo-input">
                                <input name="ConfirmarContraseña" id="ConfirmarContraseña" class="formulario__input" type="password" placeholder="Contraseña">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">La confirmacion no coincide con la contraseña
                                    introducida.
                                </p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="formulario__mensaje" id="formulario__mensaje">
                            <p><i class="fas fa-exclamation-triangle"></i><b>Error: </b>Rellene el formulario
                                correctamente
                            </p>
                        </div>
                    </li>

                    <!--Grupo Rol-->
                    <li>
                        <div class="formulario__grupo" id="grupo__Rol">
                            <label for="Rol" class="formulario__label">Rol de usuario</label>
                            <div class="formulario__grupo-input" id="Rol">
                                <input type="radio" name="Rol" value="0"> Vendedor
                                <input type="radio" name="Rol" value="1"> Cliente
                                <input type="radio" name="Rol" value="2"> Administrador
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">No se ha escogido un rol.
                                </p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="formulario__grupo formulario__grupo-btn-crear">
                            <button type="submit" class="formulario__btn">Crear</button>
                            <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">La cuenta se ha creado exitosamente</p>
                        </div>
                    </li>
                </ul>
            </form>
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
                <p>Contáctanos y estaremos encantados de ayudarte.</p>
            </div>



            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
            </div>



        </div>
    </footer>

    <!--<script src="../JS/RegistroUsuario.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/Registro.js"></script>
</body>

</html>
