<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
sesionAdministrador();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\FormulariosAdministrador as formulariosAdministrador;
use \clases\ConsultasAdministrador as consultasAdministrador;
use \clases\FuncionesAdministrador as funcionesAdministrador;
use \clases\FiltroDatos as filtrado;

$filtro = new filtrado;
$formularios = new formulariosAdministrador;
$consulta = new consultasAdministrador($_SESSION['administrador'][1]);
$funcion = new funcionesAdministrador;




if ($_SERVER["REQUEST_METHOD"] == "POST"  ) {
          
     $img = $_FILES['imagen'];
   
    
    
    if($insertado=$consulta->agregarProducto($_POST,$img)){
        echo "Producto agregado correctamente";
    }else{
        echo $insertado;
    }
  

} else {
$tipo = $consulta->productoTipo();
$subtipo = $consulta->productoSubTipo();
$alergenos = $consulta->nombreAlergenos();
$formularios->htmlAgregarProducto($tipo, $subtipo, $alergenos);

}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");