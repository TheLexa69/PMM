<?php

namespace clases;

include dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "leerConfiguracion.php";

use \PDO;
use \PDOException;

class Conexion {

    protected $conexion;

    /**
     * Constructor de la clase que se encarga de establecer la conexión con la base de datos.
     * Lee los datos de conexión del fichero de configuración y establece conexión con PDO validando los datos.
     * @throws PDOException si ocurre algún error durante la conexión.
     */
    protected function __construct() {
        try {
            $res = leer_config(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracion.xml", dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracion.xsd");
            $this->conexion = new PDO($res[0], $res[1], $res[2]);
            //$this->conexion = new PDO('mysql:dbname=LuaChea; host=mysql-5707.dinaserver.com', 'Raul', 'oSyh36033^(/');
            //conexion = new PDO('mysql:dbname=LuaChea; host=localhost','root','');
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            echo 'No conectado a la base de datos porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Destructor de la clase que se encarga de destruir el puntero de conexión a la BBDD.
     */
    public function __destruct() {
        $this->conexion = null;
    }

}
