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
    if (isset($_POST['confirmado'])) {

        $aceptadas = $_POST['confirmado'];
        foreach ($aceptadas as $a) {
            $reserva = "si";
            $id = $a;
            $consulta->actualizarReservas($id, $reserva);
        }

        $fila = $consulta->comprobarReservas();

        $formularios->tablaReservas($fila);
    } else {
        
    }
} else {

    $fila = $consulta->comprobarReservas(0);

    if (!empty($fila)) {
        $formularios->tablaReservas($fila, "pendientes");
    } else {
        $consulta2 = new consultasAdministrador;
        $fila = $consulta2->comprobarReservas();
         
        $formularios->tablaReservas($fila);
    }
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
