<?php

namespace clases;

class FormulariosAdministrador {

    /**
     * Método que muestra los botones de redirecion del administrador.
     */
    public function redirecionesAdministrador() {
        ?>
        <div class="main container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3> Panel Administrador </h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Panel administrador.</h5>
                    <p class="card-text">Aquí podrás añadir trabajadores o listarlos, modificar productos o añadirlos, ver las reservas y mucho más.</p>
                    <hr>
                    <div class="d-flex flex-wrap justify-content-center pt-2">
                        <a href='altaTrabajador.php'><input type='button' class='btn btn-outline-success me-1 mb-2' value='Añadir Trabajador'></a>
                        <a href='trabajadores.php'><input type='button' class='btn btn-outline-success me-1 mb-2' value='Listar Trabajadores'></a>
                        <a href='productos.php'><input type='button' class='btn btn-outline-success me-1 mb-2' value='Modificar Productos'></a>
                        <a href='consultaReservas.php'><input type='button' class='btn btn-outline-success me-1 mb-2' value='Reservas sin confirmar'></a>
                        <a href='reservasPorDias.php'><input type='button' class='btn btn-outline-success me-1 mb-2' value='Historico Reservas'></a>
                        <a href='pedidosPendientes.php'><input type='button' class='btn btn-outline-success me-1 mb-2' value='Pedidos Pendientes'></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que muestra el formulario de Registro de los empleados
     * @param $necesarios  En caso de faltar algun campo se le manda cual
     * @param $mensaje     Mensaje que mostrara cual es el empleado al cual hace referencia el formulario  
     */
    public function htmlRegistroEmpleados($necesarios, $mensaje = "") {
        ?>
        <div class="main container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3> Registrar Trabajador </h3>
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
                        <div class="text-center">
                            <h2>
                                <?php
                                if (isset($mensaje)) {
                                    echo $mensaje;
                                }
                                ?>
                            </h2>
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
            </div>
        </div>
        <?php
    }

    /**
     * Método que carga el formulario para filtrar los empleados
     * Por Nombre, Rol, Si esta activa la cuenta , Fecha de ultimo loggin, Orden ascendente o descendente.
     */
    public function listaFiltradaEmpleados() {
        ?>
        <div class="container mt-5">
            <div class="card rounded-top">
                <div class="card-header text-center">
                    <h3> Lista de Empleados </h3>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center ">
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
                                <option value="">-Seleccionar- </option>
                                <option value="fecha">Fecha ultimo login</option> 
                                <option value="nombre">Nombre</option> 
                                <option value="id_rol">Privilegios</option> 
                                <option value="trabajando">En activo</option> 
                            </select>
                            <div class="my-2 d-flex align-items-center justify-content-between">
                                <input type="radio" name="orden" value="ASC" class="form-check-input"> Ascendente
                                <input type="radio" name="orden" value="DESC" class="form-check-input"> Descendente
                            </div>
                            <input type="submit" name=validar value="Filtrar" class='btn btn-default btn-outline-success'>
                        </form>
                    </div>
                </div>
            </div> 
        </div> 
        <?php
    }

    /**
     * Método que carga los empleados en una tabla en caso de no tener ninguno saldra un mensaje alert avisando de ello
     * @param $fila. Datos de  la consulta de empleados
     */
    public function tablaEmpleados($fila, $total_paginas, $pagina_actual) {
        if (isset($_GET["mensaje"])) {
            echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
        }
        ?> 
        <div class="container">
            <div class="main card">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light text-center">
                            <tr>
                                <th scope="col">NIE</th>
                                <th scope="col">Pasaporte</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Último Login</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Privilegios</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Trabajando</th>
                                <th scope="col">Editar</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            foreach ($fila as $a) {
                                if ($a["id_rol"]) {
                                    $b = $a["nombre_rol"];
                                }
                                echo "<tr>"
                                . "<td class = 'text-center'>" . $a["nie_trabajador"] . "</td> "
                                . "<td class = 'text-center'>" . $a["pasaporte_trabajador"] . "</td> "
                                . "<td class = 'text-center'>" . $a["nombre"] . " " . $a["apellido1"] . " " . $a["apellido2"] . "</td>"
                                . "<td class = 'text-center'>" . $a["fecha"] . "</td> "
                                . "<td class = 'text-center'>" . $a["num_telef"] . "</td>"
                                . "<td class = 'text-center'>" . $b . "</td>"
                                . "<td class = 'text-center'>" . $a["estado_trabajador"] . "</td>"
                                . "<td class = 'text-center'>" . $a["trabajando"] . "</td>"
                                . "<td class = 'text-center'><a href = modificarDatosTrabajador.php?codigo=" . $a["id_trabajador"] . " class = 'btn btn-default btn-outline-info'>Modificar</a></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center gap-3">
                    <?php 
                        echo "<nav aria-label='...'>
                            <ul class='pagination pagination-lg'>
                            ";
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina_actual) {
                            echo "<li class='page-item active' aria-current='page'><span class='page-link'><a style = 'color: black;' href='#'> $i </a></span></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' style = 'color: black;' href='?pagina=$i'> $i </a></li>";
                            }
                        }
                        echo "</ul></nav>";
                
                    ?>
                    </div>
                    <div class="d-flex justify-content-center mb-2">
                        <a href='indexAdministrador.php'>
                            <input type='button' value='Volver' class="btn btn-outline-warning">
                        </a>
                    </div>
                </div>
            </div>
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
        <div class='container main mt-5'>
            <div class="card">
                <div class="card-header text-center">
                    <h3>Editar Empleado <?php echo $id["nombre"] ?></h3>
                </div>
                <div class="d-flex justify-content-center">
                    <h1><b><?php echo $mensaje ?></b></h1>
                </div>
                <div class="card-body table-responsive">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <table class="table table-striped table-hover">
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
                        <div class="mt-3 d-flex flex-wrap justify-content-evenly">
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
            </div>
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
        <div class="container main mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Editar Producto <?php echo $id["nombre"] ?></h3>
                </div>
                <div class='card-body table-responsive'>
                    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="my-3 d-flex justify-content-center">
                            <?php
                            // Ruta de la imagen
                            $ruta_imagen = $id['img'];
                            // Comprobar si la imagen existe
                            if (file_exists($ruta_imagen)) {
                                // Mostrar la imagen
                                echo '<img class="rounded-circle border border-dark img-fluid" src="' . $ruta_imagen . '" width="200" height="200">';
                            } else {
                                echo '<img class="rounded-circle border border-dark img-fluid" src="../imagenes/imgProductos/defecto.jpg" title="perfil" width="200" height="200">';
                            }
                            ?>
                        </div>
                        <table class="table table-striped table-hover">
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
                        <div class="my-3 d-flex flex-wrap justify-content-evenly">
                            <input type="hidden" name="id" value="<?php echo $id["id_comida"]; ?>">
                            <input type="submit" name="actualizar" value="Actualizar" class="btn btn-outline-info mb-2">
                            <input type="submit" name="eliminar" value="Eliminar" class="btn btn-outline-danger mb-2"> 
                            <a href="productos.php"><input type="button" value="Modificar Otro Producto" class="btn btn-outline-success mb-2"></a>
                            <a href="indexAdministrador.php"><input type="button" value="Volver a inicio" class="btn btn-outline-warning mb-2"></a>
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
        <div class="container mt-5">
            <div class="card rounded-top">
                <div class="card-header text-center">
                    <h3>Lista de Productos</h3>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center ">
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
                                <option value="">- Seleccionar -</option>      
                                <option value="disponible">En stock</option> 
                                <option value="fecha_inicio" >Disponible desde</option> 
                                <option value="fecha_fin" >Disponible hasta </option> 
                                <option value="nombre">Nombre</option> 
                                <option value="precio">Precio</option> 
                            </select> 
                            <div class="mt-2 d-flex align-items-center justify-content-center">
                                <input type="radio" name="orden" id="ASC" value="ASC" class="form-check-input"> 
                                <label class="form-check-label" for="ASC">Ascendente</label>
                                <input type="radio" name="orden" id="DESC" value="DESC" class="form-check-input ms-2"> 
                                <label class="form-check-label" for="DESC">Descendente</label>
                            </div>
                            <input type="submit" name="validar2" value="Filtrar" class="btn btn-default btn-outline-success mt-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Método que precarga los datos de los productos en un formulario para su posterior tratamiento 
     * @param $fila  Continene los productos
     */
    public function tablaProductos($fila, $total_paginas, $pagina_actual) {
        if (isset($_GET["mensaje"])) {
            echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
        }
        ?> 
           
        <div class="container">
            <div class="main card">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light text-center">
                            <tr>
                                <th class=" d-sm-table-cell">Nombre</th>
                                <th class=" d-sm-table-cell">Descripcion</th>
                                <th class=" d-sm-table-cell">Tipo</th>
                                <th class=" d-sm-table-cell">Subtipo</th>
                                <th class=" d-sm-table-cell">Disponible desde</th>
                                <th class=" d-sm-table-cell">Disponible hasta</th>
                                <th class=" d-sm-table-cell">Precio</th>
                                <th class=" d-sm-table-cell">Visible</th>
                                <th class=" d-sm-table-cell">Imagen</th>
                                <th class=" d-sm-table-cell">Editar</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            if (empty($fila)) {
                                echo "<tr><td class='text-center'></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                echo "<script defer>
                                    window.onload = function() {
                                    var mensajeDiv = document.getElementById('mensaje');
                                    mensajeDiv.style.top = '20%';
                                    setTimeout(function() {
                                        mensajeDiv.style.top = '-150%';
                                    }, 5000);
                                    }
                                    </script>";
                            }
                            foreach ($fila as $a) {
                                echo "<tr>"
                                . "<td class='text-center'>" . $a["nombre"] . "</td> "
                                . "<td class='text-center'>" . $a["descripcion"] . "</td> "
                                . "<td class=' d-sm-table-cell text-center'>" . $a["nombre_tipo"] . "</td>"
                                . "<td class=' d-sm-table-cell text-center'>" . $a["nombre_subtipo"] . "</td> "
                                . "<td class=' d-sm-table-cell text-center'>" . $a["fecha_inicio"] . "</td>"
                                . "<td class=' d-sm-table-cell text-center'>" . $a["fecha_fin"] . "</td>"
                                . "<td class=' d-sm-table-cell text-center'>" . $a["precio"] . " €" . "</td>"
                                . "<td class=' d-sm-table-cell text-center'>" . $a["disponible"] . "</td>"
                                . "<td class=' d-sm-table-cell text-center'>" . ($a["img"] != '' ? 'tiene' : 'no tiene') . "</td>"
                                . "<td class='text-center'>"
                                . "<a href=modificarProductos.php?codigo=" . $a["id_comida"] . " class='btn btn-default btn-outline-info'>Modificar</a>"
                                . "</td>"
                                . "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center gap-3">
                    <?php 
                        echo "<nav aria-label='...'>
                            <ul class='pagination pagination-lg'>
                            ";
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina_actual) {
                            echo "<li class='page-item active' aria-current='page'><span class='page-link'><a style = 'color: black;' href='#'> $i </a></span></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' style = 'color: black;' href='?pagina=$i'> $i </a></li>";
                            }
                        }
                        echo "</ul></nav>";
                
                    ?>
                    </div>
                    <div class="d-flex justify-content-center mb-2">
                        <a href='indexAdministrador.php'>
                            <input type='button' value='Volver' class="btn btn-outline-warning">
                        </a>
                    </div>
                </div>
            </div>
            <div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">
                Producto no encontrado
            </div>
        </div>
        <?php
    }

