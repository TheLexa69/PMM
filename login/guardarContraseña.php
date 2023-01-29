<?php
require_once "../conexion/conexion.php";
include "funciones_login.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["mail"])) {
        $mail = $_POST["mail"];
    }



    if ($_POST["pass"] == $_POST["pass2"]) {
        $contranueva = $_POST["pass"];
        $contra = password_hash($contranueva, PASSWORD_DEFAULT);

        try {
            $conexion = conexion();

            $sql = "select * from usuario where correo=?";

            $stmt = $conexion->prepare($sql);

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
            $rol = $datos["rol"];

            $sql1 = "UPDATE usuario SET nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, correo=:correo, "
                    . "fecha=:fecha,num_telef=:num_telef, rol=:rol, contraseña=:contrasena where id_usuario = :id";
 
            $stmt = $conexion->prepare($sql1);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 25);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR, 25);
            $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR, 25);
            $stmt->bindParam(':correo', $mail, PDO::PARAM_STR, 50);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':num_telef', $telef, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contra, PDO::PARAM_STR); //nueva contraseña de usuario hash


            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                unset($conexion);
                unset($stmt);
                 header("Location: login.php");
            }   

            unset($conexion);
            unset($stmt);
        } catch (PDOException $e) {
            echo 'Accion no realizada porque:<br>';
            die("ERROR: " . $e->getMessage() . "<br>" . $e->getCode());
        }
    } else {
        ?>
        <html lang="ES">
            <head>
            </head>

            <body>
                <div  >
                    <form   action="guardarContraseña.php" method="POST">
                        <h1>Tienen que ser iguales</h1>   
                        <label for="c2" class="form-label">Escriba su contraseña:</label><br>
                        <label for="c3" class="form-label">Contraseña:</label><br>
                        <input type="password" name="pass" class="form-control" id="c3"  ><br>
                        <label for="c4" class="form-label">Repite contraseña:</label><br>
                        <input type="password" name="pass2" class="form-control" id="c4"><br><br>

                        <input type="hidden" name="mail" value="<?php if(!empty($mail)){echo $mail;}?>">

                        <input type="submit" name="contraMail" value="PULSAR PARA VERIFICAR"></input>
                    </form> 
                </div>
            </body>
        </html>
        <?php
    }
}
