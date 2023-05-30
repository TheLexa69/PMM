<?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php"); ?>

<div class="main container mt-5">
    <div class="card">
        <div class="card-header"><h2>Error.</h2></div>
        <div class="card-body">    
            <p>
                Lo sentimos, no hemos podido darte permiso a este sitio.
            </p>
            <div class="d-flex justify-content-center align-items-center"><img src="http://drive.google.com/uc?export=view&id=1Xbtt3Mz2tc3hc29oeDUH70ua2U0gbixg" class="rounded img-fluid" alt="alt"/></div>
        </div>
        <div class="card-footer">
            <a href="<?php echo DIRECTORY_SEPARATOR . "proyecto" . DIRECTORY_SEPARATOR . "index.php"; ?>" id="cancel" name="cancel" class="btn btn-success">Volver al inicio</a>
        </div>
    </div>
</div>

<?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>