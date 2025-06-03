<?php
require_once "../Middleware/middleware.php";
redirectIfNotLoggedIn();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

//session_start();

if (!isset($_SESSION['username']) || !isset($_GET['nombusu'])) {
    header("Location: PagIni.php");
    exit();
}

$usuario = $_SESSION['username'];
$usuarioconta = $_GET['nombusu'];

// Obtener datos del usuario actual
$stmtUsuario = $miConexion->prepare("SELECT * FROM Usuario WHERE NomUsu = :usuario");
$stmtUsuario->bindParam(':usuario', $usuario);
$stmtUsuario->execute();
$datosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

// Obtener datos del usuario contacto
$stmtContacto = $miConexion->prepare("SELECT * FROM Usuario WHERE NomUsu = :contacto");
$stmtContacto->bindParam(':contacto', $usuarioconta);
$stmtContacto->execute();
$datosContacto = $stmtContacto->fetch(PDO::FETCH_ASSOC);

// Si alguno de los usuarios no existe
if (!$datosUsuario || !$datosContacto) {
    echo "Usuario no encontrado.";
    exit();
}

// Obtener mensajes entre ambos usuarios
$stmtMensajes = $miConexion->prepare("SELECT * FROM V5 WHERE 
    (ID_usuario = :id1 AND ID_usuariorecibidor = :id2) OR 
    (ID_usuario = :id2 AND ID_usuariorecibidor = :id1)
    ORDER BY FechaHora ASC");
$stmtMensajes->bindParam(':id1', $datosUsuario['Usuario_ID']);
$stmtMensajes->bindParam(':id2', $datosContacto['Usuario_ID']);
$stmtMensajes->execute();
$mensajes = $stmtMensajes->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>F-Store | Cotización</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" href="../CSS/Mensajes.css">
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <style>
        #contenedorMensajes {
            max-height: 400px;
            overflow-y: auto;
            padding: 15px;
            background-color: #e5ddd5;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-family: Arial, sans-serif;
        }

        .mensaje {
            max-width: 75%;
            min-width: 120px;       
            padding: 14px 20px;           
            border-radius: 15px;
            font-size: 15px;
            line-height: 1.6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 400;
            color: #202020;
            position: relative;
            display: inline-block;
            clear: both;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            word-break: break-word;
            background-clip: padding-box;
        }

        .enviado {
            background-color: #dcf8c6;
            align-self: flex-end;
            border-bottom-right-radius: 0;
            text-align: left;
        }

        .recibido {
            background-color: #fff;
            align-self: flex-start;
            border-bottom-left-radius: 0;
            text-align: left;
        }

        .hora {
            display: block;
            font-size: 11px;
            color: #666;
            text-align: right;
            margin-top: 5px;
        }

        .mensaje strong {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 5px;
        }
    </style>

</head>
<body>
<header>
    <a href="PagIni.php" class="logo"><h1 style="color:  #339EFF;">F-Store</h1></a>
    <hr>
    <a href="#" class="sub-menu-link"><i class="fa-solid fa-cart-shopping"></i><p>Carrito</p></a>
    <a href="../HTML/Perfil.php" class="sub-menu-link"><i class="fa-solid fa-right-from-bracket"></i><p>Regresar</p></a>
</header>

<div class="contenedor">
    <div class="area1">
        <h1 class="Titulo"><?php echo htmlspecialchars($usuarioconta); ?></h1>
        <div class="card">
            <div class="card-body" id="contenedorMensajes">
                Cargando mensajes...
            </div>
            <div class="card-footer">
                <form id="formMensaje" action="../PHP/envmensaje.php" method="post" class="input-group">
                    <input type="hidden" name="idUsu" value="<?php echo $datosUsuario['Usuario_ID']; ?>">
                    <input type="hidden" name="idUsucon" value="<?php echo $datosContacto['Usuario_ID']; ?>">
                    <input class="Input_mensaje form-control" type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>
                    <button class="btn" type="submit">Enviar</button>
                </form>

                <?php
                // Verificar si hay productos en oferta
                $stmtProductos = $miConexion->prepare("SELECT * FROM Producto WHERE Usu_ID = :idusu AND Tipo_Oferta = 1 AND Eliminado = 0");
                $stmtProductos->bindParam(':idusu', $datosUsuario['Usuario_ID']);
                $stmtProductos->execute();

                $hayPropuesta = $stmtProductos->rowCount() > 0;
                ?>
                <div class="boton-derecha">
                    <form action="<?php echo !$hayPropuesta ? '../HTML/Recibircot.php' : '../HTML/envpcU.php'; ?>" method="get">
                            <input type="hidden" name="nombusurec" value="<?php echo htmlspecialchars($usuarioconta); ?>"> <!-- nombre del contacto -->
                            <input type="hidden" name="idusuario" value="<?php echo htmlspecialchars($datosContacto['Usuario_ID']); ?>"> <!-- ID del comprador -->
                        <button type="submit" class="btn"><?php echo !$hayPropuesta ? 'Ver Propuesta' : 'Propuesta de Producto'; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer_container">
        <div class="footer_box">
            <div class="logo"><h1>F-Store</h1></div>
            <div class="terminos">
                <p>La Empresa En Sí Es Una Empresa Muy Exitosa...</p>
            </div>
        </div>
        <div class="footer_box">
            <h3>Creadores</h3>
            <br>
                <br>
                <p>Diego Sebastian Cortés Acosta.</p>
                <p>Alejandro Calderón Luna.</p>
        </div>
        <div class="box__copyright">
            <hr>
            <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let primeraCarga = true;
    const contenedorMensajes = document.getElementById("contenedorMensajes");
    const id1 = "<?php echo $datosUsuario['Usuario_ID']; ?>";
    const id2 = "<?php echo $datosContacto['Usuario_ID']; ?>";

    let scrollForzado = false; // 🟢 bandera para saber si acabas de enviar mensaje

    function cargarMensajes() {
        fetch(`../PHP/obtener_mensajes.php?id1=${id1}&id2=${id2}`)
            .then(response => response.text())
            .then(data => {
                contenedorMensajes.innerHTML = data;

                const estaCercaDelFinal = contenedorMensajes.scrollHeight - contenedorMensajes.scrollTop - contenedorMensajes.clientHeight < 50;

                if (estaCercaDelFinal || scrollForzado || primeraCarga) {
                    contenedorMensajes.scrollTop = contenedorMensajes.scrollHeight;
                    scrollForzado = false;
                    primeraCarga = false;
                }
            });
    }


    setInterval(cargarMensajes, 2000);
    cargarMensajes();

    const form = document.getElementById("formMensaje");
    form.addEventListener("submit", () => {
        scrollForzado = true; // ✅ marcar que se debe hacer scroll tras cargar
        // limpiar input también si deseas:
        setTimeout(() => {
            form.querySelector('input[name="mensaje"]').value = "";
        }, 100);
    });
</script>
</body>
</html>
