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

    if (isset($_POST["mail"])) {
        $mail = $_POST["mail"];
    }



    if ($_POST["pass"] == $_POST["pass2"]) {
        $contranueva = $_POST["pass"];
        $contra = password_hash($contranueva, PASSWORD_DEFAULT);

        try {
          $stmt= $c->nuevaContraseña($mail,$contra);
          
           
            if ($stmt->rowCount() > 0) {
                unset($conexion);
                unset($stmt);
                 header("Location: login.php");
            }   

            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    } else {
        $a->contraMail($mail);
    }
}
