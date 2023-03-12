<?php

namespace clases;

class FormulariosAdministrador {

    /**
     * Método que muestra los botones de redirecion del administrador.
     */
    public function redirecionesAdministrador() {
        echo "<div class='container bg-light rounded mt-5 p-5'>";
        echo "<div class='text-center'>
              <h2>Panel Administrador</h2>
              <hr>
              </div>";
        echo "<div class='d-flex justify-content-around'>";
        echo "<a href='altaTrabajador.php'><input type='button' class='btn btn-outline-success' value='Añadir Trabajador'></a>";
        echo "<a href='trabajadores.php'><input type='button' class='btn btn-outline-success' value='Listar Trabajadores'></a>";
        echo "<a href='productos.php'><input type='button' class='btn btn-outline-success' value='Modificar Productos'></a>";
        echo "<a href='consultaReservas.php'><input type='button' class='btn btn-outline-success' value='Reservas sin confirmar'></a>";
        echo "<a href='reservasPorDias.php'><input type='button' class='btn btn-outline-success' value='Historico Reservas'></a>";
        echo "<a href='pedidosPendientes.php'><input type='button' class='btn btn-outline-success' value='Pedidos Pendientes'></a>";
        echo "</div>";
        echo "</div>";
    }

    /**
     * Método que muestra el formulario de Registro de los empleados
     * @param $necesarios  En caso de faltar algun campo se le manda cual
     * @param $mensaje     Mensaje que mostrara cual es el empleado al cual hace referencia el formulario  
     */
    public function htmlRegistroEmpleados($necesarios, $mensaje = "") {
        ?>
        <div class='container bg-light rounded mt-5 p-3'>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                <div class="text-center">
                    <h2>Registrar Trabajador<?php
                        if (isset($mensaje)) {
                            echo $mensaje;
                        }
                        ?></h2>
                    <hr>
                </div>

                <div class="mt-3">
                    <label for="c1" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" id="c1" <?php
                    if (!empty($_POST['nombre'])) {
                        echo " value='" . $_POST['nombre'] . "'";
                    }
                    ?> >
                </div>

                <div class="mt-3">
                    <label for="c2" class="form-label">Primer Apellido:</label>
                    <input type="text" name="apellido1" class="form-control" id="c2" <?php
                    if (!empty($_POST['apellido1'])) {
                        echo " value='" . $_POST['apellido1'] . "'";
                    }
                    ?> >
                </div>

                <div class="mt-3">
                    <label for="c3" class="form-label">Segundo Apellido:</label>
                    <input type="text" name="apellido2" class="form-control" id="c3" <?php
                    if (!empty($_POST['apellido2'])) {
                        echo " value='" . $_POST['apellido2'] . "'";
                    }
                    ?> >
                </div>

                <div class="mt-3">
                    <label for="c4" class="form-label">Mail:</label>
                    <input type="email" name="mail" class="form-control" id="c4"  <?php
                    if (!empty($_POST['mail'])) {
                        echo " value='" . $_POST['mail'] . "'";
                    }
                    ?>>
                </div>

                <div class="mt-3">
                    <label for="c5" class="form-label">Telefono:</label>
                    <input type="text" name="telefono" class="form-control" id="c5" <?php
                    if (!empty($_POST['telefono'])) {
                        echo " value='" . $_POST['telefono'] . "'";
                    }
                    ?>>
                </div>

                <div class="mt-3">
                    <label for="c6" class="form-label">Nie:</label>             
                    <input type="text" name="nie" class="form-control" id="c6" <?php
                    if (!empty($_POST['nie'])) {
                        echo " value='" . $_POST['nie'] . "'";
                    }
                    ?> >
                </div>

                <div class="mt-3">
                    <label for="c7" class="form-label">Pasaporte:</label>
                    <input type="text" name="pasaporte" class="form-control" id="c7" <?php
                    if (!empty($_POST['pasaporte'])) {
                        echo " value='" . $_POST['pasaporte'] . "'";
                    }
                    ?> >
                </div>

                <div class="mt-3">
                    <label for="c8" class="form-label">Privilegios:</label>
                    <select class="form-select" name="rol"> 
                        <option value="3" selected="selected">Trabajador</option>
                        <option value="2" >Gestor</option>
                        <option value="1">Administrador</option>
                    </select>
                </div>

                <div class='mt-3 d-flex justify-content-center'>
                    <div class="pe-2">
                        <input type="submit" class='btn btn-outline-success' style='width: 100px' name="registro" value='Añadir'>
                    </div>
                    <?php
                    if (isset($mensaje)) {
                        echo "<a href='indexAdministrador.php' id='cancel' name='cancel' style='width: 100px' class='btn btn-default btn-outline-danger'>Cancelar</a>";
                    }
                    ?>
                </div>

                <?php
                if (!empty($_POST['registro']) && $necesarios !== true) {
                    //Enseña los campos que faltan al usuario
                    $necesarios = str_replace('apellido1', 'primer apellido', $necesarios);
                    $necesarios = str_replace('nie', 'nie incorrecto', $necesarios);
                    $necesarios = str_replace('pasaporte', 'pasaporte o NIE', $necesarios);
                    $necesarios = str_replace('privilegios', 'privilegios', $necesarios);
                    $necesarios = str_replace('password', 'contraseña', $necesarios);
                    // $necesarios = str_replace('password2', 'confirmación de la contraseña',$necesarios);
                    $necesarios = str_replace('email', 'correo', $necesarios);
                    echo "<br><br><b style=color:red>Faltan campos obligatorios:</b> <br>$necesarios";
                }
                ?>

            </form>
        </div>
        <?php
    }

