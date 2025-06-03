<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$usuariorec = isset($_GET['nombusurec']) ? $_GET['nombusurec'] : '';
$idusu = isset($_GET['idusuario']) ? $_GET['idusuario'] : '';

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$stmt4 = $miConexion->prepare($q);
$stmt4->execute();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Enviar Prod</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloPerf.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    

</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">
            <i class="fa-solid "></i>
            <h1>F-Store</h1>
        </a>


        <?php
            foreach($stmt4 as $row)
            {
                $priv = $row['Privacidad'];

                if($priv === 0)
                {
        ?>
                    <!-- <nav class="Opciones">
                        <a href="../HTML/PubProd.php" class="Opc_1">Publicar producto</a>
                        <a href="../HTML/Categorias.php" class="Opc_2">Categorias</a>
                        <a href="../HTML/Listas.php" class="Opc_3">Crear Lista</a>
                        <a href="../HTML/Contactos.php" class="Opc_4">Contactos</a>
                    </nav> -->
        <?php
                }

                if($priv === 1)
                {
        ?>
                    <!-- <a href="../HTML/Contactos.php" class="Opc_1">Contactos</a> -->
        <?php
                }
            }
        ?>


       
                    <hr>
                    <a href="../HTML/Perfil.php" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Ver perfil</p>
                        <span></span>
                    </a>
                    <a href="" class="sub-menu-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Carrito</p>
                        <span></span>
                    </a>
                    <a href="../HTML/InicioSesion.php" class="sub-menu-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Cerrar Sesion</p>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>

        <script>
            let SubMenu = document.getElementById("SubMenu");

            function mostrar() {
                SubMenu.classList.toggle("open-menu")
            }
        </script>
    </header>

    <div class="contenedor">
        <div class="area1">
            <div class="c">
                <div class="c1">
                    <h1 class="Titulo">Propuestas Recibidas</h1>
                    <?php
                        // Obtener productos cotizables del cliente actual
                        $sqlProd = "SELECT * FROM Producto_cotizable WHERE ID_usuariorecibidor = :idusu AND Eliminado = 0";
                        $stmtProd = $miConexion->prepare($sqlProd);
                        $stmtProd->bindParam(':idusu', $idusu);
                        $stmtProd->execute();
                        $productos = $stmtProd->fetchAll();

                        if ($productos) {
                            echo "<table border='1'>";
                            echo "<tr><th>Código</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Cantidad</th><th>Especificaciones</th><th>Aceptar</th></tr>";

                            foreach ($productos as $row4) {
                                echo "<tr>";
                                echo "<td>{$row4['Producto_ID2']}</td>";
                                echo "<td>{$row4['Descripcion']}</td>";
                                echo "<td>{$row4['Nombre']}</td>";
                                echo "<td>{$row4['Precio']}</td>";
                                echo "<td>{$row4['Cantidad']}</td>";
                                echo "<td>{$row4['Especificaciones']}</td>";
                                echo "<td><a href='../PHP/acepcot.php?idprod={$row4['Producto_ID2']}&idusu={$usuario}'>Aceptar</a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p>No tienes propuestas nuevas.</p>";
                        }
                    ?>

                    <h2>Propuestas Aceptadas</h2>
                    <?php
                        $row = $stmt->fetch(); // resultado de Usuario
                        $id_usuario = $row['Usuario_ID'];

                        $sql = "SELECT * FROM Producto_cotizable WHERE ID_usuario = :id_usuario AND Eliminado = 1";
                        $stmt = $miConexion->prepare($sql);
                        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                        $stmt->execute();
                        $resultados = $stmt->fetchAll();

                        if ($resultados) {
                            echo "<table border='1'>";
                            echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Especificaciones</th><th>Agregar al carrito</th></tr>";

                            foreach ($resultados as $row) {
                                echo "<tr>";
                                echo "<td>{$row['Nombre']}</td>"; // nombre del producto
                                echo "<td>{$row['Precio']}</td>";
                                echo "<td>{$row['Cantidad']}</td>";
                                echo "<td>{$row['Especificaciones']}</td>";
                                echo "<td>
                                    <form action='../PHP/agcarusv.php' method='post'>
                                        <input type='hidden' name='producto' value='{$row['Nombre']}'>      
                                        <input type='hidden' name='idprod' value='{$row['Producto_ID2']}'>                                      
                                        <input type='hidden' name='Precio' value='{$row['Precio']}'>
                                        <input type='hidden' name='cant' value='{$row['Cantidad']}'>
                                        <input type='hidden' name='usuc' value='{$row['ID_usuario']}'>
                                        <button type='submit'>Agregar al carrito</button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                        } else {
                            echo "<p>No tienes propuestas aceptadas aún.</p>";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
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
</body>

</html>