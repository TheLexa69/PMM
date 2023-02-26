<?php

namespace clases;

class FormulariosAdministrador {

    public function redirecionesAdministrador() {
        echo "<div class='container bg-light rounded mt-5 w-50 p-3'>";
        echo "<div class='text-center'>
              <h2>Panel Administrador</h2>
              <hr>
              </div>";
        echo "<div class='d-flex justify-content-around'>";
        echo "<a href='altaTrabajador.php'><input type='button' class='btn btn-outline-success' value='Añadir Trabajador'></a>";
        echo "<a href='trabajadores.php'><input type='button' class='btn btn-outline-success' value='Listar Trabajadores'></a>";
        echo "<a href='productos.php'><input type='button' class='btn btn-outline-success' value='Modificar Productos'></a>";
        echo "</div>";
        echo "</div>";
    }

    public function htmlRegistroEmpleados($necesarios = "", $mensaje = "") {
        ?>
        <div class='container bg-light rounded mt-5 w-50 p-3'>
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
        </div>


        <?php
    }

    public function listaFiltradaEmpleados() {
        ?>
        <center>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="c0"><h3>Filtrar por:</h3></label><br><br>
                <label for="c1">Nombre:</label><input type="text" id="c1" name="nombre"<?php
                if (!empty($_POST['nombre'])) {
                    echo " value='" . $_POST['nombre'] . "'";
                }
                ?> >  <label for="v">Ordenados por:</label> 
                <select name="opcion">            
                    <option value="fecha" >Fecha ultimo loggin</option> 
                    <option value="nombre">Nombre</option> 
                    <option value="id_rol">Privilegios</option> 
                    <option value="trabajando">En activo</option> 
                </select> 
                <input type="radio" name="orden" value="ASC"> Ascendente
                <input type="radio" name="orden" value="DESC"> Descendente
                <input type="submit" name=validar value="Filtrar" ><br><br>
            </form><br><br>
            <h1>Lista de empleados registrados:</h1>
        </center>
        <?php
    }

    public function tablaEmpleados($fila) {
        if (isset($_GET["mensaje"])) {
            echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
        }

        echo "<center><table >";
        echo "<tr>";
        echo "<th>Nie</th> <th>Pasaporte</th> <th>Nombre y apellidos</th><th>Fecha último loggin</th><th>Telefono</th><th>Privilegios</th><th>Cuenta verificada</th><th>Dado de alta en la empresa</th>";
        echo "</tr>";

        foreach ($fila as $a) {
            if ($a["id_rol"]) {
                $b = $a["nombre_rol"];
            }

            echo "<tr><td>" . $a["nie_trabajador"] . "</td> <td>" . $a["pasaporte_trabajador"] . "</td> <td>" . $a["nombre"] . " " . $a["apellido1"] . " " . $a["apellido2"] . "</td><td>" . $a["fecha"] . "</td> <td>" . $a["num_telef"] . "</td><td>" . $b . "</td><td>" . $a["estado_trabajador"] . "</td><td>" . $a["trabajando"] . "</td><td><a href=modificarDatosTrabajador.php?codigo=" . $a["id_trabajador"] . ">Modificar Trabajador</a><td></tr>";
        }
        echo "</table></center>";
        echo "<center><a href='indexAdministrador.php'><input type='button' value='Volver a inicio'></a></center>";
    }

