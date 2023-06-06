<?php

namespace clases;

use \PDO;
use \PDOException;

class ConsultasUsuario extends Conexion {

    /**
     * Método contruct que al extender de la clase padre Conexión hereda
     * su constructor que es el puntero de conexión.
     */
    public function __construct($rol = 5) {

        parent::__construct($rol);
    }

    /**
     * Método destructor de la clase que se encarga de destruir el objeto de conexión a la base de datos.
     */
    public function __destruct() {
        $this->conexion = null;
    }

    /**
     * Método que devuelve los datos de un usuario dado su id
     * @param $id
     * @return $dato
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que actualiza los datos de un usuario.
     * @param $id
     * @param $nombre
     * @param $apellido1
     * @param $apellido2
     * @param $telefono    
     * @param $mail        
     * @param $nif         Dni
     * @param $direccion   Direcion donde vive
     * @param $cp          Codigo postal
     * @param $rutaImg     Ruta en la cual esta la imagen que tendra por nombre (id.formato imagen) 
     * @return $stmt
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function actualizarDatosUsuario($id, $nombre, $apellido1, $apellido2, $codPais, $telefono, $mail, $nif, $direccion, $cp, $rutaImg) {
        try {
            if ($rutaImg == 0) {
                $sql = "UPDATE usuario SET nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, codPais=:codPais, num_telef=:telefono, correo=:mail, NIF=:nif, direccion=:direccion, cp=:cp where id_usuario = :id";
            } else {
                $rutaImagen = '../imagenes/imgUsuarios/' . $rutaImg;
                $sql = "UPDATE usuario SET nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, codPais=:codPais, num_telef=:telefono, correo=:mail, NIF=:nif, direccion=:direccion, cp=:cp, img=:img where id_usuario = :id";
            }

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR);
            $stmt->bindParam(':codPais', $codPais, PDO::PARAM_STR);
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
     * Método que devuelve los restaurantes disponibles.
     * @return $fila.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que devuelve las mesas disponibles sin selecionar en la tabla de reservas.
     * @return $dato
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function mesas() {
        try {
            $sql = "select * from mesas WHERE id_mesa not in (select id_mesa from reservas where fecha_reserva >= now())";

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
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método para conseguir el cif del restaurante através del nombre.
     * @param $restaurante Nombre restaurante
     * @return $stmt
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function conseguirIDRestaurante($restaurante) {
        try {
            $sql = "SELECT cif FROM empresa WHERE nombreLocal LIKE :nombreLocal";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombreLocal', $restaurante, PDO::PARAM_STR);
            $stmt->execute();
            $dato = $stmt->fetchAll(PDO::FETCH_ASSOC);

            unset($stmt);
            return $dato;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método para resever una mesa en un determinado dia.
     * @param $id
     * @param $restaurante    Que restaurante
     * @param $mesa           Mesa que se asigna 
     * @param $fecha          Fecha para la cual se solicita
     * @param $turno          Turno de comida o Cena
     * @return $stmt
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function hacerReserva($id, $restaurante, $mesa, $fecha, $turno) {
        try {
            $sql = "INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) VALUES (:id, :restaurante, :mesa, :fecha, :turno)";
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
     * Método que muestra los datos cambiados de los usuarios
     * @param $id
     * @param $orden
     * @return $dato
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function solicitarDatosCambiados($id, $orden, $indice_primer_elemento, $por_pagina) {
        try {
            if (empty($orden)) {
                $sql = "select * from datos_usuario where id_usuario = :id LIMIT :indice_primer_elemento, :por_pagina";
            } else {
                $sql = "select * from datos_usuario where id_usuario = :id ORDER BY fecha $orden LIMIT :indice_primer_elemento, :por_pagina";
            }
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":indice_primer_elemento", $indice_primer_elemento, PDO::PARAM_INT);
            $stmt->bindParam(":por_pagina", $por_pagina, PDO::PARAM_INT);
            $stmt->execute();
            $dato = $stmt->fetchAll(PDO::FETCH_ASSOC);

            unset($stmt);
            return $dato;
        } catch (Exception $ex) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que devuelve las filas del histórico de datos de un usuario pasandole el email
     * @param $mail
     * @return $datos
     */
    public function comprobarFilasDatos($id) {
        $sql = "select count(*) from datos_usuario where id_usuario=?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute(array($id));

        $fila = $stmt->fetch();

        unset($stmt);
        return $fila[0];
    }

}
