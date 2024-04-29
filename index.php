<?php
require_once 'config/config.php';

$db = new Database();
$con = $db->conectar();

$idCategoria = $_GET['cat'] ?? '';
$orden = $_GET['orden'] ?? '';

$orders = [
    'asc' => 'nombre ASC',
    'desc' => 'nombre DESC',
    'precio_alto' => 'precio DESC',
    'precio_bajo' => 'precio ASC',
];
$order = $orders[$orden] ?? '';

if (!empty($order)) {
    $order = " ORDER BY $order";
}

if (!empty($idCategoria)) {
    $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1
    AND id_categoria = ? $order");
    $sql->execute([$idCategoria]);
} else {
    $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1 $order");
    $sql->execute();
}

$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

$sqlCategorias = $con->prepare("SELECT id, nombre FROM categorias WHERE activo = 1");
$sqlCategorias->execute();
$categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);
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
    <style>
        /* Estilo para las imágenes de productos */
        .card-img-top {
            width: 100%;
            /* Ajusta el ancho de la imagen al 100% del contenedor */
            height: auto;
            /* Mantiene la proporción de la imagen */
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>
    <main class="flex-shrink-0">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Categorias
                        </div>
                        <div class="list-group">
                            <a href="index.php" class="list-group-item list-group-item-action">Todos los productos</a>
                            <?php foreach ($categorias as $categoria) { ?>
                                <a href="index.php?cat=<?php echo $categoria['id'] ?>" class="list-group-item list-group-item-action <?php if ($idCategoria == $categoria['id']) echo 'active' ?> ">
                                    <?php echo $categoria['nombre']; ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 justify-content-end g-4">
                        <div class="col mb-2">
                            <form action="index.php" id="ordenForm" method="get">
                                <input type="hidden" name="cat" id="cat" value="<?php echo $idCategoria; ?>">
                                <select name="orden" id="orden" class="form-select form-select-sm" onchange="submitForm()">
                                    <option value="">Ordenar por...</option>
                                    <option value="precio_alto" <?php echo ($orden === 'precio_alto') ? 'selected'  : ''; ?>>Precios más altos</option>
                                    <option value="precio_bajo <?php echo ($orden === 'precio_bajo') ? 'selected'  : ''; ?>">Precios más bajos</option>
                                    <option value="asc" <?php echo ($orden === 'asc') ? 'selected'  : ''; ?>>Nombres A-Z</option>
                                    <option value="desc" <?php echo ($orden === 'desc') ? 'selected'  : ''; ?>>Nombre Z-A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        <?php foreach ($resultado as $row) { ?>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <?php
                                    $id = $row['id'];
                                    $imagen = "images/productos/" . $id . "/principal.jpg";
                                    if (!file_exists($imagen)) {
                                        $imagen = "images/no-photo.jpg";
                                    }
                                    ?>
                                    <img src="<?php echo $imagen; ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                        <p class="card-text"><?php echo MONEDA . number_format($row['precio'], 2, '.', ''); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                            </div>
                                            <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar al carrito</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function addProducto(id, token) {
            let url = 'clases/carrito.php';
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero
                    } else {
                        alert("No hay suficientes productos en el stock")
                    }
                })
        }

        function submitForm() {
            document.getElementById('ordenForm').submit();
        }
    </script>
    <script src="js/all.min.js"></script>
</body>

</html>