    /**
     * Método que carga el formulario para filtrar los empleados
     * Por Nombre, Rol, Si esta activa la cuenta , Fecha de ultimo loggin, Orden ascendente o descendente.
     */
    public function listaFiltradaEmpleados() {
        ?>
        <div class='container bg-light rounded mt-5 p-3'>
            <div class="d-flex justify-content-center text-center">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h3>Filtrar por:</h3>
                    <label for="c1">Nombre:</label>
                    <input class="form-control mt-2" type="text" id="c1" name="nombre"<?php
                    if (!empty($_POST['nombre'])) {
                        echo " value='" . $_POST['nombre'] . "'";
                    }
                    ?> >  
                    <label for="v">Ordenados por:</label> 
                    <select name="opcion" class="form-select mt-2">            
                        <option value="fecha">Fecha ultimo login</option> 
                        <option value="nombre">Nombre</option> 
                        <option value="id_rol">Privilegios</option> 
                        <option value="trabajando">En activo</option> 
                    </select>
                    <div class="mt-2 d-flex align-items-center">
                        <input type="radio" name="orden" value="ASC" class="form-check-input"> Ascendente
                        <input type="radio" name="orden" value="DESC" class="form-check-input"> Descendente
                        <input type="submit" name=validar value="Filtrar" class='btn btn-default btn-outline-success'>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-center">
                <h1>Lista de empleados registrados:</h1>
                <hr>
            </div>
        </div>
        <?php
    }

