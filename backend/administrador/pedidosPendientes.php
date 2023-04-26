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
            $consulta->actualizarPedidos($id, $reserva);
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
        $fecha1 = date("j-m-y");
        echo '<div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">';
        echo ' No hay Pedidos pendientes para el dia ' . $fecha1;
        echo ' </div>';
        echo "<tr><td class='text-center'></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        echo "<script defer>
              window.onload = function() {
              var mensajeDiv = document.getElementById('mensaje');
              mensajeDiv.style.top = '20%';
              setTimeout(function() {
                    mensajeDiv.style.top = '-150%';
                    }, 5000);
                    }
              </script>";
    }
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");

