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
       // try {
            // Conexión a la base de datos
            $this->pdo = conexion();
        //} catch(PDOException $e) {
        //    die("Error de conexión: " . $e->getMessage());
        //}
    }

    /*saca todas las filas de la cesta del usuario con el que tenemos sesión*/
    public function getCarro($email) {
        $stmt = $this->pdo->prepare("select c.id_carro from $this->table c, usuario u where (correo = '$email') and (u.id_usuario = c.id_usuario)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*Saca cada producto que tiene en la cesta con esos campos, parecido al de arriba*/
    /*Falta añadir descripción y cantidad, despues se imprimen los campos en html*/
    public function printCarro($email) {
        $rows = "";
        $stmt = $this->pdo->prepare("select p.img, p.nombre, precio, c.id_usuario from ((carta_comida p inner join $this->table c on (p.id_comida = c.id_comida)) inner join usuario u on (c.id_usuario = u.id_usuario)) where correo = '$email'");
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

}




