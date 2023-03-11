<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

//include "../../autoloadClasesLogin.php";

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\Mails as mailAdministrador;
use \clases\FiltroDatos as filtrado;
 
$filtro = new filtrado;
$formularios = new formulariosAdministrador;
$funciones = new funcionesLogin;
$consulta = new consultasAdministrador;
$envioMail = new mailAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST = $filtro->validarPost($_POST);
    $nombre = $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['nombre']);
    $apellido1 = $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['apellido1']);
    $apellido2 = ($_POST['apellido2']) ? $filtro->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]", $_POST['apellido2']) : null;
    $mail = ($funciones->correo($_POST['mail'])) ? $funciones->correo($_POST['mail']) : "";
    $telefono = $filtro->verificarDatos("[0-9]{9,9}", $_POST['telefono']);
    $telefono = (strlen($telefono) == 9) ? $telefono : "";
    $nie2=true;
    if(!empty($_POST['nie'])){
          $nie = ( $filtro->validaDniCifNie($_POST['nie'])) ? $_POST['nie'] : "";
          $nie2 =$filtro->validaDniCifNie($_POST['nie']);
           
    }
    $pasaporte = (!empty($_POST['pasaporte']))?$_POST['pasaporte']: "";
    $error=$filtro->validaDniCifNie($_POST['nie']);
    $privilegios = $_POST['rol'];
    $fecha = $funciones->fechaHoraActual();
   
    
    if(!$nie2){
             $mensaje3 = "<h2> Empleado<b> $nombre </b> <a style='color:red'>NIE INCORRECTO</a>.</h2>";
    }

    if (empty($nie) || empty($pasaporte)) {

        if (!empty($nie) && !empty($pasaporte)) {
           
            $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail, "nie" => $nie, "pasaporte" => $pasaporte, "privilegios" => $privilegios); 
            $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email', 'nie', 'pasaporte', 'privilegios'], $campos);
        } else {
            if (empty($nie)) {
            
                $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail,  "pasaporte" => $pasaporte, "privilegios" => $privilegios); 
                 $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email', 'pasaporte', 'privilegios'], $campos);
            } else if (empty($pasaporte) && !$nie2== false) {
             
                $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail, "nie" => $nie,  "privilegios" => $privilegios); 
                $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email', 'nie', 'privilegios'], $campos);
            }
        }
    }
 

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {

        // aqui se le indica que se le envio un codigo de comprovacion al mail
        $token = intval(rand(100000, 900000) * 25 / 4 + 3);
        //      $token = 123456;
        $token2 = password_hash($token, PASSWORD_DEFAULT);
        $envioMail->mail($mail, $nombre, $token);
        $consulta->añadirTrabajador($nombre, $apellido1, $apellido2, $token2, $mail, $telefono, $privilegios, $fecha, $nie, $pasaporte);
         
        $mensaje2 = "<h2> Empleado<b> $nombre </b> registrado con éxito.</h2>";
        $formularios->htmlRegistroEmpleados($necesarios, $mensaje2);
 
    } else {
if(!$nie2){
    $formularios->htmlRegistroEmpleados($necesarios,$mensaje3);
}else{
        $formularios->htmlRegistroEmpleados($necesarios );
    }}
} else {

    $formularios->htmlRegistroEmpleados();
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
