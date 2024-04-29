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

$sql = "SELECT id, nombre FROM categorias WHERE activo =1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-3">Categorias</h1>
        <a href="nuevo.php" class="btn btn-primary">Nuevo</a>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $cat) { ?>
                        <tr>
                            <td><?php echo $cat['id']; ?></td>
                            <td><?php echo $cat['nombre']; ?></td>
                            <td><a class="btn btn-warning btn-sm" href="edita.php?id=<?php echo $cat['id']; ?>">Editar</a></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalElimina" data-bs-id="<?php echo $cat['id']; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</main>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalElimina" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Confirmar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">¿Desea Eliminar el registro?</div>
            <div class="modal-footer">
                <form action="elimina.php" method="post">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Place to the bottom of scripts -->
<script>
    let eliminaModal = document.getElementById("modalElimina");
    eliminaModal.addEventListener('show.bs.modal', function(event){
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id');

        let modalInput = eliminaModal.querySelector('.modal-footer input');
        modalInput.value = id;
    });
</script>


<?php require_once '../footer.php' ?>