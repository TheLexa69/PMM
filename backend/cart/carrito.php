<?php
/**
 * Description of carrito
 *
 * @author Nuria
 */
require_once 'conexion.php';
class carrito {
    private $pdo;
    private $table = 'carrito';

    public function __construct() {
        if (!isset($_SESSION['user_id'])) { 
            // If not, check if there are any products in the cookie
            if (isset($_COOKIE['carrito'])) {
                // If there are, unserialize the data and store it in a variable
                $cart = unserialize($_COOKIE['carrito'], true);
            } else {
                // If not, create an empty array to store the products in
                $cart = array();
            }
        
            // Add the new product to the cart
            array_push($cart, $id_comida, $cantidad);
        
            // Serialize the cart data and store it in a cookie
            setcookie('carrito', serialize($cart), time() + (86400 * 30), "/");
        } else {
            // If the user is logged in, add the product to their cart in the database

        // try {
                // Conexión a la base de datos
                $this->pdo = conexion();
            //} catch(PDOException $e) {
            //    die("Error de conexión: " . $e->getMessage());
            //}

            
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO carrito (id_usuario, id_comida, cantidad) VALUES (?, ?, ?)");

            // Bind the parameters
            $stmt->bindParam(1, $_SESSION['user_id']);
            $stmt->bindParam(2, $product_id);
            $stmt->bindParam(3, $cantidad);

            // Execute the statement
            $stmt->execute();
            
        // Redirect the user back to the product page
        //header("Location: product.php?id=" . $product_id);
        //exit;
        }
    }

    /*saca todas las filas de la cesta del usuario con el que tenemos sesión
    -- cambiar email por id -- */
    public function getCarro($email) {
        $stmt = $this->pdo->prepare("select c.id_carro from $this->table c, usuario u where (correo = '$email') and (u.id_usuario = c.id_usuario)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*Saca cada producto que tiene en la cesta con esos campos, parecido al de arriba*/
    /*Falta añadir descripción y cantidad, despues se imprimen los campos en html*/
    public function printCarro($email) {
        $rows = "";
        $stmt = $this->pdo->prepare("select p.img, p.nombre, precio, c.id_usuario, c.cantidad from ((carta_comida p inner join $this->table c on (p.id_comida = c.id_comida)) inner join usuario u on (c.id_usuario = u.id_usuario)) where correo = '$email'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $rows .= 'Imagen: ' . $row['img'] . ', Nombre: ' . $row['nombre'] . ', Precio: ' . $row['precio'] . ', ID usuario: ' . $row['id_usuario'] . '<br>';
        }
        return $rows;
        //Código para visualizar el carro
    }
    /*Añadir productos al carro*/
    public function add($id_usuario, $id_comida, $cantidad) {
        $stmt = $this->pdo->prepare("INSERT INTO $this->table (id_usuario, id_comida, cantidad) VALUES (:id_usuario, :id_comida, :cantidad)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_comida', $id_comida);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }
    
    /* si ya existe el código de comida, le sumamos unidades de momento no funcional */
    public function update($id_comida, $cantidad)
    {
        $query = "UPDATE $this->table SET cantidad = :cantidad WHERE id_comida = :id_comida";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_comida', $id_comida);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }
    
    /*Elimina un producto de la cesta*/
    public function removeItem($id_comida)
    {
        $query = "DELETE FROM $this->table WHERE id_comida = :id_comida";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_comida', $id_comida);
        return $stmt->execute();
    }
    
    /*Limpiar cesta (después se añade todo a la factura)*/
    public function clearCarro($email)
    {
        $query = "DELETE FROM $this->table WHERE id_usuario IN (SELECT id_usuario FROM usuario WHERE correo = '$email')";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute();
    }
    
    public function getTotalPrice($email) {
        $query = "select sum(precio) from carta_comida p, $this->table c, usuario u where (correo = '$email') and (p.id_comida = c.id_comida) and (c.id_usuario = u.id_usuario)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
        //guardar en variable y return en html
    }

    public function searchId($email) {
        $query = "SELECT id_usuario FROM usuario WHERE correo = '$email'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }

}




