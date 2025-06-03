$("#formulario").on("submit", function (e) {
    e.preventDefault();

    if (!validarFormulario()) return;

    let formData = new FormData(this);
    
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    }

    $.ajax({
        type: "POST",
        url: "http://localhost/API/api.php?case=register",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            try {
                let data = typeof response === "string" ? JSON.parse(response) : response;

                if (data.success) {
                    alert("Registro exitoso: " + data.message);
                    window.location.href = "../HTML/InicioSesion.php";
                } else {
                    alert("Error: " + data.message);
                }
            } catch (err) {
                console.error("Error procesando respuesta:", err, response);
                alert("Respuesta inesperada del servidor.");
            }
        },
        error: function (xhr) {
            console.error("Error al registrar:", xhr);

            try {
                const data = JSON.parse(xhr.responseText);
                if (data && data.message) {
                    alert("Error: " + data.message);
                } else {
                    alert("Error inesperado (sin mensaje)");
                }
            } catch (e) {
                alert("Error inesperado (formato desconocido)");
            }
        }
    });
});

function validarFormulario() {
    const usuario = document.getElementById("NombredeUsuario").value.trim();
    const correo = document.getElementById("CorreoElectronico").value.trim();
    const contra = document.getElementById("Contraseña").value.trim();
    const confirmar = document.getElementById("ConfirmarContraseña").value.trim();

    if (!usuario || !correo || !contra || !confirmar) {
        alert("Por favor completa todos los campos obligatorios.");
        return false;
    }

    // Validar formato de correo
    const regexCorreo = /^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.com$/;
    if (!regexCorreo.test(correo)) {
        alert("El correo debe ser @gmail.com o @hotmail.com.");
        return false;
    }

    // Validar contraseña segura
    const regexContra = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\[\]{}\-_+=:;"'<>,.?\/]).{8,}$/;
    if (!regexContra.test(contra)) {
        alert("La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.");
        return false;
    }

    if (contra !== confirmar) {
        alert("Las contraseñas no coinciden.");
        return false;
    }

    return true;
}
