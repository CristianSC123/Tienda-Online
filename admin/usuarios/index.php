<?php
require_once '../config/database.php';
require_once '../config/config.php';


if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin')) {
    header("Location: ../index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();


$sql = "SELECT usuarios.id, CONCAT(clientes.nombres, ' ', clientes.apellidos) as cliente, usuarios.usuario, 
usuarios.activacion, 
CASE 
    WHEN usuarios.activacion = 1 THEN 'Activo'
    WHEN usuarios.activacion = 0 THEN 'No activado'
    ELSE 'Deshabilitado'
END AS estatus
FROM usuarios INNER JOIN clientes ON usuarios.id_cliente = clientes.id;
";
$resultado = $con->query($sql);

require_once '../header.php';

//session_destroy();


?>
<main>
    <div class="container">
        
        <h4>Clientes registrados</h4>
        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['cliente'] ?></td>
                        <td><?php echo $row['usuario'] ?></td>
                        <td><?php echo $row['estatus'] ?></td>
                        <td>
                            <a href="cambiar_password.php?user_id=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Cambiar contraseña</a>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalElimina" data-bs-orden="<?= $row['id']; ?>">Desactivar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<div class="modal fade" id="modalElimina" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Confirmar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">¿Desea desactivar al usuario?</div>
            <div class="modal-footer">
                <form action="elimina.php" method="post">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-danger">Desactivar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Place to the bottom of scripts -->
<script>
    let eliminaModal = document.getElementById("modalElimina");
    eliminaModal.addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id');

        let modalInput = eliminaModal.querySelector('.modal-footer input');
        modalInput.value = id;
    });
</script>
<?php include '../footer.php';
