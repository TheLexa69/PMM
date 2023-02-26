<?php
namespace clases;

use \PDO;
use \PDOException;

class ConsultasUsuario extends Conexion {

    public function __construct() {
        //  var_dump ($this->conexion= $this->conectar());
        //$this->conexion= $this->conectar();
        parent::__construct();
    }

    public function datosUsuario($id) {
        try {
            $sql = "select * from usuario where id_usuario=?";
 
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array($id));
             
            $dato = $stmt->fetch(PDO::FETCH_ASSOC);
            unset($stmt);
            return $dato;
            
        } catch (Exception $ex) {
            
        }
    }

}
