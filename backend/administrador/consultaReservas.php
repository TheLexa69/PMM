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
    if (isset($_POST['aceptar'])) {
   
        $selecionadas  = $_POST['confirmado'];
        $email=$_POST['correo'];
        $nombre=$_POST['nombre'];
        foreach ($selecionadas  as $a) {
            $reserva = "si";
            $id = $a;
            $consulta->actualizarReservas($id, $reserva);
        } 
        $mensaje=$formularios->mensageReserva();
        $envioMail->mailReservas($email, $nombre, $mensaje);
        $fila = $consulta->comprobarReservas();

        $formularios->tablaReservas($fila);
  
    
    } else if( (isset($_POST['rechazar']))){ 
        $selecionadas = $_POST['confirmado'];
        $email=$_POST['correo'];
         $nombre=$_POST['nombre'];
        foreach ($selecionadas as $a) {
            $reserva = "denegada";
            $id = $a;
            $consulta->actualizarReservas($id, $reserva);
        } 
        $mensaje=$formularios->mensageReserva("cancelada");
        $envioMail->mailReservas($email, $nombre, $mensaje);
        $fila = $consulta->comprobarReservas();

        $formularios->tablaReservas($fila);
         
    }
} else {

    $fila = $consulta->comprobarReservas(0);

    if (!empty($fila)) {
        $formularios->tablaReservas($fila, "pendientes");
    } else {
       echo "<h1 class='  text-center'>No hay reservas por validar </h1>";
    }
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
