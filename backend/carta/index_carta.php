<?php 
session_start();
require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "nav.php"); 
use \clases\Carta as carta;

$carta = new carta();
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

    <div class="row mt-5">
        <div class="col-4">
            <div class="layered box container d-flex flex-column mt-2">
                <h2>Alergenos</h2>
                <div class="row">
                    <div class="col-6">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/altramuces.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/apio.svg"
                            alt="Responsive image">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/cacahuete.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/crustaceos.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/huevo.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/lacteos.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/molusco.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/mostaza.svg" alt="">

                    </div>
                    <div class="col-6">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/pescado.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/soja.svg" alt="">
                        <img width="100px" height="auto" class="img-responsive" src="../../frontend/img/sulfitos.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/sesamo.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/frutoscascara.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../../frontend/img/gluten.svg" alt="">
                    </div>
                </div>
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

                            <h5 class="precio-producto"> Precio: <?php echo number_format($fila[3], 2, '.', '') ?> €</h5>
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
                                <button class="btn-add-cart btn btn-outline-secondary" id="compra" type="submit">Añadir</button></form>
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
                    <div class="row align-items-center border-bottom pt-2 pb-2">
                        <div class="col-3">a</div>
                        <div class="col-3">a</div>
                        <div class="col-3">a</div>
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center border-bottom pt-2 pb-2">
                        <div class="col-3">a</div>
                        <div class="col-3">a</div>
                        <div class="col-3">a</div>
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center border-bottom pt-2 pb-2">
                        <div class="col-3">a</div>
                        <div class="col-3">a</div>
                        <div class="col-3">a</div>
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around pt-5">
                        <button type='button' class='btn btn-outline-success '>Finalizar Compra</button>
                        <h4>Total: 650.35€</h4>
                    </div>
                </div>
            </div>
        </div> 



    </div>
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
    </script>
<?php require(dirname(__DIR__,2) .DIRECTORY_SEPARATOR ."frontend". DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "footer.php"); 
