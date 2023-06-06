<?php

namespace clases;

class FormulariosUsuario {

    /**
     * Método que muestra las redireciones disponibles para el usuario
     */
    public function redirecionesUsuario() {
        echo "<br><a href='modificarDatosUsuario.php'><input type='button' value='Actualiza tus datos'></a><br>";
        //  echo "<br><a href='trabajadores.php'><input type='button' value='Trabajadores'></a><br>";
        //  echo "<br><a href='productos.php'><input type='button' value='Productos'></a><br>";
    }

    /**
     * Método que muestra los datos del usuario precargado con los metidos en la base de datos.
     * @param $id
     * @param $necesarios   Campos obligatorios
     */
    public function registroDatosPorUsuario($id, $necesarios, $mensaje = "") {
        ?>
        <div class="container main mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Modifica tus datos:</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <form enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                        <div class="my-3 d-flex justify-content-center">
                            <?php
                            // Ruta de la imagen
                            $ruta_imagen = $id['img'];
                            // Comprobar si la imagen existe
                            if (file_exists($ruta_imagen)) {
                                // Mostrar la imagen
                                echo '<img class="rounded-circle border border-dark img-fluid" width="200" height="200" src="' . $ruta_imagen . '" alt="Imagen de perfil">';
                            } else {
                                echo '<img class="rounded-circle border border-dark img-fluid" width="200" height="200" src="../imagenes/imgUsuarios/defecto.jpg" alt="Imagen de perfil predeterminada">';
                            }
                            ?>
                        </div>
                        <table class="table table-striped table-hover">
                            <tr>
                                <td>Nombre: </td>
                                <td><input type="text" name="nombre" class="form-control" id="c1" value="<?php echo $id["nombre"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Primer Apellido: </td>
                                <td><input type="text" name="apellido1" class="form-control" id="c2" value="<?php echo $id["apellido1"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Segundo Apellido: </td>
                                <td><input type="text" name="apellido2" class="form-control" id="c3"  value="<?php echo $id["apellido2"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Correo: </td>
                                <td><input type="email" name="mail" class="form-control" id="c4" readonly value="<?php echo $id["correo"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Teléfono: (<?php echo $id["codPais"]; ?>)</td>
                                <td>
                                    <input type="hidden" name="codPais" class="form-control" id="c5"  value="<?php echo $id["codPais"]; ?>">
                                    <input type="text" name="telefono" class="form-control" id="c5"  value="<?php echo $id["num_telef"]; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>NIF: </td>
                                <td><input type="text" name="nif" class="form-control" id="c6"  value="<?php echo $id["NIF"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Dirección: </td>
                                <td><input type="text" name="direcion" class="form-control" id="c7"  value="<?php echo $id["direccion"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Código Postal: </td>
                                <td><input type="text" name="cp" class="form-control" id="c8"  value="<?php echo $id["cp"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Imagen: </td>
                                <td><input type="file" name="imagen[]" class="form-control" id="c9"></td>
                            </tr>
                        </table>

                        <div class="text-center my-3">
                            <button type="submit"  name="registro" class="btn btn-outline-success">Actualizar</button>
                            <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Cancelar</a>
                        </div>

                        <?php
                        if (empty($_POST["registro"]) && $necesarios !== true) {
                            //Enseña los campos que faltan al usuario
                            $necesarios = str_replace('nombre', 'Nombre', $necesarios);
                            $necesarios = str_replace('telefono', 'Telefono', $necesarios);
                            $necesarios = str_replace('apellido1', 'Primer apellido', $necesarios);
                            $necesarios = str_replace('email', 'Correo', $necesarios);
                            $necesarios = str_replace('nif', 'NIF', $necesarios);
                            $necesarios = str_replace('direcion', 'Direccion', $necesarios);
                            $necesarios = str_replace('cp', 'Codigo Postal', $necesarios);
                            echo "<br><br><b style=color:red>Faltan campos obligatorios para completar el registro:</b> <br>$necesarios";
                        }
                        ?>               

                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que muestra el formulario de reservas de las mesas al usuario
     * @param $restaurante    Restaurantes disponibles
     * @param $mesas          Mesas disponibles o no
     * @param $necesarios     Campos obligatorios
     */
    public function formularioReserva($restaurante, $mesas) {
        ?>
        <div class="container main mt-5">

            <div class="card">
                <div class="card-header text-center">
                    <h3>Reserva tu mesa:</h3>
                </div>
                <div class="card-body text-center">
                    <form enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >

                        <div class="mt-3">
                            <label for="c1" class="form-label">Fecha de Reserva:</label>     
                            <input type=datetime-local name="fecha" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}">
                        </div>

                        <div class="mt-3">
                            <label for="c2" class="form-label">Restaurante:</label>  
                            <select name="restaurante" class="form-select">
                                <?php foreach ($restaurante as $res) { ?>
                                    <option value = "<?php echo ($res["nombreLocal"]) ? $res["nombreLocal"] : "no"; ?>"><?php echo ($res["nombreLocal"]) ? $res["nombreLocal"] : "Restaurante no disponible"; ?></option>;
                                <?php } ?>
                            </select>
                        </div>

                        <div class='mt-3'>
                            <label for="c2" class="form-label">Mesas:</label>

                            <select name="mesas" class="form-select">
                                <option value = "<?php echo (!empty($mesas["id_mesa"])) ? $mesas["id_mesa"] : ""; ?>"><?php echo (!empty($mesas["id_mesa"])) ? "Hay mesas disponibles" : "No hay mesas disponibles"; ?></option>;
                            </select>
                        </div>

                        <div class='mt-3'>
                            <label for="c2" class="form-label">Turno:</label>  
                            <select name="turno" class="form-select">
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
            </div>
        </div>
        <?php
    }

