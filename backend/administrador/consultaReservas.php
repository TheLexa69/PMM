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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aceptar'])) {

        $selecionadas = $_POST['confirmado'];
        $email = $_POST['correo'];
        $nombre = $_POST['nombre'];
        foreach ($selecionadas as $a) {
            $reserva = "si";
            $id = $a;
            $consulta->actualizarReservas($id, $reserva);
        }
        $mensaje = $formularios->mensageReserva();
        $fila = $consulta->comprobarReservas();

        $formularios->tablaReservas($fila);
    } else if ((isset($_POST['rechazar']))) {
        $selecionadas = $_POST['confirmado'];
        $email = $_POST['correo'];
        $nombre = $_POST['nombre'];
        foreach ($selecionadas as $a) {
            $reserva = "denegada";
            $id = $a;
            $consulta->actualizarReservas($id, $reserva);
        }
        $mensaje = $formularios->mensageReserva("cancelada");
        $envioMail->mailReservas($email, $nombre, $mensaje);
        $fila = $consulta->comprobarReservas();

        $formularios->tablaReservas($fila);
    }
} else {

    $fila = $consulta->comprobarReservas(0);

    if (!empty($fila)) {
        $formularios->tablaReservas($fila, "pendientes");
    } else {
        ?>
        <div class="bg-light p-2 fs-5">
            <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "administrador" . DIRECTORY_SEPARATOR . "indexAdministrador.php"; ?>">Panel administrador</a> > Validar Reservas
        </div>
        <?php
        echo "<div class='main container bg-light mt-5'>
               <div class='card'>
                <div class='card-header text-center'>
                    <h3>Validar Reservas</h3>
                </div>
                <div class='card-body text-center'>
                    <h4>No hay reservas por validar</h4>
                </div>
            </div>
            </div>";
    }
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");

