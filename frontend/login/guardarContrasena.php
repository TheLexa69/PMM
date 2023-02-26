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

    if (isset($_POST["mail"])) {
        $mail = $_POST["mail"];
    }



    if ($_POST["pass"] == $_POST["pass2"]) {
        $contranueva = $_POST["pass"];
        $contra = password_hash($contranueva, PASSWORD_DEFAULT);
        $rol=$_POST["rol"];
        try {
          

                if($rol==4 ){  
                    $stmt = $consulta->nuevaContraseña($mail,$contra);
                
                }else{
                    $stmt = $consultaAdministrador->nuevaContraseñaTrabajador($mail,$contra);
                   
                }
        
            
            if ($stmt->rowCount() > 0) {
                unset($conexion);
                unset($stmt);
                header("Location:/proyecto/backend/login/indexLogin.php");
                //  echo "falla la ruta XD";
            }

            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
           
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    } else {
        $formularios->contraMail($mail,$rol);
    }
} else {
    header("Location:/proyecto/backend/login/indexLogin.php");
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
