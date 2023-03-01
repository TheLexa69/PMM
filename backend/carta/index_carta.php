<?php 
session_start();
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
use \clases\Carta as carta;
use \clases\Carrito as carrito;

$carta = new carta();
$carrito = new carrito();

if(isset($_SESSION['carrito'])) {
    $array_carrito = $_SESSION['carrito'];
} elseif (isset($_COOKIE['carrito'])) {
    $array_carrito = unserialize($_COOKIE['carrito']);
} else {
    $array_carrito = [];
}

    /* Realizamos la consulta que nos pide para enseñar los datos. */
    if (isset($_GET["tipo"])) {
        $tipo = $_GET["tipo"];
        $rdo = $carta->filterByTipo($tipo);
        $url = "&tipo=$tipo";
    } else {
        $rdo = $carta->printCarta();
        $url = "";
    }
    ?>
<script>
    var radios = document.getElementsByName('inlineRadioOptions');
    var mostrar = true;
    function reset() {
        console.log("a")
        mostrar = !mostrar;
        console.log(radios);

        if (mostrar) {
            radios[0].checked = false;
            radios[1].checked = false;
        }
    }


    // Obtener todos los elementos <img> del documento
    const imagenes = document.getElementsByTagName("img");

    // Crear un array vacío para almacenar los nombres de las imágenes seleccionadas
    let seleccionadas = [];

    // Recorrer todas las imágenes y agregar un listener de click a cada una
    for (let i = 0; i < imagenes.length; i++) {
        imagenes[i].addEventListener("click", function () {
            // Obtener el valor del atributo "alt" de la imagen
            const nombre = this.getAttribute("alt");

            // Si el nombre ya está en el array, eliminarlo
            if (seleccionadas.includes(nombre)) {
                seleccionadas = seleccionadas.filter(n => n !== nombre);
                imagenes[i].style.border = 'none';
            }
            // Si no está en el array, agregarlo
            else {
                seleccionadas.push(nombre);
                imagenes[i].style.border = '1px solid red';
            }

            // Actualizar el contenido del contenedor de alérgenos
            const contenedor = document.getElementById("contenedorAlergenos");
            contenedor.innerHTML = seleccionadas.join(", ");
        });

        // Obtener todas las imágenes

    }

    function updateCantidad(id_comida, cantidad) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../cart/actualizar_carrito.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			// Actualizar la página para reflejar los cambios
			window.location.reload();
			}
		};
		xhr.send('id_comida=' + id_comida + '&cantidad=' + cantidad);
	}
</script>
        <div class="container">
            <div class="text-center mt-3">
                <h2>Alergenos</h2>
                <hr>
            </div>
            <div class="text-center">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/2.svg" alt="2">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/3.svg" alt="3">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/4.svg" alt="4">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/5.svg" alt="5">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/6.svg" alt="6">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/7.svg" alt="7">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/8.svg" alt="8">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/9.svg" alt="9">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/10.svg" alt="10">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/11.svg" alt="11">
                <img class="img-select" width="100px" height="auto" src="../../frontend/img/12.svg" alt="12">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/13.svg" alt="13">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/14.svg" alt="14">
                <img class="img-select" width="80px" height="auto" src="../../frontend/img/15.svg" alt="15">
            </div>
            <div class="text-center mt-3">
                <h2>Filtros</h2>
                <hr>
            </div>
            <div id="contenedorAlergenos">
            </div>
            <div class="d-flex justify-content-center pb-3" id="reset">
                <input class="btn btn-outline-dark" type="button" value="Filtrar">
                <input class="btn btn-outline-dark" type="reset" value="Reset">
            </div>
        </div>
        <div class="col-4">
            <div class="layered box row">
                <div class="col-3">
                    <h2>Filtros:</h2>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            value="option1" onclick="reset()">
                        <label class="form-check-label" for="inlineRadio1">Precio Ascendente</label>
                    </div>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            value="option2" onclick="reset()">
                        <label class="form-check-label" for="inlineRadio2">Precio Descendente</label>
                    </div>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <input class="btn btn-outline-dark" type="reset" value="Reset">
                </div>
            </div>
            <div id="boton">
                <?php
                if($rdo) {
                    
                    foreach ($rdo as $fila) { ?>
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

<<<<<<< Updated upstream
                            <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> </h5>
=======
                            <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> €</h5>
>>>>>>> Stashed changes
                            <form method="post" action="<?php echo  DIRECTORY_SEPARATOR ."proyecto".DIRECTORY_SEPARATOR ."backend". DIRECTORY_SEPARATOR . "cart". DIRECTORY_SEPARATOR."agregar_carrito.php?cod=". $fila[6] . $url; ?>">
                            <label for="cantidad">Cantidad:</label>
                              <select id="cantidad" name="cantidad">'
		                        <?php for($i=1; $i<=10;$i++) {        
		                        echo '<option value="'.$i.'">'.$i.'</option>';
		                        }
                              echo '</select>'; ?> 
                              </div>
                        <div class="col-4 d-flex justify-content-center">
                                <!-- if session rol = admin button editar, deshabilitar -->     
<<<<<<< Updated upstream
                                <button class="btn-add-cart btn btn-outline-secondary" id="compra" type="submit">Comprar</button></form>
=======
                                <button class="btn-add-cart btn btn-outline-secondary" id="compra" type="submit">Añadir</button></form>
>>>>>>> Stashed changes
                            </div>
                        </div>
                    <?php }}
                
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
                    foreach($array_carrito as $comida => $cant) {
                        echo $carrito->printCarritoCarta($comida, $cant);
                    }
                    ?>
                    <div class="d-flex justify-content-around pt-5">
                        <a href='<?php echo  DIRECTORY_SEPARATOR ."proyecto".DIRECTORY_SEPARATOR ."backend". DIRECTORY_SEPARATOR . "cart". DIRECTORY_SEPARATOR."index_carrito.php"; ?>'><button type='button' class='btn btn-outline-success'>Realizar Compra</button></a>
                        <h4>Total: <?php echo $carrito->getTotalPrice($array_carrito) ?> </h4>
                    </div>
                </div>
            </div>
        </div> 



    </div>
<?php require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
