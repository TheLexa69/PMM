<?php
require "../sesiones/sesiones.php";
//session_start();
comprobar_sesion();
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
//require "../clases/Pedido.php";
use \clases\Pedido as pedido;
$p = new pedido();
$res = $p->getEmpresas();
$modo_pago = $p->getModoPago();
/* crear pedido, añadir last insert id a carrito, $rdo = $carrito->add if true se vacia el carrito
if false print error */

if (isset($_SESSION['usuario'])) {
    ?>

    <form action="procesar_pedido.php" method="post">
      <label for="opciones_res">Elige en qué restaurante quieres recoger tu pedido:</label><br>
      <!-- foreach de la base de datos -->
      <?php
        foreach ($res as $restaurante) {
            $cif = $restaurante['cif'];
            $nombre = $restaurante['nombreLocal'];
            $dir = $restaurante['direccion'];
            echo "<input type='radio' id='" .$dir."' name='opciones_res' value='".$cif."' required>
            <label for='" .$dir."'>$nombre<br>Dirección: $dir</label><br>";
        }
      ?>
      
      <label for="especif">Indícanos aquí si deseas quitar algún ingrediente:</label><br>
      <input type="text" id="especif" name="especif"><br><br>

      <label for="met_pago">Elige el método de pago:</label><br>
      <!-- foreach de la base de datos -->
      <?php
        foreach ($modo_pago as $pago) {
            $nombre = $pago['nombre'];
            $id = $pago['id_modo_pago'];
            echo "<input type='radio' id='" .$id."' name='opciones_modo_pago' value='".$id."' required>
            <label for='" .$id."'>". strtoupper($nombre) . "</label><br>";
        }
      ?>
      
      <input type="submit" value="Finalizar compra">
    </form>

    <?php
}
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
