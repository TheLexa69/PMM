<?php
//funcion que recoge loggin
function html($err = " ",$num=" " ) {
    ?>


    <html>
        <head>
            <title>title</title>
        </head>
        <body>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <h2>Login:</h2>
                Mail:<br>     
                <input type="email" name="mail"   <?php if(!empty($_POST['mail'])){ echo " value='" . $_POST['mail'] . "'";} ?>   ><br>
                Contraseña:<br>
                <input type="password" name="pass"   ><br><br>
                <input type="submit" name="login">
                <br> <?php echo $err; ?><br> 
                     <?php echo $num; ?> <br>
                
                     <p> <a href='recuperarContra.php 'style="color:red">Recuperar</a><b> tu contraseña!!!  </b></p> 
                     <p> <b>No estas dado de alta!!!  </b><a href='registro.php 'style="color:blue">Registrate</a> para tener mas ventajas</p>
            </form>
       
           
        
        </body>
    </html>

    <?php
}
//funcion que recoge datos de registro
function htmlRegistro($necesarios="") {
    ?>

    <html>
        <head>
            <title>title</title>
        </head>
        <body>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <h2>Registro:</h2>
                Nombre:<br>
                <input type="text" name="nombre" <?php if(!empty($_POST['nombre'])){ echo " value='" . $_POST['nombre'] . "'";} ?> ><br>
                Primer Apellido:<br>
                <input type="text" name="apellido1" <?php if(!empty($_POST['apellido1'])){ echo " value='" . $_POST['apellido1'] . "'";} ?> ><br>
                Segundo Apellido:<br>
                <input type="text" name="apellido2" <?php if(!empty($_POST['apellido2'])){ echo " value='" . $_POST['apellido2'] . "'";} ?> ><br>
                Mail:<br>     
                <input type="email" name="mail"   <?php if(!empty($_POST['mail'])){ echo " value='" . $_POST['mail'] . "'";} ?>   ><br>
                Telefono:<br>
                <input type="text" name="telefono" <?php if(!empty($_POST['telefono'])){ echo " value='" . $_POST['telefono'] . "'";} ?>   ><br>
                Contraseña:<br>
                <input type="password" name="pass"   ><br>
                Repite contraseña:<br>
                <input type="password" name="pass2"   ><br><br>
                <input type="submit" name="registro">
           
                <?php
                
                if (!empty($_POST['registro']) && $necesarios !== true) {
                  //Enseña los campos que faltan al usuario
                            $necesarios = str_replace('apellido1', 'primer apellido', $necesarios );        
                           // $necesarios = str_replace('apellido2', 'segundo apellido', $necesarios);
                            $necesarios = str_replace('password', 'contraseña', $necesarios);
                           // $necesarios = str_replace('password2', 'confirmación de la contraseña',$necesarios);
                            $necesarios = str_replace('email', 'correo', $necesarios);
                         echo "<br><br><b style=color:red>Faltan campos obligatorios:</b> <br>$necesarios";
                        }
                    ?>
                
            </form>

        </body>
    </html>

    <?php
}

function comprobartoken( ) {
 ?>
  <div >
                <form action="comprobarToken.php" method="POST">
                    <input type="hidden" name="pass" <?php if(!empty($_POST['pass'])){ echo " value='" . $_POST['pass'] . "'";} ?> ><br>
                    <input type="hidden" name="mail" <?php if(!empty($_POST['mail'])){ echo " value='" . $_POST['mail'] . "'";} ?>>
                    <input type="submit" value="Verificar Cuenta">
                </form>
    </div>
<?php
}

 
 
function campos(array $campos, $requeridos) {
    $noCubiertos = [];
    foreach ($campos as $campo) {
        if (empty($requeridos[$campo])) {
            $noCubiertos[] = $campo;
        }
    }
    if (sizeof($noCubiertos) > 0) {
        $respuesta = implode(', ', $noCubiertos);
    } else {
        $respuesta = true;
    }
    return $respuesta;
}
 
 



 
  if (!empty($_POST['send_register']) && $required !== true) {
           //Para que nos muestre en castellano los campos que faltan
                $required = str_replace('name', 'nombre', $required);
                $required = str_replace('password_confirm', 'confirmación de la password', $required);
                $required = str_replace('birthday', 'fecha de nacimiento', $required);
                echo "Faltan campos obligatorios: $required";
            }


function texto($texto) {
    /*
     * Función que compruebe que la cadena recibida sólo acepta letras, incluyendo tildes
     */
    $pattern = '/[a-zA-ZáéíóúÁÉÍÓÚñÑ]$/';
    return preg_match($pattern, $texto);
}

function contraseña($pass, $pass2) {
       
    if ($pass == $pass2) {
        return true;
    } else{
    return false;}
    
}

function correo($mail) {

    return filter_var($mail, FILTER_SANITIZE_EMAIL);
}
/*
 function cookis($var1, $var2 = " ", $var3 = " ") {
             
            if (empty($var3)) {
                $cook1 = setcookie($var1, $var2);
            } else { 
                $cook1 = setcookie($var1, $var2, time() + $var3);
                 
            }

            if ($cook1) {
                echo "cookie creada<br>";
            }
        }
*/