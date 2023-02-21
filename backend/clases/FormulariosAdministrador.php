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
 
 
    
    

    public function redirecionesAdministrador() {
       
        echo "<br><a href='altaTrabajador.php'><input type='button' value='Añadir Trabajador'></a><br>";
          echo "<br><a href='trabajadores.php'><input type='button' value='Trabajadores'></a><br>";
    }
    
    
    
       public function modificarEmpleados() {
        ?>
<center>
        <h1>Lista de empleados registrados</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="c0">Mostrar empleados segun filtro:</label><br><br>
                <label for="c1">Nombre:</label><input type="text" id="c1" name="nombre"<?php if (!empty($_POST['nombre'])) {  echo " value='" . $_POST['nombre'] . "'";}?> >  <label for="v">Ordenados por:</label> 
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
</center>
                <?php
    }

     public function tablaEmpleados($fila) {
 
    echo "<center><table >";
    echo  "<tr>";
    echo  "<th>Nie</th> <th>Pasaporte</th> <th>Nombre y apellidos</th><th>Fecha último loggin</th><th>Telefono</th><th>Privilegios</th><th>Cuenta verificada</th><th>Dado de alta en la empresa</th>";
    echo  "</tr>";
 
  
      foreach ($fila as $a) {
         if($a["id_rol"]){
             $b=$a["nombre_rol"];
         }
     
      
      
 
       echo "<tr><td>" . $a["nie_trabajador"] . "</td> <td>" . $a["pasaporte_trabajador"] . "</td> <td>" . $a["nombre"] . " " . $a["apellido1"] . " " . $a["apellido2"] . "</td><td>" . $a["fecha"] . "</td> <td>" . $a["num_telef"] . "</td><td>" . $b  . "</td><td>" . $a["estado_trabajador"] . "</td><td>" . $a["trabajando"] . "</td><td><a href=modificarDatosTrabajador.php?codigo=" . $a["id_trabajador"] . ">Modificar</a><td></tr>";
    }
    echo "</table></center>";
    
     }
}