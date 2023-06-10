<?php
//ob_start();
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/bd61d050b0.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


        <link rel="stylesheet" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR . "estilos.css"; ?>'/>
        <link rel="stylesheet" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR . "index.css"; ?>'/>
        <script src="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "js" . DIRECTORY_SEPARATOR . "main.js"; ?>" defer></script>
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
                        <a class="nav-link" href='<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "cart" . DIRECTORY_SEPARATOR . "index_carrito.php"; ?>'><i class="fa-solid fa-basket-shopping fa-2xl menu-responsive  my-auto pe-4"></i>Cesta</a>
                    </li>
                    <li class="nav-item"> <button class="btn btn-link nav-link" onclick="changeTheme();"><i class="fa-solid fa-circle-half-stroke fa-xl pe-4 menu-responsive my-auto"></i>Tema</button> </li>
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
                </ul> 
            </div>

        </div>



