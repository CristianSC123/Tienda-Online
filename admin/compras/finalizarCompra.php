<?php
require_once '../config/database.php';
date_default_timezone_set('America/La_Paz');

// Comprobar si se recibió la solicitud POST con el ID de la compra
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['idCompra'])) {
    $db = new Database();
    $con = $db->conectar();

    $idTransaccion = $_POST['idCompra'];

    // Actualizar el estado de envío a 'enviado' para la compra con el ID recibido
    $sqlUpdate = $con->prepare("UPDATE compra SET estado_envio = 'entregado' WHERE id_transaccion = ?");
    $sqlUpdate->execute([$idTransaccion]);

    // Verificar si se realizó la actualización correctamente
    if ($sqlUpdate->rowCount() > 0) {
        echo "Actualización guardada correctamente";
    } else {
        echo "Error: No se pudo actualizar el estado de envío";
    }
} else {
    echo "Error: Datos incorrectos recibidos";
}
?>

