<?php
require_once '../config/database.php';
require_once '../config/config.php';

if (!isset($_SESSION['user_type'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['user_type'] != 'admin') {
    header("Location: ../../index.php");
    exit;
}


$db = new Database();
$con = $db->conectar();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$carnet = $_POST['carnet'];
$celular = $_POST['celular'];
$empresa = $_POST['empresa'];

$sql = $con->prepare("UPDATE couriers SET nombre = ?, carnet = ?, celular = ?, empresa = ? WHERE id = ?");
$sql->execute([$nombre, $carnet, $celular, $empresa, $id]);

header('Location: index.php');


?>
