function validarFormulario() {
    var nombre = document.getElementById("nombre").value.trim();
    var descripcion = document.getElementById("decrip").value.trim();
    var foto1 = document.getElementById("foto1").value;
    var foto2 = document.getElementById("foto2").value;
    var foto3 = document.getElementById("foto3").value;
    var video1 = document.getElementById("video1").value;
    var categoria = document.querySelector('input[name="categ"]:checked');
    var precio = document.getElementById("prec").value.trim();
    var cantidad = document.getElementById("cant").value.trim();

    var errores = false;

    if (nombre === "") {
        mostrarError("error-nombre", "El nombre del producto es requerido.");
        errores = true;
    } else {
        ocultarError("error-nombre");
    }

    if (descripcion === "") {
        mostrarError("error-descripcion", "La descripción del producto es requerida.");
        errores = true;
    } else {
        ocultarError("error-descripcion");
    }

    if (foto1 === "" || foto2 === "" || foto3 === "") {
        mostrarError("error-imagenes", "Debe seleccionar tres imágenes para el producto.");
        errores = true;
    } else {
        ocultarError("error-imagenes");
    }

    if (video1 === "") {
        mostrarError("error-video", "Debe seleccionar un video para el producto.");
        errores = true;
    } else {
        ocultarError("error-video");
    }

    if (!categoria) {
        mostrarError("error-categoria", "Debe seleccionar una categoría para el producto.");
        errores = true;
    } else {
        ocultarError("error-categoria");
    }

    if (precio === "") {
        ocultarError("error-precio");
    } else if (!/^\d*\.?\d+$/.test(precio) || parseFloat(precio) <= 0) { // Verifica que el precio sea un número válido
        mostrarError("error-precio", "El precio debe ser un número válido y mayor que 0.");
        errores = true;
    } else {
        ocultarError("error-precio");
    }

    if (cantidad === "") {
        mostrarError("error-cantidad", "La cantidad del producto es requerida.");
        errores = true;
    } else {
        ocultarError("error-cantidad");
    }

    if (errores) {
        alert("Llenar todos los campos");
        return false;
    } else {
        alert("Producto se agregó correctamente");
        window.location.href = "../HTML/Producto.php";
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
