<?php
/*Elimina el producto de la cesta */
session_start();
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
//require "../clases_carrito/carrito.php";
use clases\Carrito as carrito;
$cod_comida = $_GET["cod"];
if (!isset($_SESSION['usuario'])) { 
	// Si no hay una sesión iniciada, comprobar si hay productos en la cookie
	if (isset($_COOKIE['carrito'])) {
		// Si hay productos, deserializar los datos y guardarlos en una variable
		$arr_carrito = unserialize($_COOKIE['carrito'], []);
	} else {
		// Si no hay productos se crea un array vacío para guardarlos
		$arr_carrito = array();
	}

	// Eliminar producto del array
	if($_GET["cod"]) {
		if($arr_carrito["$cod_comida"]) {
			unset($arr_carrito["$cod_comida"]);
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

    // Eliminar producto del array
    if($_GET["cod"]) {
        if(isset($arr_carrito["$cod_comida"])) {
            unset($arr_carrito["$cod_comida"]);
        }
        // Actualizar la variable de sesión con los cambios realizados
        $_SESSION['carrito'] = $arr_carrito;
	}
}

header("Location: index_carrito.php");
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 