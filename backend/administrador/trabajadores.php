<?php
require   dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."backend".DIRECTORY_SEPARATOR."sesiones".DIRECTORY_SEPARATOR."sesiones.php";
 sesionAdministrador();
 
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

 

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;

$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador($_SESSION['administrador'][1]);

//$cantidadResultados = 15;
//$paginaActual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;
//$paginaInicio = ($paginaActual - 1) * $cantidadResultados;

$por_pagina = 10;

if (isset($_GET['pagina'])) {
    $pagina_actual = $_GET['pagina'];
} else {
    $pagina_actual = 1;
}
$indice_primer_elemento = ($pagina_actual - 1) * $por_pagina;
$total_paginas = ceil($consulta->obtenerNumTrabajadores() / $por_pagina);

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
        $_SESSION["orden"] = $orden;
        
    }
}
$nombre = (isset($nombre)) ? $nombre :"";
$opcion = (isset($opcion)) ? $opcion :"";
$orden = (isset($_SESSION["orden"])) ? $_SESSION["orden"] : false;

$fila = $consulta->filtradoTrabajadores($indice_primer_elemento, $por_pagina, $nombre, $opcion, $orden);


$formularios->listaFiltradaEmpleados();
if(empty($fila)){
    $mensaje1 = "Nombre de empleado no registrado";
echo "<script> alert('".$mensaje1."'); </script>";
    
}
$formularios->tablaEmpleados($fila, $total_paginas, $pagina_actual);

$contador = $consulta->trabajadoresActivos();
//$total = ceil($contador / $cantidadResultados);
/*
echo '<div class="paginado" style="text-align:center">';
for ($i = 1; $i <= $total; $i++) {
    echo "<a href='modificarDatosTrabajador.php?pagina=" . $i . "' > " . $i . "</a>";
}
echo " </div>";*/
echo "</div>";

 
 require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
