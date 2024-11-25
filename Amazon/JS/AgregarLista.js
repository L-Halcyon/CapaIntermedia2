function validarFormulario() {
    var nombreLista = document.getElementById("nombre").value.trim();
    var descripcionLista = document.getElementById("decrip").value.trim();
    var tipoListaPrivada = document.getElementById("tipo-privada").checked;
    var tipoListaPublica = document.getElementById("tipo-publica").checked;

    if (nombreLista === "") {
        mostrarError("error-nombre", "El nombre de la lista es obligatorio.");
        return false;
    } else {
        ocultarError("error-nombre");
    }

    if (descripcionLista === "") {
        mostrarError("error-descripcion", "La descripción de la lista es obligatoria.");
        return false;
    } else {
        ocultarError("error-descripcion");
    }

    if (!tipoListaPrivada && !tipoListaPublica) {
        mostrarError("error-tipo", "Debes seleccionar un tipo de lista.");
        return false;
    } else {
        ocultarError("error-tipo");
    }

    return true; // Si se pasan todas las validaciones, el formulario se puede enviar
}

function mostrarError(idError, mensaje) {
    var errorElement = document.getElementById(idError);
    errorElement.innerText = mensaje;
    errorElement.style.display = "block";
}

function ocultarError(idError) {
    var errorElement = document.getElementById(idError);
    errorElement.innerText = "";
    errorElement.style.display = "none";
}
