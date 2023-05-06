<?php
include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "autoloadClasesLogin.php";

//echo"../../autoloadClasesLogin.php";
use \clases\Carta as carta;

$c = new carta();
$categorias = $c->getCategorias();
if (isset($_GET['red'])) {
    setcookie("carrito", 0, 1, "/");
}
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
        <script src="https://kit.fontawesome.com/bd61d050b0.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR . "estilos.css"; ?>'/>

    </head>

    <body>
        <div class="d-flex bg-dark sticky-top justify-content-end navNavgationBar">
            <div class="menu-responsive px-3" onclick="showHideNav()">
                <label for="check-nav" class="checkbtn text-white">
                    <i class="fa-solid fa-bars fa-2xl"></i>
                </label>
            </div>
            <div class="p-2 navgationbar" id="navbarNavAltMarkup">
                <ul class="nav nav-tabs justify-content-end ">

                    <li class="nav-item"> 
                        <a class="nav-link active" aria-current="page" href= '<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>' ><i class="fa-solid fa-house fa-xl pe-4 menu-responsive my-auto"></i>Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-utensils fa-2xl menu-responsive my-auto pe-4"></i>Carta</a>
                        <ul class="dropdown-menu ">   
                            <?php
                            foreach ($categorias as $nombre11) {
                                $tipo = $nombre11['nombre_tipo'];
                                ?>
                                <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php?tipo=" . strtolower($tipo); ?>'><?php echo $tipo ?></a></li>
                                <?php
                            }
                            ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "carta" . DIRECTORY_SEPARATOR . "index_carta.php"; ?>'>Carta</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "contacto.php"; ?>'><i class="fa-solid fa-file-signature fa-2xl menu-responsive my-auto pe-4"></i>Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "usuario" . DIRECTORY_SEPARATOR . "reservas.php"; ?>'><i class="fa-solid fa-book fa-2xl menu-responsive my-auto pe-4"></i>Reservas</a>
                    </li>
                    <li class="nav-item">  
                        <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "index_carrito.php"; ?>'><i class="fa-solid fa-basket-shopping menu-responsive fa-2xl my-auto pe-4"></i>Cesta</a>
                    </li>
                    <?php
                    if (!empty($_SESSION['usuario']) && isset($_SESSION)) {
                        ?> 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-user fa-2xl  menu-responsive my-auto pe-4"></i>Usuario</a>
                            <ul class="dropdown-menu ">   
                                <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "usuario" . DIRECTORY_SEPARATOR . "modificarDatosUsuario.php"; ?>'>Cambiar Perfil</a>                                </li> 
                                <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "usuario" . DIRECTORY_SEPARATOR . "index_pedidos.php"; ?>'>Pedidos</a></li>
                                <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "usuario" . DIRECTORY_SEPARATOR . "verCambios.php"; ?>'>Histórico Datos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "logout.php"; ?>'>Cerrar Session</a></li>
                            </ul>
                        </li>
                        <?php
                    } elseif (!empty($_SESSION['administrador'])) {
                        ?> 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-user fa-2xl menu-responsive my-auto pe-4"></i>Administración</a>
                            <ul class="dropdown-menu ">
                                <li>
                                    <a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "administrador" . DIRECTORY_SEPARATOR . "indexAdministrador.php"; ?>'>Panel Administrador </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "logoutAdministrador.php"; ?>' style="color: black">Cerrar Session</a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    } else {
                        ?> 
                        <li class="nav-item">
                            <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "login" . DIRECTORY_SEPARATOR . "indexLogin.php"; ?>'><i class="fa-solid fa-right-to-bracket fa-2xl pe-4 menu-responsive my-auto"></i>Login</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item"> 
                        <a class="nav-link" href= '#' onclick="changeTheme();"><i class="fa-solid fa-circle-half-stroke fa-xl pe-4 menu-responsive my-auto"></i>Tema</a>
                    </li>
                </ul> 
            </div>

            <script>
                const nav = document.getElementById('navbarNavAltMarkup');
                console.log(document.getElementById('navbarNavAltMarkup'));
                nav.style.top = nav.style.top == '0px' ? '-60vh' : '0px';
                function changeTheme() {
                    console.log(document.body.style.backgroundImage);
                    if (document.body.style.background == "url(\"https://drive.google.com/uc?export=view&id=1zOM1Ia5DCjou5eFGgEplQvpJ1n2Q061Y\") no-repeat") {
                        document.body.style.background = "url(\"https://drive.google.com/uc?export=view&id=1CMd-GRGmu2Puri9bhJ--eieCaBZH_D7r\") no-repeat";
                        document.body.style.backgroundSize = "cover";
                        document.body.style.backgroundPosition = "center center";
                        document.body.style.backgAttachment = 'fixed';

                    } else {
                        document.body.style.background = "url(\"https://drive.google.com/uc?export=view&id=1zOM1Ia5DCjou5eFGgEplQvpJ1n2Q061Y\") no-repeat";
                        
                    }
                }
            </script>
        </div>



