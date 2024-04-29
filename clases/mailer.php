<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    function enviarEmail($email, $asunto, $cuerpo)
    {
        require_once __DIR__ .'/../config/config.php';
        require_once __DIR__ .'/../phpmailer/src/PHPMailer.php';
        require_once __DIR__ .'/../phpmailer/src/SMTP.php';
        require_once __DIR__ .'/../phpmailer/src/Exception.php';
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; //SMTP::DEBUG OFF (para subir a produccion)                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;                     //SMTP username
            $mail->Password   = MAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(MAIL_USER, 'TIENDA ONLINE PRUEBAS');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = mb_convert_encoding($cuerpo, 'ISO-8859-1','UTF-8');
            $mail->setLanguage('es', __DIR__ . '/../phpmailer/languaje/phpmailer.lang-es.php');
      
            if($mail->send()){
                return true;
            }else{
                 return false;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
            return false;
        }
    }
}
