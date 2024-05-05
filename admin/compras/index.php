<?php
require_once '../config/database.php';
require_once '../config/config.php';


if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin')) {
    header("Location: ../index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();


$sql = "SELECT id_transaccion, fecha, status, medio_pago, CONCAT(nombres, ' ', apellidos) AS cliente,
totalBOB FROM compra 
INNER JOIN clientes ON compra.id_cliente = clientes.id
ORDER BY DATE(fecha) DESC";
$resultado = $con->query($sql);

require_once '../header.php';

//session_destroy();


?>
<main class="flex-shrink-0">
    <div class="container mt-3">
        <h4>Compras</h4>
        <a href="genera_reporte_compras.php" class="btn btn-success btn-sm">Reporte de compras</a>
        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['id_transaccion'] ?></td>
                        <td><?php echo $row['cliente'] ?></td>
                        <td><?php echo $row['totalBOB'] . ' '.MONEDA ?></td>
                        <td><?php echo $row['fecha'] ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detalleModal" data-bs-orden="<?= $row['id_transaccion']; ?>">Ver detalles</button>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Button trigger modal -->


<!-- Modal -->
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

<script>
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

    detalleModal.addEventListener('hide.bs.modal', function(event) {
        const modalBody = detalleModal.querySelector('.modal-body');
        modalBody.innerHTML = '';
    });
</script>
<?php include '../footer.php';
