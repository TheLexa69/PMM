<?php
require("../../frontend/php/nav.php");

//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';

if (!isset($_SESSION['usuario'])) { 
    if(isset($_COOKIE['carrito']));
} elseif (isset( $_SESSION['usuario'])) {
	session_start();
//$db = conexion();

	$email = $_SESSION['usuario'];
	$carrito = new carrito();
	$filas_carro = $carrito->getCarro($email);
		if ($filas_carro->rowCount() == 0) {
			echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
		} else {
			$carrito->printCarro($email);
		}	
}
require "../../frontend/php/footer.php";
?>