    public function formularioReservaSuccess() {
        ?>
        <div class="container main mt-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">¡Gracias por reservar con nosotros!</h3> 
                </div>
                <div class="card-body">
                    <h5 class="mt-3">Su reserva ha sido recibida y está siendo procesada por nuestro equipo. <br><br>En breve, recibirá un correo electrónico con la confirmación de su reserva o con cualquier información adicional que pueda requerir. Si tiene alguna pregunta o inquietud, no dude en ponerse en contacto con nosotros. <br><br>¡Esperamos darle la bienvenida pronto en nuestro restaurante!</h5>
                </div>
                <div class="card-footer">
                    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="volver" name="volver" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
        <?php
    }
    
    public function formularioReservaError() {
        ?>
        <div class="container main mt-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">¡Lo sentimos mucho!</h3> 
                </div>
                <div class="card-body">
                    <h5 class="mt-3">Hemos encontrado un problema al procesar su reserva. <br><br>Por favor, disculpe las molestias ocasionadas. Nuestro equipo está trabajando para solucionar la situación lo antes posible. <br><br>Le pedimos que espere un momento y vuelva a intentar realizar la reserva. <br><br>Si el problema persiste, por favor, póngase en contacto con nosotros para que podamos ayudarle a resolverlo.<br><br> Gracias por su comprensión.</h5>
                </div>
                <div class="card-footer">
                    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="volver" name="volver" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que muestra un formulario con los datos modificados del usuario
     * @param type $id
     */
    public function formularioCambiosPerfil($id, $total_paginas, $pagina_actual) {
        ?>
        <div class="container main mt-5">
            <div class="card rounded">
                <div class="card-header text-center">
                    <h3>Lista de cambios realizados.</h3>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <h3>Filtrar por:</h3>
                            <div class="mt-2 d-flex align-items-center justify-content-center">
                                <input type="radio" name="orden" value="ASC" class="form-check-input" id="asc"> 
                                <label class="form-check-label" for="asc">
                                    Ascendente
                                </label>
                                <input type="radio" name="orden" checked value="DESC" class="form-check-input ms-2"> 
                                <label class="form-check-label" for="desc">
                                    Descendente
                                </label>
                            </div>
                            <input type="submit" name=validar value="Filtrar" class='btn btn-default btn-outline-success mt-2'>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th scope=" d-sm-table-cell">Nombre</th>
                                <th scope=" d-sm-table-cell">Apellido</th>
                                <th scope=" d-sm-table-cell">Apellido</th>
                                <th scope=" d-sm-table-cell">Fecha</th>
                                <th scope=" d-sm-table-cell">Teléfono</th>
                                <th scope=" d-sm-table-cell">NIF</th>
                                <th scope=" d-sm-table-cell">Dirección</th>
                                <th scope=" d-sm-table-cell">Código Postal</th>
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
                </div>
                <div class="text-center my-3">
                    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
        <?php
    }

}
?>