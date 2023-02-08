<?php
//require_once "../conexion/conexion.php";
//include "funciones_login.php";

include "../clases/formularios.php";
include "../clases/funciones.php";
include "../clases/consultas.php";
$a= new formularios;
$b= new funciones;
$c= new consultas;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['mail'])) {

        $mail = $_POST['mail'];
        $contra = $_POST['pass'];
        Try {
            $datos= $c->comprobarDatos($mail);
            
            $verificado = "si"; //$datos["verificado"]; //campo verificado
            
            $mailBd = $datos["correo"];
             $hash = $datos["contraseña"];
            
            if ($verificado == "si") {
                unset($conexion);
                unset($stmt);
               

             $a-> contrastaToken( $mailBd );
            } else {



                if (isset($_COOKIE['access_error']) && $_COOKIE['access_error'] > 6) {
                    //al 7º intento de sesion se manda aqui
                   // header("Location: index.php");
                    echo"No puede entrar por 5 min por superar el maximo numero de intentos";
                }

                if (isset($_POST['mail']) && isset($_POST['pass'])) {
 

                    $campos = array("email" => $mail, "password" => $contra); //mail base de datos y contraseña
                    $necesarios = $b->campos(['email', 'password'], $campos);

                    if (!isset($_POST['login']) || (isset($_POST['login']) && !is_string($necesarios))) {

                        $tiempo = 300;
                        if (password_verify($_POST['pass'], $hash) && $b->correo($mail) == $mailBd) {  ////sql mail y contraseña sql
                            //redirecionar a la pagina correspondiente
                            // cookis($nombre, $valor, $tiempo);
                            // header("location:http://localhost/examen_1_eva/proyectos.php");
                            echo "entro loggeado";
                        } else {

                            if (isset($_COOKIE['access_error'])) {
                                // Caduca en un año 
                                setcookie('access_error', $_COOKIE['access_error'] + 1, time() + $tiempo);
                                $access_error = $_COOKIE['access_error'];

                               $a-> html("Revisa contraseña y correo", "Numero de intentos maximos 6 lleva: " . $access_error . " Si alcanza el maximo no podra ingresar en 5 min");
                            } else {
                                // Caduca en un año 
                                setcookie('access_error', 2, time() + $tiempo);
                                $a->html("Revisa contraseña y correo");
                            }
                        }
                    } else {
                        $a->html("No ha puesto datos de loggin");
                    }
                } else {
                    $a->html();
                }
            }

            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
} else {
    $a->html();
}
 