<?php
//funcion que recoge loggin
function html($err = " ", $num = " ") {
    ?>

    <html lang="ES">
        <head>
            <title>title</title>
        </head>
        <body>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <h2>Login:</h2>
                <label for="c1" class="form-label">Mail:</label><br>     
                <input type="email" name="mail" class="form-control" id="c1"  <?php
                if (!empty($_POST['mail'])) {
                    echo " value='" . $_POST['mail'] . "'";
                }
                ?>   ><br>
                <label for="c2" class="form-label">Contraseña:</label><br>
                <input type="password" name="pass" class="form-control" id="c2"  ><br><br>
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
function htmlRegistro($necesarios = "") {
    ?>

    <html lang="ES">
        <head>
            <title>title</title>
        </head>
        <body>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <h2>Registro:</h2>
                <label for="c1" class="form-label">Nombre:</label><br>
                <input type="text" name="nombre" class="form-control" id="c1" <?php
                if (!empty($_POST['nombre'])) {
                    echo " value='" . $_POST['nombre'] . "'";
                }
                ?> ><br>
                <label for="c2" class="form-label">Primer Apellido:</label><br>
                <input type="text" name="apellido1" class="form-control" id="c2" <?php
                if (!empty($_POST['apellido1'])) {
                    echo " value='" . $_POST['apellido1'] . "'";
                }
                ?> ><br>
                <label for="c3" class="form-label">Segundo Apellido:</label><br>
                <input type="text" name="apellido2" class="form-control" id="c3" <?php
                if (!empty($_POST['apellido2'])) {
                    echo " value='" . $_POST['apellido2'] . "'";
                }
                ?> ><br>
                <label for="c4" class="form-label">Mail:</label><br>     
                <input type="email" name="mail" class="form-control" id="c4"  <?php
                if (!empty($_POST['mail'])) {
                    echo " value='" . $_POST['mail'] . "'";
                }
                ?>   ><br>
                <label for="c5" class="form-label">Telefono:</label><br>
                <input type="text" name="telefono" class="form-control" id="c5" <?php
                if (!empty($_POST['telefono'])) {
                    echo " value='" . $_POST['telefono'] . "'";
                }
                ?>   ><br>
                <br> 


                <input type="submit" name="registro">
                <?php
                if (!empty($_POST['registro']) && $necesarios !== true) {
                    //Enseña los campos que faltan al usuario
                    $necesarios = str_replace('apellido1', 'primer apellido', $necesarios);
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


function contrastaToken($token2,$mail,$nombre){

           ?> 
    
    <html lang="ES">
        <head>
        </head>
        <body>
            <div  > 
                <form   action= "comprobarToken.php " method="POST">
                    <h2>Comprobar Mail</h2>
                    <div  >
                        <label for="c" class="form-label">Codigo Mail:</label><br>
                        <input type="password" class="form-control" id="c" name="token"><br><br>
                        <input type="hidden" name="testigo" >
                      
                        <input type="hidden" name="mail" value="<?php if (!empty($mail)){echo $mail;}?>">
                        
                    </div>
                    <input type="submit" name="validar" value="Activar Cuenta" ></input>
                </form> 
            </div>

        </body> 
    </html>
    <?php
}

 


function tokenMail() {
    ?> 
    <!DOCTYPE html>
    <html lang="ES">
        <head>
        </head>
        <body>
            <div  > 
                <form   action= "comprobarToken.php " method="POST">
                    <h2>Comprobar Mail</h2>
                    <div  >
                        <label for="c" class="form-label">Codigo Mail <b>INCORRECTO</b> vuelva a ponerlo:</label><br><br>
                        <input type="password" class="form-control" id="c" name="token"><br><br>
                        <input type="hidden" name="testigo" >
                       
                    </div>
                    <input type="submit" name="validar" value="Activar Cuenta" ></input>
                </form> 
            </div>

        </body> 
    </html>
    <?php
}


function tokenMal($mail){

  ?>  
            <html lang="ES">
        <head>
        </head>
        <body>
            <div  > 
                <form   action= "comprobarToken.php " method="POST">
                    <h2>Comprobar Mail</h2>
                    <div  >
                        <label for="c" class="form-label">Codigo Mail <b>INCORRECTO</b> vuelva a ponerlo:</label><br><br>
                        <input type="password" class="form-control" id="c" name="token"><br><br>
                        <input type="hidden" name="testigo" >
             
                        <input type="hidden" name="mail" value="<?php if (!empty($mail)){echo $mail;}?>">
                      
                    </div>
                    <input type="submit" name="validar" value="Activar Cuenta" ></input>
                </form> 
            </div>

        </body> 
    </html>
    <?php


}
 



function contraseña($mail){
   ?>
            <html lang="ES">
                <head>
                </head>
                <body>
                    <div  >
                        <form   action="guardarContraseña.php" method="POST">

                            <label for="c2" class="form-label">Escriba su contraseña:</label><br>
                            <label for="c3" class="form-label">Contraseña:</label><br>
                            <input type="password" name="pass" class="form-control" id="c3"  ><br>
                            <label for="c4" class="form-label">Repite contraseña:</label><br>
                            <input type="password" name="pass2" class="form-control" id="c4"  ><br><br> 
                            <input type="hidden" name="mail" value="<?php if (!empty($mail)) {echo $mail;} ?>">
                            
                            <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR"></input>
                        </form> 
                    </div>
                </body>
            </html>
            <?php

}
 


function contraMail() {
    ?>
    <html lang="ES">
        <head>
        </head>
        <body>
            <div  >
                <form   action="guardarContraseña.php" method="POST">

                    <label for="c2" class="form-label">Escriba su contraseña:</label><br>
                    <label for="c3" class="form-label">Contraseña:</label><br>
                    <input type="password" name="pass" class="form-control" id="c3"  ><br>
                    <label for="c4" class="form-label">Repite contraseña:</label><br>
                    <input type="password" name="pass2" class="form-control" id="c4"  ><br><br> 
                    <input type="hidden" name="mail" value="<?php if (!empty($mail)){echo $mail;}?>">
                    <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR"></input>
                </form> 
            </div>
        </body>
    </html>
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



function texto($texto) {
    /*
     * Función que compruebe que la cadena recibida sólo acepta letras, incluyendo tildes
     */
    $pattern = '/[a-zA-ZáéíóúÁÉÍÓÚñÑ]$/';
    return preg_match($pattern, $texto);
}
/*
function contrasenas($pass, $pass2) {

    if ($pass == $pass2) {
        return true;
    } else {
        return false;
    }
}*/

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

function hora() {
    $a = getdate(time());
    return $a["hours"] . ":" . $a["minutes"] . ":" . $a["seconds"];
}

function fechaActual() {
    return $fecha_actual = date("Y-m-d ");
}
