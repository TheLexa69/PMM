<?php

namespace clases;

include dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "leerConfiguracion.php";

use \PDO;
use \PDOException;

class Conexion {

    protected $conexion;
 /**
  * 
  * @return metodo constructor de la conexion validando los datos 
  */
    protected function __construct() {

        try {
            $res = leer_config(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracion.xml", dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracion.xsd");
            $this->conexion = new PDO($res[0], $res[1], $res[2]);
            //$this->conexion = new PDO('mysql:dbname=LuaChea; host=mysql-5707.dinaserver.com', 'Raul', 'oSyh36033^(/');
            //conexion = new PDO('mysql:dbname=LuaChea; host=localhost','root','');
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("SET CHARACTER SET utf8");
            return "conectado";
        } catch (PDOException $e) {
            echo 'No conectado a la base de datos porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
        
    }
/**
 *  metodo destructor de la conexion  
 */
    public function __destruct() {
        $this->conexion = null;
    }

}
