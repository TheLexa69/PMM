<?php
session_start();
require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
?>
<head>
    <title>Contacto</title>
    <style>
        canvas {
            border: 1px solid black;
        }
        .medal {
            display: inline-block;
            position: relative;
            width: 40px;
            height: 40px;
            background: #FFD700;
            border-radius: 50%;
            margin-right: 5px;
        }

        .medal:before,
        .medal:after {
            content: "";
            position: absolute;
            top: 5px;
            width: 20px;
            height: 10px;
            background: #8B4513;

        }

        .medal:before {
            left: -10px;
            transform: rotate(45deg);
        }

        .medal:after {
            right: -10px;
            transform: rotate(-45deg);
        }
    </style>
</head>
<body>
    <div class="main container">

        <div class=" mt-5 card p-3">
            <h3 class="text-success border-bottom pb-2">LuaChea Games (Beta)</h3>
            ¡Hola! ¡Bienvenido al lobby! <br>
            Aquí podrás elegir entre dos juegos en fase Beta. Esperamos que disfrutes montando la comida y que logres obtener la mayor puntuación posible. 
            Además, no te olvides de recolectar medallas durante el juego para mejorar tu experiencia. 
            <br><b>¡Diviértete!</b>
            <div class="d-flex flex-wrap align-items-center ps-3 pt-3">
                <button class="btn btn-success" onclick="if ($('#cachopo').hasClass('d-none')) {
                            $('#hamburguesa').removeClass('d-none');
                        }">Hamburguesa</button>
                <button class="btn btn-success ms-3" onclick="if ($('#hamburguesa').hasClass('d-none')) {
                            $('#cachopo').removeClass('d-none');
                        }">Cachopo</button>
            </div>
        </div>

        <div class=" mt-5 card p-0 d-none" id="hamburguesa">
            <?php
            include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "juego_hamburguesa.php";
            ?>
        </div>
        <div class = " mt-5 card p-0 d-none" id = "cachopo">
            <?php
            include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "juego_cachopo.php";
            ?>
        </div>
    </div>


    <?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>