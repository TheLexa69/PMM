<?php
/**
 * Description of pedido
 *
 * @author Nuria
 */
require_once 'conexion.php';
class pedido extends conexion {
    
    private $tabla_pedidos;
    private $tabla_productos;
    private $tabla_factura;
    
    public function __construct() {
        parent::__construct();
        $this->tabla_pedidos = 'pedidos';
        $this->tabla_productos = 'ped_prod';
        $this->tabla_factura = 'factura';
    }
    
    public function __destruct() {
        $this->conexion = null;
    }
    
    /* Método para crear un nuevo pedido */
    public function crearPedido($id_usuario, $carrito, $precio, $cif, $modo_pago) {
        $fecha = date('Y-m-d H:i:s');
        try {
            $this->conexion->beginTransaction();
            $stmt = $this->conexion->prepare("INSERT INTO $this->tabla_pedidos (id_usuario, fecha, enviado, restaurante) VALUES (?, ?, 'no', ?)");
            $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(2, $fecha);
            $stmt->bindParam(3, $cif, PDO::PARAM_STR);
            $stmt->execute();
            $id_pedido = $this->conexion->lastInsertId();
            foreach ($carrito as $comida => $cant) {
                $stmt = $this->conexion->prepare("INSERT INTO $this->tabla_productos (id_ped, id_prod, cantidad, precio) VALUES (?, ?, ?, ?)");
                $stmt->bindParam(1, $id_pedido, PDO::PARAM_INT);
                $stmt->bindParam(2, $comida, PDO::PARAM_INT);
                $stmt->bindParam(3, $cant, PDO::PARAM_INT);
                $stmt->bindParam(4, $precio, PDO::PARAM_INT);
                $stmt->execute();
            }
            $stmt = $this->conexion->prepare("INSERT INTO $this->tabla_factura (id_usuario, cif_empresa, fecha, id_ped, total, modo_pago) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(2, $cif, PDO::PARAM_STR);
            $stmt->bindParam(3, $fecha);
            $stmt->bindParam(4, $id_pedido, PDO::PARAM_INT);
            $stmt->bindParam(5, $precio, PDO::PARAM_INT);
            $stmt->bindParam(6, $modo_pago, PDO::PARAM_INT);
            $stmt->execute();

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

    public function obtenerPedidosAdmin($id_usuario) {
        $stmt = $this->conexion->prepare("SELECT * FROM $this->tabla_pedidos ORDER BY fecha DESC");
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

    public function getEmpresas() {
        $stmt = $this->conexion->prepare("SELECT cif, nombreLocal, direccion FROM empresa");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getModoPago() {
        $stmt = $this->conexion->prepare("SELECT * FROM modo_pago");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
