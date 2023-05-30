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

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["codigo"])) {
    if (isset($_POST["id"])) {
        $_POST = $filtro->validarPost($_POST);
    }

    $numero = (isset($_POST["id"])) ? $_POST["id"] : $_GET["codigo"];

    $fila = $consulta->comprobarDatosProducto($numero);

    $tipobd = $consulta->comprobarTipoSubtipo(0);

    $subtipobd = $consulta->comprobarTipoSubtipo(1);

    if (isset($_POST["actualizar"])) {

        $id = ($_POST["id"] == $fila["id_comida"]) ? $fila["id_comida"] : $_POST["id"];
        $nombre = ucfirst(($_POST["nombre"] == $fila["nombre"]) ? $fila["nombre"] : $_POST["nombre"]);
        $descripcion = ucfirst(($_POST["descripcion"] == $fila["descripcion"]) ? $fila["descripcion"] : $_POST["descripcion"]);
        $tipo = ($_POST["tipo"] == $fila["tipo"]) ? $fila["tipo"] : $_POST["tipo"];
        $subtipo = ($_POST["subtipo"] == $fila["subtipo"]) ? $fila["subtipo"] : $_POST["subtipo"];
        $desde = ($_POST["desde"] == $fila["fecha_inicio"]) ? $fila["fecha_inicio"] : $_POST["desde"];
        $hasta = ($_POST["hasta"] == $fila["fecha_fin"]) ? $fila["fecha_fin"] : $_POST["hasta"];
        $precio = round(($_POST["precio"] == $fila["precio"]) ? $fila["precio"] : $_POST["precio"], 2);
        $disponible = ($_POST["disponible"] == $fila["disponible"]) ? $fila["disponible"] : $_POST["disponible"];

        if (empty($_FILES['imagen']['name'][0])) {
            $img = 0;
        } else {

            $img = $_FILES['imagen'];
            $img = $funcion->anadirImagenProducto($id, $img);
        }


        $consulta->actualizarDatosProductos($id, $nombre, $descripcion, $tipo, $subtipo, $desde, $hasta, $precio, $disponible, $img);
        $fila2 = $consulta->comprobarDatosProducto($numero);
        echo "<center><h1><b>Datos actualizados<b></h1></center>";
        $formularios->datosProducto($fila2, $tipobd, $subtipobd);
    } else if (isset($_POST["eliminar"])) {
        $nombre = $_POST["nombre"];
        $consulta->eliminarProducto($numero);

        header("Location:/proyecto/backend/administrador/productos.php?mensaje=Producto $nombre fue eliminado");
    } else {
        // $numero = $_GET["codigo"];
        $formularios->datosProducto($fila, $tipobd, $subtipobd);
    }
} else {
    header("Location:/proyecto/backend/administrador/indexAdministrador.php");
}


require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
