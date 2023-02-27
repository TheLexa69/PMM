<?php
session_start();
require "../clases_carrito/pedido.php";
require "../clases_carrito/carrito.php";
//require "../clases/Mails.php";
$c = new carrito();
$p = new pedido();
//$c_envio = new Mails();
$id_usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'];
$precio = $c->getTotalPrice(serialize($_SESSION['carrito']));
$cif = $_POST['opciones_res'];
$modo_pago = $_POST['opciones_modo_pago'];
$especif = $_POST['especif'];

$pedido = $p->crearPedido($id_usuario, $carrito, $precio, $cif, $modo_pago);
if($pedido) {
    $array_carrito = $p->array_carrito($carrito, $precio, $especif);
    $cuerpo = $p->crear_correo($array_carrito, $pedido);
    $p->enviar($_SESSION['mail'], $cuerpo);
    //$c_envio->enviar_correo_pedidos("nuriabuceta@gmail.com", "dshfksdh");
    echo "pedido realizado con éxito";
    $_SESSION['carrito'] = [];
} else {
    echo "ocurrió algún error y no se pudo realizar el pedido";
}
?>
</br>
<a href="../cart/index_carrito.php">Volver a la cesta</a>
