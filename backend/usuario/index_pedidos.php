<?php

require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Pedido as pedido;

$pedidos = new pedido();

$id = $_SESSION["usuario"];

if (!empty($_POST['orden'])) {
    $orden = $_POST['orden'];
}
$orden = (isset($orden)) ? $orden : false;
$ped = $pedidos->obtenerPedidos($id, $orden);
?>
<div class="container bg-light rounded mt-5 w-60 p-3">
<div class="d-flex justify-content-center text-center">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h3>Ordenar por fecha:</h3>

        <div class="mt-2 d-flex align-items-center">
            <div class="form-check m-3">
                <input type="radio" name="orden" value="ASC" class="form-check-input" id="asc"> 
                <label class="form-check-label" for="asc">
                    Antiguas primero
                </label>
            </div>
            <div class="form-check">
                <input type="radio" name="orden" value="DESC" class="form-check-input"> 
                <label class="form-check-label" for="desc">
                    Recientes primero
                </label>
            </div>
            <div class=" m-3">
                <input type="submit" name=validar value="Filtrar" class='btn btn-default btn-outline-success'>
            </div>
        </div>
    </form>
</div>
<div class="text-center">
    <h2>Pedidos realizados:</h2>
    <hr>
</div>
<table class="table">
   <thead>
        <tr>
            <th scope="col">Nº pedido</th>
            <th scope="col">Fecha</th>
            <th scope="col">Productos</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
      <?php   foreach ($ped as $value) { 
                ?>
            <tr>
                <th scope="row"><?php echo $value['id_ped']; ?></th>
                <td><?php echo $value['fecha']; ?></td>
                <td><?php foreach($value['productos'] as $v) {
                    echo "<ul><li> " .$v['nombre']." </li>";
                    echo "<li>Cantidad: " .$v['cantidad']." </li>";
                    echo "<li>Precio: " .$v['precio']."€ </li></ul>";
                } ?></td>
                <td><?php echo $value["total"] . "€"; ?></td>
            </tr>
            <?php
                }
        ?>
    </tbody>
</table>

<div class="text-center mt-3">
    <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Volver</a>
</div>
</div>
<?php
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
