
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

        <title>Cesta</title>
    </head>
    <body>
        <?php //require("../../frontend/php/nav.php");?>
        <div class="contenedor">
        <?php
           /* require_once 'carrito.php';
            $o1 = new carrito();
            print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");

            print var_dump($o1->getCarro("restaurante@b01.daw2d.iesteis.gal"));

            $o1->add(1, 5, 2);
            print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");

            $o1->removeItem(5);
            print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");

            print var_dump($o1->getTotalPrice("restaurante@b01.daw2d.iesteis.gal"));

            $o1->clearCarro("restaurante@b01.daw2d.iesteis.gal");
            print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");*/
        ?>
        <button class="sc-iqHYmW dJJQhN">
            <div class="sc-kEjbQP bEQCBe">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24" class="sc-bdfBQB hRvObX sc-fAQxbB gBUpDn">
                <path d="M5 20c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2v-12h-14v12zm2-10h10v10h-10v-10zM15 5v-2h-6v2h-6v2h18v-2zM9 12h2v6h-2zM13 12h2v6h-2z"></path>
            </svg>
            Vaciar cesta</div>
        </button>
        </div>
        <?php //require "../../frontend/php/footer.php" ?>
    </body>
</html>

