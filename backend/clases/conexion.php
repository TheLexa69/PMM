<?php

namespace clases;

use \PDO;
use \PDOException;

class Conexion {

    protected $conexion;
    static $numeroConexion = 0;

    /**
     * Constructor de la clase que se encarga de establecer la conexión con la base de datos.
     * Lee los datos de conexión del fichero de configuración y establece conexión con PDO validando los datos.
     * @throws PDOException si ocurre algún error durante la conexión.
     */
    protected function __construct($rol = 5) {
        try {
            self::$numeroConexion++;
            // echo"Conexion Numero ". self::$numeroConexion;
            $res = $this->leerConfig(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracion.xml", dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "conexion" . DIRECTORY_SEPARATOR . "configuracion.xsd", $rol);
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

    /**
     * Lee el archivo de configuración de la base de datos y devuelve los datos de conexión.
     * @param string $fichero_config_BBDD el xml.
     * @param string $xsd  XSD que valida la estructura del archivo xml.
     * @return conect Es un array con tres valores: cadena de conexión, nombre de usuario y clave.
     * @throws InvalidArgumentException Si el archivo XSD no existe o no es válido para ese XML.
     */
    protected function leerConfig($fichero_config_BBDD, $xsd, $rol) {

        $conf = new \DOMDocument();
        $conf->load($fichero_config_BBDD);

        if (!$conf->schemaValidate($xsd)) {
            throw new PDOException("Ficheiro de usuarios no valido");
        }

        $datos = simplexml_load_file($fichero_config_BBDD);

        $host = $datos->xpath('//host[../rol="' . $rol . '"]');
        $nombreBd = $datos->xpath('//bd[../rol="' . $rol . '"]');
        $usuario = $datos->xpath('//nombre[../rol="' . $rol . '"]');
        $password = $datos->xpath('//clave[../rol="' . $rol . '"]');

        $cadena = sprintf("mysql:dbname=%s;host=%s", $nombreBd[0], $host[0]);
        $conect = [];
        $conect[] = $cadena;
        $conect[] = $usuario[0];
        $conect[] = $password[0];

        return $conect;
    }

}
