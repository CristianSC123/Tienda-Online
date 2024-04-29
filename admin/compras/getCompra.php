<?php
require_once '../config/database.php';
require_once '../config/config.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$orden = $_POST['orden'] ?? null;


if ($orden == null) {
    exit;
}

$db = new Database();
$con = $db->conectar();

$sqlCompra = $con->prepare("SELECT compra.id, id_transaccion, fecha, totalBOB, CONCAT(nombres, ' ', apellidos) AS cliente
 FROM compra 
 INNER JOIN clientes on compra.id_cliente = clientes.id
 WHERE id_transaccion = ? LIMIT 1");
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);

if (!$rowCompra) {
    exit;
}

$idCompra = $rowCompra['id'];

$fecha = new DateTime($rowCompra['fecha']);
$fecha = $fecha->format('d/m/Y H:i:s');

$sqlDetalle = $con->prepare("SELECT id, nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
$sqlDetalle->execute([$idCompra]);

$html = '<p> <strong>Fecha: </strong> ' . $fecha . ' </p>';
$html .= '<p> <strong>ID compra: </strong> ' . $rowCompra['id_transaccion'] . ' </p>';
$html .= '<p> <strong>Total: </strong> ' . number_format($rowCompra['totalBOB'], 2, ',', '') . ' </p>';

$html .= '<table class="table">
<thead>
<tr>
<th>Producto</th>
<th>Precio</th>
<th>Cantidad</th>
<th>Subtotal</th>
 <th></th>
</tr>
</thead>';

$html .= '<tbody>';
while ($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) {
    $precio = $row['precio'];
    $cantidad = $row['cantidad'];
    $subtotal = $precio * $cantidad;

    $html .= '<tr>';

    $html .= '<td>' . $row['nombre'] . '</td>';
    $html .= '<td>' . MONEDA . " " . $precio . '</td>';
    $html .= '<td>' . $cantidad . '</td>';
    $html .= '<td>' . MONEDA . " " . $subtotal . '</td>';

    $html .= '</tr>';
}
$html .= '</tbody></table>';
echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>
