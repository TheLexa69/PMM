<?php

session_start();
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use clases\Carrito as carrito;

$carrito = new carrito();
$rol = isset($_SESSION['id_rol']) ? $_SESSION['id_rol'] : null;
$win_loc = "../login/indexLogin.php";
?>
<head>
    <title>Cesta</title>
</head>
<?php
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    //Sacamos el carrito de la base de datos y lo igualamos a la variable de sesión
    //Si no encuentra nada en la base de datos va a mirar a las cookies y si no hay 
    //nada en ninguno de los dos crear la variable de sesión como array vacío 
    //Mejora: elegir entre el carrito de la base de datos y el carrito de las cookies

    if (!isset($_SESSION['carrito'])) {
        if (isset($_COOKIE['carrito']) && !empty(unserialize($_COOKIE['carrito']))) {
            $_SESSION['carrito'] = unserialize($_COOKIE['carrito'], ["allowed_classes" => false]);
        } elseif (!isset($_SESSION['carrito'])) {
            $carrito_guardado = $carrito->getCarro($usuario);
            if ($carrito_guardado) {
                $_SESSION['carrito'] = unserialize($carrito_guardado['comida_cantidad'], ["allowed_classes" => false]);
            }
        }
    }

    if (empty($_SESSION["carrito"])) {
        echo
        '<div class="container main mt-5 bg-light rounded text-center py-5">'
        . '<h2>No tienes productos en tu cesta todavía.</h2>'
        . '</div>';
    } else {
        ?><!--Tiene comida almacenada-->
        <div class="container main mt-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="fw-bold">Cesta</h3>
                </div>
                <div class="card-body">
                    <?php
                    foreach ($_SESSION['carrito'] as $comida => $cant) {
                        $id_comida = $comida;
                        $cantidad = (int) $cant;
                        print ($carrito->printCarroSes($id_comida, $cantidad));
                    }
                    $precio_total = $carrito->getTotalPrice($_SESSION['carrito']);
                    echo '<div class="mt-5 rounded py-3 d-flex justify-content-end align-items-center">'
                    . '<h3 class="fw-bold me-2 mb-0">Total: ' . $precio_total . '</h3>'
                    . '<a href="realizar_pedido.php"><button type="button" class="btn btn-outline-success">Finalizar compra</button>'
                    . '</a>'
                    . '</div>';
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    if (isset($_COOKIE['carrito'])) {
        if (empty(unserialize($_COOKIE['carrito']))) {
            echo '<div class="container mt-5 bg-light rounded text-center py-5"><h2>No tienes productos en tu cesta todavía.</h2></div>';
        } else {
            ?>
            <div class="container main mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold">Cesta</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        foreach (unserialize($_COOKIE['carrito'], []) as $comida => $cant) {
                            $id_comida = $comida;
                            $cantidad = (int) $cant;
                            echo ($carrito->printCarroSes($id_comida, $cantidad));
                        }

                        $precio_total = $carrito->getTotalPrice(unserialize($_COOKIE['carrito'], ["allowed_classes" => false]));
                        echo '<div class="mt-5 rounded py-3 d-flex justify-content-end align-items-center">'
                        . '<h3 class="fw-bold me-2 mb-0">Total: ' . $precio_total . '</h3>'
                        . '<a href=#><button id="log" type="button" class="btn btn-outline-success">Finalizar compra</button>'
                        . '</a>'
                        . '</div>';
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<div class="container mt-5 bg-light rounded text-center py-5"><h2>No tienes productos en tu cesta todavía.</h2></div>';
    }
}
require(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
?>