<?php
session_start();
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
   
        <link rel="stylesheet" href='<?php echo "frontend" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR . "index.css"; ?>'/>
        <title>Inicio</title>
    </head>
    <body>
        <?php require(__DIR__ . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php"); 
        ?>

        <div id="carouselExampleDark" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="2000">
                    <section class="home" id="home">
                        <div class="home-slider">
                            <div class="wrapper">
                                <div class="slide">
                                    <div class="content">
                                        <div>
                                            <span> ¡ Top Ventas !</span>
                                            <h3 id="texto_c1">Cachopo</h3>
                                        </div>

                                        <div class="image text_img">
                                            <img id="imagen_c1" src="<?php echo "frontend" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "comida" . DIRECTORY_SEPARATOR . "cachopo1.png"?>">
                                        </div>
                                        <p id="descripcion_c1">
                                        ¿Quieres probar algo delicioso de Asturias? El cachopo es una comida típica que no puedes perderte. Hecho con jamón serrano, queso tetilla, cheddar, cebolla caramelizada y tomate, es una deliciosa combinación de sabores en una delgada pieza de carne. ¡No te pierdas la oportunidad de probar este plato asturiano imprescindible!
                                        </p>
                                        <div class="d-grid gap-3">
                                            <a class="btn btn-primary" href="./backend/carta/index_carta.php?tipo=cachopo">Pedir ya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <div class="swiper-slide slide">
                        <section class="home" id="home">
                            <div class="home-slider">
                                <div class="wrapper">
                                    <div class="slide">
                                        <div class="content">
                                            <div>
                                                <span> ¡ Nuestro catalago !</span>
                                                <h3 id="texto_c2">Brownie</h3>
                                            </div>

                                            <div class="image text_img">
                                                <img id="imagen_c2" src="<?php echo "frontend" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "comida" . DIRECTORY_SEPARATOR . "brownie.jpg"?>">
                                            </div>
                                            <p id="descripcion_c2">¿Amante del chocolate? Prueba el brownie con chocolate fundido, nata y helado de vainilla. 
                                                Este postre decadente combina un brownie suave con una bola de helado de vainilla cremoso y nata montada. 
                                                Perfecto para aquellos que buscan una delicia dulce y seductora.
                                            <div class="d-grid gap-3">
                                                <a class="btn btn-primary" href="./backend/carta/index_carta.php?tipo=postre">Pedir ya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <div class="slide">
                        <section class="home" id="home">
                            <div class="home-slider">
                                <div class="wrapper">
                                    <div class="slide">
                                        <div class="content">
                                            <div>
                                                <span> ¡ Novedades !</span>
                                                <h3 id="texto_c3">Fabada</h3>
                                            </div>

                                            <div class="image text_img">
                                                <img id="imagen_c3" src="<?php echo "frontend" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "comida" . DIRECTORY_SEPARATOR . "fabada.jpg"?>">
                                            </div>
                                            <p id="descripcion_c3">¿Buscas una comida sabrosa y satisfactoria? Prueba la fabada, 
                                                un plato típico de Galicia. Con <b>fabas, chorizo, panceta y morcilla, </b>
                                                es perfecto para días fríos y lluviosos y para aquellos que buscan una comida 
                                                abundante y sustanciosa. 
                                                ¡No te pierdas la oportunidad de probar este plato gallego imprescindible!</p>
                                            <div class="d-grid gap-3">
                                                <a class="btn btn-primary" href="./backend/carta/index_carta.php?tipo=entrantes">Pedir ya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <?php require(__DIR__ . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>
    </body>
</html>