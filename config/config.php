<?php
$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;


require_once $path.'/database.php';
require_once $path.'/../admin/clases/cifrado.php';


$db = new Database();
$con = $db->conectar();
$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datosConfig = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach($datosConfig as $datoConfig){
    $config[$datoConfig['nombre']]= $datoConfig['valor'];  
}
//configuracion del sistema
define("SITE_URL", "http://localhost/pasarela");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "Bs ");

//configuracion de paypayl
define("CLIENT_ID", "AY5YL-hCri9BFPQrnDBmqah6dxYmxYBNEA4g32UAKwFdej4c4-kGvF8zkZ5_2MS9OH98H6z4ekAsZr5b");
define("CURRENCY", "USD");
$cambio_actual = 0.145;




//Datos para el envio de correo electronico
define("MAIL_HOST",$config['correo_smtp']);
define("MAIL_USER",$config['correo_email']);
define("MAIL_PASS",descifrar($config['correo_password']));
define("MAIL_PORT",$config['correo_puerto']);

session_start();


$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>