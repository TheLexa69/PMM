<?php
/**
 * Cierra la session y nos lleva a login
 */
require_once '../sesiones/sesiones.php';
comprobar_sesionAdministrador();

$_SESSION=array(); //Destruye las variables de sesión
session_destroy(); // Eliminaa la sesion
//setcookie(session_name(), 123, time() - 1000); // Elimina la cookie de sesión
header("Location: /proyecto/index.php");
?>
 