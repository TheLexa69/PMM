<?php

namespace clases;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

class Mails {

    protected $host;
    protected $mailRestaurante;
    protected $clave;

    function __construct() {

        $datos = $this->leerConfigMail(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracionMail.xml", dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracionMail.xsd");

        $this->host = $datos[0];
        $this->mailRestaurante = $datos[1];
        $this->clave = $datos[2];
    }

    /**
     * Lee el archivo de configuración del correo y devuelve los datos Para poder mandarlo.
     * @param string $xmlMail el xml.
     * @param string $xsd  XSD que valida la estructura del archivo xml.
     * @return datosMail Es un array con tres valores: hostMail, correo y password.
     * @throws InvalidArgumentException Si el archivo XSD no existe o no es válido para ese XML.
     */
    function leerConfigMail($xlmMail, $xsd) {

        $config = new \DOMDocument();
        $config->load($xlmMail);
        $res = $config->schemaValidate($xsd);
        if ($res === FALSE) {
            throw new \InvalidArgumentException("Revise el fichero de configuración de mail");
        }
        $datos = simplexml_load_file($xlmMail);

        $host = $datos->xpath("//host");
        $mail = $datos->xpath("//mail");
        $clave = $datos->xpath("//clave");

        $datosMail = [];
        $datosMail[] = $host[0];
        $datosMail[] = $mail[0];
        $datosMail[] = $clave[0];
        return $datosMail;
    }

    /**
     * Envía un correo electrónico de verificación de cuenta a un destinatario dado.
     * @param string $email La dirección de correo electrónico del destinatario.
     * @param string $nombre El nombre del destinatario.
     * @param string $token El código de verificación que se incluirá en el cuerpo del correo electrónico.
     * @throws Exception si se produce un error al enviar el correo electrónico.
     */
    public function mail($email, $nombre, $token) {
        //novoluachea@gmail
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $this->host;                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = $this->mailRestaurante;   //SMTP credenciales de correo para aceder
            $mail->Password = $this->clave;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;               //587  465                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom($this->mailRestaurante, 'NovoLuaChea');     //Desde donde se envia
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
            $mail->Body = 'Vaya a la página y ponga este codigo </b>' . $token;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';    //mensaje alternativo

            $mail->send();

            //echo 'Mensaje enviado correctamente';
        } catch (Exception $e) {

            echo "Mensaje no enviado Error : {$mail->ErrorInfo}";
        }
    }

    /**
     * Función para enviar correos electrónicos con los datos del pedido.
     * @param string $correo Dirección de correo electrónico del destinatario
     * @param string $cuerpo Cuerpo del correo electrónico con los datos del pedido
     * @param string $asunto (Opcional) Asunto del correo electrónico, por defecto es "Pedido realizado"
     * @throws \PHPMailer\PHPMailer\Exception si hay algún error al enviar el correo electrónico
     */
    function enviar_correo_pedidos($correo, $cuerpo, $asunto = "Pedido realizado") {
        //$res = leer_configCorreo(dirname(__FILE__) . "/config/correo.xml", dirname(__FILE__) . "/config/correo.xsd");
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;  // cambiar a 1 o 2 para ver errores
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Host = $this->host;
        $mail->Port = 465;
        $mail->Username = $this->mailRestaurante;  //usuario de gmail
        $mail->Password = $this->clave; //contraseña de gmail          
        $mail->SetFrom($this->mailRestaurante, 'NovoLuaChea');
        $mail->isHTML(true);
        $mail->Subject = mb_convert_encoding($asunto, 'UTF-8');
        $mail->Body = $cuerpo;
        $mail->AddAddress($correo, $correo);

        $mail->send();
    }

    /**
     * Envía un correo electrónico de solicitud de reserva al destinatario proporcionado utilizando la biblioteca PHPMailer.
     * @param string $email La dirección de correo electrónico del destinatario.
     * @param string $nombre El nombre del destinatario.
     * @param string $mensaje El mensaje de correo electrónico a enviar.
     * @throws Exception Si se produce un error al enviar el correo electrónico.
     */
    public function mailReservas($email, $nombre, $mensaje) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailRestaurante;
            $mail->Password = $this->clave;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;               //587  465                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom($this->mailRestaurante, 'NovoLuaChea');
            $mail->addAddress($email, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Solicitud de reserva';
            $mail->Body = $mensaje;

            $mail->send();

            //echo 'Mensaje enviado correctamente';
        } catch (Exception $e) {

            echo "Mensaje no enviado Error : {$mail->ErrorInfo}";
        }
    }

}
