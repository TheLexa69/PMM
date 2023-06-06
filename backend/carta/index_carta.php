<?php
session_start();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Carta as carta;
use \clases\Carrito as carrito;

$carta = new carta();
$carrito = new carrito();

// Comprueba si hay un usuario autenticado en la sesión actual y si existe un carrito en la sesión o en una cookie
if (isset($_SESSION['usuario'])) {
    // Si hay un usuario autenticado en la sesión actual, lo guarda en una variable
    $usuario = $_SESSION['usuario'];

    // Si hay un carrito en la sesión actual, lo guarda en una variable
    if (isset($_SESSION['carrito'])) {
        $array_carrito = $_SESSION['carrito'];

        // Si no hay un carrito en la sesión actual, pero hay uno en una cookie, lo guarda en una variable
    } elseif (isset($_COOKIE['carrito']) && !empty($_COOKIE['carrito'])) {
        $array_carrito = $_SESSION['carrito'] = unserialize($_COOKIE['carrito'], ["allowed_classes" => false]);

        // Si no hay un carrito en la sesión actual ni en una cookie, pero hay uno en la base de datos, lo recupera y lo guarda en una variable
    } elseif (!isset($_SESSION['carrito'])) {
        $carrito_guardado = $carrito->getCarro($usuario);
        if ($carrito_guardado) {
            $array_carrito = unserialize($carrito_guardado['comida_cantidad'], ["allowed_classes" => false]);
            $_SESSION['carrito'] = $array_carrito;
        } else {
            $array_carrito = [];
        }
    }

// Si no hay un usuario autenticado en la sesión actual, pero hay un carrito en una cookie, lo guarda en una variable
} elseif (isset($_COOKIE['carrito'])) {
    $array_carrito = unserialize($_COOKIE['carrito'], ["allowed_classes" => false]);

// Si no hay un usuario autenticado ni un carrito en una cookie, guarda un array vacío en una variable
} else {
    $array_carrito = [];
}

// Si se recibe un valor en el parámetro POST llamado "dato", filtra la lista de artículos en la carta por alérgenos
if (isset($_POST['dato'])) {
    $consultaAlergenos = $carta->filterByAlergeno($_POST['dato']);
    if (isset($_GET["tipo"])) {
        $tipo = $_GET["tipo"];
        $url = "&tipo=$tipo";
    } else {
        $url = "";
    }

// Si se recibe un valor en el parámetro GET llamado "tipo", filtra la lista de artículos en la carta por tipo
} else if (isset($_GET["tipo"])) {
    $tipo = $_GET["tipo"];
    $rdo = $carta->filterByTipo($tipo);
    $url = "&tipo=$tipo";

// Si no se recibe ningún valor en los parámetros POST o GET, muestra la lista completa de artículos en la carta
} else {
    $rdo = $carta->printCarta();
    $url = "";
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    /**
     *
     * Actualiza la cantidad de un producto en el carrito a través de una petición AJAX
     * @param {number} id_comida - El ID del producto a actualizar
     * @param {number} cantidad - La nueva cantidad del producto
     * @return {void}
     */
    function updateCantidad(id_comida, cantidad) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../cart/actualizar_carrito.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Actualizar la página para reflejar los cambios
                window.location.reload();
            }
        };
        xhr.send('id_comida=' + id_comida + '&cantidad=' + cantidad);
    }
    function showCarritoFlotante() {
        document.getElementById('carritoFlotante').style.top = "70px";
    }
    function closeCarritoFlotante() {
        document.getElementById('carritoFlotante').style.top = "150vh";
    }
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>
<head>
    <title>Carta</title>
