<?php
require   dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."backend".DIRECTORY_SEPARATOR."sesiones".DIRECTORY_SEPARATOR."sesiones.php";
 sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

 

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;

$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador;

if(isset($_GET["todos"])){
    $cantidadResultados=$_GET["todos"] ;
} else {
$cantidadResultados = 20;    
}

$paginaActual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;
$paginaInicio = ($paginaActual - 1) * $cantidadResultados;

if (isset($_POST["validar"])) {
      $_POST['nombre'];
    if (!empty($_POST['nombre'])) {
          $nombre = trim($_POST['nombre']);
    }
    if (!empty($_POST['opcion'])) {
        $opcion = $_POST['opcion'];
    }
    if (!empty($_POST['orden'])) {
        $orden = $_POST['orden'];
    }
}
$nombre = (isset($nombre)) ? $nombre :"";
$opcion = (isset($opcion)) ? $opcion :"";
$orden = (isset($orden)) ? $orden :"";

$fila = $consulta->filtradoProductos($paginaInicio, $cantidadResultados, $nombre, $opcion, $orden);


$formularios->listaFiltradaProductos();
if(empty($fila)){
    $mensaje1 = "Nombre de empleado no registrado";
echo "<script> alert('".$mensaje1."'); </script>";
    
}
$formularios->tablaProductos($fila);

$contador = $consulta->productosActivos();
$total = ceil($contador / $cantidadResultados);

echo '<div class="paginado" style="text-align:center">';
for ($i = 1; $i <= $total; $i++) {
    echo "<a href='productos.php?pagina=" . $i . "' > " . $i . "</a>";
}
echo "<a href='productos.php?todos=1000000 ' > Mostrar todos  </a>";
echo " </div>";

 
 require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");