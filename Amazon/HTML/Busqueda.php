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
                    <select id="filtro1" name="filtro1">
                        <option value="opcion1">Mayor a Menor Presio</option>
                        <option value="opcion2">Mejor calificado</option>
                        <option value="opcion2">Mas vendidos</option>
                    </select>
                </div>
                <div class="c2">
               <div id="resultadoBusqueda" class="contenedor-tarjetas"></div>
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
    </script>