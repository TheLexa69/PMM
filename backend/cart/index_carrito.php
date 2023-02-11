<?php
require("../../frontend/php/nav.php");

//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';

if (!isset($_SESSION)) {
	session_start();
        //guardar en cookies el carrito
} 

//$db = conexion();

$email = $_SESSION['usuario'];
$carrito = new carrito();
//Se manda un proucto por $_GET y añade a la añade
if($_GET["cod"]) {
	$carrito->add($carrito->searchId($email), $_GET["cod"], $_POST["cantidad"]);
}

if (!isset($_SESSION['usuario'])) {
	echo "<div class='warning'>Necesitas iniciar sesión para visualizar este contenido</div>";
} else {
	$email = $_SESSION['usuario'];
        
        $carrito->getCarro($email);
        if ($carrito->rowCount() == 0) {
		echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
	} else {
		
           
	}	
}




require "../../frontend/php/footer.php";
?>