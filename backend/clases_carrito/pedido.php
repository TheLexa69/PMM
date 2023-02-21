<?php
/**
 * Description of pedido
 *
 * @author Nuria
 */
class pedido extends conexion {
    
    private $tabla_pedidos;
    private $tabla_productos;
    
    public function __construct() {
        parent::__construct();
        $this->tabla_pedidos = 'pedidos';
        $this->tabla_productos = 'productos';
    }
    
    public function __destruct() {
        $this->conexion = null;
    }
    
    /* Método para crear un nuevo pedido */
    public function crearPedido($id_usuario, $productos) {
        $fecha = date('Y-m-d H:i:s');
        try {
            $this->conexion->beginTransaction();
            $stmt = $this->conexion->prepare("INSERT INTO $this->tabla_pedidos (id_usuario, fecha) VALUES (?, ?)");
            $stmt->execute([$id_usuario, $fecha]);
            $id_pedido = $this->conexion->lastInsertId();
            foreach ($productos as $producto) {
                $stmt = $this->conexion->prepare("SELECT precio FROM $this->tabla_productos WHERE id = ?");
                $stmt->execute([$producto['id']]);
                $precio = $stmt->fetch(PDO::FETCH_ASSOC)['precio'];
                $stmt = $this->conexion->prepare("INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id_pedido, $producto['id'], $producto['cantidad'], $precio]);
            }
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            $this->conexion->rollback();
            return false;
        }
    }
    
    /* Método para obtener todos los pedidos de un usuario */
    public function obtenerPedidos($id_usuario) {
        $stmt = $this->conexion->prepare("SELECT * FROM $this->tabla_pedidos WHERE id_usuario = ? ORDER BY fecha DESC");
        $stmt->execute([$id_usuario]);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pedidos as &$pedido) {
            $stmt = $this->conexion->prepare("SELECT $this->tabla_productos.nombre, pedidos_productos.cantidad, pedidos_productos.precio FROM pedidos_productos INNER JOIN $this->tabla_productos ON pedidos_productos.id_producto = $this->tabla_productos.id WHERE pedidos_productos.id_pedido = ?");
            $stmt->execute([$pedido['id']]);
            $pedido['productos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $pedidos;
    }
    
    /* Método para obtener un pedido en particular */
    public function obtenerPedido($id_pedido) {
        $stmt = $this->conexion->prepare("SELECT * FROM $this->tabla_pedidos WHERE id = ?");
        $stmt->execute([$id_pedido]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->conexion->prepare("SELECT $this->tabla_productos.nombre, pedidos_productos.cantidad, pedidos_productos.precio FROM pedidos_productos INNER JOIN $this->tabla_productos ON pedidos_productos.id_producto = $this->tabla_productos.id WHERE pedidos_productos.id_pedido = ?");
        $stmt->execute([$id_pedido]);
        $pedido['productos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedido;
    }
    
}
