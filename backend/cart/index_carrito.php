<?php
session_start();
<<<<<<< Updated upstream
//use clases_carrito\carrito as carrito;
require "../clases_carrito/carrito.php";
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
?>
<script>
	function updateCantidad(id_comida, cantidad) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'actualizar_carrito.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
		// Actualizar la página para reflejar los cambios
		window.location.reload();
		}
	};
	xhr.send('id_comida=' + id_comida + '&cantidad=' + cantidad);
}
=======
//require "../clases_carrito/carrito.php";
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
use clases\Carrito as carrito;
$carrito = new carrito();
$rol = isset($_SESSION['id_rol']) ? $_SESSION['id_rol'] : null;
$win_loc = "../login/indexLogin.php";
?>
<script>


	function updateCantidad(id_comida, cantidad) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'actualizar_carrito.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			// Actualizar la página para reflejar los cambios
			window.location.reload();
			}
		};
		xhr.send('id_comida=' + id_comida + '&cantidad=' + cantidad);
	}

	document.addEventListener("DOMContentLoaded", function(event) {
	// Obtener el botón de realizar compra
	const miEnlace = document.getElementById("log");

		// Añadir un evento de clic al botón
		miEnlace.addEventListener("click", function() {
		// Comprobar si el usuario ha iniciado sesión
		if (!usuarioIniciado()) {
			// Mostrar un alerta y redirigir a la página de inicio de sesión
			alert("Tienes que iniciar sesión");
			window.location.href = "../login/indexLogin.php";
		} 
		});

		// Función para comprobar si el usuario ha iniciado sesión
		function usuarioIniciado() {
			// Obtener todas las cookies del sitio
			var cookies = document.cookie.split(";");

			// Buscar la cookie de sesión específica
			for (var i = 0; i < cookies.length; i++) {
			var cookie = cookies[i].trim();
			if (cookie.indexOf("carrito=") == 0) {
				// La cookie de sesión específica existe
				return false;
			}
			}

			// Si no, el usuario no ha iniciado sesión
			return true;
		}
});

>>>>>>> Stashed changes
</script>
<?php
//fichero conexion (no hace falta al tenerlo en la clase)
//require_once 'conexion.php';
if (isset($_SESSION['usuario'])) {
	$usuario = $_SESSION['usuario'];
	if (!isset($_SESSION['carrito'])) {
		$carrito_guardado = $carrito->getCarro($usuario);
		//Sacamos el carrito de la base de datos y lo igualamos a la variable de sesión
		//Si no encuentra nada en la base de datos va a mirar a las cookies y si no hay 
		//nada en ninguno de los dos crear la variable de sesión como array vacío 
		//Mejora: elegir entre el carrito de la base de datos y el carrito de las cookies
		if ($carrito_guardado) {
			$_SESSION['carrito'] = unserialize($carrito_guardado['comida_cantidad'], []);
		} elseif (isset($_COOKIE['carrito']) && !empty(unserialize($_COOKIE['carrito']))) {
			$_SESSION['carrito'] = unserialize($_COOKIE['carrito'], []);
		} else {
			$_SESSION['carrito'] = [];
		}
	}
	
	
	if(empty($_SESSION["carrito"])) {
		echo '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-center">No tienes productos en tu cesta todavía.</h2></div>';
	} else {
		foreach($_SESSION['carrito'] as $comida => $cant) {
			$id_comida = $comida;
			$cantidad = (int) $cant;
			print ($carrito->printCarroSes($id_comida, $cantidad));
		}
<<<<<<< Updated upstream
<<<<<<< Updated upstream
		$precio_total = $carrito->getTotalPrice(serialize($_SESSION['carrito']));
<<<<<<< Updated upstream
		print $precio_total;
=======
		echo $precio_total ."€";
>>>>>>> Stashed changes
		echo '<br><a href="procesar_pedido.php">Realizar compra</a>	';
=======
		$precio_total = $carrito->getTotalPrice($_SESSION['carrito']);
		echo  '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-end">Total: '. $precio_total .'</h2>';
		echo '<div class="col-2 d-flex justify-content-right"><a href="realizar_pedido.php"<button type="button" class="btn btn-outline-success">Finalizar compra</button></a></div></div>';
>>>>>>> Stashed changes
=======
		$precio_total = $carrito->getTotalPrice($_SESSION['carrito']);
		echo  '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-end">Total: '. $precio_total .'</h2>';
		echo '<div class="col-2 d-flex justify-content-right"><a href="realizar_pedido.php"><button type="button" class="btn btn-outline-success">Finalizar compra</button></a></div></div>';
>>>>>>> Stashed changes
	}
	
	
		
} else { 
    if (isset($_COOKIE['carrito'])) {
		if (empty(unserialize($_COOKIE['carrito']))) {
			echo '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-center">No tienes productos en tu cesta todavía.</h2></div>';
		} else {
			foreach(unserialize($_COOKIE['carrito'], []) as $comida => $cant) {
				$id_comida = $comida;
				$cantidad = (int) $cant;
				echo ($carrito->printCarroSes($id_comida, $cantidad));
			}
<<<<<<< Updated upstream
<<<<<<< Updated upstream
			$precio_total = $carrito->getTotalPrice($_COOKIE['carrito']);
<<<<<<< Updated upstream
			print $precio_total;
			echo '<a href="procesar_pedido.php">Realizar compra</a>	'; //alert js que necesita iniciar sesión
=======
			echo $precio_total . "€";
			echo '</br><a href="#" id="log">Realizar compra</a>	'; //alert js que necesita iniciar sesión
>>>>>>> Stashed changes
		}
=======
			$precio_total = $carrito->getTotalPrice(unserialize($_COOKIE['carrito'], []));
			echo  '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-end">Total: '. $precio_total .'</h2>';
		echo '<div class="col-2 d-flex justify-content-right"><a id="log" href="../login/indexLogin.php"><button type="button" class="btn btn-outline-success">Finalizar compra</button></a></div></div>';
	}
>>>>>>> Stashed changes
=======
			$precio_total = $carrito->getTotalPrice(unserialize($_COOKIE['carrito'], []));
			echo  '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-end">Total: '. $precio_total .'</h2>';
		echo '<div class="col-2 d-flex justify-content-right"><a href="#"><button id="log" type="button" class="btn btn-outline-success">Finalizar compra</button></a></div></div>';
	}
>>>>>>> Stashed changes
	} else {
		echo '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-center">No tienes productos en tu cesta todavía.</h2></div>';
    }
}
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>