<?php
require_once '../config/database.php';
require_once '../config/config.php';
require_once '../header.php';

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

$id = $_GET['id'];

$sql = $con->prepare("SELECT id, nombre, carnet, celular, empresa FROM couriers WHERE id = ? LIMIT 1");
$sql->execute([$id]);
$courier = $sql->fetch(PDO::FETCH_ASSOC);

?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-3">Editar courier</h1>
        <form action="actualiza.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $courier['id'];?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control form-control-sm" name="nombre" 
                id="nombre" value="<?php echo $courier['nombre']?>" required autofocus />

                <label for="carnet" class="form-label">Carnet</label>
                <input type="text" class="form-control form-control-sm" name="carnet" 
                id="carnet" value="<?php echo $courier['carnet']?>" required/>

                <label for="celular" class="form-label">Celular</label>
                <input type="text" class="form-control form-control-sm" name="celular" 
                id="celular" value="<?php echo $courier['celular']?>" required/>

                <label for="empresa" class="form-label">Empresa</label>
                <input type="text" class="form-control form-control-sm" name="empresa" 
                id="empresa" value="<?php echo $courier['empresa']?>" required/>

            </div>

            <button type="submit" class="btn btn-primary">
                Guardar
            </button>

        </form>
    </div>
</main>

<?php require_once '../footer.php' ?>