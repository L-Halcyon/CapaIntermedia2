<?php
require_once "../Middleware/middleware.php";
redirectIfNotLoggedIn();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
//session_start();
require_once "../PHP/conexion.php";

$conexion = new Conexion();
$db = $conexion->obtenerConexion();

// Obtener categorías activas (no eliminadas)
$stmt = $db->prepare("SELECT Categoria_ID, Nombre FROM categoria WHERE Eliminado = 0");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>F-Store | Ventas Realizadas</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" href="../CSS/VentasRealizadas.css">
</head>
<body>
    <header>
        <a href="PagIni.php" class="logo">
          
            <h1>F-Store</h1>
        </a>

     
                    <hr>
                    <a href="../HTML/Perfil.php" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Ver perfil</p>
                        <span></span>
                    </a>
                    <a href="../HTML/Carrito.php" class="sub-menu-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Carrito</p>
                        <span></span>
                    </a>
                    <a href="../HTML/salir.php" class="sub-menu-link">
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

    <div class="contenedor area1">
        <h2 class="Titulo">Ventas Realizadas</h2>

        <form id="formFiltros" class="Fitros_Cuerpo row justify-content-center">
            <div class="col-md-3">
                <label>Desde:</label>
                <input type="date" name="fechaInicio" class="form-control" >
            </div>
            <div class="col-md-3">
                <label>Hasta:</label>
                <input type="date" name="fechaFin" class="form-control" >
            </div>
            <div class="col-md-3">
                <label>Categoría:</label>
                <select name="categoriaID" class="form-select">
                    <option value="todas">Todas</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['Categoria_ID'] ?>"><?= $cat['Nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-light boton w-100">Consultar</button>
            </div>
        </form>

        <div class="row justify-content-center mt-3">
            <div class="col-md-4">
                <button onclick="verVista('detallada')" class="btn btn-dark w-100">Vista Detallada</button>
            </div>
            <div class="col-md-4">
                <button onclick="verVista('agrupada')" class="btn btn-dark w-100">Vista Agrupada</button>
            </div>
        </div>

        <div id="resultadosDetallados" class="mt-4"></div>
        <div id="resultadosAgrupados" class="mt-4" style="display:none;"></div>
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

    <script src="../Librerias/bootstrap-5.3.1-dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("formFiltros").addEventListener("submit", async function (e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const filtros = {
                fechaInicio: formData.get("fechaInicio"),
                fechaFin: formData.get("fechaFin"),
                categoriaID: formData.get("categoriaID")
            };

            cargarDatos(filtros, "detallada");
            cargarDatos(filtros, "agrupada");
        });

        function verVista(vista) {
            document.getElementById("resultadosDetallados").style.display = vista === "detallada" ? "block" : "none";
            document.getElementById("resultadosAgrupados").style.display = vista === "agrupada" ? "block" : "none";
        }

        async function cargarDatos(filtros, tipo) {
            try {
                const response = await fetch(`../PHP/getVentasVendedor.php?tipo=${tipo}&fechaInicio=${filtros.fechaInicio}&fechaFin=${filtros.fechaFin}&categoriaID=${filtros.categoriaID}`);
                const data = await response.json();

                if (tipo === "detallada") {
                    mostrarDetallado(data);
                } else {
                    mostrarAgrupado(data);
                }
            } catch (error) {
                console.error("Error al cargar los datos:", error);
            }
        }

        function mostrarDetallado(data) {
            const contenedor = document.getElementById("resultadosDetallados");
            contenedor.innerHTML = "";

            if (data.length === 0) {
                contenedor.innerHTML = "<p>No se encontraron ventas.</p>";
                return;
            }

            const tabla = document.createElement("table");
            tabla.className = "table table-bordered";

            tabla.innerHTML = `
                <thead class="Encabezado_Tabla">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Categoría</th>
                        <th>Producto</th>
                        <th>Calificación</th>
                        <th>Precio</th>
                        <th>Existencia</th>
                    </tr>
                </thead>
                <tbody class="Registro_Tabla">
                    ${data.map(v => `
                        <tr>
                            <td>${v.FechaHora}</td>
                            <td>${v.Categoria}</td>
                            <td>${v.Producto}</td>
                            <td>${v.Calificacion ?? 'N/A'}</td>
                            <td>$${v.Precio.toFixed(2)}</td>
                            <td>${v.Existencia}</td>
                        </tr>
                    `).join('')}
                </tbody>
            `;

            contenedor.appendChild(tabla);
        }

        function mostrarAgrupado(data) {
            const contenedor = document.getElementById("resultadosAgrupados");
            contenedor.innerHTML = "";

            if (data.length === 0) {
                contenedor.innerHTML = "<p>No se encontraron ventas agrupadas.</p>";
                return;
            }

            const tabla = document.createElement("table");
            tabla.className = "table table-bordered";

            tabla.innerHTML = `
                <thead class="Encabezado_Tabla">
                    <tr>
                        <th>Año-Mes</th>
                        <th>Categoría</th>
                        <th>Total Ventas</th>
                    </tr>
                </thead>
                <tbody class="Registro_Tabla">
                    ${data.map(v => `
                        <tr>
                            <td>${v.Mes}</td>
                            <td>${v.Categoria}</td>
                            <td>${v.TotalVentas}</td>
                        </tr>
                    `).join('')}
                </tbody>
            `;

            contenedor.appendChild(tabla);
        }
    </script>
</body>
</html>
