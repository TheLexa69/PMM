<?php

namespace clases;

use \RuntimeException;

class FuncionesUsuario {

    /**
     * Método que añade la imagen del usuario.
     * @param type $id
     * @param type $imagen
     * @return string
     * @throws RuntimeException
     */
    public function anadirImagen($id, $imagen) {
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
                    throw new RuntimeException('El archivo no es una imagen Jpg o png.');
                }
                // Comprobamos si existe el directorio, si no existe se crea
                $nombreArchivo = $id;

                $resultado = move_uploaded_file($archivos['tmp_name'][$indice], '../imagenes/imgUsuarios/' . $nombreArchivo . '.' . $ext);
                $ruta = $nombreArchivo . '.' . $ext;
                return $ruta;
            }
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }

}
