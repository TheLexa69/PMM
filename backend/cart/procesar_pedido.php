<?php
require "../clases_carrito/carrito.php";
session_start();
/* crear pedido, añadir last insert id a carrito, $rdo = $carrito->add if true se vacia el carrito
if false print error */
if ($_SESSION['usuario']) {}