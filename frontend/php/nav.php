<?php
include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "autoloadClasesLogin.php";
//echo"../../autoloadClasesLogin.php";
?>
<!DOCTYPE html>
<html lang="Es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
        <link rel="stylesheet" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR . "estilos.css"; ?>'/>
        <title>Carta</title>
    </head>

    <body> 

        <ul class="nav nav-tabs justify-content-end sticky-top bg-dark bg-gradient">
            <li class="mr-10">
                
              
            </li>
            <li class="nav-item"> 
                <a class="nav-link active" aria-current="page" href= '<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>' >Inicio</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">Carta</a>
                <ul class="dropdown-menu ">   
                       <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=cachopo";?> '>Cachopo</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=arroz";?>'>Arroz</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=carne";?>'>Carnes</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=pescado";?>'>Pescados</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=postre";?>'>Postres</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=bebida";?>'>Bebidas</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php";?>'>Carta</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contacto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "usuario" . DIRECTORY_SEPARATOR . "reservas.php"; ?>'>Reservas</a>
            </li>
            <li class="nav-item">  
                <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "index_carrito.php"; ?>'>Cesta</a>
            </li>


            <?php
            if (!empty($_SESSION['usuario'])) {
                ?> 
                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "logout.php"; ?>'>Cerrar Session</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "usuario" . DIRECTORY_SEPARATOR . "modificarDatosUsuario.php"; ?>'>Usuario </a>
                </li> 
                <?php
            } elseif (!empty($_SESSION['administrador'])) {
                ?> 
                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "logoutAdministrador.php"; ?>'>Cerrar Session</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "administrador" . DIRECTORY_SEPARATOR . "indexAdministrador.php"; ?>'>Administrador </a>
                </li>
                <?php
            } else {
                ?> 
                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "indexLogin.php"; ?>'>Login</a>
                </li>
                <?php
            }
            ?>
        </ul> 
