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
 

 
    
     if (isset($_POST['mailr'])) {

        $mail = $_POST['mailr'];
        
        Try {
          
            $datos= $consulta->comprobarDatos($mail);
           if(!empty($datos)){
            $mailBd = $datos['correo'];
            $nombre=$datos['nombre'];
            
            
              $token = intval(rand(100000, 900000) * 25 / 4 + 3);
            // $token = 123456;
             $token2 = password_hash($token, PASSWORD_DEFAULT);
              $envioMail->mail($mail,$nombre,$token);
              $consulta->quitarActivacion($mail, $token2);
               
              $formularios-> contrastaToken( $mailBd );
            
            }
            else{
                $mensaje="<b>".$mail."</b>   No existe en nuestra base de datos<br>";
               $formularios->recuperar($mensaje);
            }
            
            
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
             
     }else{
  
    $formularios->recuperar();
}

  require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>
  </body>
</html>