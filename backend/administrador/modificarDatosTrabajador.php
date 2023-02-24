<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;

$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["codigo"])) {
    $numero = (isset($_POST["id"])) ? $_POST["id"] : $_GET["codigo"];

    $fila = $consulta->comprobarDatosTrabajador($numero);
    $rol= $consulta->rolesTrabajadores();
    if (isset($_POST["actualizar"])) {

        $id = ($_POST["id"] == $fila["id_trabajador"]) ? $fila["id_trabajador"] : $_POST["id"];
        $nie = trim(($_POST["nie"] == $fila["nie_trabajador"]) ? $fila["nie_trabajador"] : $_POST["nie"]);
        $pasaporte = trim(($_POST["pasaporte"] == $fila["pasaporte_trabajador"]) ? $fila["pasaporte_trabajador"] : $_POST["pasaporte"]);
        $nombre = ucfirst(trim(($_POST["nombre"] == $fila["nombre"]) ? $fila["nombre"] : $_POST["nombre"]));
        $apellido1 = ucfirst(trim(($_POST["apellido1"] == $fila["apellido1"]) ? $fila["apellido1"] : $_POST["apellido1"]));
        $apellido2 = ucfirst(trim(($_POST["apellido2"] == $fila["apellido2"]) ? $fila["apellido2"] : $_POST["apellido2"]));
        $telefono = trim(($_POST["telefono"] == $fila["num_telef"]) ? $fila["num_telef"] : $_POST["telefono"]);
        $trabajando = trim(($_POST["trabajando"] == $fila["trabajando"]) ? $fila["trabajando"] : $_POST["trabajando"]);
        $privilegios = ($_POST["privilegios"] == $fila["id_rol"]) ? $fila["id_rol"] : $_POST["privilegios"];

        if ($_POST["correo"] == $fila["correo"]) {
            $correo = trim($fila["correo"]);
            $estado = "activado";
        } else {
            echo $correo = trim($_POST["correo"]);
            $estado = "desactivado";
        }

        $consulta->actualizarDatosTrabajador($id, $nie, $pasaporte, $nombre, $apellido1, $apellido2, $correo, $telefono, $privilegios, $estado, $trabajando);
        $fila2 = $consulta->comprobarDatosTrabajador($numero);
        echo "<center><h1><b>Datos actualizados<b></h1></center>";
        $formularios->datosEmpleado($fila2,$rol);
        
    } else if (isset($_POST["eliminar"])) {
        $nombre=$_POST["nombre"];
        $consulta->eliminarTrabajador($numero);
     
         header("Location:/proyecto/backend/administrador/trabajadores.php?mensaje=Empleado $nombre fue eliminad@");
        
    } else {
       // $numero = $_GET["codigo"];
        $formularios->datosEmpleado($fila,$rol);
    }
} else {
    header("Location:/proyecto/backend/administrador/indexAdministrador.php");
}


require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
