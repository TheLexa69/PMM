<?php
session_start();
//use clases_carrito\carrito as carrito;
require "../clases_carrito/carrito.php";
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 

//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';
$carrito = new carrito();
if (isset( $_SESSION['usuario'])) {
	$usuario = $_SESSION['usuario'];
	
	//$db = conexion();
	if (isset($_COOKIE['carrito'])) {
		/*foreach (unserialize($_COOKIE['carrito']) as $array) {
			$_SESSION['carrito'][] = $array;
		}*/
		$_SESSION['carrito'] = unserialize($_COOKIE['carrito'], []);
		//var_dump($_SESSION['carrito']);
	}
		
		foreach($_SESSION['carrito'] as $comida => $cant) {
			$id_comida = $comida;
			$cantidad = $cant;
			print ($carrito->printCarroSes($id_comida, $cantidad));
		}
		/*$filas_carro = $carrito->getCarro($usuario);
			if ($filas_carro) {
				print $carrito->printCarro($usuario);
			} else {*/
			if(empty($_SESSION["carrito"])) {
				echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
			}
		echo '<a href="procesar_pedido.php">Realizar compra</a>	';
	}else { 
    if (isset($_COOKIE['carrito'])) {
		foreach(unserialize($_COOKIE['carrito'], []) as $comida => $cant) {
			$id_comida = $comida;
			$cantidad = $cant;
			echo ($carrito->printCarroSes($id_comida, $cantidad));
		}
		echo '<a href="procesar_pedido.php">Realizar compra</a>	'; //alert js que necesita iniciar sesión
    } else {
        echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
    }
}
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>