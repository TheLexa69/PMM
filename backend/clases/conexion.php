<?php 
 
class conexion{
    protected $conexion;
   
    protected function __construct() {
         
    try {              
        $this->conexion = new PDO('mysql:dbname=LuaChea; host=mysql-5707.dinaserver.com','Raul','oSyh36033^(/');
       //conexion = new PDO('mysql:dbname=LuaChea; host=localhost','root','');
         $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         $this->conexion->exec("SET CHARACTER SET utf8");
         
        } catch (PDOException $e) {
             echo 'No conectado a la base de datos porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
           
        }
	
        
         
        
    }
                                      
}