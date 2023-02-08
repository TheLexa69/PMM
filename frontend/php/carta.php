<?php
/* Bloque try-catch con la conexión a la bdd. */
require_once ("..\..\backend" . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "conexion.php");
$conexion = conexion();
/*try {
    $conexion = new PDO('mysql:dbname=luachea;host=localhost', 'root', '');
    $conexion->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    die("ERROR: " . $e->getMessage());
}*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="../js/main.js"></script>
    <title>Inicio</title>
</head>

<body>
    <?php require("./nav.php") ?>
    <?php
    /* Realizamos la consulta que nos pide para enseñar los datos. */
    if (isset($_GET["tipo"])) {
        $tipo = $_GET["tipo"];
        $consulta = "select nombre, descripcion, tipo, cantidad, precio, img, disponible, id_comida from carta_comida where tipo='$tipo'";
    } else {
        $consulta = "select nombre, descripcion, tipo, cantidad, precio, img, disponible, id_comida from carta_comida";
    }
    ?>

    <div class="row mt-5">
        <div class="col-4">
            <div class="layered box container d-flex flex-column mt-2">
                <h2>Alergenos</h2>
                <div class="row">
                    <div class="col-6">
                        <img width="80px" height="auto" class="img-responsive" src="../img/altramuces.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/apio.svg"
                            alt="Responsive image">
                        <img width="80px" height="auto" class="img-responsive" src="../img/cacahuete.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/crustaceos.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/huevo.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/lacteos.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/molusco.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/mostaza.svg" alt="">

                    </div>
                    <div class="col-6">
                        <img width="80px" height="auto" class="img-responsive" src="../img/pescado.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/soja.svg" alt="">
                        <img width="100px" height="auto" class="img-responsive" src="../img/sulfitos.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/sesamo.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/frutoscascara.svg" alt="">
                        <img width="80px" height="auto" class="img-responsive" src="../img/gluten.svg" alt="">
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
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch()) {
                        echo '<div class="layered box row mr-2" id="producto">';
                        echo '<div class="col-4">                        
                                <img class="imagenes rounded img-fluid" id="producto_img" title="vaso" src="https://cdn.pixabay.com/photo/2020/12/15/13/44/children-5833685__340.jpg">
                                </div>';
                        echo '<div class="col-4 d-flex ml-2 flex-column">
                            <h4 class="nombre-producto">' . $fila[0] . '</h4>
                            <p>Descripción:
                            <a href="#" id="info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                </svg>
                            </a>
                            </p>
                            <h5 class="precio-producto"> Precio: ' . number_format($fila[4], 2, '.', '') . '</h5>
                                </div>';
                        echo '<div class="col-4 d-flex justify-content-center">
                            <a href="..\..\backend\cart\ejemplo.php?id="'.$fila[7].'">
                                <button class="btn-add-cart btn btn-outline-secondary" id="compra" type="button">Comprar</button>
                            </a>
                            </div>';
                        echo '</div>';
                    }
                } else {
                    echo "ERROR: " . print_r($pdo->errorInfo());
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
    <?php
    unset($consulta);
    unset($conexion);
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
    </script>
</body>

</html>