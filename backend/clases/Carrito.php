<?php

namespace clases;

/**
 * Description of carrito
 *
 * @author Nuria
 */
use \PDO;
use \PDOException;

class Carrito extends Conexion {

    private $table = 'carrito';

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        $this->conexion = null;
    }

    /**
     * Devuelve la cantidad de cada producto en el carrito del usuario con sesión iniciada
     *
     * @param int $id_usuario El ID del usuario
     * @return mixed Un array con la cantidad de cada producto en el carrito del usuario, o false si hay un error
     */
    public function getCarro($id_usuario) {
        /* saca todas las filas de la cesta del usuario con el que tenemos sesión */
        $stmt = $this->conexion->prepare("SELECT comida_cantidad FROM $this->table WHERE id_usuario = :id_usuario AND id_ped IS NULL");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Devuelve el HTML para mostrar un producto en el carrito con su imagen, nombre, precio y cantidad
     *
     * @param int $id_comida El ID del producto
     * @param int $cantidad La cantidad del producto
     * @return string El HTML para mostrar el producto en el carrito
     */
    public function printCarroSes($id_comida, $cantidad) {
        $stmt = $this->conexion->prepare("SELECT id_comida, img, nombre, precio
                                            FROM carta_comida WHERE id_comida = :id_comida");
        $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        
        //Código para visualizar el carro
        $url = DIRECTORY_SEPARATOR . 'proyecto' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'cart' . DIRECTORY_SEPARATOR . 'eliminar_carrito.php?cod=' . $result['id_comida'];
        $html_code = "<div class=\"layered box row mr-2\" id=\"producto\">
                        <div class=\"col-4\">                        
                                <img class=\"imagenes rounded img-fluid\" id=\"producto_img\" title=\"vaso\" src=\"https://cdn.pixabay.com/photo/2020/12/15/13/44/children-5833685__340.jpg\">
                                </div>
                        <div class=\"col-4 d-flex ml-2 flex-column\">
                            <h4 class=\"nombre-producto\">" . $result['nombre'] . "</h4>
                            <p>Descripción:
                            <a href=\"#\" id=\"info\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-exclamation-circle\" viewBox=\"0 0 16 16\">
                                <path d=\"M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z\"/>
                                <path d=\"M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z\"/>
                                </svg>
                            </a>
                            </p>

                            <h5 class=\"precio-producto\"> Precio: " . $result['precio'] . "€</h5>
                            <form method=\"post\" action=\"" . $url . "\">
                            <label for=\"cantidad\">Cantidad:</label>
                            <input type=\"number\" name=\"cantidad\" value=\"" . $cantidad . "\" min=\"1\" max=\"10\" onchange=\"updateCantidad(" . $id_comida . ", this.value)\">

                </div>
        <div class=\"col-4 d-flex justify-content-center\">    
                <button class=\"btn-add-cart btn btn-outline-secondary\" id=\"eliminar\" type=\"submit\">Eliminar</button></form></div></div>";

        return $html_code;
    }

    /**
    *
    * @param int $id_comida El id de la comida que se desea agregar al carrito
    * @param int $cantidad La cantidad de la comida que se desea agregar al carrito
    *
    * @return string El fragmento de HTML generado para mostrar la información
    * de la comida en el carrito de compras
    */
    function printCarritoCarta($id_comida, $cantidad) {
        $stmt = $this->conexion->prepare("SELECT id_comida, nombre, precio
                                        FROM carta_comida WHERE id_comida = :id_comida");
        $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        //Código para visualizar el carro
        $url = DIRECTORY_SEPARATOR . 'proyecto' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'cart' . DIRECTORY_SEPARATOR . 'eliminar_carrito.php?cod=' . $result['id_comida'] . '&red=1';
        $html_code = '<div class="row align-items-center border-bottom pt-2 pb-2">
                <div class="col-3">' . $result['nombre'] . '</div>
                <div class="col-3">' . $result['precio'] . '</div>
                <div class="col-3">
                <input type="number" name="cantidad" size="5" value="' . $cantidad . '" min="1" max="10" onchange="updateCantidad(\'' . $id_comida . '\', this.value)"></div>
                <div class="col-3 d-flex justify-content-center align-items-center">
                    <a href="' . $url . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </a>
                </div>
            </div>';

        return $html_code;

    }
    
    /**
    *
    * Añadir productos al carrito del usuario en la base de datos.
    *
    * @param int $id_usuario El ID del usuario al que se va a añadir productos al carrito.
    *
    * @param array $carrito El array que contiene los detalles de los productos que se van a añadir.
    *
    * @return bool Devuelve true si se ha añadido correctamente el producto al carrito, de lo contrario devuelve false.
    */
    public function add($id_usuario, $carrito) {
        $comida_cantidad = serialize($carrito);
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();

            if ($this->getCarro($id_usuario)) {
                $stmt = $this->conexion->prepare("UPDATE $this->table SET comida_cantidad = :comida_cantidad WHERE id_usuario = :id_usuario AND id_ped IS NULL");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':comida_cantidad', $comida_cantidad, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $stmt = $this->conexion->prepare("INSERT INTO $this->table (id_usuario, comida_cantidad) VALUES (:id_usuario, :comida_cantidad)");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':comida_cantidad', $comida_cantidad, PDO::PARAM_STR);
                $stmt->execute();
            }
            // Si la consulta de inserción o actualización se ejecuta correctamente
            // se confirma la transacción, de lo contrario se hace un rollback
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
    
    /**
    *
    * Calcula el precio total de los productos en el carrito
    *
    * @param array $carrito Array de productos en el carrito con su cantidad correspondiente
    *
    * @return string Precio total con formato de moneda (€)
    */
    public function getTotalPrice($carrito) {
        $precio = 0;
        // Obtener todos los productos en el carrito
        foreach ($carrito as $cod => $cant) {
            $stmt = $this->conexion->prepare("SELECT precio FROM carta_comida WHERE id_comida = ?");
            $stmt->bindParam(1, $cod, PDO::PARAM_INT);
            $stmt->execute();
            $productos = $stmt->fetch();
            if ($productos) {
                $precio += (double) $productos['precio'] * (double) $cant;
            }
        }

        return number_format($precio, 2) . "€";
    }
    
    /**
    *
    * Busca el ID de un usuario por su dirección de correo electrónico
    * @param string $email Dirección de correo electrónico del usuario
    * @return array|false Devuelve un array con el ID de usuario si existe, o false si no existe
    */
    function searchId($email) {
        $query = "SELECT id_usuario FROM usuario WHERE correo = :email";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
    *
    * Busca el rol de un usuario por su ID de usuario
    * @param int $id_usuario ID de usuario
    * @return array|false Devuelve un array con el ID de rol del usuario si existe, o false si no existe
    */
    function searchRol($id_usuario) {
        $query = "SELECT id_rol FROM usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

}
