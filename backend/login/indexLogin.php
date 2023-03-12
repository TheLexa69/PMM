<?php

require_once '../sesiones/sesiones.php';
comprobar_sesiones();
include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosLogin as formulariosLogin;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\ConsultasLogin as consultasLogin;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\FiltroDatos as filtrado;

$filtro = new filtrado;
$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin();
$consultaTrabajador = new consultasAdministrador();

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['mail'])) {

        $_POST = $filtro->validarPost($_POST);

        $trabajas = $_POST['trabajo'];
        $mail = ($funciones->correo($_POST['mail'])) ? $funciones->correo($_POST['mail']) : "";
        $contra = $_POST['pass'];
        try {

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
                $TrabajadorVerificado = (!empty($TrabajadorVerificado)) ? $TrabajadorVerificado : "";
                $verificado = (!empty($verificado)) ? $verificado : "";

                if ($TrabajadorVerificado == "desactivado" && $trabajas == "SI") {
                    $formularios->contrastaToken($mailBdTrabajador, $roltrabajador);
                } else if ($verificado == "desactivado" && $trabajas == "NO") {
                    $formularios->contrastaToken($mailBd, $rol);
                } else {

                    if (isset($_COOKIE['access_error']) && $_COOKIE['access_error'] >= 6) {
                        $formularios->html("No puede entrar por 5 min por superar el maximo numero de intentos hora local " . $funciones->hora() . " Si hace otro intento el contador se reinicia");
                        exit();
                    }

                    if (isset($_POST['mail']) && isset($_POST['pass'])) {
                        $campos = array("email" => $mail, "password" => $contra); //mail base de datos y contraseña
                        $necesarios = $funciones->campos(['email', 'password'], $campos);

                        if (!isset($_POST['login']) || (isset($_POST['login']) && !is_string($necesarios))) {
                            $tiempo = 370;

                            if ($rol == 4 && $trabajas == "NO") {
                                if (password_verify($_POST['pass'], $hash) && $funciones->correo($mail) == $mailBd) {  ////sql mail y contraseña sql
                                    // cookis($nombre, $valor, $tiempo);
                                    try {
                                        $datos = $consulta->comprobarDatos($mail);

                                        $id_usuario = $datos["id_usuario"];
                                        $rol = $datos ["id_rol"];
                                        $fecha = $funciones->fechaHoraActual();
                                        $consulta2 = new consultasLogin($rol);
                                        $consulta2->registroHoraSession($id_usuario, $fecha);
                                        
                                        // session_start();
                                        // $usu tiene campos correo y codRes, correo 
                                        //$_SESSION['rol'] = $datos["id_rol"];
                                        $_SESSION['mail'] = $datos['correo'];
                                        $_SESSION['usuario'] = $id_usuario; //array de dos elementos
                                        $_SESSION['rolUsusario'] =$rol;
                                        // $_SESSION['carrito'] = [];
                                        if (isset($_GET['redirigido'])) {
                                            header("Location: /proyecto/backend/cart/index_carrito.php");
                                        } else {
                                            header("Location: /proyecto/index.php");
                                        }
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
                                        $consultaTrabajador2 = new consultasAdministrador($roltrabajador);
                                        $consultaTrabajador2->registroHoraSessionTrabajador($id_trabajador, $fecha);

                                        //   session_start();
                                        // $usu tiene campos correo y codRes, correo 
                                        $_SESSION['administrador'] = array($id_trabajador, $roltrabajador); //array de dos elementos
                                        
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
