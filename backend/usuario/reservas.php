<?php
require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosUsuario as formulariosUsuario;
use \clases\ConsultasUsuario as consultasUsuario;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\FuncionesUsuario as funcionesUsuario;

$formularios = new formulariosUsuario;
$consulta = new consultasUsuario;
$funciones = new funcionesLogin;
$funcionesU = new funcionesUsuario;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $restaurante = $_POST['restaurante'];
    $turno = $_POST['turno'];
    $id = $_SESSION['usuario'];
    $mesa = !empty($_POST['mesa']) ? $_POST['mesa'] : 0;
    if ($mesa == 0) {
        echo 'No hay mesas disponibles';
        ?>
        <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'usuario' . DIRECTORY_SEPARATOR . "indexUsuario.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Cancelar</a>
        <?php
    } else {
        $consulta->hacerReserva($id, $restaurante, $mesa, $fecha, $turno);
    }
} else {
    $restaurante = $consulta->restaurantes();
    $mesas = $consulta->mesas();
    $formularios->formularioReserva($restaurante, $mesas);
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
?>