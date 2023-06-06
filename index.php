<?php
session_start();
require(__DIR__ . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
?>
<head>
    <title>Inicio</title>
</head>
<div class='main'>
    <div class="my-5 bg-light rounded container p-3" id="indexJuego">
        <h3 class="text-success border-bottom pb-2">LuaChea Game (Beta)</h3>
        ¡Hola! Estamos encantados de presentarte nuestro nuevo juego de montar comidas. En este juego, podrás crear tu cachopo o hamburguesa ideal y competir por la máxima puntuación y cantidad de estrellas. El juego se encuentra actualmente en fase beta, lo que significa que todavía estamos trabajando en mejoras y nuevas características. Esperamos que disfrutes jugando y que nos brindes tus comentarios para seguir mejorando. ¡Que te diviertas!
        <br>
        <div class="d-flex flex-wrap align-items-center ps-3 pt-3">
            <a href="<?php echo DIRECTORY_SEPARATOR . 'proyecto' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'juego.php' ?>" class="btn btn-success">Juega ya!</a>

            <i class="fa-solid fa-gamepad fa-beat-fade fa-2xl ps-3"></i>
        </div>
    </div>

    <div id="carouselExampleDark" class="carousel carousel-dark slide rounded container">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="2000">
                <section class="home" id="home">
                    <div class="home-slider">
                        <div class="wrapper">
                            <div class="slide">
                                <div class="content bg-light rounded p-3 shadow">
                                    <div>
                                        <span>¡Top Ventas!</span>
                                        <h3 id="texto_c1">Cachopo</h3>
                                    </div>
                                    <div class="image text_img">
                                        <img id="imagen_c1" src="frontend/img/comida/cachopo1.png" alt="Imagen de Cachopo">
                                    </div>
                                    <p class="descripcionCarrusel" id="descripcion_c1">
                                        ¿Quieres probar algo delicioso de Asturias? El cachopo es una comida típica que no puedes perderte. Hecho con jamón serrano, queso tetilla, cheddar, cebolla caramelizada y tomate, es una deliciosa combinación de sabores en una delgada pieza de carne. ¡No te pierdas la oportunidad de probar este plato asturiano imprescindible!
                                    </p>
                                    <div class="d-grid gap-3">
                                        <a class="btn btn-success" href="./backend/carta/index_carta.php?tipo=cachopo">Pedir ya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <section class="home" id="home">
                    <div class="home-slider">
                        <div class="wrapper">
                            <div class="slide">
                                <div class="content bg-light rounded p-3 shadow">
                                    <div>
                                        <span>¡Nuestro catálogo!</span>
                                        <h3 id="texto_c2">Brownie</h3>
                                    </div>
                                    <div class="image text_img">
                                        <img id="imagen_c2" src="frontend/img/comida/brownie.jpg" alt="Imagen de Brownie">
                                    </div>
                                    <p class="descripcionCarrusel" id="descripcion_c2">¿Amante del chocolate? Prueba el brownie con chocolate fundido, nata y helado de vainilla. Este postre decadente combina un brownie suave con una bola de helado de vainilla cremoso y nata montada. Perfecto para aquellos que buscan una delicia dulce y seductora.</p>
                                    <div class="d-grid gap-3">
                                        <a class="btn btn-success" href="./backend/carta/index_carta.php?tipo=postre">Pedir ya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <section class="home" id="home">
                    <div class="home-slider">
                        <div class="wrapper">
                            <div class="slide">
                                <div class="content  bg-light rounded p-3 shadow">
                                    <div>
                                        <span>¡Novedades!</span>
                                        <h3 id="texto_c3">Fabada</h3>
                                    </div>
                                    <div class="image text_img">
                                        <img id="imagen_c3" src="frontend/img/comida/fabada.jpg" alt="Imagen de Fabada">
                                    </div>
                                    <p class="descripcionCarrusel" id="descripcion_c3">¿Buscas una comida sabrosa y satisfactoria? Prueba la fabada, un plato típico de Galicia. Con fabas, chorizo, panceta y morcilla, es perfecto para días fríos y lluviosos y para aquellos que buscan una comida abundante y sustanciosa. ¡No te pierdas la oportunidad de probar este plato gallego imprescindible!</p>
                                    <div class="d-grid gap-3">
                                        <a class="btn btn-success" href="./backend/carta/index_carta.php?tipo=entrantes">Pedir ya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
    <div class="container-fluid bg-light rounded d-flex justify-content-center shadow-lg align-items-center text-center py-3" id="cookie">
        <p class="fs-2 fw-bold">Consentimiento de Cookies</p>
        <p>¡Tu privacidad es importante para nosotros! En nuestro sitio web utilizamos cookies desarrolladas internamente para mejorar tu experiencia de navegación. Estas cookies nos permiten personalizar el contenido y ofrecerte promociones especiales. Al hacer clic en "Lo entiendo", estás dando tu consentimiento para el uso de cookies en nuestro sitio web. Puedes obtener más información en nuestra Política de Privacidad. ¡Gracias por confiar en nosotros!</p>
        <p>Puedes visitar nuestro Sitemap: <a href="https://www.dropbox.com/scl/fi/i9aqp1574byllz116xa2d/sitemap_LuaChea.png?dl=0&rlkey=hhbnsxlak614tgq2iv1xllnra" target="_blank">enlace directo.</a></p>
        
        <button class="btn btn-success" onclick="ocultarBarraCookies();">Lo entiendo</button>
    </div>

</div>
<?php require(__DIR__ . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>

