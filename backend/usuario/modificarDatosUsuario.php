<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosUsuario as formulariosUsuario;
use \clases\ConsultasUsuario as consultasUsuario;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\FuncionesUsuario as funcionesUsuario;
use \clases\FiltroDatos as filtrado;

$filtro = new filtrado;
$formularios = new formulariosUsuario;
$consulta = new consultasUsuario($_SESSION['rolUsusario'][0]);
$funciones = new funcionesLogin;
$funcionesU = new funcionesUsuario;
$id = $_SESSION["usuario"];

$datos = $consulta->datosUsuario($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_POST = $filtro->validarPost($_POST);

    $nombre = ucfirst(($_POST["nombre"] == $datos["nombre"]) ? $datos["nombre"] : $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['nombre']));

    $apellido1 = ucfirst(($_POST["apellido1"] == $datos["apellido1"]) ? $datos["apellido1"] : $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST["apellido1"]));
    $apellido2 = ucfirst(($_POST["apellido2"] == $datos["apellido2"]) ? $datos["apellido2"] : $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST["apellido2"]));
    $apellido2 = (!empty($_POST["apellido2"])) ? ucfirst($filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST["apellido2"])) : "";
    $telefono = ($_POST["telefono"] == $datos["num_telef"]) ? $datos["num_telef"] : $_POST["telefono"];
    $telefono = $filtro->verificarDatos("[0-9]{9,9}", $telefono);
    $telefono = (strlen($telefono) == 9) ? $telefono : "";
    $mail = ($_POST["mail"] == $datos["correo"]) ? $datos["correo"] : $funciones->correo($_POST["mail"]);
    $direccion = ($_POST["direcion"] == $datos["direccion"]) ? $datos["direccion"] : $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ 0-9]{5}", $_POST["direcion"]);
    $cp = ($_POST["cp"] == $datos["cp"]) ? $datos["cp"] : $_POST["cp"];
    $cp = $filtro->verificarDatos("[0-9]{5,5}", $cp);
    $cp = (strlen($cp) == 5) ? $cp : "";
    $nif = ( $_POST['nif'] == $datos["NIF"]) ? $datos["NIF"] : "";

    if ($nif == "") {
        if ($filtro->validaDniCifNie($_POST['nif'])) {
            $nif = $_POST['nif'];
        } else {

            $mensaje2 = "<h2>Estimado cliente <b> $nombre </b> el NIF introducido era <a style='color:red'>INCORRECTO</a>.</h2>";
        }
    }

    if (empty($_FILES['imagen']['name'][0])) {
        $img = 0;
    } else {
        $img = $_FILES['imagen'];
    }

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail, "nif" => $nif, "direcion" => $direccion, "cp" => $cp); //mail base de datos y contraseña

    $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email', 'nif', 'direcion', 'cp'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {
        //Consulta de update
        if ($img == 0) {
            $imagen = 0;
        } else {
            $imagen = $funcionesU->anadirImagen($id, $img);
        }

        $consulta->actualizarDatosUsuario($id, $nombre, $apellido1, $apellido2, $telefono, $mail, $nif, $direccion, $cp, $imagen);

        $datos = $consulta->datosUsuario($id);
        $formularios->registroDatosPorUsuario($datos, $necesarios);
    } else {


        if (isset($mensaje2)) {

            $formularios->registroDatosPorUsuario($datos, $necesarios, $mensaje2);
        } else {
            $formularios->registroDatosPorUsuario($datos, $necesarios);
        }
    }
} else {
    $formularios->registroDatosPorUsuario($datos, $necesarios = true);
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
