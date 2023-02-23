<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
//sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;

$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador;

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["codigo"])) {
    $numero = (isset($_POST["id"])) ? $_POST["id"] : $_GET["codigo"];

     $fila = $consulta->comprobarDatosProducto($numero);

    if (isset($_POST["actualizar"])) {
 
        $id = ($_POST["id"] == $fila["id_comida"]) ? $fila["id_comida"] : $_POST["id"];
        $nombre = ucfirst(trim(($_POST["nombre"] == $fila["nombre"]) ? $fila["nombre"] : $_POST["nombre"]));
        $descripcion = ucfirst(trim(($_POST["descripcion"] == $fila["descripcion"]) ? $fila["descripcion"] : $_POST["descripcion"]));
        $tipo =  ($_POST["tipo"] == $fila["tipo"]) ? $fila["tipo"] : $_POST["tipo"];
        $subtipo =  ($_POST["subtipo"] == $fila["subtipo"]) ? $fila["subtipo"] : $_POST["subtipo"];
        $desde = ($_POST["desde"] == $fila["fecha_inicio"]) ? $fila["fecha_inicio"].":00" : $_POST["desde"].":00";
       
        $hasta = ($_POST["hasta"] == $fila["fecha_fin"]) ? $fila["fecha_fin"].":00" : $_POST["hasta"].":00";
        
        $precio = round(($_POST["precio"] == $fila["precio"]) ? $fila["precio"] : $_POST["precio"],2);
        $disponible = ($_POST["disponible"] == $fila["disponible"]) ? $fila["disponible"] : $_POST["disponible"];
        $img=trim(($_POST["img"] == $fila["img"]) ? $fila["img"] : $_POST["img"]);

        $consulta->actualizarDatosProductos($id, $nombre, $descripcion, $tipo, $subtipo, $desde, $hasta, $precio, $disponible,$img);
        $fila2 = $consulta->comprobarDatosProducto($numero);
        echo "<center><h1><b>Datos actualizados<b></h1></center>";
        $formularios->datosProducto($fila2);
    } else if (isset($_POST["eliminar"])) {
        $nombre=$_POST["nombre"];
        $consulta->eliminarProducto($numero);
     
         header("Location:/proyecto/backend/administrador/productos.php?mensaje=Producto $nombre fue eliminado");
        
    } else {
       // $numero = $_GET["codigo"];
        $formularios->datosProducto($fila);
    }
} else {
    header("Location:/proyecto/backend/administrador/indexAdministrador.php");
}


require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
