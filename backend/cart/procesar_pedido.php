<?php
require "../sesiones/sesiones.php";
//session_start();
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Pedido as pedido;
use \clases\Carrito as carrito;

$c = new carrito($_SESSION['rolUsusario']);
$p = new pedido($_SESSION['rolUsusario']);

$id_usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'];
// Calcula el precio total del carrito
$precio = $c->getTotalPrice($_SESSION['carrito']);

// Obtiene la CIF y el modo de pago del formulario de envío
$cif = $_POST['opciones_res'];
$modo_pago = $_POST['opciones_modo_pago'];

// Obtiene las especificaciones adicionales del pedido del formulario de envío
$especif = $_POST['especif'];

// Crea un nuevo pedido y guarda el resultado en $pedido
$pedido = $p->crearPedido($id_usuario, $carrito, $precio, $cif, $modo_pago);

// Si se creó el pedido, crea un array con el contenido del carrito, el precio total y las especificaciones adicionales,
// crea el cuerpo del correo y lo envía al correo del usuario.
// Si no se creó el pedido, muestra un mensaje de error.
?>
<div class="container main p-0 mt-5 card">
    <?php
    if ($pedido) {
        $array_carrito = $p->array_carrito($carrito, $precio, $especif);
        $cuerpo = $p->crear_correo($array_carrito, $pedido);
        $p->enviar($_SESSION['mail'], $cuerpo);
        echo ''
        . '<div class="card-header text-center"><h2>Pedido confirmado.</h2></div>'
        . '<div class="card-body">¡Muchas gracias por comprar con nosotros! <br>'
        . 'Nos complace haber tenido la oportunidad de servirle y esperamos que haya disfrutado de su experiencia de compra. <br>'
        . 'En nuestra empresa, nos esforzamos por ofrecer productos y servicios de alta calidad, y su satisfacción es nuestra máxima prioridad. <br>'
        . 'Si tiene alguna pregunta o comentario sobre su compra, no dude en ponerse en contacto con nosotros. <br><br>'
        . '¡Gracias de nuevo por elegirnos como su proveedor y esperamos poder servirle nuevamente en el futuro!</div>';
        echo '<div class="card-body"><div class="col-2 d-flex justify-content-right"><button type="button" class="btn btn-outline-secondary" id="download-button">Descargar factura en PDF</button></div>';
        echo '<div id="descargar">';
        echo $cuerpo;
        echo '</div></div>

        <script>
            const guardarpdf = document.getElementById("download-button");
            function generarpdf() {
                const element = document.getElementById("descargar");
                html2pdf().from(element).save();
            }

            guardarpdf.addEventListener("click", generarpdf);
        </script> ';

        echo '<div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #80ff00; color: black; padding: 10px;">';
        echo '<h2>Pedido realizado con éxito, te hemos enviado un correo.</h2>';
        echo '</div>';
        echo "<script defer>
              window.onload = function() {
              var mensajeDiv = document.getElementById('mensaje');
              mensajeDiv.style.top = '20%';
              setTimeout(function() {
                    mensajeDiv.style.top = '-150%';
                    }, 5000);
                    }
              </script>";
        $_SESSION['carrito'] = [];
        $c->add($id_usuario, NULL);
    } else {
        //echo '<div class="layered box row mr-2"><h2 class="col-10 d-flex justify-content-center">Ocurrió algún error y no se pudo realizar el pedido</h2></div>';
        echo ''
        . '<div class="card-header text-center"><h2>Pedido confirmado.</h2></div>'
        . '<div class="card-body">¡Muchas gracias por comprar con nosotros! <br>'
        . 'Lamentamos sinceramente el error que ocurrió durante su intento de compra con nosotros. <br>'
        . 'Por favor, acepte nuestras disculpas por cualquier inconveniente que esto haya causado. <br>'
        . 'Si hay algo más que podamos hacer para ayudar a solucionar el problema, no dude en hacérnoslo saber. <br><br>'
        . 'Gracias por su comprensión y por darnos la oportunidad de servirle mejor en el futuro.</div>';
        
        echo '<div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #f44336; color: white; padding: 10px;">';
        echo '<h2>Ocurrió algún error y no se pudo realizar el pedido.</h2>';
        echo '</div>';
        echo "<script defer>
              window.onload = function() {
              var mensajeDiv = document.getElementById('mensaje');
              mensajeDiv.style.top = '20%';
              setTimeout(function() {
                    mensajeDiv.style.top = '-150%';
                    }, 5000);
                    }
              </script>";
    }
    ?>
    <br>
    <div class="card-footer">
        <div class="col-2 d-flex justify-content-right">
            <a href="../login/indexLogin.php"><button type="button" class="btn btn-outline-secondary">Volver al inicio</button></a>
        </div>
    </div>
</div> <!--NO BORRAR ES EL FINAL DEL DIV DE ARRIBA-->

<?php
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