    public function datosEmpleado($id, $rol) {
        ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <center>   <table class="edicion">

                    <h1>Editar Empleado <?php echo $id["nombre"] ?></h1>
                    <tr><td>   Nie: </td><td><input type="text" name="nie" value="<?php echo $id["nie_trabajador"]; ?>"><br></td></tr>
                    <tr><td>   Pasaporte: </td><td><input type="text" name="pasaporte" value="<?php echo $id["pasaporte_trabajador"]; ?>"><br></td></tr>
                    <tr><td>   Nombre: </td><td><input type="text" name="nombre" value="<?php echo $id["nombre"]; ?>"><br></td></tr>
                    <tr><td>    Apellidos:</td><td> <input type="text" name="apellido1" value="<?php echo $id["apellido1"]; ?>">  <input type="text" name="apellido2" value=" <?php echo $id["apellido2"]; ?>"><br>  </td></tr>     
                    <tr><td>   Correo:</td><td> <input type="text" name="correo" value="<?php echo $id["correo"]; ?>"><br></td></tr>
                    <tr><td>   Numero de telefono:</td><td> <input type="text" name="telefono" value="<?php echo $id["num_telef"]; ?>"><br></td></tr>
                    <tr><td>    Trabajando:</td><td> <select name="trabajando"> <option value="<?php echo ($id["trabajando"] == 'si') ? 'si' : 'no'; ?>"><?php echo ($id["trabajando"] == 'si') ? 'ACTIVO Laboralmente' : 'Laboralmente De baja'; ?></option>
                                <option  value="<?php echo ($id["trabajando"] == 'no') ? 'si' : 'no'; ?>"> <?php echo ($id["trabajando"] == 'si') ? 'Laboralmente De baja' : 'ACTIVO Laboralmente'; ?> </option> 

                            </select></td></tr>
                    <br>
                    <tr><td>    Privilegios:</td><td> <select name="privilegios"> 
                                <option value="<?php echo ($id["id_rol"]) ? $id["id_rol"] : ''; ?>"><?php echo ($id["id_rol"]) ? $id["nombre_rol"] : ''; ?></option>

                                <?php
                                foreach ($rol as $id2 => $nombre) {

                                    if ($id2 + 1 == 4 || $id2 + 1 == 5) {
                                        
                                    } else {
                                        ?> <option value='<?php echo $id2 + 1 ?>'><?php echo $nombre["nombre_rol"] ?></option> <?php
                                    }
                                }
                                ?>


                            </select></td></tr>     

                    <br><br>
                    <tr><td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id["id_trabajador"]; ?>">
                            <input type="submit" name="actualizar" value="Actualizar">
                            <input type="submit" name="eliminar" value="Eliminar" > 
                            <a href="trabajadores.php"><input type="button" value="Modificar Otro Trabajador"></a>
                            <a href="indexAdministrador.php"><input type="button" value="Volver a inicio"></a></td><td>
                </table></center>
        </form> 

        <?php
    }

