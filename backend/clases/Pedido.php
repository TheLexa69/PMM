<?php

namespace clases;

/**
 * Description of pedido
 *
 * @author Nuria
 */
//require_once 'conexion.php';
//require "../clases/Conexion.php";
//require "../clases/Mails.php";
use \clases\Mails as mails;
use \PDO;
use \PDOException;

class Pedido extends Conexion {

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
            $stmt = $this->conexion->prepare("INSERT INTO $this->tabla_pedidos (id_usuario, fecha, enviado, restaurante) VALUES (:id_usuario, :fecha, 'no', :cif)");
            $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(":fecha", $fecha);
            $stmt->bindParam(":cif", $cif, PDO::PARAM_STR);
            $stmt->execute();
            $id_pedido = $this->conexion->lastInsertId();
            foreach ($carrito as $comida => $cant) {
                $stmt = $this->conexion->prepare("SELECT precio FROM carta_comida WHERE id_comida = :comida");
                $stmt->bindParam(":comida", $comida, PDO::PARAM_INT);
                $stmt->execute();
                $precio_por_unidad = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = $this->conexion->prepare("INSERT INTO $this->tabla_productos (id_ped, id_prod, cantidad, precio) VALUES (:id_ped, :id_prod, :cantidad, :precio)");
                $stmt->bindParam(":id_ped", $id_pedido, PDO::PARAM_INT);
                $stmt->bindParam(":id_prod", $comida, PDO::PARAM_INT);
                $stmt->bindParam(":cantidad", $cant, PDO::PARAM_INT);
                $stmt->bindParam(":precio", $precio_por_unidad['precio'], PDO::PARAM_INT);
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
            return $id_pedido;
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
        $stmt = $this->conexion->prepare("SELECT $this->tabla_productos.nombre, pedidos_productos.cantidad, ped_prod.precio FROM ped_prod INNER JOIN $this->tabla_productos ON ped_prod.id_producto = $this->tabla_productos.id WHERE ped_prof.id_pedido = ?");
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

    function array_carrito($carrito, $precio_total, $especif) {
        $array_carrito = "";
        foreach ($carrito as $id_comida => $cantidad) {
            $stmt = $this->conexion->prepare("SELECT id_comida, nombre, precio
                                    FROM carta_comida WHERE id_comida = :id_comida");
            $stmt->bindParam(':id_comida', $id_comida, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
            $array_carrito .= "<tr><td>" . $result['nombre'] . "</td><td>$cantidad</td><td>" . $result['precio'] . "€</td><td> </tr>";
        }
        $array_carrito .= "<tr><td colspan=3>_________________</td></tr></tr>
                            <tr><td>Precio Total</td><td colspan=2>$precio_total </td> </tr>
                            <tr><td colspan=3>_________________</td></tr>
                            <tr><td>Especificaciones del cliente: </td><td colspan=2>$especif</td> </tr>";
        return $array_carrito;
    }

    function crear_correo($carrito, $pedido) {
        /*
         * Crea la tabla HTML con los productos que se piden, incluyendo el peso
         */
        $stmt = $this->conexion->prepare("SELECT e.nombreLocal, e.cif, e.nombre_sociedad, e.direccion, e.ciudad, e.cp, e.telefono, f.fecha, m.nombre
                                    FROM factura f INNER JOIN empresa e INNER JOIN modo_pago m WHERE id_ped = :pedido AND e.cif = f.cif_empresa AND f.modo_pago = m.id_modo_pago");
        $stmt->bindParam(':pedido', $pedido, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pesoTotal = 0;
        $texto = "<h1>Pedido nº $pedido</h1>";
        $texto .= "<p><h3>" . $result["nombreLocal"] . "</h3></p><p><h3>" . $result["cif"] . "</h3></p><p><h3>" . $result["nombre_sociedad"] . "</h3></p><p><h3>" . $result["direccion"] . "</h3></p><p><h3>" . $result["ciudad"] . "</h3></p><p><h3>" . $result["cp"] . "</h3></p><p><h3>" . $result["fecha"] . "</h3></p>";
        $texto .= "Detalle del pedido:";
        $texto .= "<table>"; //abrir la tabla
        $texto .= "<tr><th>Nombre</th><th>Unidades</th><th>Precio</th></tr>";
        $texto .= $carrito;
        $texto .= "<tr><td colspan=3> Modo de pago: " . $result["nombre"] . "</td></tr>";
        $texto .= "<tr><td colspan=3> Su pedido se está cocinando... </td></tr></table>";
        return $texto;
    }

    function enviar($email, $cuerpo) {
        $c_envio = new mails;
        $c_envio->enviar_correo_pedidos($email, $cuerpo);
    }

}
