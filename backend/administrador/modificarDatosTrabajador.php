<?php
require   dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."backend".DIRECTORY_SEPARATOR."sesiones".DIRECTORY_SEPARATOR."sesiones.php";
comprobar_sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

echo "El codigo del trabajador es ".$_GET["codigo"];

 require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");