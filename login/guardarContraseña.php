<?php

session_start();
require_once "../conexion/conexion.php";
include "funciones_login.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_COOKIE["sessionTemporal"])) {

        $datos = explode(",", $_COOKIE["sessionTemporal"]);

        
        $mail = $datos[4];
         
        if (contraseña($_POST["pass"], $_POST["pass2"])) {
            $contra = $_POST["pass"];
            try {
                $conexion = conexion();

                $sql = 'UPDATE usuario SET contraseña=:contrasena where correo=:correo';

                $stmt = $conexion->prepare($sql);

                $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);

                $stmt->execute();

                if ($stmt == true) {
                    header("Location: login.php");
                } else {
                    echo "fallo la insercion";
                }

                unset($conexion);
            } catch (PDOException $e) {
                echo 'Accion no realizada porque:<br>';
                if ($e->getCode() == 23000) {
                    echo "<br>El correo introducido <b>ya existe</b> en la base de datos.<br><br> ";
                }
                die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
            }
        }
    }
}