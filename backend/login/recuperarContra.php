<?php 
include "../../autoloadClasesLogin.php";
 
use \clases\formularios as formulariosLogin;
use \clases\funciones as funcionesLogin;
use  consultas as consultasLogin;
use \clases\mails as mailLogin;
 
$formularios= new formulariosLogin;
$funciones= new funcionesLogin;
$consulta= new consultasLogin;
$envioMail = new mailLogin;
 

 
    
     if (isset($_POST['mailr'])) {

        $mail = $_POST['mailr'];
        
        Try {
          
            $datos= $consulta->comprobarDatos($mail);
           if(!empty($datos)){
            $mailBd = $datos['correo'];
            $nombre=$datos['nombre'];
            
            
              $token = intval(rand(100000, 900000) * 25 / 4 + 3);
            // $token = 123456;
             $token2 = password_hash($token, PASSWORD_DEFAULT);
              $envioMail->mail($mail,$nombre,$token);
              $consulta->quitarActivacion($mail, $token2);
               
              $formularios-> contrastaToken( $mailBd );
            
            }
            else{
                $mensaje="<b>".$mail."</b>   No existe en nuestra base de datos<br>";
               $formularios->recuperar($mensaje);
            }
            
            
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
             
     }else{
  
    $formularios->recuperar();
}
