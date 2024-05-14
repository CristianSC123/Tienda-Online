<?php
require_once 'config/config.php';
require_once 'config/database.php';


if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin')) {
    header("Location: ../index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

$hoy = date('Y-m-d');
$lunes = date('Y-m-d', strtotime('monday this week', strtotime($hoy)));
$domingo = date(('Y-m-d'), strtotime('sunday this week', strtotime($hoy)));

$fechaInicial = new DateTime($lunes);
$fechaFinal = new DateTime($domingo);

$diasVentas = [];

for ($i = $fechaInicial; $i <= $fechaFinal; $i->modify('+1 day')) {
    $diasVentas[] = totalDia($con, $i->format('Y-m-d'));
}

$diasVentas = implode(',', $diasVentas);

/// -----------------------------------

$listaProductos = productosMasVendidos($con, $lunes, $domingo);
$nombreProductos = [];
$cantidadProductos = [];

foreach ($listaProductos  as $producto) {
    $nombreProductos[] = $producto['nombre'];
    $cantidadProductos[] = $producto['cantidad'];
}

$nombreProductos = implode("','", $nombreProductos);
$cantidadProductos = implode(',', $cantidadProductos);


function totalDia($con, $fecha)
{
    $sql = "SELECT IFNULL(SUM(totalBOB), 0) AS total FROM compra 
    WHERE DATE (fecha) = '$fecha' AND status LIKE 'COMPLETED'";
    $resultado = $con->query($sql);
    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function productosMasVendidos($con, $fechaInicial, $fechaFinal)
{
    $sql = "SELECT SUM(dc.cantidad) AS cantidad, dc.nombre FROM detalle_compra AS dc 
    INNER JOIN compra AS c ON dc.id_compra = c.id
    WHERE DATE(c.fecha) BETWEEN '$fechaInicial' AND '$fechaFinal'
    GROUP BY dc.id_producto, dc.nombre
    ORDER BY SUM(dc.cantidad) DESC
    LIMIT 5";
    $resultado = $con->query($sql);
    return $resultado->fetchAll(PDO::FETCH_ASSOC);
}

include 'header.php';
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>


        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div card-header>
                        Ventas de la semana
                    </div>

                    <div class="card-body">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-4">
                    <div card-header>
                        Productos más vendidos en la semana
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="chart-productos"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
            datasets: [{
                data: [<?php echo $diasVentas; ?>],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const ctxProductos = document.getElementById('chart-productos');

    new Chart(ctxProductos, { // Utiliza ctxProductos en lugar de ctx
        type: 'pie',
        data: {
            labels: ['<?php echo $nombreProductos;?>'],
            datasets: [{
                data: [<?php echo $cantidadProductos;?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include 'footer.php' ?>