<?php

namespace clases;

use \PDO;
use \PDOException;

class ConsultasLogin extends Conexion {

    /**
     * Método contruct que al extender de la clase padre Conexión hereda
     * su constructor que es el puntero de conexión.
     */
    public function __construct($rol=5) {

        parent::__construct($rol);
    }

    /**
     * Método destructor de la clase que se encarga de destruir el objeto de conexión a la base de datos.
     */
    public function __destruct() {
        $this->conexion = null;
    }

    /**
     * Método par añadir los datos de un usuario las variables son referenciadas al dato
     * @param $nombre
     * @param $apellido1
     * @param $apellido2
     * @param $token2          Es el numero generado aleatoriamente y pasado a hash que se guarda en la base de datos en el registro
     * @param $mail
     * @param $telefono
     * @param $privilegios     Es  rol del usuario que puede ser Administrador Gestor Administrador o Trabajador
     * @param $fecha           Fecha en la cual hace loggin o en este caso se inserta en la tabla
     * @param $nif             Nif
     * @param $direccion       Direccion donde vive
     * @param $cp              Codigo postal
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function añadirUsuario($nombre, $apellido1, $apellido2, $token2, $mail, $codPais, $telefono, $rol, $fecha, $nif, $direccion, $cp) {
        try {
            $sql = "INSERT INTO usuario (nombre,apellido1 ,apellido2,contraseña,correo,codPais,num_telef, id_rol,fecha,NIF,direccion,cp) VALUES (:nombre,:apellido1,:apellido2,:contrasena,:correo, :codPais,:num_telef,:rol,:fecha,:nif,:direccion,:cp)";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':contrasena', $token2, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':codPais', $codPais, PDO::PARAM_STR);
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
     * Método que devuelve los datos de un usuario pasandole el email
     * @param $mail
     * @return $datos
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
     * Método que registra la hora en la cual el usuario hizo el login
     * @param $id
     * @param $fecha
     * @return $stmt
     */
    public function registroHoraSession($id, $fecha) {
        $sql1 = "UPDATE usuario SET  fecha=:fecha where id_usuario = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    /**
     * Método para poner la contraseña al usuario dado su correo
     * @param $mail
     * @param $contra
     * @return $stmt
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
     * Método que deshabilita la cuenta cuando se pide cambio de contraseña
     * @param $mail
     * @param $contra
     * @return $stmt
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
