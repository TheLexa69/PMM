<?php

 class funciones{
     


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



public function texto($texto) {
    /*
     * Función que compruebe que la cadena recibida sólo acepta letras, incluyendo tildes
     */
    $pattern = '/[a-zA-ZáéíóúÁÉÍÓÚñÑ]$/';
    return preg_match($pattern, $texto);
}

public function correo($mail) {

    return filter_var($mail, FILTER_SANITIZE_EMAIL);
}



public function hora() {
    $a = getdate(time());
    return $a["hours"] . ":" . $a["minutes"] . ":" . $a["seconds"];
}

public function fechaActual() {
    return $fecha_actual = date("Y-m-d ");
}

     /*
function contrasenas($pass, $pass2) {

    if ($pass == $pass2) {
        return true;
    } else {
        return false;
    }
}*/

   /*
  function cookis($var1, $var2 = " ", $var3 = " ") {

  if (empty($var3)) {
  $cook1 = setcookie($var1, $var2);
  } else {
  $cook1 = setcookie($var1, $var2, time() + $var3);

  }

  if ($cook1) {
  echo "cookie creada<br>";
  }
  }
 */  
     
 }
