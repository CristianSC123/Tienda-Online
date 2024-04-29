<?php
require_once 'config/config.php';
require_once 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = array();
if (!empty($_POST)) {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $ci = trim($_POST['ci']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$nombres, $apellidos, $email, $telefono, $ci, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es válida";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $con)) {
        $errors[] = "El nombre de usuario " . $usuario . " ya existe";
    }

    if (emailExiste($email, $con)) {
        $errors[] = "El correo electronico " . $email . " ya existe";
    }

    if (count($errors) == 0) {

        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $ci], $con);
        if ($id > 0) {
            require_once 'clases/mailer.php';
            $mailer = new Mailer();
            $token = generarToken();

            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $id], $con);
            if ($idUsuario > 0) {
                $url = SITE_URL . '/activa_cliente.php?id=' . $idUsuario . '&token=' . $token;
                $asunto = "Activar cuenta - Tienda online";
                $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro es indispensable de
            click en el siguiente enlace <a href='$url'>Activar cuenta</a> ";
                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "Para Terminar el proceso de registro siga las instrucciones que le hemos enviado
                    a la direccion de correo electronico: " . '<b>' . $email . '</b>';
                    exit;
                }
            } else {
                $errors[] = "Error al registrar el cliente";
            }
        }
    } else {
        $errors[] = "Error al registrar el cliente";
    }
}


//session_destroy();


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <strong>Tienda Online</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Catalogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>
                    <a href="checkout.php" class="btn btn-primary">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>