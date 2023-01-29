<?php
require_once "../conexion/conexion.php";
include "funciones_login.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
        $conexion = conexion();
        $token = $_POST['token']; // token que se envio al mail

        $sql = "select * from usuario where correo=?";

        $stmt = $conexion->prepare($sql);

        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }

        $datos["id_usuario"];
        $hash = $datos["contraseña"]; //contiene hash base de datos

        $bool = false;

        if (password_verify($token, $hash)) { //$token es el del formulario // $hash es el de base de datos
            $boll = true;
        } else {
            $bool = false;
        } 
        
        unset($conexion);
        if (isset($boll)) {
         contraseña($mail);
        } else {
            
        tokenMal($mail);
        }
    } catch (PDOException $e) {
        echo 'No conectado';
        die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
    }
} else {
    ?><p> "NO PUEDE ESTAR AQUI. VUELVA A LA PAGINA  PRINCIPAL... ->"<a href=login.php> <b style="color:red">PRINGAD@</b><a/> !!!!!!</p><?php
}