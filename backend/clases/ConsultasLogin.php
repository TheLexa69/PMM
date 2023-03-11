<?php

namespace clases;

use \PDO;
use \PDOException;

class ConsultasLogin extends Conexion {
   
    /**
     * Constructor que recive la conexion de la clase padre
     */
    public function __construct() {
      
        parent::__construct();
    }
    /**
     * Destructor d ela conexion
     */
     public function __destruct() {
        $this->conexion = null;
    }
/**
 *  Metodo par añadir los datos de un usuario las variables son referenciadas al dato
 * @param type $nombre
 * @param type $apellido1
 * @param type $apellido2
 * @param type $token2          Es el numero generado aleatoriamente y pasado a hash que se guarda en la base de datos en el registro
 * @param type $mail
 * @param type $telefono
 * @param type $privilegios     Es  rol del usuario que puede ser Administrador Gestor Administrador o Trabajador
 * @param type $fecha           Fecha en la cual hace loggin o en este caso se inserta en la tabla
 * @param type $nif             Nif
 * @param type $direccion       Direccion donde vive
 * @param type $cp              Codigo postal
 */
    public function añadirUsuario($nombre, $apellido1, $apellido2, $token2, $mail, $telefono, $rol, $fecha, $nif, $direccion, $cp) {

        try {
            $sql = "INSERT INTO usuario (nombre,apellido1 ,apellido2,contraseña,correo,num_telef, id_rol,fecha,NIF,direccion,cp) VALUES (:nombre,:apellido1,:apellido2,:contrasena,:correo,:num_telef,:rol,:fecha,:nif,:direccion,:cp)";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':contrasena', $token2, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':num_telef', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

            $stmt->bindParam(':nif', $nif, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':cp', $cp, PDO::PARAM_STR);

            $stmt->execute();
            unset($stmt);
            unset($this->conexion);
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que devuelve los datos de un usuario pasandole el mail
 * @param type $mail
 * @return type
 */
    public function comprobarDatos($mail) {

        $sql = "select * from usuario where correo=?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }
      
        unset($stmt);
        return $datos;
    }
    /**
     * Metodo que registra la hora en la cual se loggeo el usuario
     * @param type $id
     * @param type $fecha
     * @return type
     */
      public function registroHoraSession($id,$fecha) {
 

        $sql1 = "UPDATE usuario SET  fecha=:fecha where id_usuario = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        

        $stmt->execute();
        
        return $stmt;
    }
    
    
/**
 * Metodo para poner la contraseña al usuario dado su correo
 * @param type $mail
 * @param type $contra
 * @return type
 */
    public function nuevaContraseña($mail, $contra) {

        $sql = "select * from usuario where correo=?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }

        $id = $datos["id_usuario"];
        $estado = $datos["estado_usuario"];

        if ($estado == "activado") {
            $estado = "desactivado";
        } else {
            $estado = "activado";
        }

        $sql1 = "UPDATE usuario SET  estado_usuario=:estado_usuario , contraseña=:contrasena where id_usuario = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':estado_usuario', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR); //nueva contraseña de usuario hash

        $stmt->execute();
        
        return $stmt;
    }
/**
 * Metodo que deshabilita la cuenta cuando se pide cambio de contraseña
 * @param type $mail
 * @param type $contra
 * @return type
 */
    public function quitarActivacion($mail, $contra) {

        $sql = "select * from usuario where correo=?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }

        $id = $datos["id_usuario"];
        $estado = "desactivado";

        $sql1 = "UPDATE usuario SET  estado_usuario=:estado_usuario , contraseña=:contrasena where id_usuario = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':estado_usuario', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR); //nueva contraseña de usuario hash

        $stmt->execute();
       
        return $stmt;
    }

}
