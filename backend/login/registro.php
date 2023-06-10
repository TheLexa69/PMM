<?php

require_once '../sesiones/sesiones.php';
comprobar_sesiones();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosLogin as formulariosLogin;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\ConsultasLogin as consultasLogin;
use \clases\Mails as mailLogin;
use \clases\FiltroDatos as filtrado;

$filtro = new filtrado;
$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin(4);
$envioMail = new mailLogin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST = $filtro->validarPost($_POST);
    $nombre = $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['nombre']);
    $apellido1 = $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['apellido1']);
    $apellido2 = ($_POST['apellido2']) ? $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['apellido2']) : null;
    $mail = ($funciones->correo($_POST['mail'])) ? $funciones->correo($_POST['mail']) : "";
    $codPais = $_POST['codPais'];

    //$telefono = $filtro->verificarDatos("[0-9]{9,9}", $_POST['telefono']);
    //$telefono = (strlen($telefono) == 9) ? $telefono : "";
    $telefono =$_POST['telefono'];
    $nif = null;
    $direccion = null;
    $cp = null;
    $rol = 4;
    $fecha = $funciones->fechaHoraActual();

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail); //mail base de datos y contraseña

    $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {

        //aqui se le indica que se le envio un codigo de comprobacion al mail
        $token = intval(rand(100000, 900000) * 25 / 4 + 3);
        //$token = 123456;
        $token2 = password_hash($token, PASSWORD_DEFAULT);
        $envioMail->mail($mail, $nombre, $token);

        $consulta->añadirUsuario($nombre, $apellido1, $apellido2, $token2, $mail, $codPais, $telefono, $rol, $fecha, $nif, $direccion, $cp);

        if ($necesarios == true) {

            $formularios->contrastaToken($mail, $rol);

            // header("Location: comprobarToken.php");
        } else {
            $formularios->htmlRegistro($necesarios);
        }
    } else {
        $formularios->htmlRegistro($necesarios);
    }
} else {
    if (isset($_GET['registro'])) {
        echo $mensaje = '<div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">
                        Fallo al iniciar sesión, por favor, registrese.
                        </div>' . "<script defer>
                                    window.onload = function() {
                                    var mensajeDiv = document.getElementById('mensaje');
                                    mensajeDiv.style.top = '20%';
                                    setTimeout(function() {
                                        mensajeDiv.style.top = '-150%';
                                    }, 5000);
                                    }
                                    </script>";
    }
    $formularios->htmlRegistro();
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
