<?php

 require   dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."backend".DIRECTORY_SEPARATOR."sesiones".DIRECTORY_SEPARATOR."sesiones.php";
 comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

 

use \clases\FormulariosUsuario as formulariosUsuario;
use \clases\ConsultasUsuario as consultasUsuario;
use \clases\FuncionesLogin as funcionesLogin;

$formularios = new formulariosUsuario;
$consulta = new consultasUsuario;
$funciones = new funcionesLogin;
 $id=$_SESSION["usuario"];

$datos=$consulta->datosUsuario($id);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre=$_POST["nombre"];
    $apellido1=$_POST["apellido1"]; 
    $telefono=$_POST["apellido2"];
    $mail=$_POST["mail"];
    $nif=$_POST["nif"];
    $direcion=$_POST["direcion"];
    $cp=$_POST["cp"]; 
     
    
    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail ,"nif"=>$nif ,"direcion"=>$direcion, "cp"=>$cp); //mail base de datos y contraseña

    $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email', 'nif', 'direcion','cp'], $campos);
 
if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {
    $formularios->registroDatosPorUsuario($datos,$necesarios);
}else{
    $formularios->registroDatosPorUsuario($datos,$necesarios);
}
 


}else{
$formularios->registroDatosPorUsuario($datos);
}
 
 

 
 require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
