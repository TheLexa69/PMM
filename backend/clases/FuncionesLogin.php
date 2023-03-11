<?php

namespace clases;

class FuncionesLogin {
/**
 * Metodo que comprueba que los campos pasdos existan en los dos array
 * @param array $campos      Campos que fueron cubiertos
 * @param type $requeridos   Campos que son obligatorios
 * @return boolean   en caso de que esten todos devuelve true  en caso contrario devuelve un string en formato del array dado
 */
    public function campos(array $campos, $requeridos) {
        $noCubiertos = [];
        foreach ($campos as $campo) {
            if (empty($requeridos[$campo])) {
                $noCubiertos[] = $campo;
            }
        }
        if (sizeof($noCubiertos) > 0) {
            $respuesta = implode(', ', $noCubiertos);
        } else {
            $respuesta = true;
        }
        return $respuesta;
    }
/**
 * Metodo que comprueba si el mail cumple con el formato mail y lo devuelve saneado
 * @param type $mail
 * @return type
 */
    public function correo($mail) {

        return filter_var($mail, FILTER_SANITIZE_EMAIL);
    }
/**
 * Metodo para coger la hora separada por 
 * @return type
 */
    public function hora() {
        $a = getdate(time());
        return $a["hours"] . ":" . $a["minutes"] . ":" . $a["seconds"];
    }
/**
 * Metodo para coger la Fecha actual 
 * @return type
 */
    public function fechaActual() {
        return date("Y-m-d ");
    }
/**
 * Metodo para coger la Fecha actual hora minutos y segundos 
 * @return type
 */
    public function fechaHoraActual() {
        return date("Y-m-d H:i:s", time());
    }
 
}
