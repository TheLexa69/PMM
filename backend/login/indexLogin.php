<?php

include "../../autoloadClasesLogin.php";

use \clases\formularios as formulariosLogin;
use \clases\funciones as funcionesLogin;
use consultas as consultasLogin;

$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['mail'])) {

        $mail = $_POST['mail'];
        $contra = $_POST['pass'];
        Try {

            $datos = $consulta->comprobarDatos($mail);

            if (!empty($datos["correo"])) {
                $verificado = $datos["estado_usuario"]; 
                $hash = $datos["contraseña"];
                 $mailBd = $datos["correo"];
                // $verificado="desactivado"  entonces no acabo el registro
                if ($verificado == "desactivado") {
               
                //campo verificado
                
                    $formularios->contrastaToken($mailBd);
                } else {



                    if (isset($_COOKIE['access_error']) && $_COOKIE['access_error'] > 6) {
                        //al 7º intento de sesion se manda aqui
                        // header("Location: index.php");
                        echo"No puede entrar por 5 min por superar el maximo numero de intentos";
                    }

                    if (isset($_POST['mail']) && isset($_POST['pass'])) {


                        $campos = array("email" => $mail, "password" => $contra); //mail base de datos y contraseña
                        $necesarios = $funciones->campos(['email', 'password'], $campos);

                        if (!isset($_POST['login']) || (isset($_POST['login']) && !is_string($necesarios))) {

                            $tiempo = 300;
                            if (password_verify($_POST['pass'], $hash) && $funciones->correo($mail) == $mailBd) {  ////sql mail y contraseña sql
                                //redirecionar a la pagina correspondiente
                                // cookis($nombre, $valor, $tiempo);
                                // header("location:http://localhost/examen_1_eva/proyectos.php");
                                try {
                                    $datos = $consulta->comprobarDatos($mail);

                                    $id_usuario = $datos["id_usuario"];
                                    session_start();
                                    // $usu tiene campos correo y codRes, correo 

                                    $_SESSION['usuario'] = $id_usuario; //array de dos elementos
                                    $_SESSION['carrito'] = [];

                                    header("Location: /proyecto/index.php");
                                    return;
                                } catch (PDOException $e) {
                                    echo 'Accion no realizada porque:<br>';
                                    die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
                                }
                            } else {

                                if (isset($_COOKIE['access_error'])) {
                                    // Caduca en un año 
                                    setcookie('access_error', $_COOKIE['access_error'] + 1, time() + $tiempo);
                                    $access_error = $_COOKIE['access_error'];

                                    $formularios->html("Revisa contraseña y correo", "Numero de intentos maximos 6 lleva: " . $access_error . " Si alcanza el maximo no podra ingresar en 5 min");
                                } else {
                                    // Caduca en un año 
                                    setcookie('access_error', 2, time() + $tiempo);
                                    $formularios->html("Revisa contraseña y correo");
                                }
                            }
                        } else {
                            $formularios->html("No ha puesto datos de loggin");
                        }
                    } else {
                        $formularios->html();
                    }
                }
            } else {
                $formularios->htmlRegistro();
            }


            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
} else {
    $formularios->html();
}
 

