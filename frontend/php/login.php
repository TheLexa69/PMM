<?php
define('DS', DIRECTORY_SEPARATOR);
//require  __DIR__.DS."backend".DS."sesiones".DS."sesiones.php";
// comprobar_sesion();
session_start();
?>
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

        <?php require(__DIR__ . DS . "nav.php"); ?>

        <?php
       $ruta=dirname(dirname(__DIR__));
        require($ruta. DS . "backend" . DS . "login" . DS . "indexLogin.php"); ?>


        <?php require(__DIR__ . DS . "footer.php"); ?>
    </body>
</html>