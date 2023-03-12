<?php

namespace clases;

/**
 * Description of carta
 *
 * @author Nuria y Guillermo
 */
use \PDO;
use \PDOException;

class Carta extends Conexion {

    private $table = 'carta_comida';

    public function __construct($rol = 5) {
        parent::__construct($rol);
    }

    public function __destruct() {
        $this->conexion = null;
    }

    /**
     * Obtiene una lista de platos filtrados por tipo.
     *
     * @param string $tipo El tipo de plato por el que se quiere filtrar.
     * @return array Un array con la información de los platos que coinciden con el filtro.
     */
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

    /**
     * Obtiene una lista de todos los platos de la carta.
     *
     * @return array Un array con la información de todos los platos de la carta.
     */
    public function printCarta() {
        $fecha_hoy = date('Y-m-d', time());
        $query = "SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida from $this->table WHERE fecha_inicio <= :fecha_hoy AND (fecha_fin >= :fecha_hoy OR fecha_fin IS NULL) AND disponible = 'si'";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':fecha_hoy', $fecha_hoy);
        $stmt->execute();
        return $stmt->fetchAll();
    }

     /**
     * Obtiene una lista de todas las categorías disponibles en la carta.
     *
     * @return array Un array con los nombres de todas las categorías disponibles en la carta.
     */
    public function getCategorias() {
        $query = "select nombre_tipo from tipo;";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una lista de platos filtrados por alérgenos.
     *
     * @param array $alergenos Array con los ids de los alérgenos a filtrar.
     * @return array Retorna un array con los platos que no contienen los alérgenos especificados.
     */
    public function filterByAlergeno($alergenos) {
        $text = "";
        //var_dump($alergenos);
        if (count($alergenos) == 1) {
            $a;
            foreach ($alergenos as $id) {
                $a = $id;
            }
            $query = "SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida from $this->table WHERE id_comida NOT IN ( SELECT id_comida FROM carta_alergenos WHERE id_alergeno = $a)";
        } else {
            $cantidad = count($alergenos);
            //$alergenos = implode(',', $alergenos);
            foreach ($alergenos as $id) {
                $text .= $id;
                --$cantidad;
                if ($cantidad != 0) {
                    $text .= ", ";
                }
            }
            echo $query = "SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida from $this->table WHERE id_comida NOT IN ( SELECT id_comida FROM carta_alergenos WHERE id_alergeno IN ($text))";
        }
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
