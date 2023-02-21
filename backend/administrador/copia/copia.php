<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="./tareas.css">
    </head>
    <body>
        <?php
        try {
            $pdo = new PDO('mysql:dbname=LuaChea; host=mysql-5707.dinaserver.com', 'Raul', 'oSyh36033^(/');
            //$this->conexion = new PDO('mysql:dbname=luachea; host=localhost','root','');
        } catch (PDOException $e) {
            echo 'No conectado a la base de datos porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }


        $cantidadResultados = 2;
        $paginaActual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;
        $paginaInicio = ($paginaActual - 1) * $cantidadResultados;

        if (isset($_POST["validar"])) {
            
              if ( !empty($_POST["nombre"])&& empty($_POST["opcion"]) && empty($_POST["orden"])) {
                $nombre = $_POST["nombre"];

                $sql2 = "select * from trabajador where nombre='$nombre'LIMIT :paginaInicio, :cantidadResultados";
            
                
            } else if (!empty($_POST["opcion"]) && !empty($_POST["nombre"])) {
                $opcion = $_POST["opcion"];
                $nombre = $_POST["nombre"];

                $sql2 = "select * from trabajador where nombre='$nombre' ORDER BY $opcion  LIMIT :paginaInicio, :cantidadResultados";
            
                
            }else if (!empty($_POST["opcion"])&& empty($_POST["nombre"]) && empty($_POST["orden"])) {
                $opcion = $_POST["opcion"];

                $sql2 = "select * from trabajador ORDER BY $opcion LIMIT :paginaInicio, :cantidadResultados";
            
                
            }elseif (!empty($_POST["opcion"]) && !empty($_POST["orden"]) && empty($_POST["nombre"])) {
                $opcion = $_POST["opcion"];
                $orden = $_POST["orden"];

                $sql2 = "select * from trabajador ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
            
                
            }  elseif (!empty($_POST["opcion"]) && !empty($_POST["nombre"]) && !empty($_POST["orden"])) {
                $opcion = $_POST["opcion"];
                $nombre = $_POST["nombre"];
                $orden = $_POST["orden"];
                $sql2 = "select * from trabajador where nombre='$nombre' ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
           
            }
      } else {
            $sql2 = "select * from trabajador LIMIT :paginaInicio, :cantidadResultados";
        }
       
        $stmt = $pdo->prepare($sql2);
        $stmt->bindValue(':paginaInicio', $paginaInicio, PDO::PARAM_INT);
        $stmt->bindValue(':cantidadResultados', $cantidadResultados, PDO::PARAM_INT);
        $stmt->execute();
        $fila = $stmt->fetchAll();
        ?>
        <div id="contenido">
            <h1>Lista de empleados registrados</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="c0">Mostrar empleados:</label><br><br>
                <label for="c1">Nombre:</label><input type="text" id="c1" name="nombre">  <label for="v">Ordenados por:</label> 
                <select name="opcion">                
                    <option value="fecha" >Fecha ultimo loggin</option> 
                    <option value="nombre">Nombre</option> 
                    <option value="id_rol">Privilegios</option> 
                    <option value="trabajando">En activo</option> 
                </select> 
                <input type="radio" name="orden" value="ASC"> Ascendente
                <input type="radio" name="orden" value="DESC"> Descendente
                <input type="submit" name=validar value="Filrar" ><br><br>
            </form>
        </div>


    <center><table >
            <tr>
                <th>Nie</th> <th>Pasaporte</th> <th>Nombre y apellidos</th><th>Fecha último loggin</th><th>Telefono</th><th>Privilegios</th><th>Cuenta verificada</th><th>Dado de alta en la empresa</th>
            </tr>

<?php
foreach ($fila as $a) {

    echo "<tr><td>" . $a["nie_trabajador"] . "</td> <td>" . $a["pasaporte_trabajador"] . "</td> <td>" . $a["nombre"] . " " . $a["apellido1"] . " " . $a["apellido2"] . "</td><td>" . $a["fecha"] . "</td> <td>" . $a["num_telef"] . "</td><td>" . $a["id_rol"] . "</td><td>" . $a["estado_trabajador"] . "</td><td>" . $a["trabajando"] . "</td><td><a href=modificarDatosTrabajador.php?codigo=" . $a["id_trabajador"] . ">Modificar</a><td></tr>";
}
echo "</table></center>";

$sql = "select count(*) from trabajador ";
$res1 = $pdo->query($sql);
$contador = $res1->fetchColumn();
$total = ceil($contador / $cantidadResultados);

echo '<div class="paginado" style="text-align:center">';
for ($i = 1; $i <= $total; $i++) {
    echo "<a href='modificarDatosTrabajador.php?pagina=" . $i ."' > "  . $i . "</a>";
}
echo " </div>";

unset($res);
unset($res1);
unset($pdo);
?>

            </body>
            </html>
            
            
            <?php
            
            
            
            if (!empty($nombre) && empty($orden)&& empty($opcion)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre='$nombre'LIMIT :paginaInicio, :cantidadResultados";
            
                
                } else if (!empty($opcion) && !empty($nombre)) {


                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre='$nombre' ORDER BY $opcion  LIMIT :paginaInicio, :cantidadResultados";
          
                } else if (!empty($opcion) && empty($nombre) && empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion LIMIT :paginaInicio, :cantidadResultados";
          
                } elseif (!empty($opcion) && !empty($orden) && empty($nombre)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";

                } elseif (!empty($opcion) && !empty($nombre) && !empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol   where nombre='$nombre'    ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
            }
         else {
            $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador  as t inner join roles as r on r.id_rol = t.id_rol  LIMIT :paginaInicio, :cantidadResultados";
        }