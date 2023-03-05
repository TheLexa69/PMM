<?php

namespace clases;

class FormulariosUsuario {

    public function redirecionesUsuario() {

        echo "<br><a href='modificarDatosUsuario.php'><input type='button' value='Actualiza tus datos'></a><br>";
        //  echo "<br><a href='trabajadores.php'><input type='button' value='Trabajadores'></a><br>";
        //  echo "<br><a href='productos.php'><input type='button' value='Productos'></a><br>";
    }

    public function registroDatosPorUsuario($id, $necesarios = "") {
        ?>
        <div class="container bg-light rounded mt-5 w-60 p-3">
            <form enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <div class="text-center">
                    <h2>Modifica tus datos:</h2>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-4 mt-3 d-flex justify-content-center">
                        <?php
                        // Ruta de la imagen
                        $ruta_imagen = $id['img'];
                        // Comprobar si la imagen existe
                        if (file_exists($ruta_imagen)) {
                            // Mostrar la imagen
                            echo '<img class="rounded-circle border border-dark" src="' . $ruta_imagen . '" width="200" height="200">';
                        } else {
                            echo '<img class="rounded-circle border border-dark" src="../imagenes/imgUsuarios/defecto.jpg" title="perfil" width="200" height="200">';
                        }
                        ?>
                    </div>
                    <div class="col-8">
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
                    </div>
                </div>

                <div class="mt-3">
                    <label for="c4" class="form-label">Mail:</label>     
                    <input type="email" name="mail" class="form-control" id="c4" readonly value="<?php echo $id["correo"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c5" class="form-label">Telefono:</label>
                    <input type="text" name="telefono" class="form-control" id="c5"  value="<?php echo $id["num_telef"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c6" class="form-label">Nif:</label><br>
                    <input type="text" name="nif" class="form-control" id="c6"  value="<?php echo $id["NIF"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c7" class="form-label">Dirección:</label><br>
                    <input type="text" name="direcion" class="form-control" id="c7"  value="<?php echo $id["direccion"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c8" class="form-label">Codigo Postal:</label><br>
                    <input type="text" name="cp" class="form-control" id="c8"  value="<?php echo $id["cp"]; ?>">
                </div>
                <div class="mt-3">
                    <label for="c9" class="form-label">Imagen:</label><br>
                    <input type="file" name="imagen[]" class="form-control" id="c9">
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-outline-success" name="registro">Actualizar</button>
                    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Cancelar</a>
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

    public function formularioReserva($restaurante, $mesas, $necesarios = "") {
        ?>
        <div class="container bg-light rounded mt-5 w-60 p-3">
            <form enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <div class="text-center">
                    <h2>Reserva tu mesa</h2>
                    <hr>
                </div>
                <div class="mt-3">
                    <label for="c1" class="form-label">Fecha de Reserva:</label>     
                    <input type=datetime-local name="fecha" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                </div>

                <div class="mt-3">
                    <label for="c2" class="form-label">Restaurante:</label>  
                    <select name="restaurante">
                        <?php foreach ($restaurante as $res) { ?>
                            <option value = "<?php echo ($res["nombreLocal"]) ? $res["nombreLocal"] : "no"; ?>"><?php echo ($res["nombreLocal"]) ? $res["nombreLocal"] : "Restaurante no disponible"; ?></option>;
                        <?php } ?>
                    </select>
                </div>

                <div class='mt-3'>
                    <label for="c2" class="form-label">Mesas:</label>

                    <select name="mesas">
                        <option value = "<?php echo (!empty($mesas["id_mesa"])) ? $mesas["id_mesa"] : ""; ?>"><?php echo (!empty($mesas["id_mesa"])) ? "Hay mesas disponibles" : "No hay mesas disponibles"; ?></option>;
                    </select>
                </div>

                <div class='mt-3'>
                    <label for="c2" class="form-label">Turno:</label>  
                    <select name="turno">
                        <option value = "comer" selected>Comer</option>;
                        <option value = "cenar">Cenar</option>;
                    </select>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-outline-success" name="registro">Reservar</button>
                    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Cancelar</a>
                </div>

            </form>
        </div>
        <?php
    }

    public function formularioCambiosPerfil($id) {
        ?>
        <div class="container bg-light rounded mt-5 w-60 p-3">
            <div class="d-flex justify-content-center text-center">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h3>Filtrar por:</h3>

                    <div class="mt-2 d-flex align-items-center">
                        <div class="form-check m-3">
                            <input type="radio" name="orden" value="ASC" class="form-check-input" id="asc"> 
                            <label class="form-check-label" for="asc">
                                Ascendente
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="orden" value="DESC" class="form-check-input"> 
                            <label class="form-check-label" for="desc">
                                Descendente
                            </label>
                        </div>
                        <div class=" m-3">
                        <input type="submit" name=validar value="Filtrar" class='btn btn-default btn-outline-success'>
                        </div>
                    </div>
                </form>
            </div>
            <div class="text-center">
                <h2>Cambios realizados:</h2>
                <hr>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Número de Teléfono</th>
                        <th scope="col">NIF</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Código Postal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($id as $key => $id) { ?>
                        <tr>
                            <th scope="row"><?php echo $id["nombre"]; ?></th>
                            <td><?php echo $id["apellido1"]; ?></td>
                            <td><?php echo $id["apellido2"]; ?></td>
                            <td><?php echo $id["fecha"]; ?></td>
                            <td><?php echo $id["num_telef"]; ?></td>
                            <td><?php echo $id["NIF"]; ?></td>
                            <td><?php echo $id["direccion"]; ?></td>
                            <td><?php echo $id["cp"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Volver</a>
            </div>
        </div>
        <?php
    }

}
?>