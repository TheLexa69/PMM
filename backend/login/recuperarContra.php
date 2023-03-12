<?php

require_once '../sesiones/sesiones.php';
comprobar_sesiones();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosLogin as formulariosLogin;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\ConsultasLogin as consultasLogin;
use \clases\Mails as mailLogin;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\FiltroDatos as filtrado;

$filtro = new filtrado;
$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin;
$envioMail = new mailLogin;
$consultaTrabajador = new consultasAdministrador;

if (isset($_POST['mailr'])) {
    $_POST = $filtro->validarPost($_POST);

    $mail = $_POST['mailr'];
    $trabajas = $_POST['trabajo'];

    try {

        $datos = $consulta->comprobarDatos($mail);
        $datosTrabajador = $consultaTrabajador->comprobarDatosTrabajador($mail);

        if (!empty($datos["correo"])) {
            $nombre = $datos['nombre'];
            $mailBd = $datos["correo"];
            $rol = $datos["id_rol"];
        }
        
        if (!empty($datosTrabajador["correo"])) {
            $nombreTrabajador = $datosTrabajador['nombre'];
            $mailBdTrabajador = $datosTrabajador["correo"];
            $roltrabajador = $datosTrabajador["id_rol"];
        }

        if (!empty($datos) && $trabajas == "NO") {
            $token = intval(rand(100000, 900000) * 25 / 4 + 3);

            $token2 = password_hash($token, PASSWORD_DEFAULT);
            $envioMail->mail($mailBd, $nombre, $token);
            $consulta->quitarActivacion($mailBd, $token2);

            $formularios->contrastaToken($mailBd, $rol);
        } else if (!empty($datosTrabajador["correo"]) && $trabajas == "SI") {
            $token = intval(rand(100000, 900000) * 25 / 4 + 3);

            $token2 = password_hash($token, PASSWORD_DEFAULT);
            $envioMail->mail($mailBdTrabajador, $nombreTrabajador, $token);
            $consultaTrabajador->quitarActivacionTrabajador($mailBdTrabajador, $token2);

            $formularios->contrastaToken($mailBdTrabajador, $roltrabajador);
        } else {
            if ($trabajas == "SI") {
                $mensaje = "<b>" . $mail . "</b>  Usted no trabaja con nosotros<br>";
            } else {
                $mensaje = "<b>" . $mail . "</b>   No existe en nuestra base de datos<br>";
            }
            $formularios->recuperar($mensaje);
        }
    } catch (PDOException $e) {

        die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
    }
} else {

    $formularios->recuperar();
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
