<?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php"); ?>

<div class="main container mt-5">
    <div class="card">
        <div class="card-header"><h2>Error.</h2></div>
        <div class="card-body">    
            <p>
                Lo sentimos, no hemos podido encontrar el sitio que buscas.
            </p>
            <div class="d-flex justify-content-center align-items-center">
                <img src="http://drive.google.com/uc?export=view&id=1zgX5dV85nltjWr8vyK7OArwhwi8iswEp" class="rounded img-fluid" style="max-width: 300px; height: 300px;" alt="alt"/>
            </div>
        </div>
        <div class="card-footer">
            <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-success">Volver al inicio</a>
        </div>
    </div>
</div>

<?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>