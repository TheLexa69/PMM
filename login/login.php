<?php

session_start();
include "funciones_login.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_COOKIE['access_error']) && $_COOKIE['access_error'] > 6) {
        //al 7º intento de sesion se manda aqui
        header("Location: index.php");
    }

    if (isset($_COOKIE['sessionTemporal'])&& isset($_POST['mail']) && isset($_POST['pass']) ) {
        
        $mail = $_POST['mail'];
        $contra = $_POST['pass'];

        $campos = array("email" => $mail, "password" => $contra); //mail base de datos y contraseña
        $necesarios = campos(['email', 'password'], $campos);

        if (!isset($_POST['login']) || (isset($_POST['login']) && !is_string($necesarios))) {

            $tiempo = 300;
            if (contraseña($contra, "sql contraseña") && correo($mail) == " mail sql") {  ////sql mail y contraseña sql
                //redirecionar a la pagina correspondiente
                // cookis($nombre, $valor, $tiempo);
                // header("location:http://localhost/examen_1_eva/proyectos.php");
            } else {

                if (isset($_COOKIE['access_error'])) {
                    // Caduca en un año 
                    setcookie('access_error', $_COOKIE['access_error'] + 1, time() + $tiempo);
                    $access_error = $_COOKIE['access_error'];

                    html("Revisa contraseña y correo", "Numero de intentos maximos 6 lleva: " . $access_error . " Si alcanza el maximo no podra ingresar en 5 min");
                } else {
                    // Caduca en un año 
                    setcookie('access_error', 2, time() + $tiempo);
                    html("Revisa contraseña y correo");
                }
            }
        } else {
            html("No ha puesto datos de loggin");
        }
    } else {
        html();
    }
} else {
    html();
}