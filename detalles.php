<?php
require_once 'config/config.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
if ($id == '' || $token == '') {
    echo "Error al procesar la petición";
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id = ? AND activo = 1");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id = ? AND activo = 1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_images = 'images/productos/' . $id . '/';
            $rutaImg = $dir_images . 'principal.jpg';
            if (!file_exists($rutaImg)) {
                $rutaImg = 'images/no-photo.jpg';
            }

            $imagenes = array();
            if (file_exists($dir_images)) {
                $dir = dir($dir_images);
                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg')) || strpos($archivo, 'jpeg')) {
                        $image = $dir_images . $archivo;
                        $imagenes[] = $image;
                    }
                }
                $dir->close();

                $sqlTallas =  $con->prepare("SELECT DISTINCT t.id, t.nombre FROM productos_variantes as pv
                INNER JOIN c_tallas AS t ON pv.id_talla = t.id
                WHERE pv.id_producto = ?");
                $sqlTallas->execute([$id]);
                $tallas = $sqlTallas->fetchAll(PDO::FETCH_ASSOC);

                $sqlColores =  $con->prepare("SELECT DISTINCT c.id, c.nombre FROM productos_variantes as pv
                INNER JOIN c_colores AS c ON pv.id_color = c.id
                WHERE pv.id_producto = ?");
                $sqlColores->execute([$id]);
                $colores = $sqlColores->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            echo "Producto no encontrado";
            exit;
        }
    } else {
        echo "Error al procesar la petición";
        exit;
    }
}
/*$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php include 'menu.php' ?>


    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $rutaImg ?>" class="d-block w-100">
                            </div>
                            <?php foreach ($imagenes as $img) { ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img ?>" class="d-block w-100">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre ?></h2>
                    <?php if ($descuento > 0) { ?>
                        <p><del><?php echo MONEDA . number_format($precio, 2, '.', ''); ?></del></p>
                        <h2>
                            <?php echo MONEDA . number_format($precio_desc, 2, '.', ''); ?>
                            <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                        </h2>
                    <?php } else { ?>
                        <h2><?php echo MONEDA . number_format($precio, 2, '.', ''); ?></h2>
                    <?php } ?>
                    <p class="lead"><?php echo $row['descripcion']; ?></p>

                    <?php /*
                    <div class="col-3 my-3">
                        <?php
                        while ($row_cat = $sqlCaracter->fetch(PDO::FETCH_ASSOC)) {
                            $idCat = $row_cat['idCat'];
                            echo $row_cat['caracteristica'] . ":";

                            echo "<select class='form-select' id='cat_" . $idCat . "'>";

                            $sqlDet = $con->prepare("SELECT id, valor, stock 
                                FROM det_prod_caracter WHERE id_producto = ? AND id_caracteristica=?");
                            $sqlDet->execute([$id, $idCat]);
                            while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option id='" . $row_det['id'] . "'>" . $row_det['valor'] . "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    </div>*/
                    ?>

                    <div class="row g-2">
                        <?php if ($tallas) { ?>
                            <div class="col-3 my-3">
                                <label for="tallas" class="form-label">Tallas</label>
                                <select class="form-select form-select-lg" name="tallas" id="tallas" onchange="cargarColores()">

                                    <?php foreach ($tallas as $talla) { ?>
                                        <option value="<?php echo $talla['id']; ?>"><?php echo $talla['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>

                        <?php if ($colores) { ?>
                            <div class="col-3 my-3" id="div-colores">
                                <label for="colores" class="form-label">Colores</label>
                                <select class="form-select form-select-lg" name="colores" id="colores">
                                    <?php foreach ($colores as $color) { ?>
                                        <option value="<?php echo $color['id']; ?>"><?php echo $colores['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>

                    </div>



                    <div class="col-3 my-3">
                        Cantidad: <input class="form-control" id="cantidad" name="cantidad" type="number" type="number" min="1" max="10" value="1">
                    </div>

                    <div class="col-3 my-3">
                        Precio: <input class="form-control" id="nuevo_precio">
                    </div>

                    <div class="d-grid gap-3 col-7">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, cantidad.value, '<?php echo $token_tmp ?>')">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function addProducto(id, cantidad, token) {
            let url = 'clases/carrito.php';
            let formData = new FormData()
            formData.append('id', id)
            formData.append('cantidad', cantidad)
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
                    }else{
                        alert("No hay suficientes productos en stock")
                    }
                })
        }

        const cbxTallas = document.getElementById('tallas');
        cargarColores();

        const cbxColores = document.getElementById('colores');
        cbxColores.addEventListener('change', cargarVariante, false)


        function cargarColores() {
            let idTalla = 0;
            if (document.getElementById('tallas')) {
                idTalla = document.getElementById('tallas').value;
            }
            const cbxColores = document.getElementById('colores');
            const divColores = document.getElementById('div-colores');


            let url = 'clases/productosAjax.php';
            let formData = new FormData()
            formData.append('id_producto', '<?php echo $id ?>')
            formData.append('id_talla', idTalla)
            formData.append('action', 'buscarColoresPorTalla')
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.colores != '') {
                        divColores.style.display = 'block';
                        cbxColores.innerHTML = data.colores;
                    } else {
                        divColores.style.display = 'none';
                        cbxColores.innerHTML = '';
                        cbxColores.value = 0;
                    }
                    cargarVariante()
                })
        }

        function cargarVariante() {


            let idTalla = 0;
            if (document.getElementById('tallas')) {
                idTalla = document.getElementById('tallas').value;
            }

            let idColor = 0;

            if (document.getElementById('colores')) {
                idColor = document.getElementById('colores').value;
            }

            let url = 'clases/productosAjax.php';
            let formData = new FormData()
            formData.append('id_producto', '<?php echo $id; ?>')
            if (idTalla !== 0 && idTalla !== '') {
                formData.append('id_talla', idTalla)
            }

            if (idColor !== 0 && idColor !== '') {
                formData.append('id_color', idColor)
            }
            formData.append('action', 'buscarIdVariante')
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.variante != '') {
                        document.getElementById('nuevo_precio').value = data.variante.precio
                    } else {
                        document.getElementById('nuevo_precio').value = 'No encontrado'
                    }

                })
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>