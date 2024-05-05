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
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detalleModal" data-bs-orden="<?= $row['id']; ?>">Ver detalles</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../footer.php';