</head>
<div class="main">
    <div class="card container mt-5" style="padding: 0 !important">
        <div class="card-header text-center">
            <h3 class="fw-bold">Alérgenos</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="text-center">
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="2">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/2.svg" alt="2" value="2">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="3">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/3.svg" alt="3" value="3">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="4">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/4.svg" alt="4" value="4">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="5">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/5.svg" alt="5" value="5">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="6">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/6.svg" alt="6" value="6">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="7">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/7.svg" alt="7" value="7">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="8">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/8.svg" alt="8" value="8">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="9">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/9.svg" alt="9" value="9">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="10">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/10.svg" alt="10" value="10">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="11">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/11.svg" alt="11" value="11">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="12">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/12.svg" alt="12" value="12">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="13">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/13.svg" alt="13" value="13">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="14">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/14.svg" alt="14" value="14">
                        </input>
                    </label>
                    <label class="checkeable">
                        <input type="checkbox" name="dato[]" value="15">
                        <img class="img-select" width="80px" height="auto" src="../../frontend/img/15.svg" alt="15" value="15">
                        </input>
                    </label>
                </div>
                <div class="text-center mt-3">
                    <h2>Filtros</h2>
                    <hr>
                </div>
                <div id="contenedorAlergenos">
                </div>
                <div class="d-flex justify-content-center pb-3" id="reset">
                    <input class="btn btn-success" type="submit" value="Filtrar" ">
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow" id="carritoFlotante">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="fw-bold text-center mx-auto">Cesta</h3>
            <i class="fa-solid fa-xmark fa-2xl" onclick="closeCarritoFlotante();" style="cursor: pointer"></i>
        </div>
        <div class="card-body" style="padding: 0 !important">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd"
                                  d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($array_carrito as $comida => $cant) {
                        echo $carrito->printCarritoCarta($comida, $cant);
                    }
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-around mb-3" id="totalFixed">
                <a href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "index_carrito.php"; ?>'><button type='button' class='btn btn-outline-success'>Realizar Compra</button></a>
                <h4>Total: <?php echo $carrito->getTotalPrice($array_carrito) ?> </h4>
            </div>
        </div>
    </div>
    <div id="divPopUpForm" onclick="showCarritoFlotante();" style="">
        <p class="px-2 py-2 shadow fw-bold"
           style="margin-right: 40px; margin-bottom: -30px; height: 60px;background-color: white; width: 180px; border-radius: 5px;">
            Confiere tus productos!</p>
        <i class="fa-solid fa-circle fa-2xl circ" style="font-size: 4em; position: absolute; bottom: 0; right: 0;"></i>
        <i class="fa-solid fa-basket-shopping fa-bounce fa-2xl" style="position: absolute; right: 14px; color: white;"></i>
    </div>
    <div class="container d-flex flex-wrap justify-content-evenly mt-5">
        <!--<div class="row mt-5">-->
        <?php
        if (isset($consultaAlergenos)) {
            foreach ($consultaAlergenos as $fila) {
                ?>
                <div class="d-flex flex-wrap my-3 mx-2 shadow">
                    <div class="card" style="width: 20rem;">
                        <?php if (!empty($fila[4])) { ?>
                            <img src="<?php echo $fila[4] ?>" alt="Card image cap" class="card-img rounded" style="object-fit: cover; width: 100%; height: 200px;">
                        <?php } else { ?>
                            <img src="../imagenes/imgProductos/defecto.jpg" alt="Card image cap" class="card-img rounded" style="object-fit: cover; width: 100%; height: 200px;">
                        <?php } ?>
                        <div class="card-body text-center lh-sm">
                            <h4 class="nombre-producto"><?php echo $fila[0] ?></h4>
                            <div class="text-center">
                                <p>Descripción:
                                    <a href="#" onclick="event.preventDefault();" title="<?php echo $fila[1] ?>" data-toggle="popover" data-trigger="focus" data-content="Click anywhere in the document to close this popover">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                        </svg>
                                    </a>
                                </p>
                                <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> €</h5>
                                <form method="post" action="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "agregar_carrito.php?cod=" . $fila[6] . $url; ?>">
                                    <label for="cantidad">Cantidad:</label>
                                    <select id="cantidad" name="cantidad" style="margin-bottom: 5px"">
                                        <?php
                                        for ($i = 1; $i <= 15; $i++) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="col-md-4 d-flex mt-2" id="botonCompra">
                                        <!-- if session rol = admin button editar, deshabilitar -->
                                        <button class="btn-add-cart btn btn-success" id="compra" type="submit">Añadir</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            foreach ($rdo as $fila) {
                ?>
                <div class="d-flex flex-wrap my-3 mx-2 shadow">
                    <div class="card" style="width: 20rem;">
                        <?php if (!empty($fila[4])) { ?>
                            <img src="<?php echo $fila[4] ?>" alt="Card image cap" class="card-img rounded" style="object-fit: cover; width: 100%; height: 200px;">
                        <?php } else { ?>
                            <img src="../imagenes/imgProductos/defecto.jpg" alt="Card image cap" class="card-img rounded" style="object-fit: cover; width: 100%; height: 200px;">
                        <?php } ?>
                        <div class="card-body text-center lh-sm">
                            <h4 class="nombre-producto"><?php echo $fila[0] ?></h4>
                            <div class="text-center">
                                <p>Descripción:
                                    <a href="#" onclick="event.preventDefault();" title="<?php echo $fila[1] ?>" data-toggle="popover" data-trigger="focus" data-content="Click anywhere in the document to close this popover">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                        </svg>
                                    </a>
                                </p>
                                <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> €</h5>
                                <form method="post" action="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "agregar_carrito.php?cod=" . $fila[6] . $url; ?>">
                                    <label for="cantidad">Cantidad:</label>
                                    <select id="cantidad" name="cantidad" style="margin-bottom: 5px"">
                                        <?php
                                        for ($i = 1; $i <= 15; $i++) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="col-md-4 d-flex mt-2" id="botonCompra">
                                        <!-- if session rol = admin button editar, deshabilitar -->
                                        <button class="btn-add-cart btn btn-success" id="compra" type="submit">Añadir</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    <!--</div>-->
</div>
<?php
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
