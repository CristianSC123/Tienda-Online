<?php

require_once 'config/config.php';
$db = new Database();
$con = $db->conectar();


$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE  id=? AND activo =1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location : index.php");
    exit;
}

//Recuperar el id del departamento de envio
$id_departamento = $_GET['id_departamento'];
$calle_avenida = isset($_GET['calle_avenida']) ? $_GET['calle_avenida'] : null;
$numero_puerta = isset($_GET['numero_puerta']) ? $_GET['numero_puerta'] : null;


// Consulta SQL para obtener el costo de envío
$sql_costo_envio = $con->prepare("SELECT nombre_departamento, costo FROM destinos WHERE id = ?");
$sql_costo_envio->execute([$id_departamento]);
$datos_costo_envio = $sql_costo_envio->fetch(PDO::FETCH_ASSOC);

$departamento = $datos_costo_envio['nombre_departamento'];



// Verificar si se encontraron datos del departamento para calcular el costo de envío
if ($datos_costo_envio) {
    $nombre_departamento = $datos_costo_envio['nombre_departamento'];
    $costo_envio = $datos_costo_envio['costo'];
} else {
    // En caso de no encontrar el departamento, establecer un valor predeterminado para el costo de envío
    $nombre_departamento = "Departamento no especificado";
    $costo_envio = 0;
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/allmin.css">
</head>

<body>
    <?php include 'menu.php' ?>
    <!-- Agrega la imagen de carga -->
    <img id="loader" src="images/cargando.gif" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none; z-index: 9999;">

    <!-- Resto de tu código HTML -->

    <main>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $descuento = $producto['descuento'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal;

                                ?>
                                        <tr>
                                            <td><?php echo $nombre ?></td>
                                            <td>
                                                <div id="subtotal_<?php echo $_id ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ''); ?></div>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                                <tr>
                                    <td><?php echo "Envio a " . $nombre_departamento ?></td>
                                    <td>
                                        <?php echo MONEDA .  $costo_envio ?>
                                    </td>
                                    <?php $total = $total + $costo_envio;
                                    $precio_usd = $total * $cambio_actual;
                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, '.', ''); ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AY5YL-hCri9BFPQrnDBmqah6dxYmxYBNEA4g32UAKwFdej4c4-kGvF8zkZ5_2MS9OH98H6z4ekAsZr5b&currency=USD"></script>
    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo number_format($precio_usd, 2, '.', ''); ?>
                        },
                        description: 'Compra TIENDA ONLINE'
                    }],
                    application_context: {
                        shipping_preference: "NO_SHIPPING"
                    }
                });
            },
            onApprove: function(data, actions) {
                let url = 'clases/captura.php';
                actions.order.capture().then(function(details) {
                    console.log(details);
                    let trans = details.purchase_units[0].payments.captures[0].id;

                    // Datos adicionales que deseas enviar
                    let departamento = '<?php echo $departamento; ?>';
                    let calle_avenida = '<?php echo $calle_avenida; ?>';
                    let numero_puerta = '<?php echo $numero_puerta; ?>';

                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            details: details,
                            departamento: departamento,
                            calle_avenida: calle_avenida,
                            numero_puerta: numero_puerta
                        })
                    }).then(function(response) {
                        var nuevaVentana = window.open("completado.php?key=" + details['id'], "_blank");
                        window.location.href = "index.php";
                    });
                });
            },

            onCancel: function(data) {
                alert("El pago se canceló. Puede intentarlo nuevamente más tarde.");
                console.log(data);
            }
        }).render('#paypal-button-container');

    </script>

</body>

</html>