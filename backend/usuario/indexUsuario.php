<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();

include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosUsuario as formulariosUsuario;

$formularios = new formulariosUsuario;

$formularios->redirecionesUsuario();

include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
