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
use consultas as consultasLogin;
use \clases\mails as mailLogin;
  
$formularios= new formulariosLogin;
$funciones= new funcionesLogin;
$consulta= new consultasLogin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $token = $_POST['token'];
      
     $mail = $_POST['mail'];
    
     //es el token generado
    //$tokenGenerado = $_POST['tokenGenerado'];
    //$contra= password_verify($token, $contra); //$token es el de base de datos //$contra es la de la cooki
    static $cont = 0;
    if (isset($_POST["testigo"]) && $cont = 0) {
        echo "Registro correcto!!!   <br> <b>Rebise su Email para finalizar el proceso</b><br> ----No cierre el navegador gracias---";
        $cont++;
    }


    try {
        
        $token = $_POST['token']; // token que se envio al mail

          $mail;
         
      $datos=$consulta->comprobarDatos($mail);
        
         
        $datos["id_usuario"];
        $hash = $datos["contraseña"]; //contiene hash base de datos

        $bool = false;

        if (password_verify($token, $hash)) { //$token es el del formulario // $hash es el de base de datos
            $boll = true;
        } else {
            $bool = false;
        } 
        
        unset($conexion);
        
        if (isset($boll)) {
         
            $formularios->contrasena($mail);
        } else {
            
        $formularios->tokenMal($mail);
        }
    } catch (PDOException $e) {
        echo 'No conectado';
        die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
    }
} else {
     header("Location:/proyecto/backend/login/login.php");
    
}

  require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>
  </body>
</html>