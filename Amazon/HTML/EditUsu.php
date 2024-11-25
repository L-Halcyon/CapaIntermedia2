<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['user_id'];

$q = "SELECT * FROM Usuario WHERE Usuario_ID = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>F-Store | Modicar datos</title>
    <link rel="stylesheet" type="text/css" href="..\CSS\ElementosGenerales.css">
    <link rel="stylesheet" type="text/css" href="..\CSS\RegistroUsuario.css">
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link type="text/javascript" href="..\JS\ModUsu.js">
    <link type="text/javascript" href="..\JS\RegistroUsuario.js">

</head>

<body>
    <header>
        <a href="PagIni.php" class="logo">

            <h1>F-Store</h1>
        </a>
        <a href="../HTML/Perfil.php" class="sub-menu-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>Cancelar</p>
            <span></span>
            </a> 
    </header>

    <main>
        <div class="cuadro">
          <!--  <form action="../PHP/EditUsu.php" onsubmit=" return validarFormulario();" class="formulario" id="formulario" method="post" enctype="multipart/form-data">-->
            <form action="../PHP/EditUsu.php"  class="formulario" id="formulario" method="post" enctype="multipart/form-data">
                <ul class="lista">
                <?php
                        foreach($stmt as $row)
                        {
                            $id = $row['Usuario_ID'];
                            $Rol = $row['Rol'];
                            $priv = $row['Privacidad'];
                      
                    ?>
                      <input type="hidden" id="idUsu" name="ID" value="<?php echo $id;?>">
                      <input type="hidden" id="Rol" name="Rol" value="<?php echo $Rol;?>">
                    <li>
                        <h1 class="Titulo">Modificar</h1>
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
                                <input name="FechadeNacimiento" id="Fecha de Nacimiento" class="formulario__input" type="date">
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
                                <input name="CorreoElectrónico" id="Correo Electrónico" class="formulario__input" type="text" placeholder="ejemplo@gmail.com">
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
                                <input name="ImagendePerfil" id="Imagen de Perfil" class="formulario__input" type="file" accept="image/png,image/jpeg">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">Extensión no permitida. Utiliza: .jpeg/.jpg/.png/.
                                </p>
                            </div>
                        </div>

                        <!--Grupo Nombre de Usuario-->
                        <div class="formulario__grupo" id="grupo__nombre_usuario">
                            <label for="NombredeUsuario" class="formulario__label">Nombre de Usuario</label>
                            <div class="formulario__grupo-input">
                                <input name="NombredeUsuario" id="Nombre de Usuario" class="formulario__input" type="text" placeholder="Nombre de Usuario">
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
                                <input name="ConfirmarContraseña" id="Confirmar Contraseña" class="formulario__input" type="password" placeholder="Contraseña">
                                <span class="material-symbols-rounded">cancel</span>
                                <p class="formulario__input-error">La confirmacion no coincide con la contraseña
                                    introducida.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <input type="radio" name="privacidad" value=0
                            <?php echo $priv === 0 ? 'checked' : '' ?>> Publico
                        <input type="radio" name="privacidad" value=1
                            <?php echo $priv === 1 ? 'checked' : '' ?>> Privado
                    </li>
                    <?php
                        }
                    ?>
                    <li>
                        <div class="formulario__mensaje" id="formulario__mensaje">
                            <p><i class="fas fa-exclamation-triangle"></i><b>Error: </b>Rellene el formulario
                                correctamente
                            </p>
                        </div>
                    </li>

                

                    <li>
                        <div class="formulario__grupo formulario__grupo-btn-crear">
                            <button type="submit" class="formulario__btn">Editar</button>
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
    <script src="../JS/RegistroUsuario.js"></script>
</body>

</html>

