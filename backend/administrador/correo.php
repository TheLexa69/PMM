<?php
session_start();
require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");

use \clases\Mails as mailLogin;
use \clases\FiltroDatos as filtrado;

$filtro = new filtrado;
$envioMail = new mailLogin;

$_POST = $filtro->validarPost($_POST);

if ($envioMail->mailContacto($_POST)) {
    ?>
    <div class="container mt-5 card">
        <div class="card-header"><h3>Mensaje enviado.</h3></div>
        <div class="card-body"><h5>Pronto le responderemos!</h5></div>
        <div class="card-footer"><a class="btn btn-success" href="/proyecto/index.php"   >Volver</a></div>
    </div> 
    <?php
} else {
    ?>
 
    <div class="container mt-5 card">
        <div class="card-header"><h3>Algo salio mal.</h3></div>
        <div class="card-body"><h5>Perdone las molestias</h5></div>
        <div class="card-footer"><a class="btn btn-success" href="/proyecto/index.php"  >Volver</a> </div>
    </div> 

    <?php
}


require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php");
