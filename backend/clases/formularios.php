<?php

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
 



public function contraseña($mail){
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
 


public function contraMail($mail) {
    ?>
         <html lang="ES">
            <head>
            </head>

            <body>
                <div  >
                    <form   action="guardarContraseña.php" method="POST">
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





/*

public function contraMail() {
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

*/

/*



     //atributos privados
     
    private  $nombre; 
    private  $apellido1;
    private  $apellido2; 
    private  $mail; 
    private  $fecha;
    private  $telefono;
    private  $rol="registrado";
    private  $estado;
    private  $nif;
    private  $direccion;
    private  $cp;
    private  $contraseña;

    
    public function __construct($nombre="",$apellido1="",$apellido2="",$mail="",$fecha="",$telefono="",$rol="",$estado="",$nif="",$direccion="",$cp="",$contraseña="") {
      
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->mail = $mail;
            $this->fecha = $fecha;
            $this->telefono = $telefono;
            $this->rol = $rol;
            $this->estado = $estado;
            $this->nif = $nif;
            $this->direccion = $direccion;
            $this->cp = $cp;
            $this->contraseña = $contraseña;
                    
            
        
    }
 
    public function get_nombre(){
       return $this->nombre;
    }
    public function set_nombre(){
        $this->nombre;
    }
    public function get_apellido1(){
       return $this->apellido1;
    }
    public function set_apellido1(){
       return $this->apellido1;
    }
    public function get_apellido2(){
       return $this->apellido2;
    }
    public function set_apellido2(){
       return $this->apellido2;
    }
    public function get_mail(){
       return $this->mail;
    }
    public function set_mail(){
       return $this->mail;
    }  
    public function get_telefono(){
       return $this->telefono;
    }
    public function set_telefono(){
       return $this->telefono;
    }  
    public function get_estado(){
       return $this->estado;
    }
    public function set_estado(){
       return $this->estado;
    }  
    public function get_nif(){
       return $this->nif;
    }
    public function set_nif(){
       return $this->nif;
    }  
    public function get_direccion(){
       return $this->direccion;
    }
    public function set_direccion(){
       return $this->direccion;
    }  
    public function get_cp(){
       return $this->cp;
    }
    public function set_cp(){
       return $this->cp;
    } 
    public function get_contraseña(){
       return $this->contraseña;
    }
    public function set_contraseña(){
       return $this->contraseña;
    }
    */


    
}