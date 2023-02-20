<?php
/**
 * Description of carta
 *
 * @author Nuria
 */
require_once 'conexion.php';
//namespace clases_carrito;
class carta extends conexion {
    
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
        $query = "SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida 
                    FROM $this->table c 
                    INNER JOIN tipo t ON c.tipo = t.id_tipo
                    WHERE t.nombre_tipo = :tipo";
                    $stmt = $this->conexion->prepare($query);
                    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll();
    }

    public function printCarta() {
        $query = "select nombre, descripcion, tipo, precio, img, disponible, id_comida from $this->table";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}




