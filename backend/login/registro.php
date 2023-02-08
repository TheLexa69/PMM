<?php
//include "../login/funciones_login.php";
 include "../clases/formularios.php";
 include "../clases/funciones.php";
 include "../clases/consultas.php";
//include"mail_reset.php";
    $a = new formularios; //(1,2,3,4,5,6,7,8,9,10,11,12);
    $b= new funciones;
    $c= new consultas;
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $telefono = $_POST['telefono'];
    $mail = ($b->correo($_POST['mail']))?$b->correo($_POST['mail']):"";
    $estado_usuario="desactivado";
    $nif=0;
    $direccion=0;
    $cp=0;
    
    $telefono =(strlen($telefono) == 9)?$telefono:"";
    $telefono =(is_numeric($telefono))?$telefono:"";
      
    $rol=1;
    $fecha = $b->fechaActual();
    // $contra = $_POST['pass'];
    // $contra2 = $_POST['pass2'];
    //, "password" => $contra, "password2" => $contra2  , 'password', 'password2'

    $campos = array("nombre" => $nombre, "apellido1" => $apellido1, "telefono" => $telefono, "email" => $mail); //mail base de datos y contraseña

    $necesarios = $b->campos(['nombre', 'apellido1', 'telefono', 'email'], $campos);

    if (!isset($_POST['registro']) || (isset($_POST['registro']) && !is_string($necesarios))) {
 
        // aqui se le indica que se le envio un codigo de comprovacion al mail
        // echo $token = intval(rand(100000, 900000) * 25 / 4 + 3);
        $token=123456;
        $token2 = password_hash($token, PASSWORD_DEFAULT);
        // mail($mail, $nombre, $token);

      $c->añadirUsuario($nombre,$apellido1,$apellido2,$token2,$mail,$telefono,$rol,$fecha,$estado_usuario,$nif,$direccion,$cp);

        if ($necesarios == true) {
             
           $a->contrastaToken($mail);
   
            // header("Location: comprobarToken.php");
        } else {
         $a->htmlRegistro($necesarios);   
        }
    } else {

       $a->htmlRegistro($necesarios); 
    }
} else {
    $a->htmlRegistro();
}

