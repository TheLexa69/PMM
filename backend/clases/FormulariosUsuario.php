<?php

namespace clases;

class FormulariosUsuario   {
    
    
    
    
      public function redirecionesUsuario() {

        echo "<br><a href='ModificarDatosUsuario.php'><input type='button' value='Actualiza tus datos'></a><br>";
      //  echo "<br><a href='trabajadores.php'><input type='button' value='Trabajadores'></a><br>";
      //  echo "<br><a href='productos.php'><input type='button' value='Productos'></a><br>";
    }
    
    
    
    
     public function registroDatosPorUsuario($id,$necesarios = "") {
        ?>

        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
            <h2>Modifica tus datos:</h2>
            <label for="c1" class="form-label">Nombre:</label><br>
            <input type="text" name="nombre" class="form-control" id="c1" value="<?php echo $id["nombre"]; ?>"><br>
            <label for="c2" class="form-label">Primer Apellido:</label><br>
            <input type="text" name="apellido1" class="form-control" id="c2" value="<?php echo $id["apellido1"]; ?>"><br>
            <label for="c3" class="form-label">Segundo Apellido:</label><br>
            <input type="text" name="apellido2" class="form-control" id="c3"  value="<?php echo $id["apellido2"]; ?>"><br>
            <label for="c4" class="form-label">Mail:</label><br>     
            <input type="email" name="mail" class="form-control" id="c4" value="<?php echo $id["correo"]; ?>"><br>
            <label for="c5" class="form-label">Telefono:</label><br>
            <input type="text" name="telefono" class="form-control" id="c5"  value="<?php echo $id["num_telef"]; ?>"><br>
            <label for="c5" class="form-label">Nif:</label><br>
            <input type="text" name="nif" class="form-control" id="c5"  value="<?php echo $id["NIF"]; ?>"><br>
            <label for="c5" class="form-label">Dirección:</label><br>
            <input type="text" name="direcion" class="form-control" id="c5"  value="<?php echo $id["direccion"]; ?>"><br>
            <label for="c5" class="form-label">Codigo Postal:</label><br>
            <input type="text" name="cp" class="form-control" id="c5"  value="<?php echo $id["cp"]; ?>"><br>
            <br> 
 

            <input type="submit" name="registro">
            <?php
            if (!empty($_POST['registro']) && $necesarios !== true) {
                //Enseña los campos que faltan al usuario
                $necesarios = str_replace('apellido1', 'primer apellido', $necesarios);
                $necesarios = str_replace('password', 'contraseña', $necesarios);
                $necesarios = str_replace('email', 'correo', $necesarios);
                $necesarios = str_replace('nif', 'NIF', $necesarios);
                $necesarios = str_replace('direcion', 'Direccion', $necesarios);
                $necesarios = str_replace('cp', 'Codigo Postal', $necesarios);            
                        echo "<br><br><b style=color:red>Faltan campos obligatorios para completar el registro:</b> <br>$necesarios";
            }
            ?>

        </form>


        <?php
    }


}
?>