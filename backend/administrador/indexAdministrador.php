<?php
require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
$tipoAdministrador = tipoDeSesionAdministrador();

include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;

if ($tipoAdministrador == 1) {

    $formularios = new formulariosAdministrador;

    $formularios->redirecionesAdministrador();
    
} else if ($tipoAdministrador == 2) {
    echo"Eres Gestor";
} else if ($tipoAdministrador == 3) {
    echo"Eres Trabajador";
} else {
    header("Location:/proyecto/backend/login/indexLogin.php");
}

 

include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
