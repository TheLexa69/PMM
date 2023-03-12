<?php
session_start();
 require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php"); ?>

<div class="container bg-light rounded mt-5 w-60 p-3">
    <div class="text-center mb-5">
        <h2>Contacto</h2>
        <hr>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="p-2">
                Teléfono de contacto: 986 13 25 37.
            </div>
            <div class="p-2">
                Dirección: Rúa de Eduardo Cabello, 25, 36208 Vigo, Pontevedra.
            </div>
            <div class="p-2">
                luacheabouzas@gmail.com
            </div>
        </div>
        <div class="col-8 d-flex justify-content-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST">
                <div class="form-group">
                    <input type="text" name="nombre" class="form-control" size="100" placeholder="Nombre">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Correo electrónico">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Asunto">
                </div>
                <div class="form-group mt-3">
                    <textarea class="form-control" placeholder="Mensaje" rows="3"></textarea>
                </div>

                <div class='mt-3 d-flex justify-content-center'>
                    <div class="pe-2">
                        <input type="submit" class='btn btn-outline-success' style='width: 100px' name="contacto" value='Enviar'>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>