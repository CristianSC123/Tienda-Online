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

$nombre = $_POST['nombre'];
$carnet = $_POST['carnet'];
$celular = $_POST['celular'];

$sql = $con->prepare("INSERT INTO couriers (nombre, carnet, celular) VALUES (?, ?, ?)");
$sql->execute([$nombre, $carnet, $celular]);

header('Location: index.php')


?>