    /**
     * Método que muestra formulario de filtrado por fechas para las reservas
     */
    public function FiltrarReservasFecha() {
        ?>
        <div class="container mt-5">
            <div class='card'>
                <div class="card-header text-center">
                    <h3>Reservas Aceptadas</h3>
                </div>
                <div class="card-body text-center">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <h3>Ordenar por:</h3>
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fecha" class="form-control" style="width: 250px; margin: 0 auto;">
                        </div>
                        <input type="submit" name=validar value="Filtrar" class="btn btn-default mt-2 btn-outline-success">
                    </form>
                </div>
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
            <div class="container mt-5">
                <div class="main card">
                    <div class="card-header text-center">
                        <h3>Reservas pendientes de ser aceptadas</h3>
                    </div>
                    <div class="table-responsive">
                        <form class='form-group' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <table class="table table-striped table-hover">
                                <thead class="table-light text-center">
                                    <tr>
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
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($fila)) {
                                        echo "<tr><td class='text-center'></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                        echo "<script defer>
                                    window.onload = function() {
                                    var mensajeDiv = document.getElementById('mensaje');
                                    mensajeDiv.style.top = '20%';
                                    setTimeout(function() {
                                        mensajeDiv.style.top = '-150%';
                                    }, 5000);
                                    }
                                    </script>";
                                    }
                                    foreach ($fila as $a) {
                                        $id = $a["id_reservas"];
                                        $correo = $a['correo'];
                                        $nombre = $a["nombre"];
                                        echo "<tr><td class='text-center'> <input type='hidden' name='correo' value='$correo'><input type='hidden' name='nombre' value='$nombre'><input type='checkbox' name='confirmado[]' value='$id'> <td class='text-center'>" . $a["id_reservas"] . "</td> <td class='text-center'>" . $a["nombre"] . " " . $a["apellido1"] . "</td><td class='text-center'>" . $a["num_telef"] . "</td><td class='text-center'>" . $a["correo"] . "</td><td class='text-center'>" . $a["nombreLocal"] . "</td><td class='text-center'>" . $a["id_mesa"] . "</td><td class='text-center'>" . $a["fecha_reserva"] . "</td> <td class='text-center'>" . $a["turno"] . "</td> <td class='text-center'>" . $a["reservaAceptada"] . "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="mt-3 text-center pb-3"> 
                                <a href='indexAdministrador.php'><input type='button' value='Volver a inicio' class="btn btn-outline-warning"></a>
                                <input class="btn btn-outline-success" type="submit" name="aceptar" value="Aceptar reservas selecionadas" >
                                <input class="btn btn-outline-success" type="submit" name="rechazar" value="Rechazar reservas selecionadas" >
                            </div>
                        </form>
                    </div>
                </div>
                <div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">
                    No hay reservas pendientes
                </div>
            </div>
        <?php } else {
            ?>
            <div class="container">
                <div class="main card">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light text-center">
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
                            </thead>
                            <tbody>
                                <?php
                                if (empty($fila)) {
                                    echo "<tr><td class='text-center'></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                    echo "<script defer>
                                    window.onload = function() {
                                    var mensajeDiv = document.getElementById('mensaje');
                                    mensajeDiv.style.top = '20%';
                                    setTimeout(function() {
                                        mensajeDiv.style.top = '-150%';
                                    }, 5000);
                                    }
                                    </script>";
                                }
                                foreach ($fila as $a) {
                                    echo "<tr>"
                                    . "<td class='text-center'>" . $a["id_reservas"] . "</td> "
                                    . "<td class='text-center'>" . $a["nombre"] . " " . $a["apellido1"] . "</td>"
                                    . "<td class='text-center'>" . $a["num_telef"] . "</td>"
                                    . "<td class='text-center'>" . $a["correo"] . "</td>"
                                    . "<td class='text-center'>" . $a["nombreLocal"] . "</td>"
                                    . "<td class='text-center'>" . $a["id_mesa"] . "</td>"
                                    . "<td class='text-center'>" . $a["fecha_reserva"] . "</td> "
                                    . "<td class='text-center'>" . $a["turno"] . "</td> "
                                    . "<td class='text-center'>" . $a["reservaAceptada"] . "</td>  "
                                    . "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3 d-flex justify-content-center">
                        <a href='indexAdministrador.php'><input type='button' value='Volver a inicio' class="btn btn-outline-warning"></a>
                    </div>
                </div>
                <div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">
                    No hay reservas por ahora
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
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Pedidos pendientes</h3>
                </div>
                <div class="table-responsive">
                    <form class='form-group' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <table class="table table-striped table-hover">
                            <thead class="table-light text-center">
                                <tr>
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
                            </thead>
                            <tbody>
                                <?php
                                if (empty($fila)) {
                                    echo "<tr><td class='text-center'></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                    echo "<script defer>
                                    window.onload = function() {
                                    var mensajeDiv = document.getElementById('mensaje');
                                    mensajeDiv.style.top = '20%';
                                    setTimeout(function() {
                                        mensajeDiv.style.top = '-150%';
                                    }, 5000);
                                    }
                                    </script>";
                                }
                                foreach ($fila as $a) {
                                    $id = $a["id_ped"];
                                    echo "<tr class='border border-dark'>"
                                    . "<td class='text-center'> "
                                    . "<input type='checkbox' name='confirmado[]' value='$id'> "
                                    . "<td class='text-center'>" . $a["id_ped"] . "</td> "
                                    . "<td class='text-center'>" . $a["nombre"] . " " . $a["apellido1"] . "</td>"
                                    . "<td class='text-center'>" . $a["num_telef"] . "</td>"
                                    . "<td class='text-center'>" . $a["correo"] . "</td>"
                                    . "<td class='text-center'>" . $a["direccion"] . "</td>"
                                    . "<td class='text-center'>" . $a["cp"] . "</td>"
                                    . "<td class='text-center'>" . $a["nombreLocal"] . "</td>"
                                    . "<td class='text-center'>" . $a["fecha"] . "</td> "
                                    . "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="mt-3 text-center pb-3"> 
                            <a href='indexAdministrador.php'><input type='button' value='Volver a inicio' class="btn btn-outline-warning"></a>
                            <input class="btn btn-outline-success" type="submit" name="aceptar" value="Aceptar pedidos selecionados" >
                        </div>
                    </form>
                </div>
            </div>

            <div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">
                No hay pedidos pendientes
            </div>
        </div>
        <?php
    }

}
