<?php

namespace clases;

class FormulariosUsuario {

    public function redirecionesUsuario() {

        echo "<br><a href='modificarDatosUsuario.php'><input type='button' value='Actualiza tus datos'></a><br>";
        echo "<br><a href='trabajadores.php'><input type='button' value='Trabajadores'></a><br>";
        echo "<br><a href='productos.php'><input type='button' value='Productos'></a><br>";
    }

    public function registroDatosPorUsuario($id, $necesarios = "") {
        ?>
        <div class="container bg-light rounded mt-5 w-50 p-3">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <div class="text-center">
                    <h2>Modifica tus datos:</h2>
                    <hr>
                </div>
                <div class="mt-3">
                    <label for="c1" class="form-label">Nombre:</label><br>
                    <input type="text" name="nombre" class="form-control" id="c1" value="<?php echo $id["nombre"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c2" class="form-label">Primer Apellido:</label>
                    <input type="text" name="apellido1" class="form-control" id="c2" value="<?php echo $id["apellido1"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c3" class="form-label">Segundo Apellido:</label>
                    <input type="text" name="apellido2" class="form-control" id="c3"  value="<?php echo $id["apellido2"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c4" class="form-label">Mail:</label>     
                    <input type="email" name="mail" class="form-control" id="c4" value="<?php echo $id["correo"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c5" class="form-label">Telefono:</label>
                    <input type="text" name="telefono" class="form-control" id="c5"  value="<?php echo $id["num_telef"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c5" class="form-label">Nif:</label><br>
                    <input type="text" name="nif" class="form-control" id="c5"  value="<?php echo $id["NIF"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c5" class="form-label">Dirección:</label><br>
                    <input type="text" name="direcion" class="form-control" id="c5"  value="<?php echo $id["direccion"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c5" class="form-label">Codigo Postal:</label><br>
                    <input type="text" name="cp" class="form-control" id="c5"  value="<?php echo $id["cp"]; ?>">
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-outline-success" name="registro">Actualizar</button>
                    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php";?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Cancelar</a>
                </div>
                <!--<input type="submit" name="registro">-->
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
        </div>
        <?php
    }

}
?>