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

    /**
     * 
     * @param type $mail  segun donde se use puede recibir un mail o un id
     * @return type
     */
    public function comprobarDatosTrabajador($dato) {

        try {
            if (is_numeric($dato)) {
                $sql = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.correo,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol where id_trabajador=?";
            } else {
                $sql = "select * from trabajador where correo=?";
            }

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute(array($dato));

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $datos = array();
            foreach ($fila as $fil) {
                $datos = $fil;
            }

            unset($stmt);
            return $datos;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
    
   

    public function actualizarDatosTrabajador($id, $nie, $pasaporte, $nombre, $apellido1, $apellido2, $correo, $telefono, $rol, $estado, $trabajando) {

        try {
            $sql = "UPDATE trabajador SET  nie_trabajador=:nie, pasaporte_trabajador=:pasaporte, nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, correo=:correo, num_telef=:telefono, id_rol=:rol,estado_trabajador=:estado, trabajando=:trabajando where id_trabajador = :id";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':nie', $nie, PDO::PARAM_STR);
            $stmt->bindParam(':pasaporte', $pasaporte, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':trabajando', $trabajando, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function eliminarTrabajador($id) {

        try {
            $sql = "DELETE from trabajador where id_trabajador = :id";
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function registroHoraSessionTrabajador($id, $fecha) {

        try {
            $sql1 = "UPDATE trabajador SET  fecha=:fecha where id_trabajador = :id";

            $stmt = $this->conexion->prepare($sql1);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function nuevaContraseñaTrabajador($mail, $contra) {

        try {
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
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function quitarActivacionTrabajador($mail, $contra) {

        try {
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
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function filtradoTrabajadores($paginaInicio, $cantidadResultados, $nombre, $opcion, $orden) {
        try {



            if (!empty($nombre) && empty($orden) && empty($opcion)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre=:nombre LIMIT :paginaInicio, :cantidadResultados";
            } else if (!empty($nombre) && !empty($opcion) && empty($orden)) {


                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre=:nombre ORDER BY $opcion  LIMIT :paginaInicio, :cantidadResultados";
            } else if (empty($nombre) && !empty($opcion) && empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion LIMIT :paginaInicio, :cantidadResultados";
            } elseif (empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion $orden LIMIT :paginaInicio, :cantidadResultados";
            } elseif (!empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol   where nombre=:nombre    ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
            } else {
                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador  as t inner join roles as r on r.id_rol = t.id_rol  LIMIT :paginaInicio, :cantidadResultados";
            }

 
            $stmt = $this->conexion->prepare($sql2);
            if (!empty($nombre)) {

                $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            }

            $stmt->bindValue(':paginaInicio', $paginaInicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidadResultados', $cantidadResultados, PDO::PARAM_INT);

            $stmt->execute();
            return $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            unset($stmt);
            unset($this->conexion);
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function trabajadoresActivos() {
        try {
            $sql = "select count(*) from trabajador ";
            $stmt = $this->conexion->query($sql);
            return  $stmt->fetchColumn();
            
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
    
    
     public function comprobarDatosProducto($dato) {

        try {
           
                $sql = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo  where id_comida=?";
           

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute(array($dato));

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $datos = array();
            foreach ($fila as $fil) {
                $datos = $fil;
            }

            unset($stmt);
            return $datos;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    
        public function actualizarDatosProductos($id, $nombre, $descripcion, $tipo, $subtipo, $desde,$hasta, $precio,$disponible,$img) {

        try {
            $sql = "UPDATE carta_comida  set nombre=:nombre, descripcion=:descripcion, tipo=:tipo, subtipo=:subtipo, fecha_inicio=:desde, fecha_fin=:hasta, precio=:precio, disponible=:disponible, img=:img where id_comida = :id";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
            $stmt->bindParam(':subtipo', $subtipo, PDO::PARAM_INT);
            $stmt->bindParam(':desde', $desde, PDO::PARAM_STR);
            $stmt->bindParam(':hasta', $hasta, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':disponible', $disponible, PDO::PARAM_STR);
            $stmt->bindParam(':img', $img, PDO::PARAM_STR);
          

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
    
    
     public function productosActivos() {
        try {
            $sql = "select count(*) from carta_comida ";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchColumn();
            
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function filtradoProductos($paginaInicio, $cantidadResultados, $nombre, $opcion, $orden) {
        try {


            if (!empty($nombre) && empty($orden) && empty($opcion)) {

                $sql2 = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo  where nombre=:nombre LIMIT :paginaInicio, :cantidadResultados";
            } else if (!empty($nombre) && !empty($opcion) && empty($orden)) {


                $sql2 = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo where nombre=:nombre ORDER BY $opcion  LIMIT :paginaInicio, :cantidadResultados";
            } else if (empty($nombre) && !empty($opcion) && empty($orden)) {

                $sql2 = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo  ORDER BY $opcion LIMIT :paginaInicio, :cantidadResultados";
            } elseif (empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo  ORDER BY $opcion $orden LIMIT :paginaInicio, :cantidadResultados";
            } elseif (!empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo where nombre=:nombre    ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
            } else {
                $sql2 = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo LIMIT :paginaInicio, :cantidadResultados";
            }


            $stmt = $this->conexion->prepare($sql2);
            if (!empty($nombre)) {

                $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            }

            $stmt->bindValue(':paginaInicio', $paginaInicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidadResultados', $cantidadResultados, PDO::PARAM_INT);

            $stmt->execute();
            return $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            unset($stmt);
            unset($this->conexion);
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
    
        public function eliminarProducto($id) {

        try {
            $sql = "DELETE from carta_comida where id_comida = :id";
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }


}
