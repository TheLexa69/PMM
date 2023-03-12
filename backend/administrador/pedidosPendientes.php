<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
sesionAdministrador(); 
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\Mails as mailAdministrador;

$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador($_SESSION['administrador'][1]);
$envioMail = new mailAdministrador;

$formularios->FiltrarReservasFecha();
$fecha = !empty(($_POST['fecha'])) ? $_POST['fecha'] : date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aceptar'])) {

        $selecionadas = $_POST['confirmado'];
        foreach ($selecionadas as $a) {
            $reserva = "si";
            $id = $a;
            $consulta->actualizarPedidos($id,$reserva);
        }

       $fila = $consulta->comprobarPedidosPorFecha($fecha);
        $formularios->tablaPedidos($fila);
    } else {

       
        
        $fila = $consulta->comprobarPedidosPorFecha($fecha);
        $formularios->tablaPedidos($fila);
    }
} else {
  
 
    $fila = $consulta->comprobarPedidosPorFecha($fecha);

    if (!empty($fila)) {
        $formularios->tablaPedidos($fila);
    } else {
        $fecha1=date("j-m-y");
        echo "<h1 class='  text-center'>No hay Pedidos pendientes para el dia $fecha1 </h1>";
    }
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");

