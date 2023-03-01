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
      <div class="layered box row mr-2">
      <h2 class="col-10 d-flex justify-content-right">
      <label for="opciones_res">Elige en qué restaurante quieres recoger tu pedido:</label></h2><br>
      <!-- foreach de la base de datos -->
      <div class="form-check">
      <?php
        foreach ($res as $restaurante) {
            $cif = $restaurante['cif'];
            $nombre = $restaurante['nombreLocal'];
            $dir = $restaurante['direccion'];
            echo '
            <input class="form-check-input" type="radio" id="' .$dir.'" name="opciones_res" value="'.$cif.'"required>
            <label class"form-label" for="' .$dir.'">'.$nombre.'<br>Dirección: ' .$dir. '</label><br>';
            
        }
      ?>
      </div>
      </div>
      <div class="layered box row mr-2">
      <h2 class="col-10 d-flex justify-content-right">
        <label for="especif" class="form-label">Indícanos aquí si deseas quitar algún ingrediente:</label></h2><br>
        <input type="text" class="form-control" id="especif" name="especif"><br><br>
      </div>

      <div class="layered box row mr-2">
      <h2 class="col-10 d-flex justify-content-right">
      <label for="met_pago">Elige el método de pago:</label></h2><br>
      <!-- foreach de la base de datos -->
      <div class="form-check">
      <?php
        foreach ($modo_pago as $pago) {
            $nombre = $pago['nombre'];
            $id = $pago['id_modo_pago'];
            echo "<input class='form-check-input' type='radio' id='" .$id."' name='opciones_modo_pago' value='".$id."' required>
            <label class='form-label' for='" .$id."'>". strtoupper($nombre) . "</label><br>";
        }
      ?>
      </div>
      </div>
      <div class="layered box row mr-2">
        <div class="col-2 d-flex justify-content-right">
          <button type="submit" class="btn btn-outline-success">Finalizar compra</button>
        </div>
      </div>
    </form>

    <?php
}
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
