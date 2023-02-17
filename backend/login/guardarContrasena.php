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

    if (isset($_POST["mail"])) {
        $mail = $_POST["mail"];
    }



    if ($_POST["pass"] == $_POST["pass2"]) {
        $contranueva = $_POST["pass"];
        $contra = password_hash($contranueva, PASSWORD_DEFAULT);

        try {
          $stmt= $consulta->nuevaContraseña($mail,$contra);
          
           
            if ($stmt->rowCount() > 0) {
                unset($conexion);
                unset($stmt);
                 header("Location:/proyecto/backend/login/indexLogin.php");
              //  echo "falla la ruta XD";
            }   

            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    } else {
        $formularios->contraMail($mail);
    }
}

  require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>
  </body>
</html>