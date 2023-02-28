<?php
session_start();
//require "../clases_carrito/carrito.php";
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
use clases\Carrito as carrito;
$carrito = new carrito();
$rol = isset($_SESSION['id_rol']) ? $_SESSION['id_rol'] : null;
?>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	const miEnlace = document.getElementById("log");
	const rol = 5;

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

	if (<?php echo json_encode($rol) ?> == null) {
		miEnlace.addEventListener("click", function(event) {
		event.preventDefault(); // evita que se recargue la página al hacer clic en el enlace
		// muestra el mensaje de alerta durante 3 segundos
			setTimeout(function() {
			alert("Necesitas iniciar sesión o registrarte");
			});

			// redirige a la página después de hacer clic en "Aceptar"
			setTimeout(function() {
			window.location.href = "../login/indexLogin.php";
			}, 1000);

		});
	}
});

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
			setcookie('carrito', null, time() - 3600, "/");
		
		} else {
			$_SESSION['carrito'] = [];
		}
	}
	
	
	if(empty($_SESSION["carrito"])) {
		echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
	} else {
		foreach($_SESSION['carrito'] as $comida => $cant) {
			$id_comida = $comida;
			$cantidad = (int) $cant;
			print ($carrito->printCarroSes($id_comida, $cantidad));
		}
		$precio_total = $carrito->getTotalPrice(serialize($_SESSION['carrito']));
		echo $precio_total ."€";
		echo '<br><a href="procesar_pedido.php">Realizar compra</a>	';
	}
	
	
		
} else { 
    if (isset($_COOKIE['carrito'])) {
		if (empty(unserialize($_COOKIE['carrito']))) {
			echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
		} else {
			foreach(unserialize($_COOKIE['carrito'], []) as $comida => $cant) {
				$id_comida = $comida;
				$cantidad = (int) $cant;
				echo ($carrito->printCarroSes($id_comida, $cantidad));
			}
			$precio_total = $carrito->getTotalPrice($_COOKIE['carrito']);
			echo $precio_total . "€";
			echo '</br><a href="#" id="log">Realizar compra</a>	'; //alert js que necesita iniciar sesión
		}
	} else {
        echo "<div class='warning'>No tienes productos en tu cesta todavía.</div>";
    }
}
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
?>