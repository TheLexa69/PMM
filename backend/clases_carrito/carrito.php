<?php
/**
 * Description of carrito
 *
 * @author Nuria
 */
require_once 'conexion.php';

//namespace clases_carrito;
class carrito extends conexion {
    
    private $table = 'carrito';

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

    /*saca todas las filas de la cesta del usuario con el que tenemos sesión */
    public function getCarro($id_usuario) {
        $stmt = $this->conexion->prepare("select id_carro from $this->table where id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*Saca cada producto que tiene en la cesta con esos campos, parecido al de arriba*/
    /*Sin utilidad, anteriormente para mostrar cada fila x producto, base de datos cambiada*/
    public function printCarro($id_usuario) {
        $rows = "";
        $stmt = $this->conexion->prepare("SELECT c.id_comida, p.img, p.nombre, precio, c.id_usuario, c.cantidad 
                                            FROM carta_comida p 
                                            INNER JOIN $this->table c ON p.id_comida = c.id_comida 
                                            WHERE c.id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $rows .= 'id comida:' .$row['id_comida']. 'Imagen: ' . $row['img'] . ', Nombre: ' . $row['nombre'] . ', Precio: ' . $row['precio'] . ', ID usuario: ' . $row['id_usuario'] . ', cantidad: ' . $row['cantidad'] . '<br>';
        }
        return $rows;
        //Código para visualizar el carro
    }

    public function printCarroSes($id_comida, $cantidad) {
        $stmt = $this->conexion->prepare("SELECT id_comida, img, nombre, precio
                                            FROM carta_comida WHERE id_comida = :id_comida");
        $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        //$row = 'id comida:' .$result['id_comida']. 'Imagen: ' . $result['img'] . ', Nombre: ' . $result['nombre'] . ', Precio: ' . $result['precio'] . ', cantidad: ' . $cantidad . '<br>';
        
        //return $row;
        
        //Código para visualizar el carro
        $url = DIRECTORY_SEPARATOR .'proyecto'.DIRECTORY_SEPARATOR .'backend'. DIRECTORY_SEPARATOR . 'cart'. DIRECTORY_SEPARATOR.'eliminar_carrito.php?cod='. $result['id_comida'];
        $html_code = "<div class=\"layered box row mr-2\" id=\"producto\">
                        <div class=\"col-4\">                        
                                <img class=\"imagenes rounded img-fluid\" id=\"producto_img\" title=\"vaso\" src=\"https://cdn.pixabay.com/photo/2020/12/15/13/44/children-5833685__340.jpg\">
                                </div>
                        <div class=\"col-4 d-flex ml-2 flex-column\">
                            <h4 class=\"nombre-producto\">" .  $result['nombre'] . "</h4>
                            <p>Descripción:
                            <a href=\"#\" id=\"info\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-exclamation-circle\" viewBox=\"0 0 16 16\">
                                <path d=\"M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z\"/>
                                <path d=\"M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z\"/>
                                </svg>
                            </a>
                            </p>

                            <h5 class=\"precio-producto\"> Precio: ". $result['precio'] ."</h5>
                            <form method=\"post\" action=\"". $url  ."\">
                            <label for=\"cantidad\">Cantidad:</label>
                              <select id=\"cantidad\" name=\"cantidad\">'";
        for($i=0; $i<=$cantidad;$i++) {        
            $html_code .= '<option value=\"'.$i.'\">'.$i.'</option>';
        }
        $html_code .= "</select>
                </div>
        <div class=\"col-4 d-flex justify-content-center\">
                <!-- if session rol = admin button editar, deshabilitar -->     
                <button class=\"btn-add-cart btn btn-outline-secondary\" id=\"eliminar\" type=\"submit\">Eliminar</button></form>";

        return $html_code;


    }
    
    /*Añadir productos al carro*/
    public function add($id_usuario, $carrito) {
        $id_comida_cantidad = json_encode($carrito);

        try {
            // Iniciar transacción
                $this->conexion->beginTransaction();

                $stmt = $this->conexion->prepare("INSERT INTO carrito (id_usuario, id_comida_cantidad) VALUES (:id_usuario, :id_comida_cantidad)");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':id_comida_cantidad', $id_comida_cantidad, PDO::PARAM_STR);
                $stmt->bindParam(':id_ped', $id_ped, PDO::PARAM_INT);
                $stmt->execute();

            // Si la consulta de inserción o actualización se ejecuta correctamente
            // se confirma la transacción, de lo contrario se hace un rollback
            $this->conexion->commit();
            return true;
        } catch(PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
/*public function add($id_usuario, $id_comida, $cantidad) {
    try {
        // Iniciar transacción
        $this->conexion->beginTransaction();

        // Verificar si el producto ya existe en el carrito
        if($this->searchRow($id_usuario, $id_comida)) {
            $this->update($id_usuario, $id_comida, $cantidad);
        } else {
            $stmt = $this->conexion->prepare("INSERT INTO $this->table (id_usuario, id_comida, cantidad) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_comida, PDO::PARAM_INT);
            $stmt->bindParam(3, $cantidad, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Si la consulta de inserción o actualización se ejecuta correctamente
        // se confirma la transacción, de lo contrario se hace un rollback
        $this->conexion->commit();
        return true;
    } catch(PDOException $e) {
        $this->conexion->rollBack();
        return false;
    }
}*/
  

/* Actualizar la cantidad de un producto en el carrito */
public function update($id_usuario,$id_comida, $cantidad)
{
    $query = "UPDATE $this->table SET cantidad = cantidad + :cantidad WHERE id_usuario = :id_usuario and id_comida = :id_comida";
    $stmt = $this->conexion->prepare($query);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    return $stmt->execute();
}

    
    /*Elimina un producto de la cesta*/
    public function removeItem($id_comida)
    {
        $query = "DELETE FROM $this->table WHERE id_comida = :id_comida";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    /*Limpiar cesta (después se añade todo a la factura)*/
    public function clearCarro($id_usuario)
    {
        $query = "DELETE FROM $this->table WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    /*public function getTotalPrice($id_usuario) {
        $query = "select sum(precio) from carta_comida p, $this->table c, usuario u where (c.id_usuario = :id_usuario) and (p.id_comida = c.id_comida)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        //guardar en variable y return en html
    }*/

    public function getTotalPrice($id_usuario) {
        $total_price_list = array();
    
        // Obtener todos los productos en el carrito
        $stmt = $this->conexion->prepare("SELECT * FROM $this->table WHERE id_usuario = ?");
        $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($productos as $producto) {
            $precio_total = $producto['precio'] * $producto['cantidad'];
            $product_info = array(
                'id_producto' => $producto['id_producto'],
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'precio_unitario' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
                'precio_total' => $precio_total
            );
            array_push($total_price_list, $product_info);
        }
    
        return $total_price_list;
    }
    

    function searchId($email) {
        $query = "SELECT id_usuario FROM usuario WHERE correo = :email";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function searchRow($id_usuario, $id_comida) {
        $query = "SELECT * FROM carrito WHERE id_usuario = :id_usuario and id_comida = :id_comida";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

}




