<?php

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
//include "../../autoloadClasesLogin.php";

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\Mails as mailAdministrador;

$formularios = new formulariosAdministrador;
$funciones = new funcionesLogin;
$consulta = new consultasAdministrador;
$envioMail = new mailAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = ($_POST['apellido2']) ? $_POST['apellido2'] : null;
    $telefono = $_POST['telefono'];
    $mail = ($funciones->correo($_POST['mail'])) ? $funciones->correo($_POST['mail']) : "";
    $telefono = (strlen($telefono) == 9) ? $telefono : "";
    $telefono = (is_numeric($telefono)) ? $telefono : "";
    $nie = $_POST['nie'];
    $pasaporte = $_POST['pasaporte'];
    $privilegios =$_POST['rol']; 
    $fecha = $funciones->fechaHoraActual();

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail, "nie"=>$nie ,"pasaporte"=>$pasaporte,"privilegios"=>$privilegios); //mail base de datos y contraseña

    $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email','nie', 'pasaporte', 'privilegios'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {

        // aqui se le indica que se le envio un codigo de comprovacion al mail
        $token = intval(rand(100000, 900000) * 25 / 4 + 3);
        //      $token = 123456;
        $token2 = password_hash($token, PASSWORD_DEFAULT);
        $envioMail->mail($mail, $nombre, $token);

        $consulta->añadirTrabajador($nombre, $apellido1, $apellido2, $token2, $mail, $telefono, $privilegios, $fecha, $nie, $pasaporte);
 
        //if ($necesarios == true) {
            $mensaje2="<h2> Empleado<b> $nombre </b> registrado con éxito.</h2>";
            $formularios->htmlRegistroEmpleados($necesarios,$mensaje2);

          /*   
        } else {
            $formularios->htmlRegistro($necesarios);
        }*/
    } else {

        $formularios->htmlRegistroEmpleados($necesarios);
    }
} else {
    
    $formularios->htmlRegistroEmpleados();
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
