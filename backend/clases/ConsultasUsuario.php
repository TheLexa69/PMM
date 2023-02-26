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
    
      public function __destruct() {
        $this->conexion = null;
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

    public function actualizarDatosUsuario($id, $nombre, $apellido1, $apellido2, $telefono, $mail, $nif, $direccion, $cp, $rutaImg) {
        try {
            if ($rutaImg == 0) {
                $sql = "UPDATE usuario SET nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, num_telef=:telefono, correo=:mail, NIF=:nif, direccion=:direccion, cp=:cp where id_usuario = :id";
            } else {
                $rutaImagen = '../imagenes/imgUsuarios/' . $rutaImg;
                $sql = "UPDATE usuario SET nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, num_telef=:telefono, correo=:mail, NIF=:nif, direccion=:direccion, cp=:cp, img=:img where id_usuario = :id";
            }


            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindParam(':nif', $nif, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':cp', $cp, PDO::PARAM_STR);
            if (!$rutaImg == 0) {
                $stmt->bindParam(':img', $rutaImagen, PDO::PARAM_STR);
            }

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

}
