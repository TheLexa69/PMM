<?php

namespace clases;

class FormulariosLogin {

    /**
     * Metodo que muestra el formulario de loggin 
     * @param $err  En caso de errar en contraseña muestra un mensaje personalizado
     * @param $num  Contador de intentos al 6 no deja logearse   
     */
    public function html($err = " ", $num = " ") {
        ?>
        <link rel="stylesheet" href="../../frontend/css/login.css"/>
        <div class="container bg-light rounded mt-5 w-50 p-3">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <div class="text-center">
                    <h2>Login</h2>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="trabajo"><b>¿Trabajas con nosotros?</b></label>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="radio" name="trabajo" id="trabajo1" value="NO" checked>
                            <label class="form-check-label" for="trabajo1">
                                Usuario.
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="radio" name="trabajo" id="trabajo2" value="SI">
                            <label class="form-check-label" for="trabajo2">
                                Trabajador.
                            </label>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-outline-success" name="login">Login</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="">
                            <label for="c1" class="form-label"><b>Email:</b></label>
                            <input type="email" name="mail" class="form-control" id="c1" placeholder="Email" <?php
                            if (!empty($_POST['mail'])) {
                                echo " value='" . $_POST['mail'] . "'";
                            }
                            ?>>
                        </div>
                        <div class="mt-3">
                            <label for="c2" class="form-label"><b>Contraseña:</b></label>
                            <div class='col-xs-3'>
                                <input type="password" name="pass" class="form-control" id="c2" placeholder="Contraseña">
                            </div>
                        </div>
                    </div>
                </div>
                <br> <?php echo $err; ?><br>
                <?php echo $num; ?><br>
                <div class=''>
                    <div class="text-center">
                        <p> <b>Haz click en </b> <a href='recuperarContra.php' style="color:red">Recuperar</a><b> para conseguir tu contraseña!  </b></p> 
                    </div>
                    <div class="text-center">
                        <p> <b>Haz click en </b> <a href='registro.php' style="color:blue">Registrarse</a> <b> para obtener más ventajas!</b></p>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Método que muestra formulario de registro  
     * @param $necesarios  En caso de no completarse todos los campos se muestra cuales faltan
     */
    public function htmlRegistro($necesarios = "") {
        ?>
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
            <label for="c4" class="form-label">Email:</label><br>     
            <input type="email" name="mail" class="form-control" id="c4"  <?php
            if (!empty($_POST['mail'])) {
                echo " value='" . $_POST['mail'] . "'";
            }
            ?>><br>
            <label for="c5" class="form-label">Telefono:</label><br>
            <input type="text" name="telefono" class="form-control" id="c5" <?php
            if (!empty($_POST['telefono'])) {
                echo " value='" . $_POST['telefono'] . "'";
            }
            ?>><br>
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
        <?php
    }

    /**
     * Método que muestra el formulario de recuperacion de contraseña
     * @param $mensaje   Muestra en caso de no existir que el mail dado no esta registrado
     */
    public function recuperar($mensaje = "") {
        ?>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
            <h2>Email con el que te diste de alta:</h2>
            <?php echo $mensaje; ?><br> 
            <label for="trabajo"><b>¿Trabajas con nosotros?</b></label> <br>
            <input type="radio" id="trabajo" name="trabajo" value="NO" checked>  <label for="trabajo"> NO </label> <br> 
            <input type="radio" id="trabajo" name="trabajo" value="SI" >  <label for="trabajo"> SI </label>
            <br><br> 
            <label for="c1" class="form-label">Correo electrónico :</label><br>     
            <input type="email" name="mailr" class="form-control" id="c1"  <?php
            if (!empty($_POST['mail'])) {
                echo " value='" . $_POST['mail'] . "'";
            }
            ?>> 
            <input type="submit" name="ENVIAR MAIL">
        </form>
        <?php
    }

    /**
     *  Metodo que saca formulario para contrastar que el token enviado al usuario sea el mismo que esta introduciendo
     * @param $mail
     * @param $rol
     */
    public function contrastaToken($mail, $rol) {
        ?> 
        <form action= "comprobarToken.php " method="POST">
            <h2><b>Revise su Email y ponga el código de verificación para finalizar el proceso</b></h2>
            <div>
                <label for="c" class="form-label">Codigo Mail:</label><br>
                <input type="password" class="form-control" id="c" name="token"><br><br>
                <input type="hidden" name="rol" value="<?php echo $rol ?>">
                <input type="hidden" name="testigo" >
                <input type="hidden" name="mail" value="<?php
                if (!empty($mail)) {
                    echo $mail;
                }
                ?>">
            </div>
            <input type="submit" name="validar" value="Activar Cuenta" >
        </form> 
        <?php
    }

    /**
     * Metodo que muestra un formulario en caso de poner mal el token recibido en el mail
     * @param $mail
     * @param $rol
     */
    public function tokenMal($mail, $rol) {
        ?>  
        <form action= "comprobarToken.php " method="POST">
            <h2>Comprobar Mail</h2><br>
            <div>
                <label for="c" class="form-label">Codigo Mail <b>INCORRECTO</b> vuelva a ponerlo:</label><br><br>
                <input type="password" class="form-control" id="c" name="token"><br><br>
                <input type="hidden" name="testigo"  >
                <input type="hidden" name="rol" value="<?php echo $rol ?>">
                <input type="hidden" name="mail" value="<?php
                if (!empty($mail)) {
                    echo $mail;
                }
                ?>">
            </div>
            <input type="submit" name="validar" value="Activar Cuenta" >
        </form> 
        <?php
    }

    /**
     * Método que muestra formulario par poner la contraseña
     * @param $mail
     * @param $rol
     */
    public function contrasena($mail, $rol) {
        ?>
        <form action="guardarContrasena.php" method="POST">
            <label for="c2" class="form-label">Escriba su contraseña:</label><br>
            <label for="c3" class="form-label">Contraseña:</label><br>
            <input type="password" name="pass" class="form-control" id="c3"  ><br>
            <label for="c4" class="form-label">Repite contraseña:</label><br>
            <input type="password" name="pass2" class="form-control" id="c4"  ><br><br> 
            <input type="hidden" name="mail" value="<?php
            if (!empty($mail)) {
                echo $mail;
            }
            ?>">
            <input type="hidden" name="rol" value="<?php echo $rol ?>">
            <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR">
        </form> 
        <?php
    }

    /**
     * Método que muestra formulario par poner la contraseña  en caso de no poner las dos iguales
     * @param $mail
     * @param $rol
     */
    public function contraMail($mail, $rol) {
        ?>
        <form action="guardarContrasena.php" method="POST">
            <h1>Tienen que ser iguales</h1>   
            <label for="c2" class="form-label">Escriba su contraseña:</label><br>
            <label for="c3" class="form-label">Contraseña:</label><br>
            <input type="password" name="pass" class="form-control" id="c3"  ><br>
            <label for="c4" class="form-label">Repite contraseña:</label><br>
            <input type="password" name="pass2" class="form-control" id="c4"><br><br>
            <input type="hidden" name="rol" value="<?php echo $rol ?>">
            <input type="hidden" name="mail" value="<?php
            if (!empty($mail)) {
                echo $mail;
            }
            ?>">
            <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR">
        </form> 
        <?php
    }

}
