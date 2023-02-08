<?php
include "header.php";

//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';

if (!isset($_SESSION)) {
	session_start();
        //guardar en cookies el carrito
} 

//$db = conexion();

if (!isset($_SESSION['usuario'])) {
	echo "<div class='warning'>Necesitas iniciar sesión para visualizar este contenido</div>";
} else {
	$email = $_SESSION['usuario'];
        $carrito = new carrito();
        $carrito->getCarro($email);
        if ($carrito->rowCount() == 0) {
		echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
	} else {
		
           
	}	
}




include "footer.php";
?>
</body>
</html>