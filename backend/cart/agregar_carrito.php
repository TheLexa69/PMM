<?php
//Se manda un proucto por $_GET desde carta.php y añade a la cesta
	if($_GET["cod"]) {
		$carrito = new carrito();
		$carrito->add($carrito->searchId($email), $_GET["cod"], $_POST["cantidad"]);
	}

header("Location: index_carrito.php");
exit();