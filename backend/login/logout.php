<?php
/**
 * Cierra la session y nos lleva a login
 */
require_once '../sesiones/sesiones.php';

comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Carrito as carrito;

if (!empty($_SESSION['carrito'])) {
    $c = new carrito();
    $agregado = $c->add($_SESSION['usuario'], $_SESSION['carrito']);
    if (!$agregado) {
        echo "Por alguna razón no se pudo guardar tu cesta";
    }
}

$_SESSION = array(); //Destruye las variables de sesión
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
        <div class="container main mt-5">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>Cierre de sesión.</h3>
                </div>
                <div class="card-body text-center">
                    <p>La sesión se ha cerrado correctamente, hasta la próxima.</p>
                </div>
                <div class="d-flex justify-content-center my-3">
                    <a href = "/proyecto/index.php?red=true" class='btn btn-default btn-outline-success'>Ir a la página principal</a>
                </div>
            </div>
        </div>

        <?php
        require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");

        