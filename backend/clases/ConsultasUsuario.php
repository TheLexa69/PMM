<?php

namespace clases;

use \PDO;
use \PDOException;

class ConsultasUsuario extends Conexion {

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
     *  Metodo que retorna los datos de un usuario dado su id
     * @param type $id
     * @return type
     */
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
/**
 * Metodo que actualiza los datos de un usuario 
 * @param type $id
 * @param type $nombre
 * @param type $apellido1
 * @param type $apellido2
 * @param type $telefono    
 * @param type $mail        
 * @param type $nif         Dni
 * @param type $direccion   Direcion donde vive
 * @param type $cp          Codigo postal
 * @param type $rutaImg     Ruta en la cual esta la imagen que tendra por nombre (id.formato imagen) 
 * @return type
 */
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
/**
 * Metodo que devuelve los restaurantes disponibles
 * @return type
 */
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
/**
 * Metodo que devuelve las mesas disponibles sin selecionar en la tabla de reservas
 * @return type
 */
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
/**
 *  Metodo para resever una mesa en un determinado dia
 * @param type $id
 * @param type $restaurante    Que restaurante
 * @param type $mesa           Mesa que se asigna 
 * @param type $fecha          Fecha para la cual se solicita
 * @param type $turno          Turno de comida o Cena
 * @return type
 */
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
/**
 * Metodo que muestra los datos cambiados de los usuarios
 * @param type $id
 * @param type $orden
 * @return type
 */
    public function solicitarDatosCambiados($id, $orden) {
        try {
            if (empty($orden)) {
                $sql = "select * from datos_usuario where id_usuario=?";
            } else {
                $sql = "select * from datos_usuario where id_usuario=? ORDER BY fecha $orden";
            }
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array($id));
            $dato = $stmt->fetchAll(PDO::FETCH_ASSOC);

            unset($stmt);
            return $dato;
        } catch (Exception $ex) {
            
        }
    }

}
