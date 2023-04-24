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
        <!--<link rel="stylesheet" href="../../frontend/css/login.css"/>-->
        <div class='main d-flex justify-content-center'>
            <div class="card rounded mt-5 pb-3">
                <div class="card-header text-center">
                    <h2 class="fw-bold">Inicia sesión en LuaChea</h2>
                </div>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                    <div class="card-body">
                        <div class="text-center border-bottom pb-2">
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
                        </div>
                        <div class="pt-2">
                            <div class="">
                                <label for="c1" class="form-label"><b>Email:</b></label>
                                <input type="email" name="mail" class="form-control" id="c1" placeholder="E-mail" <?php
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
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-outline-success" name="login">Iniciar sesión</button>
                    </div>
                    <br> <?php echo $err; ?>
                    <?php echo $num; ?>
                    <div class='pt-3 text-center lh-sm text-center'>
                        <span> Haz click en <a href='recuperarContra.php' style="color:red">Recuperar</a> para conseguir tu contraseña!</span><br>
                        <span> Haz click en <a href='registro.php' style="color:blue">Registrarse</a> para obtener más ventajas!</span>
                    </div>
                </form>
            </div>
        </div>

        <?php
    }

    /**
     * Método que muestra formulario de registro  
     * @param $necesarios  En caso de no completarse todos los campos se muestra cuales faltan
     */
    public function htmlRegistro($necesarios = "") {
        ?>
        <div class="container main mt-5">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3 class="fw-bold">Regístrate en LuaChea.</h3>
                </div>
                <div class="card-body table-responsive">
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                        <table class="table table-striped table-hover">
                            <tr>
                                <td><h5>Nombre</h5></td>
                                <td>
                                    <input type="text" name="nombre" placeholder="Nombre" class="form-control" id="c1" <?php
                                    if (!empty($_POST['nombre'])) {
                                        echo " value='" . $_POST['nombre'] . "'";
                                    }
                                    ?> >
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Primer Apellido</h5></td>
                                <td>
                                    <input type="text" name="apellido1" placeholder="Primer Apellido" class="form-control" id="c2" <?php
                                    if (!empty($_POST['apellido1'])) {
                                        echo " value='" . $_POST['apellido1'] . "'";
                                    }
                                    ?> >
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Segundo Apellido</h5></td>
                                <td>
                                    <input type="text" name="apellido2" placeholder="Segundo Apellido" class="form-control" id="c3" <?php
                                    if (!empty($_POST['apellido2'])) {
                                        echo " value='" . $_POST['apellido2'] . "'";
                                    }
                                    ?> >
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Correo electrónico</h5></td>
                                <td>
                                    <input type="email" name="mail" placeholder="Correo electrónico" class="form-control" id="c4"  <?php
                                    if (!empty($_POST['mail'])) {
                                        echo " value='" . $_POST['mail'] . "'";
                                    }
                                    ?>>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Teléfono</h5></td>
                                <td>
                                    <input type="text" name="telefono" class="form-control" id="c5" <?php
                                    if (!empty($_POST['telefono'])) {
                                        echo " value='" . $_POST['telefono'] . "'";
                                    }
                                    ?>>
                                </td>
                            </tr>
                        </table>
                        <?php
                        if (!empty($_POST['registro']) && $necesarios !== true) {
                            //Enseña los campos que faltan al usuario
                            $necesarios = str_replace('apellido1', 'primer apellido', $necesarios);
                            // $necesarios = str_replace('apellido2', 'segundo apellido', $necesarios);
                            $necesarios = str_replace('password', 'contraseña', $necesarios);
                            // $necesarios = str_replace('password2', 'confirmación de la contraseña',$necesarios);
                            $necesarios = str_replace('email', 'correo', $necesarios);
                            echo "<br><b style=color:red>Faltan campos obligatorios:</b> <br>$necesarios";
                        }
                        ?>
                        <div class="text-center"><input type="submit" class="btn btn-success" name="registro"></div>

                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que muestra el formulario de recuperacion de contraseña
     * @param $mensaje   Muestra en caso de no existir que el mail dado no esta registrado
     */
    public function recuperar($mensaje = "") {
        ?>
        <div class="container main mt-5">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>¿Has olvidado tu contraseña?</h3>
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                        <?php echo $mensaje; ?><br> 
                        <label for="trabajo"><b>¿Trabajas con nosotros?</b></label> <br>
                        <input type="radio" id="trabajo" name="trabajo" value="NO" checked>  <label for="trabajo"> NO </label> <br> 
                        <input type="radio" id="trabajo" name="trabajo" value="SI" >  <label for="trabajo"> SI </label>
                        <br><br> 
                        <label for="c1" class="form-label">Correo electrónico :</label><br>     
                        <input type="email" placeholder="Correo Electrónico" name="mailr" class="form-control" id="c1"  <?php
                        if (!empty($_POST['mail'])) {
                            echo " value='" . $_POST['mail'] . "'";
                        }
                        ?>> 
                        <div class="mt-3 text-center">
                            <input type="submit" class="btn btn-success" name="ENVIAR MAIL">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     *  Metodo que saca formulario para contrastar que el token enviado al usuario sea el mismo que esta introduciendo
     * @param $mail
     * @param $rol
     */
    public function contrastaToken($mail, $rol) {
        ?> 
        <div class="container main mt-3">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>Regístrate en LuaChea</h3>
                </div>
                <div class="card-body">
                    <form action= "comprobarToken.php " method="POST">
                        <h5 class="text-center">Para completar el proceso, por favor revise su bandeja de correo electrónico. Le hemos enviado un código de verificación.</h5>                
                        <label for="c" class="form-label">Codigo Mail:</label>
                        <input type="password" class="form-control" id="c" name="token">
                        <input type="hidden" name="rol" value="<?php echo $rol ?>">
                        <input type="hidden" name="testigo" >
                        <input type="hidden" name="mail" value="<?php
                        if (!empty($mail)) {
                            echo $mail;
                        }
                        ?>">
                        <div class="mt-3 text-center">
                            <input type="submit" name="validar" class="btn btn-success " value="Activar Cuenta" >
                        </div>
                    </form> 
                </div>
            </div>
        </div>

        <?php
    }

    /**
     * Metodo que muestra un formulario en caso de poner mal el token recibido en el mail
     * @param $mail
     * @param $rol
     */
    public function tokenMal($mail, $rol) {
        ?> 
        <div class="container main mt-3">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>Regístrate en LuaChea</h3>
                </div>
                <div class="card-body">
                    <form action= "comprobarToken.php " method="POST">
                        <h5><b>El código que ha introducido es incorrecto. Por favor, inténtelo de nuevo.</b></h5>
                        <input type="password" class="form-control" id="c" name="token">
                        <input type="hidden" name="testigo"  >
                        <input type="hidden" name="rol" value="<?php echo $rol ?>">
                        <input type="hidden" name="mail" value="<?php
                        if (!empty($mail)) {
                            echo $mail;
                        }
                        ?>">
                        <div class="mt-3 text-center">
                            <input type="submit" name="validar" class="btn btn-success" value="Activar Cuenta" >
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que muestra formulario par poner la contraseña
     * @param $mail
     * @param $rol
     */
    public function contrasena($mail, $rol) {
        ?>
        <div class="container main mt-3">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>Contraseña</h3>
                </div>
                <div class="card-body">
                    <h5>Por favor, escriba su contraseña ahora.</h5>
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
                        <div class="mt-3 text-center">
                            <input type="submit" name="contraMail" class="btn btn-success" value="PULSAR PARA VERIFICAR">
                        </div>
                    </form> 
                </div>
            </div>
        </div>

        <?php
    }

    /**
     * Método que muestra formulario par poner la contraseña  en caso de no poner las dos iguales
     * @param $mail
     * @param $rol
     */
    public function contraMail($mail, $rol) {
        ?>
        <div class="container main mt-3">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>Regístrate en LuaChea</h3>
                </div>
                <div class="card-body">
                    <form action="guardarContrasena.php" method="POST">
                        <h5 class="text-center">Lo siento, las contraseñas que ha introducido no coinciden. Por favor, inténtelo de nuevo.</h5>   
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
                        <div class="mt-3 text-center">
                            <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR">
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <?php
    }

}
