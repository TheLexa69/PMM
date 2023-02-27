<<<<<<< Updated upstream:backend/login/mail_reset.php
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 

 
require_once "../conexion/conexion.php";
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
 
 
    //novoluachea@gmail
function mail($mail,$nombre,$token){
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'b01-daw2d-iesteis-gal.correoseguro.dinaserver.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'restaurante@b01.daw2d.iesteis.gal';   //SMTP credenciales de correo para aceder
    $mail->Password   = 'Restaurante@1';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;               //587  465                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('restaurante@b01.daw2d.iesteis.gal', 'NovoLuaChea');     //Desde donde se envia
    $mail->addAddress($mail, $nombre);     //A quien se envia
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //para enviar ficheros adjuntos
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //para enviar imagenes adjuntas

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Mensaje de verificacion cuenta';
    $mail->Body    = 'Valla a la pagina y ponga este codigo </b>'.$token;
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';    //mensaje alternativo

    $mail->send();
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "Mensaje no enviado Error : {$mail->ErrorInfo}";
}
}
 
=======
<?php
namespace clases;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require"../vendor/autoload.php";
 
class Mails{
 

//novoluachea@gmail
public function mail($email,$nombre,$token){

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'b01-daw2d-iesteis-gal.correoseguro.dinaserver.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'restaurante@b01.daw2d.iesteis.gal';   //SMTP credenciales de correo para aceder
    $mail->Password   = 'Restaurante@1';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;               //587  465                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('restaurante@b01.daw2d.iesteis.gal', 'NovoLuaChea');     //Desde donde se envia
    $mail->addAddress($email, $nombre);     //A quien se envia
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //para enviar ficheros adjuntos
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //para enviar imagenes adjuntas

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Mensaje de verificacion cuenta';
    $mail->Body    = 'Vaya a la página y ponga este codigo </b>'.$token;
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';    //mensaje alternativo

    $mail->send();
 
    //echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    
    echo "Mensaje no enviado Error : {$mail->ErrorInfo}";
  
}
}


function enviar_correo_pedidos($correo, $cuerpo, $asunto = "Pedido realizado") {
    //$res = leer_configCorreo(dirname(__FILE__) . "/config/correo.xml", dirname(__FILE__) . "/config/correo.xsd");
    $mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;  // cambiar a 1 o 2 para ver errores
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Host = "b01-daw2d-iesteis-gal.correoseguro.dinaserver.com";
    $mail->Port = 465;
    $mail->Username = 'restaurante@b01.daw2d.iesteis.gal';  //usuario de gmail
    $mail->Password = 'Restaurante@1'; //contraseña de gmail          
    $mail->SetFrom('restaurante@b01.daw2d.iesteis.gal', 'NovoLuaChea');
    $mail->isHTML(true);
    $mail->Subject = mb_convert_encoding($asunto,'UTF-8');
    $mail->Body = $cuerpo;
    $mail->AddAddress($correo, $correo);
    
    $mail->send();
}

 
}
>>>>>>> Stashed changes:backend/clases/mails.php
