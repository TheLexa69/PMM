<?php  
class conexion {
protected $conexion;
   
protected function __construct(){
    try {              
        $this->conexion = new PDO('mysql:dbname=LuaChea; host=mysql-5707.dinaserver.com','Raul','oSyh36033^(/');
        //$this->conexion = new PDO('mysql:dbname=luachea; host=localhost','root','');
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->conexion->exec("SET CHARACTER SET utf8");
         
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
           
        }
	
}
public function __destruct() {
    $this->conexion = null;
}
 }
?>