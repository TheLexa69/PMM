<?php
namespace clases;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require"../vendor/autoload.php";
 
class mails{
 

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
 
}