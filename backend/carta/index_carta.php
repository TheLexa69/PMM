<?php
session_start();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Carta as carta;
use \clases\Carrito as carrito;

$carta = new carta();
$carrito = new carrito();

if (isset($_SESSION['carrito'])) {
    $array_carrito = $_SESSION['carrito'];
} elseif (isset($_COOKIE['carrito'])) {
    $array_carrito = unserialize($_COOKIE['carrito']);
} else {
    $array_carrito = [];
}

if (isset($_POST['dato'])) {
    $consultaAlergenos = $carta->filterByAlergeno($_POST['dato']);
    if (isset($_GET["tipo"])) {
        $tipo = $_GET["tipo"];
        $url = "&tipo=$tipo";
    } else {
        $url = "";
    }
} else if (isset($_GET["tipo"])) {
    $tipo = $_GET["tipo"];
    $rdo = $carta->filterByTipo($tipo);
    $url = "&tipo=$tipo";
} else {
    $rdo = $carta->printCarta();
    $url = "";
}
?>
<script>
    function updateCantidad(id_comida, cantidad) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../cart/actualizar_carrito.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Actualizar la página para reflejar los cambios
                window.location.reload();
            }
        };
        xhr.send('id_comida=' + id_comida + '&cantidad=' + cantidad);
    }
</script>
<div class="container bg-light rounded mt-2 d-flex justify-content-center">
    <div class="container">
        <div class="text-center mt-3">
            <h2>Alergenos</h2>
            <hr>
        </div>
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
                <input class="btn btn-outline-dark" type="submit" value="Filtrar" ">
                <input class="btn btn-outline-dark" type="reset" value="Reset">
            </div>
        </form>
    </div>
</div>

<div class="row mt-5">
    <div class="col-8">
        <div id="boton">
            <?php
            if (isset($consultaAlergenos)) {
                foreach ($consultaAlergenos as $fila) {
                    ?>
                    <div class="layered box row mr-2" id="producto">
                        <div class="col-4">                        
                            <img class="imagenes rounded img-fluid" id="producto_img" title="vaso" src="https://cdn.pixabay.com/photo/2020/12/15/13/44/children-5833685__340.jpg">
                        </div>
                        <div class="col-4 d-flex ml-2 flex-column">
                            <h4 class="nombre-producto"><?php echo $fila[0] ?></h4>
                            <p>Descripción:
                                <a href="#" id="info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                </a>
                            </p>

                            <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> €</h5>
                            <form method="post" action="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "agregar_carrito.php?cod=" . $fila[6] . $url; ?>">
                                <label for="cantidad">Cantidad:</label>
                                <select id="cantidad" name="cantidad">'
                                    <?php
                                    for ($i = 1; $i <= 10; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?> 
                                </select>
                                <div class="col-4 d-flex justify-content-center">
                                    <!-- if session rol = admin button editar, deshabilitar -->     
                                    <button class="btn-add-cart btn btn-outline-secondary" id="compra" type="submit">Añadir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                foreach ($rdo as $fila) {
                    ?>
                    <div class="layered box row mr-2" id="producto">
                        <div class="col-4">                        
                            <img class="imagenes rounded img-fluid" id="producto_img" title="vaso" src="https://cdn.pixabay.com/photo/2020/12/15/13/44/children-5833685__340.jpg">
                        </div>
                        <div class="col-4 d-flex ml-2 flex-column">
                            <h4 class="nombre-producto"><?php echo $fila[0] ?></h4>
                            <p>Descripción:
                                <a href="#" id="info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                </a>
                            </p>

                            <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> €</h5>
                            <form method="post" action="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "agregar_carrito.php?cod=" . $fila[6] . $url; ?>">
                                <label for="cantidad">Cantidad:</label>
                                <select id="cantidad" name="cantidad">'
                                    <?php
                                    for ($i = 1; $i <= 10; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?> 
                                </select>
                                <div class="col-4 d-flex justify-content-center">
                                    <!-- if session rol = admin button editar, deshabilitar -->     
                                    <button class="btn-add-cart btn btn-outline-secondary" id="compra" type="submit">Añadir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="col-4">
        <div id="boton">
            <div class="layered box row " id="producto">
                <h2 class="d-flex border-bottom justify-content-center">Cesta</h2>
                <div class="row border-bottom">
                    <div class="col">
                        <p>Producto</p>
                    </div>
                    <div class="col">
                        <p>Precio</p>
                    </div>
                    <div class="col d-flex align-items-center">
                        <p>Cantidad</p>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash" viewBox="0 0 16 16">
                        <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                        <path fill-rule="evenodd"
                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </div>
                </div>
                <?php
                foreach ($array_carrito as $comida => $cant) {
                    echo $carrito->printCarritoCarta($comida, $cant);
                }
                ?>
                <div class="d-flex justify-content-around pt-5">
                    <a href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "index_carrito.php"; ?>'><button type='button' class='btn btn-outline-success'>Realizar Compra</button></a>
                    <h4>Total: <?php echo $carrito->getTotalPrice($array_carrito) ?> </h4>
                </div>
            </div>
        </div>
    </div> 
</div>

<script>
    // Obtener todos los elementos <img> del documento
    const imagenes = document.getElementsByClassName('img-select');
    // Crear un array vacío para almacenar los nombres de las imágenes seleccionadas
    const seleccionadas = [];

    // Recorrer todas las imágenes y agregar un listener de click a cada una
    for (let i = 0; i < imagenes.length; i++) {
        imagenes[i].addEventListener("click", function () {
            // Obtener el valor del atributo "alt" de la imagen
            const nombre = this.getAttribute("alt");
            // Si el nombre ya está en el array, eliminarlo
            if (seleccionadas.includes(nombre)) {
                seleccionadas.splice(seleccionadas.indexOf(nombre), 1);
                imagenes[i].style.border = 'none';
            }
            // Si no está en el array, agregarlo
            else {
                seleccionadas.push(nombre);
                imagenes[i].style.border = '1px solid red';
                imagenes[i].setAttribute('checked', '');
            }

            // Actualizar el contenido del contenedor de alérgenos
            const contenedor = document.getElementById("contenedorAlergenos");
            contenedor.innerHTML = seleccionadas.join(", ");
        });
    }

    /*function enviarArray() {
     imgSeleccionadas = [];
     var alergenos = document.querySelectorAll('img[checked]');
     for (var i = 0; i < alergenos.length; i++) {
     //console.log(alergenos[i].getAttribute('value'));
     imgSeleccionadas.push(alergenos[i].getAttribute('value'));
     }
     var xhr = new XMLHttpRequest();
     xhr.open("POST", "index_carta.php", true);
     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     
     xhr.onreadystatechange = function () {
     if (xhr.readyState === 4 && xhr.status === 200) {
     //window.location.reload();
     }
     };
     console.log(JSON.stringify(imgSeleccionadas))
     xhr.send("datos=" + JSON.stringify(imgSeleccionadas));
     }*/
</script>

<?php
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
