<?php
require_once '../config/database.php';
date_default_timezone_set('America/La_Paz');

$db = new Database();
$con = $db->conectar();

$idCourier = $_POST['idCourier'] ?? 'nada';
$idTransaccion = $_POST['idCompra'] ?? 'nada';
$fechaActual = date('Y-m-d H:i:s');

if ($idCourier !== 'nada' && $idTransaccion !== 'nada') {
    $sqlUpdate = $con->prepare("UPDATE compra SET id_courier = ?, estado_envio = 'enviado', fecha_envio = ?
     WHERE id_transaccion = ?");
    $sqlUpdate->execute([$idCourier, $fechaActual, $idTransaccion]);

    echo "Envío guardado correctamente";
} else {
    echo "Error: Datos incorrectos recibidos";
}
