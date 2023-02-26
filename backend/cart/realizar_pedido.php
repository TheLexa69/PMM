<?php
session_start();
require "../clases_carrito/pedido.php";
require "../clases_carrito/carrito.php";
$c = new carrito();
$p = new pedido();
$id_usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'];
$precio = $precio_total = $c->getTotalPrice(serialize($_SESSION['carrito']));
$cif = $_POST['opciones_res'];
$modo_pago = $_POST['opciones_modo_pago'];

$p->crearPedido($id_usuario, $carrito, $precio, $cif, $modo_pago);
if($p) {
    echo "pedido realizado con éxito";
    $_SESSION['carrito'] = [];
} else {
    echo "ocurrió algún error y no se pudo realizar el pedido";
}
?>
<a href="../cart/index_carrito.php">Volver a la cesta</a>
