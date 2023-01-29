<?php
require_once "../conexion/conexion.php";
include "funciones_login.php";
//include"mail_reset.php";

   
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $mail = (correo($_POST['mail']))?correo($_POST['mail']):"";
    
    
    $telefono =(strlen($telefono) == 9)?$telefono:"";
    $telefono =(is_numeric($telefono))?$telefono:"";
      
    $rol="registrado";
    $fecha = fechaActual();
    // $contra = $_POST['pass'];
    // $contra2 = $_POST['pass2'];
    //, "password" => $contra, "password2" => $contra2  , 'password', 'password2'

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail); //mail base de datos y contraseña

    $necesarios = campos(['nombre', 'apellido1', 'telefono', 'email'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {
 
        // aqui se le indica que se le envio un codigo de comprovacion al mail
        // echo $token = intval(rand(100000, 900000) * 25 / 4 + 3);
        $token=123456;
        $token2 = password_hash($token, PASSWORD_DEFAULT);
        // mail($mail, $nombre, $token);

        try {
            $conexion = conexion();

            $sql = "INSERT INTO usuario (nombre,apellido1 ,apellido2,contraseña,correo,num_telef, rol,fecha) VALUES (:nombre,:apellido1,:apellido2,:contrasena,:correo,:num_telef,:rol,:fecha)";

            $stmt = $conexion->prepare($sql);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':contrasena', $token2, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':num_telef', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':rol',$rol , PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

            $stmt->execute();
  
            unset($conexion);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            if($e->getCode()==23000){
                echo 'Mail ya registrado <br>';
            }else{
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }}

        if ($necesarios == true) {
             
            contrastaToken($token2,$mail,$nombre);
   
            // header("Location: comprobarToken.php");
        } else {
            htmlRegistro($necesarios);
        }
    } else {

        htmlRegistro($necesarios);
    }
} else {
    htmlRegistro();
}


 