<?php
ob_clean();
require "../sesiones/sesiones.php";
//session_start();
comprobar_sesion();
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
use \clases\Pedido as pedido;
use \clases\Carrito as carrito;
$c = new carrito( $_SESSION['rolUsusario']);
$p = new pedido( $_SESSION['rolUsusario']);

$id_usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'];
// Calcula el precio total del carrito
$precio = $c->getTotalPrice($_SESSION['carrito']);

// Obtiene la CIF y el modo de pago del formulario de envío
$cif = $_POST['opciones_res'];
$modo_pago = $_POST['opciones_modo_pago'];

// Obtiene las especificaciones adicionales del pedido del formulario de envío
$especif = $_POST['especif'];

// Crea un nuevo pedido y guarda el resultado en $pedido
$pedido = $p->crearPedido($id_usuario, $carrito, $precio, $cif, $modo_pago);

// Si se creó el pedido, crea un array con el contenido del carrito, el precio total y las especificaciones adicionales,
// crea el cuerpo del correo y lo envía al correo del usuario.
// Si no se creó el pedido, muestra un mensaje de error.
if($pedido) {
$array_carrito = $p->array_carrito($carrito, $precio, $especif);
$cuerpo = $p->crear_correo($array_carrito, $pedido);
$p->enviar($_SESSION['mail'], $cuerpo);
echo '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-center">Pedido realizado con éxito, te hemos enviado un correo.</h2></div>';
$_SESSION['carrito'] = [];
$c->add($id_usuario, NULL);
} else {
echo '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-center">Ocurrió algún error y no se pudo realizar el pedido</h2></div>';
}
?>
</br>
<div class="layered box row mr-2">
        <div class="col-2 d-flex justify-content-right">
        <a href="../login/indexLogin.php"><button type="button" class="btn btn-outline-success">Volver al inicio</button></a>
        </div>
      </div>

<?php
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
