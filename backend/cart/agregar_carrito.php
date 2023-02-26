<?php
//use clases_carrito\carrito;
require "../clases_carrito/carrito.php";
session_start();
$cod_comida = $_GET["cod"];
$cantidad = $_POST["cantidad"];
if (!isset($_SESSION['usuario'])) { 
	// Si no hay una sesión iniciada, comprobar si hay productos en la cookie
	if (isset($_COOKIE['carrito'])) {
		// Si hay productos, deserializar los datos y guardarlos en una variable
		$arr_carrito = unserialize($_COOKIE['carrito'], []);
                //$arr_carrito = $_COOKIE['carrito'];
	} else {
		// Si no hay productos se crea un array vacío para guardarlos
		$arr_carrito = array();
	}

	// Añadir producto al array
	if($_GET["cod"]) {
                $arr_carrito[] = array('codigo' => $cod_comida, 'cantidad' => $cantidad);
                var_dump($arr_carrito);
		//array_push($arr_carrito, $_GET["cod"], 1);
		// Serializar los datos y guardarlos en una cookie
                setcookie('carrito', serialize($arr_carrito), time() + (86400 * 30), "/");
                //setcookie('carrito', $arr_carrito, time() + (86400 * 30), "/");
	}
} else {
//Se manda un proucto por $_GET desde carta.php y añade a la cesta
	if($_GET["cod"]) {
            $id_usuario = $_SESSION['usuario'];
            $carrito = new carrito();
            $carrito->add($id_usuario, $cod_comida, $_POST["cantidad"]);
	}
}

header("Location: index_carrito.php");