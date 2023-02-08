<?php  
 
function conexion(){
    try {              
         $conexion = new pdo('mysql:dbname=luachea; host=localhost','root','');
         $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         $conexion->exec("SET CHARACTER SET utf8");
         
        } catch (PDOException $e) {
             echo 'No conectado a la base de datos porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
           
        }
        return $conexion;
}
?>