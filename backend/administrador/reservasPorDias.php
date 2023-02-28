<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\Mails as mailAdministrador;

$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador;
$envioMail = new mailAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['validar'])) {
        $fecha = $_POST['fecha'];

        $formularios->FiltrarReservasFecha();
        $fila = $consulta->comprobarReservasPorFecha($fecha);
         
        if (empty($fila)) {
            echo "<h1 class='  text-center'>No hay reservas en esta fecha $fecha </h1>";
        } else {
            $formularios->tablaReservas($fila);
        }
    } else {
        $formularios->FiltrarReservasFecha();
        $fila = $consulta->comprobarReservasPorFecha();
        $formularios->tablaReservas($fila);
    }
} else {

    $formularios->FiltrarReservasFecha();
    $fila = $consulta->comprobarReservasPorFecha();
    $formularios->tablaReservas($fila);
}







require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
