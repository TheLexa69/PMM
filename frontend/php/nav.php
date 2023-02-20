<?php
 include dirname(__DIR__, 2) .  DIRECTORY_SEPARATOR . "autoloadClasesLogin.php";
//echo"../../autoloadClasesLogin.php";
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

        <title>Inicio</title>
    </head>
    <body> 
        <ul class="nav nav-tabs justify-content-end sticky-top">  
            <li class="nav-item"> 
                <a class="nav-link active" aria-current="page" href= '<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php";?>' >Inicio</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">Carta</a>
                <ul class="dropdown-menu">   
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php?tipo=cachopo";?> '>Cachopo</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php?tipo=arroz";?>'>Arroz</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php?tipo=carne";?>'>Carnes</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php?tipo=pescado";?>'>Pescados</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php?tipo=postre";?>'>Postres</a></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php?tipo=bebida";?>'>Bebidas</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "carta.php";?>'>Carta</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contacto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre Mi</a>
            </li>
            <li class="nav-item">  
                <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "index_carrito.php";?>'>Cesta</a>
            </li>


            <?php
            if (!empty($_SESSION['usuario'])) {
                ?> 
                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "logout.php";?>'>Log Out</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href=' #'>usuario </a>
                </li><?php
        } elseif(!empty ($_SESSION['administrador'])){
                ?> 
                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "logoutAdministrador.php";?>'>Log Out</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "Administrador" . DIRECTORY_SEPARATOR . "indexAdministrador.php";?>'>administrador </a>
                </li>
                <?php
            }else{
                ?> 
                <li class="nav-item">
                    <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "indexLogin.php";?>'>Login</a>
                </li>
                <?php
            }
            ?>
        </ul> 
   