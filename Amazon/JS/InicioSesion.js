function validarFormulario() {
    var usuario = document.getElementById("Usuario").value;
    var contra = document.getElementById("Contraseña").value;

    var errores = [];

    if (usuario === "") {
        errores.push("- Usuario");
    }

    if (contra === "") {
        errores.push("- Contraseña");
    }

    if (errores.length > 0) {
        alert("Falta la siguiente información:\n\n" + errores.join("\n"));

        return false;
    }
    else {
        console.log("La función validarFormulario se está ejecutando...");
        alert("¡Inicio de sesión exitoso!");
        location.href = '../HTML/PagIni.php';
        return false;

        /*let datos = new FormData();
        datos.append("Usuario", usuario.value);
        datos.append("Contraseña", contra.value);
        fetch('../PHP/loguear.php', {
            method: 'POST',
            body: datos
        }).then(Response => Response.json())
        .then(({ success }) => {
            if(success === 0) {
                alert("Usuario y/o Contraseña incorrectos o no esta registrado");
            }
            else{
                alert("Inicio de sesion exitoso!!!");
                location.href = '../HTML/PagIni.html';
            }
        });*/
    }
}