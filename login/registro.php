<?php
session_start();
include "funciones_login.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $mail = $_POST['mail'];
    $contra = $_POST['pass'];
    $contra2 = $_POST['pass2'];

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail, "password" => $contra, "password2" => $contra2); //mail base de datos y contraseña

    $necesarios = campos(['nombre', 'apellido1', 'telefono', 'email', 'password', 'password2'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {

        static $cont = 0;
        if (contraseña($contra, $contra2) && correo($mail) == "pepe@gmail.com") { //datos sql
            // aqui se le indica que se le envio un codigo de comprovacion al mail
            //cookis($nombre, $valor, $tiempo);
            htmlRegistro($necesarios);
           comprobartoken( );
 

} else {

}
} else {

htmlRegistro($necesarios);
} 

}else{
htmlRegistro();
}