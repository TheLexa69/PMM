<?php
require_once "../conexion/conexion.php";
include "funciones_login.php";
session_start();

if (isset($_COOKIE["sessionTemporal"])) {

    $datos = explode(",", $_COOKIE["sessionTemporal"]);

    $nombre = $datos[0];
    $mail = $datos[4];
    $contra = $datos[2]; //la contra que esta en la cookie
    //$contra= password_verify($token, $contra); //$token es el de base de datos //$contra es la de la cooki

    if (!isset($_POST["testigo"])) {
        echo "Registro correcto!!!   <br> <b>Rebise su Email para finalizar el proceso</b><br> ----No cierre el navegador gracias---";
    }
    if (isset($_POST["validar"])) {

        try {
            $conexion = conexion();
            $token = $_POST['token'];

            $sql = "select * from usuario where correo=? and contraseña=? and nombre=?";

            $stmt = $conexion->prepare($sql);
            $stmt->execute(array($mail, $contra, $nombre));

            $datossql = array();

            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $datossql = $fila;
            }


            $datossql["id_usuario"];

            $hash = $datossql["contraseña"]; //contiene hash base de datos


            $bool = false;

            if (password_verify($token, $hash)) { //$contra es la de la cooki // $hash es el de base de datos
                $boll = true;
            } else {
                $bool = false;
            }


            unset($conexion);
           if(isset($boll)){
               contraMail();
           }else{
               tokenMail();
           }
            
        } catch (PDOException $e) {
            echo 'No conectado';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    } else {

        tokenMail();
    }
} else {
    ?><p> "NO PUEDE ESTAR AQUI. VUELVA A LA PAGINA  PRINCIPAL... ->"<a href=login.php> <b style="color:red">PRINGAD@</b><a/> !!!!!!</p><?php
}