    /**
     * Método que carga los empleados en una tabla en caso de no tener ninguno saldra un mensaje alert avisando de ello
     * @param $fila. Datos de  la consulta de empleados
     */
    public function tablaEmpleados($fila) {
        if (isset($_GET["mensaje"])) {
            echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
        }
        ?> 
<div class='container bg-light rounded  p-3'>
        <div class="d-flex justify-content-center mt-3">
            <table class="text-center">
                <tr>
                    <th>Nie</th>
                    <th>Pasaporte</th>
                    <th>Nombre y apellidos</th>
                    <th>Fecha último login</th>
                    <th>Telefono</th>
                    <th>Privilegios</th>
                    <th>Cuenta verificada</th>
                    <th>Dado de alta en la empresa</th>
                </tr>
                <?php
                foreach ($fila as $a) {
                    if ($a["id_rol"]) {
                        $b = $a["nombre_rol"];
                    }
                    echo "<tr class='border border-dark'><td class='text-center'>" . $a["nie_trabajador"] . "</td> <td class='text-center'>" . $a["pasaporte_trabajador"] . "</td> <td class='text-center'>" . $a["nombre"] . " " . $a["apellido1"] . " " . $a["apellido2"] . "</td><td class='text-center'>" . $a["fecha"] . "</td> <td class='text-center'>" . $a["num_telef"] . "</td><td class='text-center'>" . $b . "</td><td class='text-center'>" . $a["estado_trabajador"] . "</td><td class='text-center'>" . $a["trabajando"] . "</td><td class='text-center'><a href=modificarDatosTrabajador.php?codigo=" . $a["id_trabajador"] . " class='btn btn-default btn-outline-info'>Modificar</a></td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href='indexAdministrador.php'>
                <input type='button' value='Volver a inicio' class="btn btn-outline-warning">
            </a>
        </div>
        <?php
    }

    /**
     * Método que muestra los datos de un empleado precargandolos en un formulario
     * @param $id      id del empleado
     * @param $rol
     * @param $mensaje   Mensaje mostrando nombre de empleado en caso de hacer alguna modificacion
     */
    public function datosEmpleado($id, $rol, $necesarios, $mensaje = "") {
        ?>
        <div class='container bg-light rounded mt-5 p-3'>
            <div class="d-flex justify-content-center">
                <h1>Editar Empleado <?php echo $id["nombre"] ?></h1><br>
            </div>
            <div class="d-flex justify-content-center">
                <h1><b><?php echo $mensaje ?></b></h1>
            </div>
            <hr>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="d-flex justify-content-center text-center">
                    <table class="edicion">
                        <tr>
                            <td>Nie: </td>
                            <td><input type="text" name="nie" value="<?php echo $id["nie_trabajador"]; ?>" class="form-control"></td>
                        </tr>
                        <tr><td>Pasaporte: </td><td><input type="text" name="pasaporte" value="<?php echo $id["pasaporte_trabajador"]; ?>" class="form-control"></td></tr>
                        <tr><td>Nombre: </td><td><input type="text" name="nombre" value="<?php echo $id["nombre"]; ?>" class="form-control"></td></tr>
                        <tr><td>Apellidos:</td><td> <input type="text" name="apellido1" value="<?php echo $id["apellido1"]; ?>" class="form-control">  <input type="text" name="apellido2" value=" <?php echo $id["apellido2"]; ?>" class="form-control"></td></tr>     
                        <tr><td>Correo:</td><td> <input type="text" name="correo" value="<?php echo $id["correo"]; ?>" class="form-control"></td></tr>
                        <tr><td>Numero de telefono:</td><td> <input type="text" name="telefono" value="<?php echo $id["num_telef"]; ?>" class="form-control"></td></tr>
                        <tr>
                            <td>Trabajando:</td>
                            <td> 
                                <select name="trabajando" class="form-select"> 
                                    <option value="<?php echo ($id["trabajando"] == 'si') ? 'si' : 'no'; ?>"><?php echo ($id["trabajando"] == 'si') ? 'ACTIVO Laboralmente' : 'Laboralmente De baja'; ?></option>
                                    <option value="<?php echo ($id["trabajando"] == 'no') ? 'si' : 'no'; ?>"> <?php echo ($id["trabajando"] == 'si') ? 'Laboralmente De baja' : 'ACTIVO Laboralmente'; ?> </option> 
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Privilegios:</td>
                            <td> 
                                <select name="privilegios" class="form-select"> 
                                    <option value="<?php echo ($id["id_rol"]) ? $id["id_rol"] : ''; ?>"><?php echo ($id["id_rol"]) ? $id["nombre_rol"] : ''; ?></option>
                                    <?php
                                    foreach ($rol as $id2 => $nombre) {
                                        if ($id2 + 1 == 4 || $id2 + 1 == 5) {
                                            
                                        } else {
                                            ?> <option value='<?php echo $id2 + 1 ?>'><?php echo $nombre["nombre_rol"] ?></option> <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?php echo $id["id_trabajador"]; ?>" class="pr-3">
                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-outline-info">
                    <input type="submit" name="eliminar" value="Eliminar" class="btn btn-outline-danger"> 
                    <a href="trabajadores.php"><input type="button" value="Modificar Otro Trabajador" class="btn btn-outline-success"></a>
                    <a href="indexAdministrador.php"><input type="button" value="Volver a inicio" class="btn btn-outline-warning"></a>
                </div>

                <?php
                if (!empty($_POST["actualizar"]) && $necesarios !== true) {
                    //Enseña los campos que faltan al usuario
                    $necesarios = str_replace('nombre', 'Nombre', $necesarios);
                    $necesarios = str_replace('telefono', 'Telefono', $necesarios);
                    $necesarios = str_replace('apellido1', 'Primer apellido', $necesarios);
                    $necesarios = str_replace('email', 'Correo', $necesarios);
                    $necesarios = str_replace('nie', 'Nie', $necesarios);
                    $necesarios = str_replace('pasaporte', 'Pasaporte', $necesarios);

                    echo "<br><br><b style=color:red>Faltan campos obligatorios para completar el registro:</b> <br>$necesarios";
                }
                ?>               

            </form> 
        </div>
        <?php
    }

    /**
     * Método que precarga los datos de los Productos en un formulario  en caso de tener imagen la carga y si no la tiene pone una por defecto
     * @param $id
     * @param $tipobd
     * @param $subtipobd
     */
    public function datosProducto($id, $tipobd, $subtipobd) {
        ?>
        <div class="container bg-light rounded mt-5 p-3">
            <div class="text-center">
                <h1>Editar Producto <?php echo $id["nombre"] ?></h1>
                <hr>
            </div>
            <div class='d-flex justify-content-center text-center'>
                <div class="d-flex justify-content-center text-center">
                    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
                                    echo '<img class="rounded-circle border border-dark" src="../imagenes/imgProductos/defecto.jpg" title="perfil" width="200" height="200">';
                                }
                                ?>
                            </div>
                            <div class="col-8">
                            </div>
                        </div>

                        <table class="edicion">
                            <tr>
                                <td>Nombre: </td>
                                <td><input type="text" name="nombre" value="<?php echo $id["nombre"]; ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Descripcion:</td>
                                <td><input type="text" name="descripcion" value="<?php echo $id["descripcion"]; ?>" class="form-control"></td>
                            </tr>     
                            <tr>
                                <td>tipo:</td>
                                <td>
                                    <select name="tipo" class="form-select"> 
                                        <option value="<?php echo ($id["nombre_tipo"]) ? $id["tipo"] : ''; ?>"><?php echo $id["nombre_tipo"]; ?></option>
                                        <?php
                                        foreach ($tipobd as $id1 => $nombre) {
                                            ?> <option value='<?php echo $id1 + 1 ?>'><?php echo $nombre["nombre_tipo"] ?></option> <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Subtipo:</td>
                                <td>
                                    <select name="subtipo" class="form-select"> 
                                        <option value="<?php echo ($id["nombre_subtipo"]) ? $id["subtipo"] : ''; ?>"><?php echo ($id["nombre_subtipo"]) ? $id["nombre_subtipo"] : ''; ?></option>
                                        <?php
                                        foreach ($subtipobd as $id2 => $nombre2) {
                                            ?> <option value='<?php echo $id2 + 1 ?>'><?php echo $nombre2["nombre_subtipo"] ?></option> <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Disponible Desde:</td>
                                <td><input type=date name="desde" value="<?php echo $id["fecha_inicio"]; ?>" class="form-control"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}"></td>
                            </tr>    
                            <tr>
                                <td>Disponible Hasta:</td>
                                <td><input type=date name="hasta" value="<?php echo $id["fecha_fin"]; ?>" class="form-control" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}"></td>
                            </tr>    

                            <tr>
                                <td>Precio:</td>
                                <td><input type="text" name="precio" value="<?php echo $id["precio"]; ?>" class="form-control"> </td>
                            </tr> 
                            <tr>
                                <td>Disponible:</td>
                                <td>
                                    <select name="disponible" class="form-select"> 
                                        <option value="<?php echo ($id["disponible"] == 'si') ? 'si' : 'no'; ?>"><?php echo ($id["disponible"] == 'si') ? 'Hay Stock' : 'Sin Stock'; ?></option>
                                        <option  value="<?php echo ($id["disponible"] == 'no') ? 'si' : 'no'; ?>"> <?php echo ($id["disponible"] == 'si') ? 'Sin Stock' : 'Hay Stock'; ?> </option> 
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Nombre Imagen:</td>
                                <td>
                                    <input type="file" name="imagen[]" class="form-control" id="c9">
                                </td>
                            </tr>  
                        </table>
                        <div class="mt-3 d-flex justify-content-center">
                            <input type="hidden" name="id" value="<?php echo $id["id_comida"]; ?>">
                            <input type="submit" name="actualizar" value="Actualizar" class="btn btn-outline-info">
                            <input type="submit" name="eliminar" value="Eliminar" class="btn btn-outline-danger"> 
                            <a href="productos.php"><input type="button" value="Modificar Otro Producto" class="btn btn-outline-success"></a>
                            <a href="indexAdministrador.php"><input type="button" value="Volver a inicio" class="btn btn-outline-warning"></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que filtra los productos por Disponibilidad (stock o fechas dadas), Nombre , precio
     */
    public function listaFiltradaProductos() {
        ?>
        <div class="container bg-light rounded mt-5 p-3">
            <div class='d-flex justify-content-center text-center'>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h3>Filtrar por:</h3>
                    <label for="c1">Nombre:</label>
                    <input class="form-control mt-2" type="text" id="c1" name="nombre"<?php
                    if (!empty($_POST['nombre'])) {
                        echo " value='" . $_POST['nombre'] . "'";
                    }
                    ?>>
                    <label for="v">Ordenados por:</label> 
                    <select name="opcion" class="form-select mt-2">           
                        <option value="disponible">En stock</option> 
                        <option value="fecha_inicio" >Disponible desde</option> 
                        <option value="fecha_fin" >Disponible Hasta </option> 
                        <option value="nombre">Nombre</option> 
                        <option value="precio">Precio</option> 
                        <option value="disponible">En stock</option> 
                    </select> 
                    <div class="mt-2 d-flex align-items-center">
                        <input type="radio" name="orden" value="ASC" class="form-check-input"> Ascendente
                        <input type="radio" name="orden" value="DESC" class="form-check-input"> Descendente
                        <input type="submit" name=validar2 value="Filtrar" class="btn btn-default btn-outline-success">
                    </div>
                </form>
            </div>
        
        </div>
        <?php
    }

    /**
     * Método que precarga los datos de los productos en un formulario para su posterior tratamiento 
     * @param $fila  Continene los productos
     */
    public function tablaProductos($fila) {
        if (isset($_GET["mensaje"])) {
            echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
        }
        ?>    <div class='d-flex justify-content-center'>
                <h1>Lista de Productos registrados:</h1>
            </div>
        
            <div class="container bg-light rounded p-3">
        <div class="d-flex justify-content-center mt-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <table class="text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Tipo</th>
                        <th>Subtipo</th>
                        <th>Disponible desde</th>
                        <th>Disponible hasta</th>
                        <th>Precio</th>
                        <th>Visible</th>
                        <th>Imagen</th>
                    </tr>
                    <?php
                    foreach ($fila as $a) {
                        echo "<tr class='border border-dark'><td class='text-center'>" . $a["nombre"] . "</td> <td class='text-center'>" . $a["descripcion"] . "</td> <td class='text-center'>" . $a["nombre_tipo"] . "</td><td class='text-center'>" . $a["nombre_subtipo"] . "</td> <td class='text-center'>" . $a["fecha_inicio"] . "</td><td class='text-center'>" . $a["fecha_fin"] . "</td><td class='text-center'>" . $a["precio"] . " €" . "</td><td class='text-center'>" . $a["disponible"] . "</td><td class='text-center'>" . $a["img"] . "</td><td class='text-center'><a href=modificarProductos.php?codigo=" . $a["id_comida"] . " class='btn btn-default btn-outline-info'>Modificar</a><td></tr>";
                    }
                    ?>
                </table>

            </form>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href='indexAdministrador.php'>
                <input type='button' value='Volver a inicio' class="btn btn-outline-warning">
            </a>
        </div>
           
        <?php
    }

    /**
     * Método que muestra formulario de filtrado por fechas para las reservas
     */
    public function FiltrarReservasFecha() {
        ?>
        <div class="container bg-light rounded mt-5 p-3">
            <div class='d-flex justify-content-center text-center'>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h3>Ordenar por:</h3>
                    <label for="c1"> Fecha de la reserva:</label>
                    <input type="date" name="fecha"   class="form-check-input">


                    <input type="submit" name=validar value="Filtrar" class="btn btn-default btn-outline-success">

                </form>
            </div>
        </div>
        <?php
    }

    /**
     * Método que precarga las reservas que estan pendientes y las que no.
     * @param $fila
     * @param $tipoTabla    Si recive pendientes muestra las pendientes   si no recive nada muestra las que ya se hicieron
     */
    public function tablaReservas($fila, $tipoTabla = "") {
        if (isset($_GET["mensaje"])) {
            echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
        }
        if ($tipoTabla == "pendientes") {
            ?>
            <div class="container bg-light rounded mt-5">
                <div class="mt-3 d-flex justify-content-center">
                    <h1>Reservas pendientes de ser aceptadas</h1>
                    <hr>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <form class='form-group' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <table>
                            <tr class='text-center'>
                                <th>Selecionar Aceptadas</th>
                                <th>Numero de reserva</th>
                                <th>Usuario</th>
                                <th>Telefono</th>
                                <th>Mail</th>
                                <th>Restaurante</th>
                                <th>Mesa</th>
                                <th>Fecha reserva</th>
                                <th>Turno</th>
                                <th>Reservas Confirmadas </th>
                            </tr>
                            <?php
                            foreach ($fila as $a) {
                                $id = $a["id_reservas"];
                                $correo = $a['correo'];
                                $nombre = $a["nombre"];
                                echo "<tr class='border border-dark'><td class='text-center'> <input type='hidden' name='correo' value='$correo'><input type='hidden' name='nombre' value='$nombre'><input type='checkbox' name='confirmado[]' value='$id'> <td class='text-center'>" . $a["id_reservas"] . "</td> <td class='text-center'>" . $a["nombre"] . " " . $a["apellido1"] . "</td><td class='text-center'>" . $a["num_telef"] . "</td><td class='text-center'>" . $a["correo"] . "</td><td class='text-center'>" . $a["nombreLocal"] . "</td><td class='text-center'>" . $a["id_mesa"] . "</td><td class='text-center'>" . $a["fecha_reserva"] . "</td> <td class='text-center'>" . $a["turno"] . "</td> <td class='text-center'>" . $a["reservaAceptada"] . "</td></tr>";
                            }
                            ?>
                        </table>
                        <div class="mt-3 text-center pb-3"> 
                            <a href='indexAdministrador.php'><input type='button' value='Volver a inicio' class="btn btn-outline-warning"></a>
                            <input class="btn btn-outline-success" type="submit" name="aceptar" value="Aceptar reservas selecionadas" >
                            <input class="btn btn-outline-success" type="submit" name="rechazar" value="Rechazar reservas selecionadas" >
                        </div>
                    </form>
                </div>
            </div>
        <?php } else {
            ?>
            <div> 
                <center> 
                    <h1>Reservas ya aceptadas</h1>
                    <table class="container bg-light rounded mt-5 ">
                        <tr>
                            <th>Numero de reserva</th>
                            <th>Usuario</th>
                            <th>Telefono</th>
                            <th>Mail</th>
                            <th>Restaurante</th>
                            <th>Mesa</th>
                            <th>Fecha reserva</th>
                            <th>Turno</th>
                            <th>Reservas Confirmadas </th>
                            <th></th>
                        </tr>
                        <?php
                        foreach ($fila as $a) {
                            echo "<tr><td>" . $a["id_reservas"] . "</td> <td>" . $a["nombre"] . " " . $a["apellido1"] . "</td><td>" . $a["num_telef"] . "</td><td>" . $a["correo"] . "</td><td>" . $a["nombreLocal"] . "</td><td>" . $a["id_mesa"] . "</td><td>" . $a["fecha_reserva"] . "</td> <td>" . $a["turno"] . "</td> <td>" . $a["reservaAceptada"] . "</td>  ";
                        }
                        ?>
                    </table>
                    <a href='indexAdministrador.php'><input type='button' value='Volver a inicio' class="btn btn-outline-warning"></a>
            </div> 
            </div>
            <?php
        }
    }

    /**
     * Método para mandar un tipo de mensaje  dependiendo de la aceptacion o el rechazo de la reserva
     * @param $tipo
     * @return $mensaje
     */
    public function mensageReserva($tipo = "") {
        if ($tipo == "cancelada") {
            $mensaje = "<h1>Estimado cliente su solicitud de reserva <b>ha sido cancelada.</b> </h1>";
        } else {
            $mensaje = "<h1>Estimado cliente su solicitud de reserva <b>ha sido aceptada.</b> </h1>";
        }
        return $mensaje;
    }

    /**
     * Método que muestra los pedidos pendientes  dentro de un formulario en formato tabla
     * @param $fila
     */
    public function tablaPedidos($fila) {
        ?>
        <div class="container bg-light rounded mt-5">
            <div class="mt-3 d-flex justify-content-center">
                <h1>Pedidos pendientes </h1>
                <hr>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                <form class='form-group' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <table>
                        <tr class='text-center'>
                            <th>Selecionar Aceptadas</th>
                            <th>Pedido Numero</th>
                            <th>Usuario</th>
                            <th>Telefono</th>
                            <th>Mail</th>
                            <th>Direccion</th>
                            <th>Codigo Postal</th>
                            <th>Restaurante</th>
                            <th>Fecha Pedido</th>
                        </tr>
                        <?php
                        foreach ($fila as $a) {
                            $id = $a["id_ped"];

                            echo "<tr class='border border-dark'><td class='text-center'> <input type='checkbox' name='confirmado[]' value='$id'> <td class='text-center'>" . $a["id_ped"] . "</td> <td class='text-center'>" . $a["nombre"] . " " . $a["apellido1"] . "</td><td class='text-center'>" . $a["num_telef"] . "</td><td class='text-center'>" . $a["correo"] . "</td><td class='text-center'>" . $a["direccion"] . "</td><td class='text-center'>" . $a["cp"] . "</td>  <td class='text-center'>" . $a["nombreLocal"] . "</td><td class='text-center'>" . $a["fecha"] . "</td> </tr>";
                        }
                        ?>
                    </table>
                    <div class="mt-3 text-center pb-3"> 
                        <a href='indexAdministrador.php'><input type='button' value='Volver a inicio' class="btn btn-outline-warning"></a>
                        <input class="btn btn-outline-success" type="submit" name="aceptar" value="Aceptar reservas selecionadas" >
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
