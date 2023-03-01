<?php
namespace clases;
/**
 * Description of carta
 *
 * @author Nuria
 */


use \PDO;
use \PDOException;

class Carta extends Conexion {
    
    private $table = 'carta_comida';

    public function __construct() {
                // Conexión a la base de datos
              //  $this->pdo = conexion();
            //} catch(PDOException $e) {
            //    die("Error de conexión: " . $e->getMessage());
            //}
            parent::__construct();
        
    }
    public function __destruct() {
        $this->conexion = null;
    }

    public function filterByTipo($tipo) {
        $fecha_hoy = date('Y-m-d', time());
        $query = "SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida 
        FROM $this->table c 
        INNER JOIN tipo t ON c.tipo = t.id_tipo
        WHERE t.nombre_tipo = :tipo AND fecha_inicio <= :fecha_hoy AND (fecha_fin >= :fecha_hoy OR fecha_fin IS NULL) AND disponible = 'si'";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_hoy', $fecha_hoy);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    

    public function printCarta() {
        $fecha_hoy = date('Y-m-d', time());
        $query = "SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida from $this->table WHERE fecha_inicio <= :fecha_hoy AND (fecha_fin >= :fecha_hoy OR fecha_fin IS NULL) AND disponible = 'si'";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':fecha_hoy', $fecha_hoy);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategorias() {
        $query = "select nombre_tipo from tipo;";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}




