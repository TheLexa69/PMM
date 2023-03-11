<?php

namespace clases;

use \PDO;
use \PDOException;

class ConsultasAdministrador extends Conexion {

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
 *  Metodo par añadir los datos de un trabajador las variables son referenciadas al dato
 * @param type $nombre
 * @param type $apellido1
 * @param type $apellido2
 * @param type $token2        es el numero generado aleatoriamente y pasado a hash que se guarda en la base de datos en el registro
 * @param type $mail
 * @param type $telefono
 * @param type $privilegios    es  rol del usuario que puede ser Administrador Gestor Administrador o Trabajador
 * @param type $fecha           Fecha en la cual hace loggin o en este caso se inserta en la tabla
 * @param type $nie             
 * @param type $pasaporte
 */
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
     * Metodo para comprobar los datos del trbajador ya sea por que recive: 
     * @param type      el ID  o el correo
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
/**
 *  Metodo para actualizar los datos del trabajador
 * @param type $id
 * @param type $nie
 * @param type $pasaporte
 * @param type $nombre
 * @param type $apellido1
 * @param type $apellido2
 * @param type $correo
 * @param type $telefono
 * @param type $rol   
 * @param type $estado
 * @param type $trabajando   Si sigue en activo o no dado de alta
 * @return type
 */
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
/**
 *  Metodo que devuelve los roles de los trabajadores
 * @return type
 */
    public function rolesTrabajadores() {

        try {
            $sql = "select * from roles";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fila;
           
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que elimina el trabajador segun su id
 * @param type $id
 * @return type
 */
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

    /**
     *  Metodo que registra la fecha en el trabajador al hacer loggin
     * @param type $id  de usuario
     * @param type $fecha  dia actual y hora
     * @return type
     */
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
/**
 *  Metodo para añadir la contraseña al trabajador
 * @param type $mail
 * @param type $contra
 * @return type
 */
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
/**
 * Metodo para quitar la activacion de la cuenta del trabajador  cuando este solicite cambiar la contraseña
 * @param type $mail
 * @param type $contra  Este es el nuevo hash qeu se guarda hasta que se active la cuenta y se meta una nueva contraseña
 * @return type
 */
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
/**
 *  Metodo para filtrar los trabajadores  ya sea por:
 * @param type $paginaInicio   pagina actual
 * @param type $cantidadResultados  cantidad de datos a mostrar
 * @param type $nombre      nombre por el que filtrar
 * @param type $opcion      Nombre, Ultimo login, Rol, Activos en la empresa
 * @param type $orden       orden ascendente o descendente
 * @return type
 */
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
 
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que devuelve la cantidad de trabajadores
 * @return type
 */
    public function trabajadoresActivos() {
        try {
            $sql = "select count(*) from trabajador ";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que devuelve el producto de la tabla carta_comida con tipo y subtipo en formato testo de las tablas  tipo y subtipo
 * @param type $dato
 * @return type
 */
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

            
            return $datos;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que devuelve los datos de  la tabla subtipo si recibe un 1  o la de tipo si recibe otro numero
 * @param type $dato
 * @return type
 */
    public function comprobarTipoSubtipo($dato) {

        try {
            if ($dato == 1) {
                $sql = "select * from subtipo";
            } else {
                $sql = "select * from tipo";
            }

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
            return $fila;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo para actualizar los datos de los productos 
 * @param type $id
 * @param type $nombre
 * @param type $descripcion  descripcion de los productos 
 * @param type $tipo
 * @param type $subtipo
 * @param type $desde  disponible desde
 * @param type $hasta  disponible hasta
 * @param type $precio
 * @param type $disponible   Si esta visible para los usuarios  independientemente de que la fecha sea disponible
 * @param string $img
 * @return type
 */
    public function actualizarDatosProductos($id, $nombre, $descripcion, $tipo, $subtipo, $desde, $hasta, $precio, $disponible, $img) {

        try {
            if ($img == 0) {
                $sql = "UPDATE carta_comida  set nombre=:nombre, descripcion=:descripcion, tipo=:tipo, subtipo=:subtipo, fecha_inicio=:desde, fecha_fin=:hasta, precio=:precio, disponible=:disponible where id_comida = :id";
            } else {
                $img = '../imagenes/imgProductos/' . $img;

                $sql = "UPDATE carta_comida  set nombre=:nombre, descripcion=:descripcion, tipo=:tipo, subtipo=:subtipo, fecha_inicio=:desde, fecha_fin=:hasta, precio=:precio, disponible=:disponible, img=:img where id_comida = :id";
            }


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
           
              if (!$img == 0) {
                $stmt->bindParam(':img', $img, PDO::PARAM_STR);
            } 
            
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
    
    /**
     * Metodo que devuelve todos los productos de la tabla carta_comida con el tipo y el subtipo ntanto en numero como string para precargar el formulario de productos del administrador
     * @return type
     */
     public function productos() {
        try {
            $sql = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo  ";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchall();
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    
/**
 * Metodo que devuelve la cantidad de productos
 * @return type
 */
    public function productosActivos() {
        try {
            $sql = "select count(*) from carta_comida ";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 *  Metodo para filtrar los productos  ya sea por:
 * @param type $paginaInicio   pagina actual
 * @param type $cantidadResultados  cantidad de datos a mostrar
 * @param type $nombre      nombre por el que filtrar
 * @param type $opcion      Nombre, Precio,En Stock , Disponibiliadad  desde  o hasta
 * @param type $orden       orden ascendente o descendente
 * @return type
 */
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
            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fila;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que elimina el producto  que tenga ese id
 * @param type $id
 * @return type
 */
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
/**
 * Metodo que muestra las reservas  si se le pasa un 0 muestra las que  no estan aceptadas si no se pasa nada muesta las que ya fueron aceptadas
 * @param type $comprobante
 * @return type
 */
    public function comprobarReservas($comprobante = "") {

        try {
            if ($comprobante == 0) {
                $sql = "select r.id_reservas,r.id_usuario,r.id_restaurante,r.id_mesa,r.fecha_reserva,r.turno ,r.reservaAceptada,u.nombre,u.apellido1,u.num_telef,u.correo,e.nombreLocal from reservas  as r inner join usuario as u on r.id_usuario = u.id_usuario inner join empresa as e on e.cif = r.id_restaurante where reservaAceptada ='no'";
            } else {
                $sql = "select r.id_reservas,r.id_usuario,r.id_restaurante,r.id_mesa,r.fecha_reserva,r.turno ,r.reservaAceptada,u.nombre,u.apellido1,u.num_telef,u.correo,e.nombreLocal from reservas  as r inner join usuario as u on r.id_usuario = u.id_usuario inner join empresa as e on e.cif = r.id_restaurante where reservaAceptada ='si'";
            }

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

         
            return $fila;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que le cambia el valor reservaAceptada a si si es aceptada
 * @param type $id
 * @param type $reserva   Estado de la reserva por defecto  no    si se acepta si y si se deniega pondra cancelada
 * @return type
 */
    public function actualizarReservas($id, $reserva) {
        try {
            $sql = "UPDATE reservas  set reservaAceptada=:reserva  where id_reservas = :id";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':reserva', $reserva, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que muestra las reservas de una fecha dada  en caso de no pasarle ninguna cojera la fecha del dia de hoy
 * @param type $fecha
 * @return type
 */
    public function comprobarReservasPorFecha($fecha = "") {

        if (empty($fecha)) {
            $fecha = date("Y-m-d");
        } else {
            $fecha = $fecha;
        }
        try {
            if ($fecha) {
                $sql = "select r.id_reservas,r.id_usuario,r.id_restaurante,r.id_mesa,r.fecha_reserva,r.turno ,r.reservaAceptada,u.nombre,u.apellido1,u.num_telef,u.correo,e.nombreLocal from reservas  as r inner join usuario as u on r.id_usuario = u.id_usuario inner join empresa as e on e.cif = r.id_restaurante where fecha_reserva ='$fecha' and reservaAceptada ='si'";
            } else {
                $sql = "select r.id_reservas,r.id_usuario,r.id_restaurante,r.id_mesa,r.fecha_reserva,r.turno ,r.reservaAceptada,u.nombre,u.apellido1,u.num_telef,u.correo,e.nombreLocal from reservas  as r inner join usuario as u on r.id_usuario = u.id_usuario inner join empresa as e on e.cif = r.id_restaurante where fecha_reserva ='$fecha' and reservaAceptada ='si'";
            }

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

       
            return $fila;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que muestra los pedidos realizados en una fecha determinada  y que no hayan sido realizados
 * @param type $fecha
 * @return type
 */
    public function comprobarPedidosPorFecha($fecha) {


        try {
            $sql = "select p.id_ped,p.id_usuario, p.fecha , p.enviado, p.restaurante ,u.nombre, u.apellido1, u.correo,u.num_telef, u.direccion, u.cp ,e.nombreLocal from pedidos  as p inner join usuario as u on p.id_usuario = u.id_usuario inner join empresa as e on e.cif = p.restaurante where p.fecha ='$fecha' and p.enviado ='no'";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

           
            return $fila;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }
/**
 * Metodo que actualiza el estado de envio de un pedido por su id
 * @param type $id
 * @param type $reserva
 * @return type
 */
    public function actualizarPedidos($id, $reserva) {


        try {
            $sql = "UPDATE  pedidos  set enviado=:enviado where id_ped=$id ";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':enviado', $reserva, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

}
