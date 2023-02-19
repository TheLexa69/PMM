<?php

namespace clases;

class FormulariosAdministrador{



    public function htmlRegistroEmpleados($necesarios = "", $mensaje="") {
        ?>

        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
            <h2>Registro:<?php if(isset($mensaje)){ echo $mensaje ;} ?></h2>
            <label for="c1" class="form-label">Nombre:</label><br>
            <input type="text" name="nombre" class="form-control" id="c1" <?php if (!empty($_POST['nombre'])) {  echo " value='" . $_POST['nombre'] . "'";}?> ><br>
            <label for="c2" class="form-label">Primer Apellido:</label><br>
            <input type="text" name="apellido1" class="form-control" id="c2" <?php if (!empty($_POST['apellido1'])) {echo " value='" . $_POST['apellido1'] . "'";}?> ><br>
            <label for="c3" class="form-label">Segundo Apellido:</label><br>
            <input type="text" name="apellido2" class="form-control" id="c3" <?php if (!empty($_POST['apellido2'])) {echo " value='" . $_POST['apellido2'] . "'";}?> ><br>
            <label for="c4" class="form-label">Mail:</label><br>     
            <input type="email" name="mail" class="form-control" id="c4"  <?php if (!empty($_POST['mail'])) {echo " value='" . $_POST['mail'] . "'";} ?>   ><br>
            <label for="c5" class="form-label">Telefono:</label><br>
            <input type="text" name="telefono" class="form-control" id="c5" <?php if (!empty($_POST['telefono'])) {echo " value='" . $_POST['telefono'] . "'";} ?>   ><br>
            <label for="c6" class="form-label">Nie:</label><br>              
            <input type="text" name="nie" class="form-control" id="c6" <?php if (!empty($_POST['nie'])) {  echo " value='" . $_POST['nie'] . "'";}?> ><br>
            <label for="c7" class="form-label">Pasaporte:</label><br>
            <input type="text" name="pasaporte" class="form-control" id="c7" <?php if (!empty($_POST['pasaporte'])) {  echo " value='" . $_POST['pasaporte'] . "'";}?> ><br>
            <label for="c8" class="form-label">Privilegios:</label><br>
            <select name="rol">  <option value="3" selected="selected">Trabajador</option>
                                 <option value="2" >Gestor</option>
                                 <option value="1">Administrador</option>
            </select>
            <br>
            <br> 


            <input type="submit" name="registro">
                       <br>   <br>   
            <?php
           if(isset($mensaje))
           { echo  "<p> <a href='indexAdministrador.php 'style='color:red'>Volver a pagina principal administrador</a></p> " ;} 
             
            if (!empty($_POST['registro']) && $necesarios !== true) {
                //Enseña los campos que faltan al usuario
                $necesarios = str_replace('apellido1', 'primer apellido', $necesarios);
                $necesarios = str_replace('nie', 'nie', $necesarios);
                $necesarios = str_replace('pasaporte', 'pasaporte', $necesarios);
                $necesarios = str_replace('privilegios', 'privilegios', $necesarios);
                $necesarios = str_replace('password', 'contraseña', $necesarios);
                // $necesarios = str_replace('password2', 'confirmación de la contraseña',$necesarios);
                $necesarios = str_replace('email', 'correo', $necesarios);
                echo "<br><br><b style=color:red>Faltan campos obligatorios:</b> <br>$necesarios";
            }
            ?>

        </form>


        <?php
    }
 

}