    public function datosProducto($id, $tipobd, $subtipobd) {
        /*   c.tipo,c.subtipo
          t.nombre_tipo,e.nombre_subtipo */
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <center>   <table class="edicion">

                    <h1>Editar Producto <?php echo $id["nombre"] ?></h1>

                    <tr><td>   Nombre: </td><td><input type="text" name="nombre" value="<?php echo $id["nombre"]; ?>"><br></td></tr>
                    <tr><td>   Descripcion:</td><td> <input type="text" name="descripcion" value="<?php echo $id["descripcion"]; ?>"> <br>  </td></tr>     
                    <tr><td>    tipo:</td><td> <select name="tipo"> 
                                <option value="<?php echo ($id["nombre_tipo"]) ? $id["tipo"] : ''; ?>"><?php echo $id["nombre_tipo"]; ?></option>

                                <?php
                                foreach ($tipobd as $id1 => $nombre) {
                                    ?> <option value='<?php echo $id1 + 1 ?>'><?php echo $nombre["nombre_tipo"] ?></option> <?php
                                }
                                ?>




                            </select></td></tr>





                    <tr><td>    Subtipo:</td><td> <select name="subtipo"> 
                                <option value="<?php echo ($id["nombre_subtipo"]) ? $id["subtipo"] : ''; ?>"><?php echo ($id["nombre_subtipo"]) ? $id["nombre_subtipo"] : ''; ?></option>

                                <?php
                                foreach ($subtipobd as $id2 => $nombre2) {
                                    ?> <option value='<?php echo $id2 + 1 ?>'><?php echo $nombre2["nombre_subtipo"] ?></option> <?php
                                }
                                ?>


                            </select></td></tr>
                    <tr><td>   Disponible Desde:</td><td> <input type=datetime-local name="desde" value="<?php echo $id["fecha_inicio"]; ?>"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}"> <br>  </td></tr>    
                    <tr><td>   Disponible Hasta:</td><td> <input type=datetime-local name="hasta" value="<?php echo $id["fecha_fin"]; ?>"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}"> <br>  </td></tr>    

                    <tr><td>   Precio:</td><td> <input type="text" name="precio" value="<?php echo $id["precio"]; ?>"> <br>  </td></tr> 
                    <tr><td>    Disponible:</td><td> <select name="disponible"> <option value="<?php echo ($id["disponible"] == 'si') ? 'si' : 'no'; ?>"><?php echo ($id["disponible"] == 'si') ? 'Hay Stock' : 'Sin Stock'; ?></option>
                                <option  value="<?php echo ($id["disponible"] == 'no') ? 'si' : 'no'; ?>"> <?php echo ($id["disponible"] == 'si') ? 'Sin Stock' : 'Hay Stock'; ?> </option> 

                            </select></td></tr>
                    <br>
                    <tr><td>   Nombre Imaguen:</td><td> <input type="text" name="img" value="<?php echo $id["img"]; ?>"> <br>  </td></tr>  
                    <br><br>
                    <tr><td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id["id_comida"]; ?>">
                            <input type="submit" name="actualizar" value="Actualizar">
                            <input type="submit" name="eliminar" value="Eliminar" > 
                            <a href="productos.php"><input type="button" value="Modificar Otro Producto"></a>
                            <a href="indexAdministrador.php"><input type="button" value="Volver a inicio"></a></td><td>
                </table></center>
        </form> 

        <?php
    }

    public function listaFiltradaProductos() {
        ?>
        <div class="container bg-light rounded mt-5 w-50 p-3">
            <center>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="c0"><h3>Filtrar por:</h3></label><br><br>
                    <label for="c1">Nombre:</label><input type="text" id="c1" name="nombre"<?php
                                                          if (!empty($_POST['nombre'])) {
                                                              echo " value='" . $_POST['nombre'] . "'";
                                                          }
                                                          ?> >  <label for="v">Ordenados por:</label> 
                    <select name="opcion">            
                        <option value="disponible">En stock</option> 
                        <option value="fecha_inicio" >Disponible desde</option> 
                        <option value="fecha_fin" >Disponible Hasta </option> 
                        <option value="nombre">Nombre</option> 
                        <option value="precio">Precio</option> 
                        <option value="disponible">En stock</option> 
                    </select> 
                    <input type="radio" name="orden" value="ASC"> Ascendente
                    <input type="radio" name="orden" value="DESC"> Descendente
                    <input type="submit" name=validar value="Filtrar" ><br><br>
                </form><br><br>
                <h1>Lista de Productos registrados:</h1>
            </center>
            <?php
        }

        public function tablaProductos($fila) {
            if (isset($_GET["mensaje"])) {
                echo "<script> alert('" . $_GET["mensaje"] . "'); </script>";
            }

            echo "<center><table >";
            echo "<tr>";
            echo "<th>Nombre</th> <th>Descripcion</th> <th>Tipo</th><th>Subtipo</th><th>Disponible desde</th><th>Disponible hasta</th><th>Precio</th><th>Visible</th><th>Imagen</th>";
            echo "</tr>";

            foreach ($fila as $a) {
                echo "<tr><td>" . $a["nombre"] . "</td> <td>" . $a["descripcion"] . "</td> <td>" . $a["nombre_tipo"] . "</td><td>" . $a["nombre_subtipo"] . "</td> <td>" . $a["fecha_inicio"] . "</td><td>" . $a["fecha_fin"] . "</td><td>" . $a["precio"] . " E" . "</td><td>" . $a["disponible"] . "</td><td>" . $a["img"] . "</td><td><a href=modificarProductos.php?codigo=" . $a["id_comida"] . " class='btn btn-default btn-outline-info'>Modificar</a><td></tr>";
            }                                                                                                                                                                                        
            echo "</table></center>";
            echo "<center><a href='indexAdministrador.php'><input type='button' value='Volver a inicio'></a></center>";
        }

    }
    