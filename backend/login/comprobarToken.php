<?php

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
//include "../../autoloadClasesLogin.php";

use \clases\FormulariosLogin as formulariosLogin;
use \clases\FuncionesLogin as funcionesLogin; 
use \clases\ConsultasLogin as consultasLogin;
use \clases\ConsultasAdministrador as consultasAdministrador;
 
$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin;
$consultaAdministrador = new consultasAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol=$_POST["rol"];
    $token = $_POST['token'];
    $mail = $_POST['mail'];

    //es el token generado
    //$tokenGenerado = $_POST['tokenGenerado'];
    //$contra= password_verify($token, $contra); //$token es el de base de datos //$contra es la de la cooki
    static $cont = 0;
    if (isset($_POST["testigo"]) && $cont = 0) {
        echo "Registro correcto!!!   <br> <b>Rebise su Email para finalizar el proceso</b><br> ----No cierre el navegador gracias---";
        $cont++;
    }
 
    try {

        $token = $_POST['token']; // token que se envio al mail

        if($rol==4 ){  

        $datos = $consulta->comprobarDatos($mail);
         $datos["id_usuario"];
        }else{
        $datos = $consultaAdministrador->comprobarDatosTrabajador($mail);
         $datos["id_trabajador"];
        }
        
       
        $hash = $datos["contraseña"]; //contiene hash base de datos

        $bool = false;

        if (password_verify($token, $hash)) { //$token es el del formulario // $hash es el de base de datos
            $boll = true;
        } else {
            $bool = false;
        }

        unset($conexion);

        if (isset($boll)) {

            $formularios->contrasena($mail,$rol);
        } else {

            $formularios->tokenMal($mail,$rol);
        }
    } catch (PDOException $e) {
        echo 'No conectado';
        die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
    }
} else {
    header("Location:/proyecto/backend/login/login.php");
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
