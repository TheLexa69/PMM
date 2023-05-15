<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosUsuario as formulariosUsuario;
use \clases\ConsultasUsuario as consultasUsuario;
use \clases\FuncionesLogin as funcionesLogin;
use \clases\FuncionesUsuario as funcionesUsuario;

$formularios = new formulariosUsuario;
$consulta = new consultasUsuario($_SESSION['rolUsusario']);
$funciones = new funcionesLogin;
$funcionesU = new funcionesUsuario;
 
$id = $_SESSION["usuario"];

$por_pagina = 10;
?>
<head>
    <title>Cambios Perfil</title>
</head>
<?php
if (isset($_GET['pagina'])) {
    $pagina_actual = $_GET['pagina'];
} else {
    $pagina_actual = 1;
}
$indice_primer_elemento = ($pagina_actual - 1) * $por_pagina;
$total_paginas = ceil($consulta->comprobarFilasDatos($id) / $por_pagina);


if (!empty($_POST['orden'])) {
    $orden = $_POST['orden'];
    $_SESSION["orden"] = $orden;
}
$orden = (isset($orden)) ? $orden : "";


$datos = $consulta->solicitarDatosCambiados($id, $_SESSION["orden"], $indice_primer_elemento, $por_pagina);

//$datos = $consulta->solicitarDatosCambiados($id, $orden);
//$formularios->formularioCambiosPerfil($datos);

$formularios->formularioCambiosPerfil($datos, $total_paginas, $pagina_actual);



require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
