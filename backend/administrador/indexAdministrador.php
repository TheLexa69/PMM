<?php
//session_start();
require   dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."backend".DIRECTORY_SEPARATOR."sesiones".DIRECTORY_SEPARATOR."sesiones.php";
comprobar_sesionAdministrador();
include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
use \clases\FormulariosAdministrador as formulariosAdministrador;
$formularios = new formulariosAdministrador;


 
$formularios->redirecionesAdministrador();









include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");