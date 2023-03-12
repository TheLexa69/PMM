<?php

/**
 * Lee el archivo de configuración de la base de datos y devuelve los datos de conexión.
 * @param string $fichero_config_BBDD Ruta del archivo de configuración de la base de datos.
 * @param string $esquema Ruta del archivo XSD para validar la estructura del archivo de configuración.
 * @return array Un array con tres valores: cadena de conexión, nombre de usuario y clave.
 * @throws InvalidArgumentException Si el archivo de configuración no existe o no es válido.
 */
function leer_config($fichero_config_BBDD, $esquema) {
    /*
      $fichero_config_BBDD es la ruta del fichero con los datos de conexión a la BBDD
      $esquema es la ruta del fichero XSD para validar la estructura del fichero anterior
      Si el fichero de configuración existe y es válido, devuelve un array con tres
      valores: la cadena de conexión, el nombre de usuario y la clave.
      Si no encuentra el fichero o no es válido, lanza una excepción.
     */

    $config = new DOMDocument();
    $config->load($fichero_config_BBDD);
    $res = $config->schemaValidate($esquema);
    if ($res === FALSE) {
        throw new InvalidArgumentException("Revise el fichero de configuración");
    }
    $datos = simplexml_load_file($fichero_config_BBDD);
    $ip = $datos->xpath("//host");
    $nombre = $datos->xpath("//bd");
    $usu = $datos->xpath("//usuario");
    $clave = $datos->xpath("//clave");
    $cad = sprintf("mysql:dbname=%s;host=%s", $nombre[0], $ip[0]);
    $resul = [];
    $resul[] = $cad;
    $resul[] = $usu[0];
    $resul[] = $clave[0];
    return $resul;
}
