<?php

include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosLogin as formulariosLogin;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\ConsultasLogin as consultasLogin;
use \clases\ConsultasAdministrador as consultasAdministrador;

$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin;
$consultaTrabajador = new consultasAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['mail'])) {
        $trabajas = $_POST['trabajo'];
        $mail = $_POST['mail'];
        $contra = $_POST['pass'];
        Try {

            $datos = $consulta->comprobarDatos($mail);
            $datosTrabajador = $consultaTrabajador->comprobarDatosTrabajador($mail);

            if (!empty($datos["correo"])) {
                $verificado = $datos["estado_usuario"];
                $hash = $datos["contraseña"];
                $mailBd = $datos["correo"];
                $rol = $datos["id_rol"];
            }
            if (!empty($datosTrabajador["correo"])) {
                $TrabajadorVerificado = $datosTrabajador["estado_trabajador"];
                $hashTrabajador = $datosTrabajador["contraseña"];
                $mailBdTrabajador = $datosTrabajador["correo"];
                $roltrabajador = $datosTrabajador["id_rol"];
            }

            if (!empty($datos["correo"]) || !empty($datosTrabajador["correo"])) {


                if (isset($verificado) || isset($TrabajadorVerificado)) {

                    if ($TrabajadorVerificado == "desactivado" && $trabajas == "SI") {

                        $formularios->contrastaToken($mailBdTrabajador, $roltrabajador);
                    } else if ($verificado == "desactivado") {

                        $formularios->contrastaToken($mailBd, $rol);
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

                                if ($rol == 4 && $trabajas == "NO") {
                                    if (password_verify($_POST['pass'], $hash) && $funciones->correo($mail) == $mailBd) {  ////sql mail y contraseña sql
                                        // cookis($nombre, $valor, $tiempo);
                                        try {
                                            $datos = $consulta->comprobarDatos($mail);

                                            $id_usuario = $datos["id_usuario"];
                                            $rol = $datos ["id_rol"];
                                            $fecha = $funciones->fechaHoraActual();
                                            $consulta->registroHoraSession($id_usuario, $fecha);
                                            setcookie('access_error', $_COOKIE['access_error'] + 1, time() - $tiempo);
                                            session_start();
                                            // $usu tiene campos correo y codRes, correo 

                                            $_SESSION['usuario'] = array($id_usuario, $rol); //array de dos elementos
                                            $_SESSION['carrito'] = [];

                                            header("Location: /proyecto/index.php");
                                        } catch (PDOException $e) {

                                            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
                                        }
                                    } else {
 
                                        if (isset($_COOKIE['access_error'])) {
                                            // Caduca en un año 
                                            setcookie('access_error', $_COOKIE['access_error'] + 1, time() + $tiempo);
                                            $access_error = $_COOKIE['access_error'];

                                            $formularios->html("Revisa contraseña y correo", "Numero de intentos maximos 6 lleva: " . $access_error . " Si alcanza el maximo no podra ingresar en 5 min");
                                        } else {

                                            setcookie('access_error', 2, time() + $tiempo);
                                            $formularios->html("Revisa contraseña y correo");
                                        }
                                    }
                                } else {




                                    if (password_verify($_POST['pass'], $hashTrabajador) && $funciones->correo($mail) == $mailBdTrabajador) {  ////sql mail y contraseña sql
                                     
                                        try {

                                            $datosTrabajador = $consultaTrabajador->comprobarDatosTrabajador($mailBdTrabajador);

                                            $id_trabajador = $datosTrabajador["id_trabajador"];
                                            $roltrabajador = $datosTrabajador["id_rol"];
                                            $fecha = $funciones->fechaHoraActual();
                                            $consultaTrabajador->registroHoraSessionTrabajador($id_trabajador, $fecha);
                                            setcookie('access_error', $_COOKIE['access_error'] + 1, time() - $tiempo);
                                            session_start();
                                            // $usu tiene campos correo y codRes, correo 

                                            $_SESSION['usuario'] = array($id_trabajador, $roltrabajador); //array de dos elementos


                                            header("Location: /proyecto/index.php");
                                        } catch (PDOException $e) {

                                            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
                                        }
                                    } else {

                                        if (isset($_COOKIE['access_error'])) {
                                            // Caduca en un año 
                                            setcookie('access_error', $_COOKIE['access_error'] + 1, time() + $tiempo);
                                            $access_error = $_COOKIE['access_error'];

                                            $formularios->html("Revisa contraseña y correo", "Numero de intentos maximos 6 lleva: " . $access_error . " Si alcanza el maximo no podra ingresar en 5 min");
                                        } else {

                                            setcookie('access_error', 2, time() + $tiempo);
                                            $formularios->html("Revisa contraseña y correo");
                                        }
                                    }
                                }
                            } else {
                                $formularios->html("No ha puesto datos de loggin");
                            }
                        } else {
                            $formularios->html();
                        }
                    }
                }
            } else {
                header("Location: /proyecto/backend/login/registro.php?registro=no");
            }
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
} else {
    $formularios->html();
}
include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
