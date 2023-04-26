<?php
require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "sesiones" . DIRECTORY_SEPARATOR . "sesiones.php";
comprobar_sesion();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Pedido as pedido;

$pedidos = new pedido();

$id = $_SESSION["usuario"];

if (!empty($_POST['orden'])) {
    $orden = $_POST['orden'];
    $_SESSION["orden"] = $orden;
}
$orden = (isset($_SESSION["orden"])) ? $_SESSION["orden"] : false;

$por_pagina = 10;

if (isset($_GET['pagina'])) {
    $pagina_actual = $_GET['pagina'];
} else {
    $pagina_actual = 1;
}
$indice_primer_elemento = ($pagina_actual - 1) * $por_pagina;
$total_paginas = ceil($pedidos->obtenerNumPedidos($id) / $por_pagina);

$ped = $pedidos->obtenerPedidos($id, $orden, $indice_primer_elemento, $por_pagina);
?>

<div class="container main mt-5">
    <div class="card rounded">
        <div class="card-header text-center">
            <h3>Lista de pedidos realizados.</h3>
        </div>
        <div class="card-body text-center">
            <div class="d-flex justify-content-center">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h3>Filtrar por fecha:</h3>
                    <div class="mt-2 d-flex align-items-center justify-content-center">
                        <input type="radio" name="orden" value="ASC" id="ASC" class="form-check-input" id="asc"> 
                        <label class="form-check-label" for="ASC">
                            Antiguas primero
                        </label>
                        <input type="radio" name="orden" value="DESC" id="DESC" class="form-check-input"> 
                        <label class="form-check-label" for="DESC">
                            Recientes primero
                        </label>
                    </div>
                    <input type="submit" name=validar value="Filtrar" class='btn btn-default btn-outline-success mt-2'>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped able-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th scope="d-sm-table-cell">Nº de pedido</th>
                        <th scope="d-sm-table-cell">Fecha</th>
                        <th scope="d-sm-table-cell">Productos</th>
                        <th scope="d-sm-table-cell">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ped as $value) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $value['id_ped']; ?></th>
                            <td><?php echo $value['fecha']; ?></td>
                            <td><?php
                                foreach ($value['productos'] as $v) {
                                    echo "<ul><li> " . $v['nombre'] . " </li>";
                                    echo "<li>Cantidad: " . $v['cantidad'] . " </li>";
                                    echo "<li>Precio: " . $v['precio'] . "€ </li></ul>";
                                }
                                ?></td>
                            <td><?php echo $value["total"] . "€"; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center gap-3">
        <?php 
            echo "<nav aria-label='...'>
                <ul class='pagination pagination-lg'>
                ";
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($i == $pagina_actual) {
                echo "<li class='page-item active' aria-current='page'><span class='page-link'><a style = 'color: black;' href='#'> $i </a></span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' style = 'color: black;' href='?pagina=$i'> $i </a></li>";
                }
            }
            echo "</ul></nav>";
      
        ?>
        </div>

        <div class="text-center my-3">
            <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-default btn-outline-danger">Volver al inicio</a>
        </div>
    </div>
</div>
<?php
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
