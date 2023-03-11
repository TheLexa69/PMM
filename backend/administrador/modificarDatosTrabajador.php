<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\FiltroDatos as filtrado;
use \clases\FuncionesLogin as funciones;

$funciones = new funciones;
$filtro = new filtrado;
$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["codigo"])) {

    $numero = (isset($_POST["id"])) ? $_POST["id"] : $_GET["codigo"];
    if (isset($_POST["id"])) {
        $_POST = $filtro->validarPost($_POST);
    }

    $fila = $consulta->comprobarDatosTrabajador($numero);
    $rol = $consulta->rolesTrabajadores();
    if (isset($_POST["actualizar"])) {

        $id = ($_POST["id"] == $fila["id_trabajador"]) ? $fila["id_trabajador"] : $_POST["id"];
        $nombre = ucfirst(($_POST["nombre"] == $fila["nombre"]) ? $fila["nombre"] : $_POST["nombre"]);
        $apellido1 = ucfirst(($_POST["apellido1"] == $fila["apellido1"]) ? $fila["apellido1"] : $_POST["apellido1"]);
        $apellido2 = ucfirst(($_POST["apellido2"] == $fila["apellido2"]) ? $fila["apellido2"] : $_POST["apellido2"]);
        $telefono = ($_POST["telefono"] == $fila["num_telef"]) ? $fila["num_telef"] : $_POST["telefono"];
        $telefono = $filtro->verificarDatos("[0-9]{9,9}", $telefono);
        $telefono = (strlen($telefono) == 9) ? $telefono : "";
        $trabajando = ($_POST["trabajando"] == $fila["trabajando"]) ? $fila["trabajando"] : $_POST["trabajando"];
        $privilegios = ($_POST["privilegios"] == $fila["id_rol"]) ? $fila["id_rol"] : $_POST["privilegios"];
        $pasaporte = ($_POST["pasaporte"] == $fila["pasaporte_trabajador"]) ? $fila["pasaporte_trabajador"] : $_POST["pasaporte"];
        $nie = ( $_POST['nie'] == $fila["nie_trabajador"]) ? $fila["nie_trabajador"] : "";

        $nie2 = 0;
        if ($nie == "") {
            if ($filtro->validaDniCifNie($_POST['nie'])) {
                $nie = $_POST['nie'];
            } else {
                $nie2 = 1;
                $mensaje3 = "<h2> Empleado<b> $nombre </b> <a style='color:red'>NIE INCORRECTO</a>.</h2>";
            }
        }

        if ($_POST["correo"] == $fila["correo"]) {
            $correo = trim($fila["correo"]);
            $estado = "activado";
        } else {
            echo $correo = trim($_POST["correo"]);
            $estado = "desactivado";
        }



        if (empty($nie) || $nie != "" && empty($pasaporte)) {

            $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "nie" => $nie, "pasaporte" => $pasaporte);
            $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'nie', 'pasaporte'], $campos);
        } else {
            if (empty($nie)) {

                $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "pasaporte" => $pasaporte);
                $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'pasaporte'], $campos);
            } else if (empty($pasaporte) || !$nie2 == 1 && $nie != "") {

                $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "nie" => $nie);
                $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'nie'], $campos);
            }
        }


        if (!is_string($necesarios)) {

            $consulta->actualizarDatosTrabajador($id, $nie, $pasaporte, $nombre, $apellido1, $apellido2, $correo, $telefono, $privilegios, $estado, $trabajando);
            $fila2 = $consulta->comprobarDatosTrabajador($numero);
            $mensaje = "Datos actualizados";
            $formularios->datosEmpleado($fila2, $rol, $necesarios = true, $mensaje);
        } else {
            $fila2 = $consulta->comprobarDatosTrabajador($numero);
            if (isset($mensaje3)) {
                $mensaje = $mensaje3;
            } else {
                $mensaje = "Datos incorrectos";
            }

            $formularios->datosEmpleado($fila2, $rol, $necesarios, $mensaje);
        }
    } else if (isset($_POST["eliminar"])) {
        $nombre = $_POST["nombre"];
        $consulta->eliminarTrabajador($numero);

        header("Location:/proyecto/backend/administrador/trabajadores.php?mensaje=Empleado $nombre fue eliminad@");
    } else {
        // $numero = $_GET["codigo"];
        $formularios->datosEmpleado($fila, $rol, $necesarios = true);
    }
} else {
    header("Location:/proyecto/backend/administrador/indexAdministrador.php");
}


require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
