<?php
/* Suma productos a la cesta si eliges el mismo al añadir producto */
//use clases_carrito\carrito;
require "../clases_carrito/carrito.php";
session_start();
$cod_comida = $_GET["cod"];
$cantidad = $_POST["cantidad"];
$tipo = $_GET['tipo'];
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
		if($arr_carrito["$cod_comida"]) {
			$arr_carrito["$cod_comida"] += $cantidad;
		}else{
			$arr_carrito["$cod_comida"] = (int) $cantidad;
		}
		// Serializar los datos y guardarlos en una cookie
		setcookie('carrito', serialize($arr_carrito), time() + (86400 * 30), "/");
	}
} else {
	
	if (isset($_SESSION['carrito'])) {
			// Si hay productos, deserializar los datos y guardarlos en una variable
			$arr_carrito = $_SESSION['carrito'];
    } else {
        // Si no hay productos se crea un array vacío para guardarlos
        $arr_carrito = array();
    }

    // Añadir producto al array
    if($_GET["cod"]) {
        if(isset($arr_carrito["$cod_comida"])) {
            $arr_carrito["$cod_comida"] += $cantidad;
        } else {
			$arr_carrito["$cod_comida"] = (int) $cantidad;
		}
        // Actualizar la variable de sesión con los cambios realizados
        $_SESSION['carrito'] = $arr_carrito;
            //$carrito = new carrito();
            //$carrito->add($id_usuario, $cod_comida, $_POST["cantidad"]);
	}
}

header("Location: ../carta/index_carta.php?tipo=$tipo");