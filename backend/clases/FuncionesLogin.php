<?php

namespace clases;

class FuncionesLogin {

    /**
     * Método que comprueba que los campos pasdos existan en los dos array
     * @param array $campos. Campos que fueron cubiertos
     * @param $requeridos. Campos que son obligatorios
     * @return boolean $respuesta. En caso de que esten todos devuelve true  en caso contrario devuelve un string en formato del array dado
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
     * Método que comprueba si el email cumple con el formato email y lo devuelve saneado.
     * @param string $mail
     * @return string $mail. La dirección de correo electrónico filtrada y saneada.
     */
    public function correo($mail) {
        return filter_var($mail, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Método para coger la hora separada por horas, :, minutos, :, segundos
     * @return $a. Ya separado y con formato.
     */
    public function hora() {
        $a = getdate(time());
        return $a["hours"] . ":" . $a["minutes"] . ":" . $a["seconds"];
    }

    /**
     * Método para coger la Fecha actual 
     * @return date.
     */
    public function fechaActual() {
        return date("Y-m-d ");
    }

    /**
     * Método para coger la Fecha actual hora minutos y segundos 
     * @return date.
     */
    public function fechaHoraActual() {
        return date("Y-m-d H:i:s", time());
    }

}
