<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>F-Store | Busqueda</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/estiloBus.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">


</head>

<body>
    <header>

        <a href="../HTML/Perfil.php" class="logo">

            <h1>F-Store</h1>
        </a>

        <div>
       

         
            <a href="PagIni.php" class="sub-menu-link">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Regresar</p>
                <span></span>
            </a>
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
                    <b><label>Productos</label></b>
                    <form id="formBusqueda">
        <input type="text" id="keyword" name="keyword" placeholder="Escribe lo que deseas buscar">
        <button type="submit">Buscar</button>
    </form>
   
                    <br>
                    <br>

                </div>
                <div class="filtros" id="contenedorFiltros">
                    <!-- Aquí puedes agregar tus elementos de filtro, como un combobox -->
                    <label for="filtro1">Filtros:</label>
                        <select id="filtro1" name="filtro">
                            <option value="">-- Ordenar por --</option>
                            <option value="precio_asc">Menor a Mayor Precio</option>
                            <option value="precio_desc">Mayor a Menor Precio</option>
                            <option value="mejor_calificados">Mejor Calificados</option>
                            <option value="mas_vendidos">Más Vendidos</option>
                            <option value="menos_vendidos">Menos Vendidos</option>
                        </select>
                </div>
                <div class="c2">
                    <!-- Este div evita el error si JS aún lo usa -->
                    <div id="resultadoBusqueda" style="display: none;"></div>

                    <!-- Resultados divididos -->
                    <div id="resultadoProductos" class="contenedor-tarjetas"></div>
                    <hr style="margin: 40px 0;">
                    <div id="resultadoUsuarios" class="contenedor-tarjetas"></div>
                </div>
            </div>
        </div>
      </div>
      <br>
                            <br>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
    document.getElementById("formBusqueda").addEventListener("submit", async function(event) {
        event.preventDefault();

        const keyword = document.getElementById("keyword").value.trim();
        const filtro = document.getElementById("filtro1").value;
        const contenedorProd = document.getElementById("resultadoProductos");
        const contenedorUsu = document.getElementById("resultadoUsuarios");

        contenedorProd.innerHTML = "";
        contenedorUsu.innerHTML = "";

        if (!keyword) {
            contenedorProd.innerHTML = '<div class="no-results">Escribe un término para buscar.</div>';
            return;
        }

        try {
            const res = await fetch(`../PHP/APIBusquedaGeneral.php?keyword=${encodeURIComponent(keyword)}&filtro=${encodeURIComponent(filtro)}`);
            const data = await res.json();

            if (data.success) {
                mostrarResultados(data.resultados);
            } else {
                contenedorProd.innerHTML = '<div class="no-results">No se encontraron resultados.</div>';
            }
        } catch (error) {
            console.error("Error al buscar:", error);
            contenedorProd.innerHTML = '<div class="no-results">Error al realizar la búsqueda.</div>';
        }
    });

    document.getElementById("filtro1").addEventListener("change", function () {
        // Simula un submit del formulario
        document.getElementById("formBusqueda").dispatchEvent(new Event("submit"));
    });

    function mostrarResultados(data) {
        const contenedorProd = document.getElementById("resultadoProductos");
        const contenedorUsu = document.getElementById("resultadoUsuarios");

        contenedorProd.innerHTML = "";
        contenedorUsu.innerHTML = "";

        const productos = data.filter(item => item.tipo === "producto");
        const usuarios = data.filter(item => item.tipo === "usuario");

        // Mostrar productos
        if (productos.length === 0) {
            contenedorProd.innerHTML = '<div class="no-results">No se encontraron productos.</div>';
        } else {
            productos.forEach(item => {
                const card = document.createElement("div");
                card.classList.add("producto-card");

                const img = document.createElement("img");
                img.src = `data:image/jpeg;base64,${item.imagen}`;
                img.alt = item.nombre;
                card.appendChild(img);

                const titulo = document.createElement("h3");
                titulo.textContent = item.nombre;
                card.appendChild(titulo);

                const precio = document.createElement("span");
                precio.className = "precio";
                precio.textContent = `${item.precio}`;
                card.appendChild(precio);

                const boton = document.createElement("button");
                boton.innerHTML = `<a href="Producto.php?idprod=${item.id}">Ver producto</a>`;
                card.appendChild(boton);

                contenedorProd.appendChild(card);
            });
        }

        // Mostrar usuarios
        if (usuarios.length === 0) {
            contenedorUsu.innerHTML = '<div class="no-results">No se encontraron perfiles.</div>';
        } else {
            usuarios.forEach(item => {
                const card = document.createElement("div");
                card.classList.add("producto-card");

                const img = document.createElement("img");
                img.src = `data:image/jpeg;base64,${item.imagen}`;
                img.alt = item.nombre;
                card.appendChild(img);

                const titulo = document.createElement("h3");
                titulo.textContent = item.nombre;
                card.appendChild(titulo);

                const boton = document.createElement("button");
                boton.innerHTML = `<a href="../HTML/Perfil.php?id=${item.id}">Ver perfil</a>`;
                card.appendChild(boton);

                contenedorUsu.appendChild(card);
            });
        }
    }



    /*
        document.getElementById('formBusqueda').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario
    var keyword = $('#keyword').val();

    $.ajax({
        url: '../PHP/APIproducto.php',
        type: 'GET',
        data: { keyword: keyword },
        dataType: 'json',
        success: function(response) {
            if (response.items) {
                mostrarResultados(response);
            } else {
                $('#resultadoBusqueda').html('<p>No se encontraron productos.</p>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', xhr.responseText);
            $('#resultadoBusqueda').html('<p>Error al realizar la búsqueda.</p>');
        }
    });
});

function mostrarResultados(data) {
    const contenedor = document.getElementById('resultadoBusqueda');
    contenedor.innerHTML = '';

    if (data.items && data.items.length > 0) {
        data.items.forEach(producto => {
            const card = document.createElement('div');
            card.className = 'producto-card';
            card.innerHTML = `
                ${producto.Imagen ? 
                    `<img src="${producto.Imagen}" alt="${producto.Nombre}">` : 
                    '<div class="img-placeholder">Sin imagen</div>'}
                <h3>${producto.Nombre || 'Producto'}</h3>
                <p class="precio">${producto.Precio == 0 ? 'Cotizar' : '$'+producto.Precio}</p>
                <button>
                    <a href="Producto.php?idprod=${producto.Producto_ID}">Ver producto</a>
                </button>
            `;
            contenedor.appendChild(card);
        });
    } else {
        contenedor.innerHTML = '<p class="no-results">No se encontraron productos</p>';
    }
}
    */
    </script>