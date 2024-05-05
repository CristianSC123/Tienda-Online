<?php
require_once '../config/database.php';
/*
$datos = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $db = new Database();
    $con = $db->conectar();
    if ($action == 'buscarColoresPorTalla') {
        $datos['colores'] = buscarColoresPorTalla($con);
    } elseif ($action = 'buscarIdVariante') {
        $datos['variante'] = buscarIdVariante($con);
    }
}
/*
function buscarColoresPorTalla($con)
{
    $idProducto = $_POST['id_producto'] ?? 0;
    $idTalla = $_POST['id_talla'] ?? 0;

    $sqlColores =  $con->prepare("SELECT DISTINCT c.id, c.nombre FROM productos_variantes as pv
                INNER JOIN c_colores AS c ON pv.id_color = c.id
                WHERE pv.id_producto = ? AND pv.id_talla = ?");

    $sqlColores->execute([$idProducto, $idTalla]);
    $colores = $sqlColores->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($colores as $color) {
        $html .= '<option value="' . $color['id'] . '">' . $color['nombre'] . '</option>';
    }
    return $html;
}

function buscarIdVariante($con)
{
    $idProducto = $_POST['id_producto'] ?? 0;
    $idTalla = $_POST['id_talla'] ?? 0;
    $idColor = $_POST['id_color'] ?? 0;


    $sql =  $con->prepare("SELECT id, precio, stock FROM productos_variantes
    WHERE id_producto = ? AND id_talla = ? AND id_color = ? LIMIT 1");

    $sql->execute([$idProducto, $idTalla, $idColor]);
    return $sql->fetch(PDO::FETCH_ASSOC);
     
}*/
echo json_encode($datos);
