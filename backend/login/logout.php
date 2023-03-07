<?php
/**
 * Cierra la session y nos lleva a login
 */
require_once '../sesiones/sesiones.php';

comprobar_sesion();
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
use \clases\Carrito as carrito;
if (!empty($_SESSION['carrito'])) {
    $c = new carrito();
    $agregado = $c->add($_SESSION['usuario'], $_SESSION['carrito']);
    if (!$agregado) {
        echo "Por alguna razón no se pudo guardar tu cesta";
    }
}
<<<<<<< Updated upstream
$_SESSION=array(); //Destruye las variables de sesión
=======

$_SESSION = array(); //Destruye las variables de sesión
>>>>>>> Stashed changes
session_destroy(); // Eliminaa la sesion
//setcookie(session_name(), 123, time() - 1000); // Elimina la cookie de sesión
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Sesión cerrada</title>
    </head>
    <body>
<<<<<<< Updated upstream
        <p>Sesión se cerrada correctamente, hasta la próxima</p>
        <a href = "/proyecto/index.php">Ir a la página principal</a>
<?php
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
=======
        <div class="container bg-light rounded mt-5 w-50 p-3">
            <div class="text-center">
                <p>La sesión se ha cerrado correctamente, hasta la próxima.</p>
            </div>
            <div class="d-flex justify-content-center">
                <a href = "/proyecto/index.php?red=true" class='btn btn-default btn-outline-success'>Ir a la página principal</a>
            </div>
>>>>>>> Stashed changes

