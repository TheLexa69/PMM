<?php

/* Actualiza la cantidad de un producto recibido con Ajax */
session_start();
$id_comida = $_POST['id_comida'];
$cantidad = $_POST['cantidad'];
if (!isset($_SESSION['usuario'])) {
    // Si no hay una sesión iniciada, comprobar si hay productos en la cookie
    if (isset($_COOKIE['carrito'])) {
        // Si hay productos, deserializar los datos y guardarlos en una variable
        $arr_carrito = unserialize($_COOKIE['carrito'], []);
    } else {
        // Si no hay productos se crea un array vacío para guardarlos
        $arr_carrito = array();
    }
    $arr_carrito["$id_comida"] = (int) $cantidad;

    // Serializar los datos y guardarlos en una cookie
    setcookie('carrito', serialize($arr_carrito), time() + (86400 * 30), "/");
} else {

    if (isset($_SESSION['carrito'])) {
        $arr_carrito = $_SESSION['carrito'];
    } else {
        // Si no hay productos se crea un array vacío para guardarlos
        $arr_carrito = array();
    }
    $arr_carrito["$id_comida"] = $cantidad;

    // Actualizar la variable de sesión con los cambios realizados
    $_SESSION['carrito'] = $arr_carrito;
}
