<?php

namespace clases;

use \PDO;
use \PDOException;

class ConsultasAdministrador extends Conexion {

    public function __construct() {
        //  var_dump ($this->conexion= $this->conectar());
        //$this->conexion= $this->conectar();
        parent::__construct();
    }

    public function añadirTrabajador($nombre, $apellido1, $apellido2, $token2, $mail, $telefono, $privilegios, $fecha, $nie, $pasaporte) {

        try {
            $sql = "INSERT INTO trabajador (nombre,apellido1 ,apellido2,contraseña,correo,num_telef, id_rol,fecha,nie_trabajador,pasaporte_trabajador) VALUES (:nombre,:apellido1,:apellido2,:contrasena,:correo,:num_telef,:rol,:fecha,:nie,:pasaporte)";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':contrasena', $token2, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':num_telef', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $privilegios, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':nie', $nie, PDO::PARAM_STR);
            $stmt->bindParam(':pasaporte', $pasaporte, PDO::PARAM_STR);

            $stmt->execute();
            unset($stmt);
            unset($this->conexion);
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function comprobarDatosTrabajador($mail) {

        $sql = "select * from trabajador where correo=?";

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

    public function registroHoraSessionTrabajador($id, $fecha) {


        $sql1 = "UPDATE trabajador SET  fecha=:fecha where id_trabajador = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
    }

    public function nuevaContraseñaTrabajador($mail, $contra) {

        $sql = "select * from trabajador where correo=?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }

        $id = $datos["id_trabajador"];
        $estado = $datos["estado_trabajador"];

        if ($estado == "activado") {
            $estado = "desactivado";
        } else {
            $estado = "activado";
        }

        $sql1 = "UPDATE trabajador SET  estado_trabajador=:estado_trabajador , contraseña=:contrasena where id_trabajador = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':estado_trabajador', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR); //nueva contraseña de usuario hash

        $stmt->execute();

        return $stmt;
    }

    public function quitarActivacionTrabajador($mail, $contra) {

        $sql = "select * from trabajador where correo=?";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }

        $id = $datos["id_trabajador"];
        $estado = "desactivado";

        $sql1 = "UPDATE trabajador SET  estado_trabajador=:estado_trabajador, contraseña=:contrasena where id_trabajador = :id";

        $stmt = $this->conexion->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
        $stmt->bindParam(':estado_trabajador', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR); //nueva contraseña de usuario hash

        $stmt->execute();

        return $stmt;
    }

    public function filtradoTrabajadores($paginaInicio, $cantidadResultados, $nombre, $opcion, $orden) {
        try {
           
           
       
                if (!empty($nombre) && empty($orden)&& empty($opcion)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre=:nombre LIMIT :paginaInicio, :cantidadResultados";
            
                
                }else if (!empty($nombre)&& !empty($opcion) &&  empty($orden) ) {


                   $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre=:nombre ORDER BY $opcion  LIMIT :paginaInicio, :cantidadResultados";
          
                }else if (empty($nombre) && !empty($opcion) &&  empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion LIMIT :paginaInicio, :cantidadResultados";
          
                } elseif (empty($nombre) && !empty($opcion) && !empty($orden) ) {

               $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion $orden LIMIT :paginaInicio, :cantidadResultados";

                } elseif (!empty($nombre) && !empty($opcion) &&  !empty($orden)) {

          $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol   where nombre=:nombre    ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
            }
         else {
            $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador  as t inner join roles as r on r.id_rol = t.id_rol  LIMIT :paginaInicio, :cantidadResultados";
        }
        
        
 
   
             
        $stmt = $this->conexion->prepare($sql2);
        if(!empty($nombre)){
            
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        } 
        
        $stmt->bindValue(':paginaInicio', $paginaInicio, PDO::PARAM_INT);
        $stmt->bindValue(':cantidadResultados', $cantidadResultados, PDO::PARAM_INT);
     
        $stmt->execute();
      return  $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        unset($stmt);
        unset($this->conexion);
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
      
      
    }
     public function  trabajadoresActivos(){
    try{
         $sql = "select count(*) from trabajador ";
        $stmt = $this->conexion->query($sql);
         $stmt->fetchColumn();
     } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
     
    }

}
