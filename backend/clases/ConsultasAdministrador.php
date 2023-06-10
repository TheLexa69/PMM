<?php

namespace clases;

use \PDO;
use \PDOException;
use \clases\TraitImagen as GuardaImagen;

class ConsultasAdministrador extends Conexion {

    use GuardaImagen;

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
     * Método para añadir los datos de un trabajador, las variables son referenciadas al dato.
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
     * Método para comprobar los datos del trbajador ya sea por que recibe. 
     * @param $dato.      el ID  o el correo
     * @return $datos.
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
     * Método para actualizar los datos del trabajador
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
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     *  Devuelve un array con todos los roles de trabajadores registrados en la base de datos.
     *  @return array El array con los roles de trabajadores.
     *  @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que elimina el trabajador segun su id.
     * @param $id
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que registra la fecha en el trabajador al hacer login.
     * @param $id  de usuario
     * @param $fecha  dia actual y hora
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método para añadir la contraseña al trabajador
     * @param $mail
     * @param $contra
     * @return $stmt
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método para quitar la activacion de la cuenta del trabajador  cuando este solicite cambiar la contraseña
     * @param $mail
     * @param $contra  Este es el nuevo hash que se guarda hasta que se active la cuenta y se meta una nueva contraseña
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método para filtrar los trabajadores  ya sea por:
     * @param $paginaInicio   pagina actual
     * @param $cantidadResultados  cantidad de datos a mostrar
     * @param $nombre      nombre por el que filtrar
     * @param $opcion      Nombre, Ultimo login, Rol, Activos en la empresa
     * @param $orden       orden ascendente o descendente
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function filtradoTrabajadores($paginaInicio, $cantidadResultados, $nombre, $opcion, $orden) {
        try {
            if (!empty($nombre) && empty($orden) && empty($opcion)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre  LIKE '%" . $nombre . "%' LIMIT :paginaInicio, :cantidadResultados";
            } else if (!empty($nombre) && !empty($opcion) && empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  where nombre  LIKE '%" . $nombre . "%' ORDER BY $opcion  LIMIT :paginaInicio, :cantidadResultados";
            } else if (empty($nombre) && !empty($opcion) && empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion LIMIT :paginaInicio, :cantidadResultados";
            } elseif (empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol  ORDER BY $opcion $orden LIMIT :paginaInicio, :cantidadResultados";
            } elseif (!empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador as t inner join roles as r on r.id_rol = t.id_rol   where nombre  LIKE '%" . $nombre . "%' ORDER BY $opcion $orden  LIMIT :paginaInicio, :cantidadResultados";
            } else {

                $sql2 = "select t.id_trabajador,t.nie_trabajador,t.pasaporte_trabajador,t.nombre,t.apellido1,t.apellido2,t.fecha,t.num_telef,t.estado_trabajador,t.trabajando,t.id_rol,r.nombre_rol from trabajador  as t inner join roles as r on r.id_rol = t.id_rol  LIMIT :paginaInicio, :cantidadResultados";
            }

            $stmt = $this->conexion->prepare($sql2);
            // if (!empty($nombre)) {
            //     $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            // }

            $stmt->bindValue(':paginaInicio', $paginaInicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidadResultados', $cantidadResultados, PDO::PARAM_INT);

            $stmt->execute();
            return $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que devuelve la cantidad de trabajadores.
     * @return $stmt
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que devuelve el producto de la tabla carta_comida con tipo y subtipo en formato texto de las tablas tipo y subtipo
     * @param $dato
     * @return $datos.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que devuelve los datos de  la tabla subtipo si recibe un 1  o la de tipo si recibe otro numero
     * @param $dato
     * @return $fila     
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método para actualizar los datos de los productos 
     * @param $id
     * @param $nombre
     * @param $descripcion  descripcion de los productos 
     * @param $tipo
     * @param $subtipo
     * @param $desde  disponible desde
     * @param $hasta  disponible hasta
     * @param $precio
     * @param $disponible   Si esta visible para los usuarios  independientemente de que la fecha sea disponible
     * @param $img
     * @return $stmt
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que devuelve todos los productos de la tabla carta_comida con el tipo y el subtipo ntanto en numero como string para precargar el formulario de productos del administrador
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function productos($indice_primer_elemento, $por_pagina) {
        try {
            $sql = "select c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo,e.nombre_subtipo from carta_comida  as c inner join tipo as t on c.tipo = t.id_tipo inner join subtipo as e on c.subtipo = e.id_subtipo  LIMIT $indice_primer_elemento, $por_pagina";
            $stmt = $this->conexion->query($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que devuelve la cantidad de productos
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método para filtrar los productos  ya sea por:
     * @param $paginaInicio   pagina actual
     * @param $cantidadResultados  cantidad de datos a mostrar
     * @param $nombre      nombre por el que filtrar
     * @param $opcion      Nombre, Precio,En Stock , Disponibiliadad  desde  o hasta
     * @param $orden       orden ascendente o descendente
     * @return $fila.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function filtradoProductos($indice_primer_elemento, $por_pagina, $nombre, $opcion, $orden) {

        try {
            //   var_dump($_SESSION);
            if (!empty($nombre) && empty($orden) && empty($opcion)) {
                $sql2 = "SELECT c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo 
                FROM carta_comida  AS c 
                INNER JOIN tipo AS t ON c.tipo = t.id_tipo 
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                WHERE nombre  LIKE '%" . $nombre . "%' LIMIT $indice_primer_elemento, $por_pagina";
            } else if (!empty($nombre) && !empty($opcion) && empty($orden)) {

                $sql2 = "SELECT c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo 
                FROM carta_comida  as c 
                inner join tipo as t on c.tipo = t.id_tipo 
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                WHERE nombre  LIKE '%" . $nombre . "%' ORDER BY $opcion  LIMIT $indice_primer_elemento, $por_pagina";
            } else if (empty($nombre) && !empty($opcion) && empty($orden)) {

                $sql2 = "SELECT c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo 
                from carta_comida  as c 
                inner join tipo as t on c.tipo = t.id_tipo 
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                ORDER BY $opcion LIMIT $indice_primer_elemento, $por_pagina";
            } elseif (empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "SELECT c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo 
                from carta_comida  as c 
                inner join tipo as t on c.tipo = t.id_tipo 
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                ORDER BY $opcion $orden LIMIT $indice_primer_elemento, $por_pagina";
            } elseif (!empty($nombre) && !empty($opcion) && !empty($orden)) {

                $sql2 = "SELECT c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo 
                from carta_comida  as c 
                inner join tipo as t on c.tipo = t.id_tipo 
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                WHERE nombre  LIKE '%" . $nombre . "%' 
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                ORDER BY $opcion $orden  LIMIT $indice_primer_elemento, $por_pagina";
            } else {
                $sql2 = "SELECT c.id_comida,c.nombre,c.descripcion,c.tipo,c.subtipo,c.fecha_inicio ,c.fecha_fin, c.precio,c.disponible,c.img, t.nombre_tipo 
                from carta_comida  as c 
                inner join tipo as t on c.tipo = t.id_tipo
                LEFT JOIN subtipo as e on c.subtipo = e.id_subtipo
                LIMIT $indice_primer_elemento, $por_pagina";
            }

            $stmt = $this->conexion->prepare($sql2);
            // if (!empty($nombre)) {
            //     $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            // }
            $stmt->execute();
            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fila;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    public function obtenerNumProductos() {
        $stmt = $this->conexion->prepare("SELECT count(*) FROM carta_comida");
        $stmt->execute();
        $num = $stmt->fetch();
        return $num[0];
    }

    public function obtenerNumTrabajadores() {
        $stmt = $this->conexion->prepare("SELECT count(*) FROM trabajador");
        $stmt->execute();
        $num = $stmt->fetch();
        return $num[0];
    }

    /**
     * Método que elimina el producto que tenga ese id.
     * @param $id
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que muestra todos los tipos de comidas que hay en la carta de comida.
     * @return $$tipo.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function productoTipo() {
        try {
            $sql = "select nombre_tipo from tipo";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $tipo;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que muestra todos los subtipos de comidas que hay en la carta de comida.
     * @return $$tipo.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function productoSubTipo() {
        try {
            $sql = "select nombre_subtipo from subtipo";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $tipo;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método para añadir los datos de un trabajador, las variables son referenciadas al dato.
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
    public function agregarProducto($datos, $imagen) {

        try {

            $sql = "insert carta_comida  set nombre=:nombre, descripcion=:descripcion, tipo=:tipo, subtipo=:subtipo, fecha_inicio=:desde, fecha_fin=:hasta, precio=:precio, disponible=:disponible ";
            $sql2 = "update carta_comida  set img=:img where id_comida=:id";
            $sql3 = "insert carta_alergenos set id_alergeno=?, id_comida=?";

            $this->conexion->beginTransaction();

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $datos['descri'], PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $datos['tipo'], PDO::PARAM_INT);
            $stmt->bindParam(':subtipo', $datos['subtipo'], PDO::PARAM_INT);
            $stmt->bindParam(':desde', $datos['desde'], PDO::PARAM_STR);
            $stmt->bindParam(':hasta', $datos['hasta'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':disponible', $datos['disponible'], PDO::PARAM_STR);

            $stmt->execute();

            $ultimoID = $this->conexion->lastInsertId();

            $img = $this->anadirImagenProductos($ultimoID, $imagen);

            if (!$img == 0) {

                $img = '../imagenes/imgProductos/' . $img;

                $stmt = $this->conexion->prepare($sql2);

                $stmt->bindParam(':img', $img, PDO::PARAM_STR);
                $stmt->bindParam(':id', $ultimoID, PDO::PARAM_STR);
                $stmt->execute();
            }

            $stmt = $this->conexion->prepare($sql3);
            foreach ($datos['alergenos']as $key => $alergeno) {


                $stmt->bindValue(1, $alergeno, \PDO::PARAM_INT);
                $stmt->bindValue(2, $ultimoID, \PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->conexion->commit();
            return true;
            unset($stmt);
            unset($this->conexion);
        } catch (PDOException $e) {
            $this->conexion->rollBack();

            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que muestra todos los subtipos de comidas que hay en la carta de comida.
     * @return $$tipo.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
     */
    public function nombreAlergenos() {
        try {
            $sql = "select id_alergeno, nombre_alergeno from alergenos";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();

            $tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $tipo;
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    }

    /**
     * Método que muestra las reservas si se le pasa un 0 muestra las que no estan aceptadas si no se pasa nada muesta las que ya fueron aceptadas
     * @param $comprobante
     * @return $fila.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que le cambia el valor reservaAceptada a si si es aceptada
     * @param $id
     * @param $reserva.   Estado de la reserva por defecto  no    si se acepta si y si se deniega pondra cancelada
     * @return $stmt.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que muestra las reservas de una fecha dada en caso de no pasarle ninguna cojerá la fecha del dia de hoy.
     * @param $fecha
     * @return $fila.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que muestra los pedidos realizados en una fecha determinada y que no hayan sido realizados.
     * @param $fecha
     * @return $fila.
     * @throws PDOException Si hay algún error al ejecutar la consulta SQL.
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
     * Método que actualiza el estado de envío de un pedido por su id.
     * @param $id
     * @param $reserva
     * @return $stmt.
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
