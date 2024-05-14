<?php
require_once '../config/database.php';
require_once '../config/config.php';

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin')) {
    header("Location: ../index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

//Listar las ventas que ya hayan sido enviadas a su destino

$sql = "SELECT compra.id_transaccion, compra.fecha, compra.status, compra.medio_pago, compra.fecha_envio,
        CONCAT(clientes.nombres, ' ', clientes.apellidos) AS cliente, compra.totalBOB, 
        compra.estado_envio, compra.ciudad_envio, couriers.nombre AS courier_nombre
        FROM compra 
        INNER JOIN clientes ON compra.id_cliente = clientes.id 
        LEFT JOIN couriers ON compra.id_courier = couriers.id
        WHERE compra.id_courier IS NOT NULL
        ORDER BY DATE(compra.fecha) DESC";
$resultado = $con->query($sql);



//Listar las ventas que todavia no han sido enviadas
$sqlPendientes = "SELECT id_transaccion, fecha, status, medio_pago, CONCAT(nombres, ' ', apellidos) AS cliente, totalBOB, 
estado_envio, ciudad_envio, id_courier
FROM compra INNER JOIN clientes ON compra.id_cliente = clientes.id 
WHERE id_courier IS NULL
ORDER BY DATE(fecha) DESC";
$resultadoPendientes = $con->query($sqlPendientes);

//Listar couriers

$sqlCouriers = "SELECT id, nombre FROM couriers WHERE activo = 1";
$resultadoCouriers = $con->query($sqlCouriers);

require_once '../header.php';
?>

<main class="flex-shrink-0">
    <div class="container mt-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras" type="button" role="tab" aria-controls="compras" aria-selected="true">Ventas Completadas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="envios-pendientes-tab" data-bs-toggle="tab" data-bs-target="#envios-pendientes" type="button" role="tab" aria-controls="envios-pendientes" aria-selected="false">Envíos Pendientes</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Compras Tab -->
            <div class="tab-pane fade show active" id="compras" role="tabpanel" aria-labelledby="compras-tab">
                <h4>Ventas Completadas</h4>
                <a href="genera_reporte_compras.php" class="btn btn-success btn-sm">Reporte de compras</a>
                <hr>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Compra</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Fecha Compra</th>
                            <th>Estado de envio</th>
                            <th>Ciudad de envio</th>
                            <th>Responsable de envio</th>
                            <th>Fecha de envio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['id_transaccion'] ?></td>
                                <td><?php echo $row['cliente'] ?></td>
                                <td><?php echo $row['totalBOB'] . ' ' . MONEDA ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><?php echo $row['estado_envio'] ?></td>
                                <td><?php echo $row['ciudad_envio'] ?></td>
                                <td><?php echo $row['courier_nombre'] ?></td>
                                <td><?php echo $row['fecha_envio']
                                    ?></td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detalleModal" data-bs-orden="<?= $row['id_transaccion']; ?>">Ver detalles</button>
                                    <button type="button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal" data-bs-target="#finalizarModal" data-bs-orden="<?= $row['id_transaccion']; ?>">Finalizar</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Envíos Pendientes Tab -->
            <div class="tab-pane fade" id="envios-pendientes" role="tabpanel" aria-labelledby="envios-pendientes-tab">
                <h4>Envíos Pendientes</h4>
                <hr>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Compra</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Fecha Compra</th>
                            <th>Estado de envio</th>
                            <th>Ciudad de envio</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultadoPendientes->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['id_transaccion'] ?></td>
                                <td><?php echo $row['cliente'] ?></td>
                                <td><?php echo $row['totalBOB'] . ' ' . MONEDA ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><?php echo $row['estado_envio'] ?></td>
                                <td><?php echo $row['ciudad_envio'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detalleModal" data-bs-orden="<?= $row['id_transaccion']; ?>">Ver detalles</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#enviosModal" data-bs-orden="<?= $row['id_transaccion']; ?>">Realizar envio</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal detalles -->
<div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleModal">Detalles de la compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Envios -->
<div class="modal fade" id="enviosModal" tabindex="-1" aria-labelledby="enviosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enviosModalLabel">Realizar Envío</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Input deshabilitado para mostrar el ID de la compra -->
                <div class="mb-3">
                    <label for="idCompra" class="form-label">ID de Compra:</label>
                    <input type="text" class="form-control" id="idCompra" disabled>
                </div>
                <div class="mb-3">
                    <label for="courierSelect" class="form-label">Seleccionar Courier:</label>
                    <select class="form-select" id="courierSelect">
                        <?php while ($row = $resultadoCouriers->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $row['id']; ?>"><?= $row['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" id="idCourier">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEnvio()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--Modal de finalizar-->

<div class="modal fade" id="finalizarModal" tabindex="-1" aria-labelledby="finalizarModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarModal">¿Desea marcar esta compra como entregada?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="idCompra" class="form-label">ID de Compra:</label>
                    <input type="text" class="form-control" id="idCompra1" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="finalizarEnvio()">Si, entregado</button>
            </div>
        </div>
    </div>
</div>





<script>
    const finalizarModal = document.getElementById('finalizarModal');
    finalizarModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const idCompra = button.getAttribute('data-bs-orden');
        const idCompraInput = document.getElementById('idCompra1');
        idCompraInput.value = idCompra;
    });

    const detalleModal = document.getElementById('detalleModal');
    detalleModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const orden = button.getAttribute('data-bs-orden');
        const modalBody = detalleModal.querySelector('.modal-body');

        const url = '<?php echo ADMIN_URL; ?>compras/getCompra.php';

        let formData = new FormData();
        formData.append('orden', orden);
        fetch(url, {
                method: 'post',
                body: formData
            })
            .then((resp) => resp.json())
            .then(function(data) {
                modalBody.innerHTML = data;
            });
    });

    const enviosModal = document.getElementById('enviosModal');
    enviosModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const idCompra = button.getAttribute('data-bs-orden');
        const idCompraInput = document.getElementById('idCompra');
        idCompraInput.value = idCompra;
    });

    function guardarEnvio() {
        const idCourier = document.getElementById('courierSelect').value;
        const idCompra = document.getElementById('idCompra').value;
        const url = '<?php echo ADMIN_URL; ?>compras/agregarCourier.php';

        let formData = new FormData();
        formData.append('idCompra', idCompra);
        formData.append('idCourier', idCourier);

        fetch(url, {
                method: 'post',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Error en la solicitud');
            })
            .then(data => {
                alert('Envío guardado correctamente');
                window.location.href = "<?php echo ADMIN_URL; ?>compras"
            })
            .catch(error => {
                alert('Error al guardar el envío: ' + error.message);
            });
    }

    function finalizarEnvio() {
        const idCompra = document.getElementById('idCompra1').value;
        const url = '<?php echo ADMIN_URL; ?>compras/finalizarCompra.php';
        let formData = new FormData();
        formData.append('idCompra', idCompra);

        fetch(url, {
                method: 'post',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Error en la solicitud de actualizacion');
            })
            .then(data => {
                alert('Actualizado correctamente');
                window.location.href = "<?php echo ADMIN_URL; ?>compras"
            })
            .catch(error => {
                alert('Error al guardar la actualizacion: ' + error.message);
            });
    }
</script>
<?php include '../footer.php'; ?>