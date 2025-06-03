<?php
require_once "../Middleware/middleware.php";
redirectIfNotLoggedIn();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "../PHP/conexion.php";

if (!isset($_GET['id'])) {
    echo "ID de perfil no especificado.";
    exit;
}

$idPerfil = $_GET['id'];
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

$q = "SELECT * FROM Usuario WHERE Usuario_ID = ?";
$stmt = $miConexion->prepare($q);
$stmt->execute([$idPerfil]);
$datosPerfil = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$datosPerfil) {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Perfil Público</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
</head>

<body>
    <header>
        <a href="PagIni.php" class="logo">
            <h1>F-Store</h1>
        </a>
        <nav class="Opciones"></nav>
        <hr>
        <a href="Carrito.php" class="sub-menu-link">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Carrito</p>
        </a>
        <a href="../HTML/InicioSesion.php" class="sub-menu-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>Cerrar Sesión</p>
        </a>
        <script>
            let SubMenu = document.getElementById("SubMenu");
            function mostrar() {
                SubMenu.classList.toggle("open-menu")
            }
        </script>
    </header>

    <main>
        <div class="contenedor">
            <div class="area1">
                <?php
                $id = $datosPerfil['Usuario_ID'];
                $usu = $datosPerfil['NomUsu'];
                $priv = $datosPerfil['Privacidad'];

                echo "<p><b>$usu</b><br><br></p>";

                if ($datosPerfil['ImagenPerfil']) {
                    $imageData = base64_encode($datosPerfil['ImagenPerfil']);
                    echo '<img src="data:image/png;base64,' . $imageData . '" height="200" width="250"/>';
                } else {
                    echo "<p>No se encontró la imagen del usuario.</p>";
                }

                if ($priv == 3) {
                    echo "<script>alert('Este perfil es privado');</script>";
                } else {
                ?>
                    <br><br>
                    <h4>LISTAS</h4>
                    <br>
                    <h5>Públicas</h5>
                    <div class="listas-container">
                        <?php
                        $sql10 = "SELECT * FROM Lista WHERE Usu_ID = ? AND Tipo = 'publica' AND Eliminado = 0";
                        $stmt10 = $miConexion->prepare($sql10);
                        $stmt10->execute([$id]);

                        foreach ($stmt10 as $row10) {
                            $idlista = $row10['Lista_ID'];
                            $nombre = $row10['Nombre'];
                            $descripcion = $row10['Descripcion'];
                        ?>
                            <div class="card-lista">
                                <h3><?= $nombre ?></h3>
                                <p><?= $descripcion ?></p>
                                <div class="acciones">
                                    <a class="btn-ver" href="verprodlis2.php?idlist=<?= $idlista ?>">Ver Lista</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
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
                    <p>La Empresa En Sí Es Una Empresa Muy Exitosa...</p>
                </div>
            </div>
            <div class="footer_box">
                <h3>Creadores</h3><br><br>
                <p>Diego Sebastian Cortés Acosta.</p>
                <p>Alejandro Calderón Luna.</p>
            </div>
            <div class="box__copyright">
                <hr>
                <p>Todos los derechos reservados © 2024 <b>F-Store</b></p>
            </div>
        </div>
    </footer>
</body>

</html>
