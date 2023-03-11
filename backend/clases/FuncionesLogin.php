<?php

namespace clases;

class FuncionesLogin {

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

    public function correo($mail) {

        return filter_var($mail, FILTER_SANITIZE_EMAIL);
    }

    public function hora() {
        $a = getdate(time());
        return $a["hours"] . ":" . $a["minutes"] . ":" . $a["seconds"];
    }

    public function fechaActual() {
        return date("Y-m-d ");
    }

    public function fechaHoraActual() {
        return date("Y-m-d H:i:s", time());
    }
 
}
