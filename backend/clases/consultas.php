<?php

require_once "../conexion/conexion.php";
 
class consultas {
    
    private $pdo;
    
    
 public function __construct() {
            
            $this->pdo = conexion();
        
    }
                                      
    
    public function añadirUsuario($nombre,$apellido1,$apellido2,$token2,$mail,$telefono,$rol,$fecha,$estado_usuario,$nif,$direccion,$cp){
    
        try {
             $sql = "INSERT INTO usuario (nombre,apellido1 ,apellido2,contraseña,correo,num_telef, id_rol,fecha,estado_usuario,NIF,direccion,cp) VALUES (:nombre,:apellido1,:apellido2,:contrasena,:correo,:num_telef,:rol,:fecha,:estado_usuario,:nif,:direccion,:cp)";
   
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':contrasena', $token2, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':num_telef', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':rol',$rol , PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':estado_usuario', $estado_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':nif', $nif, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':cp', $cp, PDO::PARAM_STR);
  
            
            $stmt->execute();
  
            unset($conexion);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            if($e->getCode()==23000){
                echo 'Mail ya registrado <br>';
            }else{
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
        
       }
       
       
    }
        
       
        public function comprobarDatos($mail){
                                                                                                                             
        $sql = "select * from usuario where correo=?";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute(array($mail));

        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = array();
        foreach ($fila as $fil) {
            $datos = $fil;
        }
            
            return  $datos;
        }
    

     public function nuevaContraseña($mail,$contra) {
      

            $sql = "select * from usuario where correo=?";

             $stmt = $this->pdo->prepare($sql);

            $stmt->execute(array($mail));

            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $datos = array();
            foreach ($fila as $fil) {
                $datos = $fil;
            }

            $id = $datos["id_usuario"];
            $nombre = $datos["nombre"];
            $apellido1 = $datos["apellido1"];
            $apellido2 = $datos["apellido2"];
            $mail = $datos["correo"];
            $fecha = $datos["fecha"];
            $telef = $datos["num_telef"];
            $rol = $datos["id_rol"];
            $estado_usuario=$datos["estado_usuario"];
            $nif=$datos["NIF"];
            $direccion=$datos["direccion"];
            $cp=$datos["cp"];
            

            $sql1 = "UPDATE usuario SET nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, correo=:correo, "
                    . "fecha=:fecha,num_telef=:num_telef, id_rol=:rol, estado_usuario=:estado_usuario,NIF=:nif,direccion=:direccion,cp=:cp, contraseña=:contrasena where id_usuario = :id";
                                                                    
            $stmt = $this->pdo->prepare($sql1);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':num_telef', $telef, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindParam(':estado_usuario', $estado_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':nif', $nif, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':cp', $cp, PDO::PARAM_STR);           
            $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR); //nueva contraseña de usuario hash
 

            $stmt->execute();
            return $stmt;
     }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     public function add($id_usuario, $id_comida) {
        $stmt = $this->pdo->prepare("INSERT INTO $this->table (id_usuario, id_comida) VALUES (:id_usuario, :id_comida)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_comida', $id_comida);
        return $stmt->execute();
    }
    
    
      public function update($id_comida, $cantidad)
    {
        $query = "UPDATE $this->table SET cantidad = :cantidad WHERE id_comida = :id_comida";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_comida', $id_comida);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }
    
    
      public function removeItem($id_comida)
    {
        $query = "DELETE FROM $this->table WHERE id_comida = :id_comida";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_comida', $id_comida);
        return $stmt->execute();
    }
    
    
      public function getTotalPrice($email) {
        $query = "select sum(precio) from carta_comida p, $this->table c, usuario u where (correo = '$email') and (p.id_comida = c.id_comida) and (c.id_usuario = u.id_usuario)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
        //guardar en variable y return en html
    }
    
    
    public function getCarro($email) {
        $stmt = $this->pdo->prepare("select c.id_carro from $this->table c, usuario u where (correo = '$email') and (u.id_usuario = c.id_usuario)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


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
    
    }