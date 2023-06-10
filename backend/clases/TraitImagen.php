<?php

 namespace clases;

use \RuntimeException;

trait TraitImagen {
    /**
     * Método para añadir la imagen a los productos.
     * @param $id
     * @param $imagen
     * @return string
     * @throws RuntimeException
     */
    public function anadirImagenProductos($id, $imagen) {
        try {
            $_FILES['imagen'] = $imagen;
                    
            if (!isset($_FILES['imagen'])) {
                throw new RuntimeException('Se produjo un error en el envío del fichero.');
            }
            $archivos = $_FILES['imagen'];
         
            foreach ($archivos['name'] as $indice => $archivo) {
                // Comprobamos el código de produce, si es OK se procesa el archivo
                switch ($archivos['error'][$indice]) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No se ha enviado ningún archivo.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('El tamaño del archivo excede el permitido.');
                    default:
                        throw new RuntimeException('Error desconocido.');
                }
                // Comprobamos el tamaño del archivo
                if ($archivos['size'][$indice] > 5000000) {
                    throw new RuntimeException('El tamaño del archivo excede el permitido.');
                }
                // Comprobamos el tipo MIME del archivo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $extensiones = array('jpg' => 'image/jpeg', 'png' => 'image/png');
                $ext = array_search(finfo_file($finfo, $archivos['tmp_name'][$indice]), $extensiones);
                // Importante cerrar el recurso
                finfo_close($finfo);
                // Comprobamos la extensión del archivo, si no es correcta se lanza una excepción
                if ($ext === false) {
                    throw new RuntimeException('El archivo no es un PDF o una imagen.');
                }
                // Comprobamos si existe el directorio, si no existe se crea
                $nombreArchivo = $id;
                //$nombreArchivo1 = $archivos['name'][$indice];
                // Se mueve el archivo a la carpeta cvs
                //$resultado = move_uploaded_file($archivos['tmp_name'][$indice], './cvs/' . $idUnico . '.' . $ext);
                $resultado = move_uploaded_file($archivos['tmp_name'][$indice], '../imagenes/imgProductos/' . $nombreArchivo . '.' . $ext);
                $ruta = $nombreArchivo . '.' . $ext;
                //echo "Se ha subido el archivo $nombreArchivo correctamente<br>";
                return $ruta;
            }
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }
}
