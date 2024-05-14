<?php
require_once 'config/config.php';
$db = new Database();
$con = $db->conectar();

// Consulta SQL para obtener los departamentos y sus costos
$sql = "SELECT id, nombre_departamento, costo FROM destinos";
$stmt = $con->prepare($sql);
$stmt->execute();
$destinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Validación del formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departamento = $_POST['departamento'];
    $calle_avenida = $_POST['calle_avenida'];
    $numero_puerta = $_POST['numero_puerta'];

    // Obtener el ID del departamento seleccionado
    $id_departamento = $_POST['departamento']; // Suponiendo que el valor enviado es el ID

    // Validación en el backend
    if (empty($departamento) || empty($calle_avenida) || empty($numero_puerta)) {
        $error_message = "Todos los campos son obligatorios.";
    } else {
        // Construir la URL con los parámetros necesarios
        $url_redireccion = "pago.php?id_departamento=$id_departamento&calle_avenida=$calle_avenida&numero_puerta=$numero_puerta&departamento=$departamento";
        header("Location: $url_redireccion");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/allmin.css">
</head>

<body>
    <?php include 'menu.php' ?>
    <main>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Datos de Envío</h4>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar mensajes de error si existen -->
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form id="formulario-envio" method="POST" action="form_envios.php">
                            <!-- Agrega un campo oculto para enviar el ID del departamento -->
                            <input type="hidden" id="id_departamento" name="id_departamento" value="">
                            <div class="mb-3">
                                <label for="departamento">Departamento:</label>
                                <select class="form-select" id="departamento" name="departamento" required>
                                    <option value="" disabled selected>Selecciona el departamento</option>
                                    <!-- Mostrar opciones desde la base de datos -->
                                    <?php foreach ($destinos as $destino) : ?>
                                        <option value="<?php echo $destino['id']; ?>"><?php echo $destino['nombre_departamento']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="calle_avenida">Calle o Avenida:</label>
                                <input type="text" class="form-control" id="calle_avenida" name="calle_avenida" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="numero_puerta">Número de Puerta:</label>
                                <input type="text" class="form-control" id="numero_puerta" name="numero_puerta" required autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Datos de Envío</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AY5YL-hCri9BFPQrnDBmqah6dxYmxYBNEA4g32UAKwFdej4c4-kGvF8zkZ5_2MS9OH98H6z4ekAsZr5b&currency=USD"></script>
    
</body>



</html>