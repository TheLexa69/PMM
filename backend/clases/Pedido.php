<?php

namespace clases;

/**
 * Description of pedido
 *
 * @author Nuria
 */
use \clases\Mails as mails;
use \PDO;
use \PDOException;
use \clases\CrearPDF;

class Pedido extends Conexion {

    private $tabla_pedidos;
    private $tabla_productos;
    private $tabla_factura;

    public function __construct($rol=5) {
        parent::__construct($rol);
        $this->tabla_pedidos = 'pedidos';
        $this->tabla_productos = 'ped_prod';
        $this->tabla_factura = 'factura';
    }

    public function __destruct() {
        $this->conexion = null;
    }
    
    /**
     * Método para crear un nuevo pedido
     * @param int $id_usuario El id del usuario que hace el pedido
     * @param array $carrito El carrito de la compra, que contiene la lista de id productos y la cantidad de cada uno
     * @param float $precio El precio total del pedido
     * @param string $cif El CIF de la empresa que envía el pedido
     * @param string $modo_pago El modo de pago utilizado para hacer el pedido
     * @return int|false El id del pedido creado, o false si hubo algún problema
     */
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
    
    /**
     * Método para obtener todos los pedidos de un usuario
     *
     * @param int $id_usuario ID del usuario del que se quieren obtener los pedidos
     * @param string $orden ASC/DESC
     * 
     * @return array Array con todos los pedidos del usuario
     */
    public function obtenerPedidos($id_usuario, $orden, $indice_primer_elemento, $por_pagina) {
        if (empty($orden)) {
            $stmt = $this->conexion->prepare("SELECT id_ped, fecha FROM $this->tabla_pedidos WHERE id_usuario = :id_usuario ORDER BY fecha DESC LIMIT :indice_primer_elemento, :por_pagina");
        } else {
            $stmt = $this->conexion->prepare("SELECT id_ped, fecha, restaurante FROM $this->tabla_pedidos WHERE id_usuario = :id_usuario ORDER BY fecha $orden LIMIT :indice_primer_elemento, :por_pagina");
        }
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(":indice_primer_elemento", $indice_primer_elemento, PDO::PARAM_INT);
        $stmt->bindParam(":por_pagina", $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pedidos as &$pedido) {
            $stmt = $this->conexion->prepare("SELECT cc.nombre, pp.cantidad, pp.precio FROM ped_prod AS pp INNER JOIN carta_comida AS cc  ON pp.id_prod = cc.id_comida WHERE pp.id_ped = ?");
            $stmt->execute([$pedido['id_ped']]);
            $pedido['productos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $this->conexion->prepare("SELECT total FROM factura WHERE id_ped = ?");
            $stmt->execute([$pedido['id_ped']]);
            $pedido['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }
        return $pedidos;
    }

  /**
     * Método para obtener todos los pedidos (de todos los usuarios) NO SE USA ES GENERAL
     * @param int $id_usuario ID del usuario para controlar que sea admin
     * @return array Array con todos los pedidos de todos los usuarios
     */
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
    
    /**
     * Método para obtener un pedido en particular
     *
     * @param int $id_pedido ID del pedido que se quiere obtener
     * 
     * @return array Array con la información del pedido y los productos que se pidieron
     */
    public function obtenerPedido($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM $this->tabla_pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->conexion->prepare("SELECT $this->tabla_productos.nombre, pedidos_productos.cantidad, ped_prod.precio FROM ped_prod INNER JOIN $this->tabla_productos ON ped_prod.id_producto = $this->tabla_productos.id WHERE ped_prof.id_pedido = ?");
        $stmt->execute([$id]);
        $pedido['productos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedido;
    }

    /**
     * Método para obtener número de pedidos 
     *
     * @param int $id ID del usuario
     * 
     * @return int 
     */
    public function obtenerNumPedidos($id_usuario) {
        $stmt = $this->conexion->prepare("SELECT count(*) FROM $this->tabla_pedidos WHERE id_usuario = :id_usuario");
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $pedidos = $stmt->fetch();
        return $pedidos[0];
    }

    /**
     * Método para obtener todas las empresas
     *
     * @return array Array con la información de todas las empresas
     */
    public function getEmpresas() {
        $stmt = $this->conexion->prepare("SELECT cif, nombreLocal, direccion FROM empresa");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Método para obtener todos los modos de pago
     *
     * @return array Array con la información de todos los modos de pago
     */
    public function getModoPago() {
        $stmt = $this->conexion->prepare("SELECT * FROM modo_pago");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    *
    * Genera una tabla HTML con los productos del carrito y su precio total, incluyendo las especificaciones del cliente.
    * @param array $carrito Un array asociativo con los IDs de los productos como clave y la cantidad como valor.
    * @param float $precio_total El precio total del carrito.
    * @param string $especif Las especificaciones del cliente.
    * @return string Una cadena de caracteres que representa la tabla HTML con los productos del carrito y su precio total, incluyendo las especificaciones del cliente.
    */
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
        $array_carrito .= "</tr>
                        <tr><td><b>Precio Total</b></td><td colspan=2><b>$precio_total </b></td> </tr>
                        
                        <tr><td>Especificaciones del cliente: </td><td colspan=2>$especif</td> </tr>";
        return $array_carrito;
    }

    /**
    *
    * Crea el contenido del correo electrónico para enviar el pedido.
    * @param array $carrito Un array asociativo con los IDs de los productos como clave y la cantidad como valor.
    * @param int $pedido El ID del pedido.
    * @return string Una cadena de caracteres que representa el contenido del correo electrónico para enviar el pedido.
    */
    function crear_correo($carrito, $pedido) {
        /*
         * Crea la tabla HTML con los productos que se piden, incluyendo el peso
         */
        $stmt = $this->conexion->prepare("SELECT e.nombreLocal, e.cif, e.nombre_sociedad, e.direccion, e.ciudad, e.cp, e.telefono, f.fecha, m.nombre
                                    FROM factura f INNER JOIN empresa e INNER JOIN modo_pago m WHERE id_ped = :pedido AND e.cif = f.cif_empresa AND f.modo_pago = m.id_modo_pago");
        $stmt->bindParam(':pedido', $pedido, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $texto = "<p style='padding-top: 30px;'><h5>" . $result["nombreLocal"] . "</h5></p><p><h5>" . $result["cif"] . "</h5></p><p><h5>" . $result["nombre_sociedad"] . "</h5></p><p><h5>" . $result["direccion"] . "</h5></p><p><h5>" . $result["ciudad"] . "</h5></p><p><h5>" . $result["cp"] . "</h5></p><p><h5>" . $result["fecha"] . "</h5></p>";
        $texto .= "<p>Detalle del pedido:</p>";
        $texto .= "<p>Pedido nº $pedido</p>";
        $texto .= "<table>"; //abrir la tabla
        $texto .= "<tr><th>Nombre</th><th>Unidades</th><th>Precio</th></tr>";
        $texto .= $carrito;
        $texto .= "<tr><td colspan=3> Modo de pago: " . $result["nombre"] . "</td></tr>";
        $texto .= "<tr><td colspan=3> Su pedido se está cocinando... </td></tr></table>";
        
        return $texto;
    }


    /**
    * Envía el correo electrónico con el contenido proporcionado.
    * @param string $email La dirección de correo electrónico a la que se enviará el correo.
    * @param string $cuerpo El contenido del correo electrónico.
    */
    function enviar($email, $cuerpo) {
        $c_envio = new mails;
        $c_envio->enviar_correo_pedidos($email, $cuerpo);
    }

}