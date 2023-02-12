<?php
require("../../frontend/php/nav.php");

//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';

if (!isset($_SESSION['usuario'])) { 
	// Si no hay una sesión iniciada, comprobar si hay productos en la cookie
	if (isset($_COOKIE['carrito'])) {
		// Si hay productos, deserializar los datos y guardarlos en una variable
		$arr_carrito = unserialize($_COOKIE['carrito'], true);
	} else {
		// Si no hay productos se crea un array vacío para guardarlos
		$arr_carrito = array();
	}

	// Añadir producto al array
	if($_GET["cod"]) {
		array_push($arr_carrito, $id_comida, $cantidad);
		// Serializar los datos y guardarlos en una cookie
	setcookie('carrito', serialize($arr_carrito), time() + (86400 * 30), "/");
	}
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