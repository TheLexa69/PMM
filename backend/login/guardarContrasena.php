<?php

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

//include "../../autoloadClasesLogin.php";

use \clases\Formularios as formulariosLogin;
use \clases\Funciones as funcionesLogin;
use \clases\Consultas as consultasLogin;

$formularios = new formulariosLogin;
$funciones = new funcionesLogin;
$consulta = new consultasLogin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["mail"])) {
        $mail = $_POST["mail"];
    }



    if ($_POST["pass"] == $_POST["pass2"]) {
        $contranueva = $_POST["pass"];
        $contra = password_hash($contranueva, PASSWORD_DEFAULT);

        try {
            $stmt = $consulta->nuevaContraseña($mail, $contra);

            if ($stmt->rowCount() > 0) {
                unset($conexion);
                unset($stmt);
                header("Location:/proyecto/backend/login/indexLogin.php");
                //  echo "falla la ruta XD";
            }

            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    } else {
        $formularios->contraMail($mail);
    }
}

require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
