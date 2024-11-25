function validarFormulario() {
    var nombreCategoria = document.getElementById("nombreCategoria").value.trim();

    if (nombreCategoria === "") {
        mostrarError("error-nombreCategoria", "El nombre de la categoría es requerido.");
        return false;
    } else {
        ocultarError("error-nombreCategoria");
        return true;
    }
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
