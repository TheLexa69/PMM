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

    public function restaurantes() {
        try {
            $sql = "select * from empresa";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fila;
            unset($fila);
        } catch (Exception $ex) {
            
        }
    }

    public function mesas() {
        try {
            $sql = "select * from mesas where (id_mesa not in (select id_mesa from reservas))";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dato = array();
            foreach ($fila as $mesa) {
                $dato = $mesa;
            }
            return $dato;

            unset($fila);
        } catch (Exception $ex) {
            
        }
    }

    public function hacerReserva($id, $restaurante, $mesa, $fecha, $turno) {
        try {
            $sql = "UPDATE reservas SET id_usuario=:id, id_restaurante=:restaurante, id_mesa=:mesa, fecha_reserva=:fecha, turno=:turno";
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
            $stmt->bindParam(':mesa', $mesa, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':turno', $turno, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

}
