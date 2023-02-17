<?php
 namespace clases;
 class formularios {
      
//funcion que recoge loggin
public function html($err = " ", $num = " ") {
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

     
    
    public function htmlRegistro($necesarios = "") {
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


public function recuperar($mensaje="") {
    ?>

    <html lang="ES">
        <head>
            <title>title</title>
        </head>
        <body>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <h2>Mail con el que te diste de alta:</h2>
                <?php echo $mensaje; ?><br> 
                <label for="c1" class="form-label">Correo electrónico :</label><br>     
                <input type="email" name="mailr" class="form-control" id="c1"  <?php
                if (!empty($_POST['mail'])) {
                    echo " value='" . $_POST['mail'] . "'";
                }
                ?>   > 
                 
                <input type="submit" name="ENVIAR MAIL">
                  
            </form>



        </body>
    </html>

    <?php
}






public function contrastaToken( $mail){

           ?> 
    
    <html lang="ES">
        <head>
        </head>
        <body>
            <div  > 
                <form   action= "comprobarToken.php " method="POST">
                    <h2><b>Revise su Email y ponga el código de verificación para finalizar el proceso</b></h2>
                   
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

 
 


public function tokenMal($mail){

  ?>  
            <html lang="ES">
        <head>
        </head>
        <body>
            <div  > 
                <form   action= "comprobarToken.php " method="POST">
                    <h2>Comprobar Mail</h2><br>
                   
                    <div  >
                        <label for="c" class="form-label">Codigo Mail <b>INCORRECTO</b> vuelva a ponerlo:</label><br><br>
                        <input type="password" class="form-control" id="c" name="token"><br><br>
                        <input type="hidden" name="testigo"  >
             
                        <input type="hidden" name="mail" value="<?php if (!empty($mail)){echo $mail;}?>">
                      
                    </div>
                    <input type="submit" name="validar" value="Activar Cuenta" ></input>
                </form> 
            </div>

        </body> 
    </html>
    <?php


}
 



public function contrasena($mail){
   ?>
            <html lang="ES">
                <head>
                </head>
                <body>
                    <div  >
                        <form   action="guardarContrasena.php" method="POST">

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
 


public function contraMail($mail) {
    ?>
         <html lang="ES">
            <head>
            </head>

            <body>
                <div  >
                    <form   action="guardarContrasena.php" method="POST">
                        <h1>Tienen que ser iguales</h1>   
                        <label for="c2" class="form-label">Escriba su contraseña:</label><br>
                        <label for="c3" class="form-label">Contraseña:</label><br>
                        <input type="password" name="pass" class="form-control" id="c3"  ><br>
                        <label for="c4" class="form-label">Repite contraseña:</label><br>
                        <input type="password" name="pass2" class="form-control" id="c4"><br><br>

                        <input type="hidden" name="mail" value="<?php if(!empty($mail)){echo $mail;}?>">

                        <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR"></input>
                    </form> 
                </div>
            </body>
        </html>
    <?php
}




    
}