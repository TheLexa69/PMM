<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

        <title>Inicio</title>
    </head>
    <body>


<?php
 require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
include "../../autoloadClasesLogin.php";
use \clases\formularios as formulariosLogin;
use \clases\funciones as funcionesLogin;
use  consultas as consultasLogin;
use \clases\mails as mailLogin;
 
$formularios= new formulariosLogin;
$funciones= new funcionesLogin;
$consulta= new consultasLogin;
$envioMail = new mailLogin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = ($_POST['apellido2'])?$_POST['apellido2']:null;
    $telefono = $_POST['telefono'];
    $mail = ($funciones->correo($_POST['mail'])) ? $funciones->correo($_POST['mail']) : "";
    $telefono = (strlen($telefono) == 9) ? $telefono : "";
    $telefono = (is_numeric($telefono)) ? $telefono : "";
    $nif=null;
    $direccion=null;
    $cp=null; 
    
    
    $rol = 1;
    $fecha = $funciones->fechaActual(); 
    
    
    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail); //mail base de datos y contraseña

    $necesarios = $funciones->campos(['nombre', 'apellido1', 'telefono', 'email'],$campos);
 
    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {

        // aqui se le indica que se le envio un codigo de comprovacion al mail
           $token = intval(rand(100000, 900000) * 25 / 4 + 3);
       //      $token = 123456;
             $token2 = password_hash($token, PASSWORD_DEFAULT);
           $envioMail->mail($mail,$nombre,$token); 
           
            $consulta->añadirUsuario($nombre, $apellido1, $apellido2, $token2, $mail, $telefono, $rol, $fecha,$nif,$direccion,$cp);
      
       
        if ($necesarios == true) {

            $formularios->contrastaToken($mail);

            // header("Location: comprobarToken.php");
        } else {
            $formularios->htmlRegistro($necesarios);
        }
    } else {

        $formularios->htmlRegistro($necesarios);
    }
} else {
    if(isset($_GET['registro'])){
       echo $mensaje="<h2><b>No estas registrado date de alta por favor</b></h2>";
    }
    $formularios->htmlRegistro();
}

  require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>
  </body>
</html>