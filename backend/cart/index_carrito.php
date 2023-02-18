<?php
session_start();
//use clases_carrito\carrito as carrito;
require "../clases_carrito/carrito.php";
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 

//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';

if (isset( $_SESSION['usuario'])) {

	//$db = conexion();
	
		$usuario = $_SESSION['usuario'];
		$carrito = new carrito();
		$filas_carro = $carrito->getCarro($usuario);
			if ($filas_carro) {
				print $carrito->printCarro($usuario);
			} else {
				echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
			}
		echo '<a href="procesar_pedido.php">Realizar compra</a>	';
	}elseif (!isset($_SESSION)) { 
    if (isset($_COOKIE['carrito'])) {
        var_dump(unserialize($_COOKIE['carrito'], [])); 
		echo '<a href="procesar_pedido.php">Realizar compra</a>	'; //alert js que necesita iniciar sesión
    } else {
        echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
    }
}
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>