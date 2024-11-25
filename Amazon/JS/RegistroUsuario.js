function validarFormulario() {
    var formulario = document.getElementById("formulario");
    var nombre = formulario["Nombres"].value.trim();
    var apellidos = formulario["Apellidos"].value.trim();
    var fechaNacimiento = formulario["FechadeNacimiento"].value;
    var correo = formulario["CorreoElectrónico"].value.trim();
    var genero = formulario["genero"].value;
    var imagenPerfil = formulario["ImagendePerfil"].value;
    var nombreUsuario = formulario["NombredeUsuario"].value.trim();
    var contrasena = formulario["Contraseña"].value;
    var confirmarContrasena = formulario["ConfirmarContraseña"].value;
    var rol = formulario["Rol"].value;

    var errores = false;

    // Validación del nombre
    if (nombre === "") {
        mostrarError("grupo__nombre", "El nombre es requerido");
        errores = true;
    } else {
        ocultarError("grupo__nombre");
    }

    // Validación de los apellidos
    if (apellidos === "") {
        mostrarError("grupo__apellido", "Los apellidos son requeridos");
        errores = true;
    } else {
        ocultarError("grupo__apellido");
    }

    // Validación de la fecha de nacimiento
    var fechaActual = new Date();
    var fechaIngresada = new Date(fechaNacimiento);
    if (fechaIngresada > fechaActual) {
        mostrarError("grupo__Fecha_Nacimiento", "La fecha de nacimiento no puede ser posterior a la fecha actual");
        errores = true;
    } else {
        ocultarError("grupo__Fecha_Nacimiento");
    }

    // Validación del correo electrónico
    var regexCorreo = /^\S+@\S+\.\S+$/;
    if (!regexCorreo.test(correo)) {
        mostrarError("grupo__correo", "El correo electrónico debe tener un formato válido");
        errores = true;
    } else {
        ocultarError("grupo__correo");
    }

    // Validación del género
    if (!genero) {
        mostrarError("grupo__Genero", "Debe seleccionar un género");
        errores = true;
    } else {
        ocultarError("grupo__Genero");
    }

    // Validación de la imagen de perfil
    if (imagenPerfil === "") {
        mostrarError("grupo__Imagen_perfil", "Debe seleccionar una imagen de perfil");
        errores = true;
    } else {
        ocultarError("grupo__Imagen_perfil");
    }

    // Validación del nombre de usuario
    if (nombreUsuario === "") {
        mostrarError("grupo__nombre_usuario", "El nombre de usuario es requerido");
        errores = true;
    } else {
        ocultarError("grupo__nombre_usuario");
    }

    // Validación de la contraseña
    var regexContrasena = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
    if (!regexContrasena.test(contrasena)) {
        mostrarError("grupo__contraseña", "La contraseña no cumple con los requisitos:\n- Mínimo de 8 caracteres.\n- Al menos una mayúscula.\n- Al menos una minúscula.\n- Al menos un número.\n- Al menos un carácter especial.");

        errores = true;
    } else {
        ocultarError("grupo__contraseña");
    }

    // Validación de la confirmación de la contraseña
    if (contrasena !== confirmarContrasena) {
        mostrarError("grupo__confirmar_contraseña", "La confirmación no coincide con la contraseña");
        errores = true;
    } else {
        ocultarError("grupo__confirmar_contraseña");
    }

    // Validación del rol
    if (!rol) {
        mostrarError("grupo__Rol", "Debe seleccionar un rol");
        errores = true;
    } else {
        ocultarError("grupo__Rol");
    }

    if (errores) {
        alert("Llenar todos los campos");
        return false;
    } else {
        alert("La información se envió correctamente");
        window.location.href = "../HTML/InicioSesion.php";
        return true;
    }
}

function mostrarError(idGrupo, mensaje) {
    var grupo = document.getElementById(idGrupo);
    grupo.classList.add("formulario__grupo-incorrecto");
    var mensajeError = grupo.querySelector(".formulario__input-error");
    mensajeError.innerText = mensaje;
    mensajeError.style.display = "block";
}

function ocultarError(idGrupo) {
    var grupo = document.getElementById(idGrupo);
    grupo.classList.remove("formulario__grupo-incorrecto");
    var mensajeError = grupo.querySelector(".formulario__input-error");
    mensajeError.innerText = "";
    mensajeError.style.display = "none";
}
