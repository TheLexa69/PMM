<?php
session_start();
require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
?>
<div class="container main">
    <div class="card mt-5">
        <div class="card-header">
            <h3 class="text-center">Contacto</h3>
        </div>
        <div class="card-body container">
            <div class="row">
                <div class="col-6 border-end pe-5">
                    <div class="p-2 pb-3 border-bottom lh-2">
                        <h5 class="pb-2">Dirección</h5>
                        <span>Rúa de Eduardo Cabello, 25</span><br>
                        <span>36208</span><br>
                        <span>Vigo, Pontevedra.</span>
                    </div>
                    <div class="p-2 py-3 border-bottom lh-2">
                        <h5 class="pb-2">Teléfono de contacto</h5>
                        <span>+34 986 13 25 37</span>
                    </div>
                    <div class="p-2 py-3 lh-2">
                        <h5 class="pb-2">Correo electrónico</h5>
                        <span>luacheabouzas@gmail.com</span>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST">
                        <div class="form-group">
                            <input type="text" name="nombre" id="nombre" class="form-control" size="100" placeholder="Nombre (*)" required>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" name="nombre" class="form-control" placeholder="Correo electrónico (*)" required>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" name="nombre" class="form-control" placeholder="Asunto (*)" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" placeholder="Mensaje (*)" rows="3" required></textarea>
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
    </div>
</div>


<?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>
