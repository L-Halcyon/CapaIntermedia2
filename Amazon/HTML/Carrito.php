<?php
require_once "../PHP/conexion.php";
$conexion = new Conexion();
$miConexion = $conexion->obtenerConexion();

session_start();

$usuario = $_SESSION['username'];

$q = "SELECT * FROM Usuario WHERE NomUsu = '$usuario'";
$stmt = $miConexion->prepare($q);
$stmt->execute();

$stmt2 = $miConexion->prepare($q);
$stmt2->execute();

$stmt3 = $miConexion->prepare($q);
$stmt3->execute();

$stmt6 = $miConexion->prepare($q);
$stmt6->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>F-Store | Carrito</title>
    <script src="https://kit.fontawesome.com/a23bf762ef.js" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AWLfE_SHdzUU20GGjOJjN8-WW9I0XKqhX5N0VqrueDaZU5TNFWqBg7zKALOb6kL-9A4QpqdB1XFw-tC1&currency=MXN&locale=es_MX" onload="paypalLoaded()"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../Librerias/bootstrap-5.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ElementosGenerales.css">
    <link rel="stylesheet" href="../CSS/Carrito.css">
</head>

<body>
    <header>

        <a href="PagIni.php" class="logo">

            <h1 style="color: #339EFF;">F-Store</h1>
        </a>


        <hr>

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

        <script>
            let SubMenu = document.getElementById("SubMenu");

            function mostrar() {
                SubMenu.classList.toggle("open-menu")
            }
        </script>
    </header>
    <div class="contenedor">
        <div class="row m-12 area1">
            <h1 class="Titulo">Carrito de compras</h1>
            <div class="separador"><hr></div>
            <table>
                <tr>
                    <td>ARTICULOS</td>
                    <td>CANTIDAD</td>
                    <td>PRECIO</td>
                    <td>Eliminar</td>
                </tr>
                <?php
                    foreach($stmt3 as $row3)
                    {
                        $idusuario = $row3['Usuario_ID'];

                        $sql4 = "SELECT * FROM Carrito WHERE Usu_ID = '$idusuario' AND Estado = 1";
                        $stmt4 = $miConexion->prepare($sql4);
                        $stmt4->execute();

                        foreach($stmt4 as $row4)
                        {
                            $idcarrito = $row4['Carrito_ID'];
                            $idproductocarrito = $row4['Prod_ID'];
                            $cantidad = $row4['Cantidad'];
                            $precioPC4 = $row4['Precio_Unitario'];

                            $sql5 = "SELECT * FROM Producto WHERE Producto_ID = '$idproductocarrito'";
                            $stmt5 = $miConexion->prepare($sql5);
                            $stmt5->execute();
                ?>
                            <tr>
                <?php
                                foreach($stmt5 as $row5)
                                {
                                    $nombreproducto = $row5['Nombre'];
                ?>
                                    <td><?php echo $nombreproducto; ?></td>
                <?php
                                }
                ?>
                                <td><?php echo $cantidad; ?></td>
                                <td>
                                    <?php
                                        $stmt10 = $miConexion->prepare($sql5);
                                        $stmt10->execute();

                                        foreach($stmt10 as $row10)
                                        {
                                            $tipooferta10 = $row10['Tipo_Oferta'];

                                            if($tipooferta10 == 1)
                                            {
                                                $preciotu = $precioPC4 * $cantidad;
                                                echo "$".$preciotu;
                                            }
                                            else
                                            {
                                                $sql8 = "SELECT F1('$idproductocarrito', '$cantidad') as Prec;";
                                                $stmt8 = $miConexion->prepare($sql8);
                                                $stmt8->execute();

                                                foreach($stmt8 as $row8)
                                                {
                                                    $preciotu = $row8['Prec'];
                                                    echo "$".$preciotu;
                                                }
                                            }
                                        }
                                    ?>
                                </td>
                                <td><?php echo "<a href='../PHP/elimprodcar.php?idprod=".$idproductocarrito."&idcar=".$idcarrito."'>ELIMINAR</a>" ?></td>
                            </tr>
                <?php
                        }
                    }
                ?>
            </table>
            <div class="separador"><hr></div>
            <div class="row m-12 area1_3">
                <div class="col-md-6">
                    <h3>Total estimado:</h3>
                </div>
                <div class="col-md-3">
                    <?php
                        $totalapagar = 0;

                        foreach($stmt6 as $row6)
                        {
                            $idusuariototal = $row6['Usuario_ID'];

                            $sql7 = "SELECT * FROM Carrito WHERE Usu_ID = '$idusuariototal' AND Estado = 1";
                            $stmt7 = $miConexion->prepare($sql7);
                            $stmt7->execute();

                            foreach($stmt7 as $row7)
                            {
                                $idproductocarritoV = $row7['Prod_ID'];
                                $precio7 = $row7['Precio_Unitario'];
                                $cantidadtotal = $row7['Cantidad'];

                                $sql11 = "SELECT * FROM Producto WHERE Producto_ID = '$idproductocarritoV'";
                                $stmt11 = $miConexion->prepare($sql11);
                                $stmt11->execute();

                                foreach($stmt11 as $row11)
                                {
                                    $tipooferta11 = $row11['Tipo_Oferta'];

                                    if($tipooferta11 == 1)
                                    {
                                        $preciototal = $precio7 * $cantidadtotal;
                                        $totalapagar = $totalapagar + $preciototal;
                                    }
                                    else
                                    {
                                        $sql9 = "SELECT F2('$idproductocarritoV', '$totalapagar', '$cantidadtotal') as TOTAL;";
                                        $stmt9 = $miConexion->prepare($sql9);
                                        $stmt9->execute();

                                        foreach($stmt9 as $row9)
                                        {
                                            $totalapagar = $row9['TOTAL'];
                                        }
                                    }
                                }
                            }
                    ?>
                                <script>
                                    var totalAPagar = <?php echo json_encode($totalapagar); ?>;
                                </script>
                                <h2 id="TotalPagar"><?php echo "$".$totalapagar; ?></h2>
                    <?php
                        }
                    ?>
                </div>
                <div class="col-md-3">
                    <!-- <button><a href="../PHP/Venta.php">Comprar</a></button> -->
                    <!-- <div id="paypal-button-container"></div>
                    <script>
                        paypal.Buttons({
                            style:{
                            color: 'blue',
                            shape: 'pill',
                            label: 'pay'
                        },
                        CreatOrder: function(data,actions){
                            return actions.order.create({
                                purchase_units:[{
                                    amount: {
                                        value: 100
                                    }
                                }]
                            });
                        }

                    }).render('#paypal-button-container');
                    </script> -->
                </div>
            </div>
        </div>
        <div class="row m-12 area2">
            <div class="col-md-3"></div>
            <div class="col-md-8" id="paypal-button-container"></div>
            <div class="col-md-1"></div>
        <script>
            paypal.Buttons({
                style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data,actions){
                return actions.order.create({
                    purchase_units:[{
                        amount: {
                            value: totalAPagar
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
            // Captura la información de la transacción
            return actions.order.capture().then(function (details) {
                // Llamada AJAX a Venta.php con información de la transacción
                    $.ajax({
                        url: '../PHP/Venta.php',
                        type: 'post',
                        data: {
                            transactionID: details.id,
                            payerID: details.payer.payer_id,
                            amount: details.purchase_units[0].amount.value
                            // Agrega más datos según sea necesario
                        },
                        success: function (response) {
                            // Manejar la respuesta, si es necesario
                            console.log(response);
                            // Redirige a Comentarios.php después de que la transacción se haya completado
                            window.location.href = '../HTML/Comentarios.php';  // Redirección aquí
                        }
                    });
                });
            },
            onCancel: function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
        </script> 
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>