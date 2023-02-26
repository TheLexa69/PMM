<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosUsuario as formulariosUsuario;
use \clases\ConsultasUsuario as consultasUsuario;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\FuncionesUsuario as funcionesUsuario;

$formularios = new formulariosUsuario;
$consulta = new consultasUsuario;
$funciones = new funcionesLogin;
$funcionesU = new funcionesUsuario;
$id = $_SESSION["usuario"];

$datos = $consulta->datosUsuario($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = (!empty($_POST["apellido2"])) ? $_POST["apellido2"] : "";
    $telefono = $_POST["telefono"];
    $mail = $_POST["mail"];
    $nif = $_POST["nif"];
    $direccion = $_POST["direcion"];
    $cp = $_POST["cp"];

    if (empty($_FILES['imagen']['name'][0])) {
        $img = 0;
    } else {
        $img = $_FILES['imagen'];
    }

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail, "nif" => $nif, "direcion" => $direccion, "cp" => $cp); //mail base de datos y contraseña

    $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email', 'nif', 'direcion', 'cp'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {
        //Consulta de update
        if ($img == 0) {
            $imagen = 0;
        } else {
            $imagen = $funcionesU->anadirImagen($id, $img);
        }

        $consulta->actualizarDatosUsuario($id, $nombre, $apellido1, $apellido2, $telefono, $mail, $nif, $direccion, $cp, $imagen);

        $datos = $consulta->datosUsuario($id);
        $formularios->registroDatosPorUsuario($datos);
    } else {
        $formularios->registroDatosPorUsuario($datos, $necesarios);
    }
} else {
    $formularios->registroDatosPorUsuario($datos);
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
