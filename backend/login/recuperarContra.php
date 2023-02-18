<?php

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
//include "../../autoloadClasesLogin.php";

use \clases\Formularios as formulariosLogin;
use \clases\Funciones as funcionesLogin;
use \clases\Consultas as consultasLogin;
use \clases\Mails as mailLogin;

$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin;
$envioMail = new mailLogin;

if (isset($_POST['mailr'])) {

    $mail = $_POST['mailr'];

    Try {

        $datos = $consulta->comprobarDatos($mail);
        if (!empty($datos)) {
            $mailBd = $datos['correo'];
            $nombre = $datos['nombre'];

            $token = intval(rand(100000, 900000) * 25 / 4 + 3);
            // $token = 123456;
            $token2 = password_hash($token, PASSWORD_DEFAULT);
            $envioMail->mail($mail, $nombre, $token);
            $consulta->quitarActivacion($mail, $token2);

            $formularios->contrastaToken($mailBd);
        } else {
            $mensaje = "<b>" . $mail . "</b>   No existe en nuestra base de datos<br>";
            $formularios->recuperar($mensaje);
        }
    } catch (PDOException $e) {
        echo 'Accion no realizada porque:<br>';
        die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
    }
} else {

    $formularios->recuperar();
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
