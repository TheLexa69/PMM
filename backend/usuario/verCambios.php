<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosUsuario as formulariosUsuario;
use \clases\ConsultasUsuario as consultasUsuario;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\FuncionesUsuario as funcionesUsuario;

$formularios = new formulariosUsuario;
$consulta = new consultasUsuario($_SESSION['rolUsusario'][0]);
$funciones = new funcionesLogin;
$funcionesU = new funcionesUsuario;
 
$id = $_SESSION["usuario"];

if (!empty($_POST['orden'])) {
    $orden = $_POST['orden'];
}
$orden = (isset($orden)) ? $orden : "";

$datos = $consulta->solicitarDatosCambiados($id, $orden);
$formularios->formularioCambiosPerfil($datos);

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
