<?php

define('DS', DIRECTORY_SEPARATOR);

/**
 * Función que se encarga de cargar automáticamente las clases del proyecto.
 * @param string $clase Nombre de la clase a cargar.
 * @return void.
 */
function autoloadClases($clase) {
    //   echo $fichero = __DIR__ . DS."backend".DS.str_replace('/','\\', DS, $clase). '.php';
     $fichero = __DIR__ . DS . "backend" . DS . str_replace('\\', DS, $clase) . '.php';
 
    if (file_exists($fichero)) {
        include $fichero;
    } else {
        include __DIR__ . DS . "backend" . DS . "clases" . DS . str_replace('\\', DS, $clase) . '.php';
    }
}

spl_autoload_register("autoloadClases");
/*
define('DS',DIRECTORY_SEPARATOR);

function autoloadClases($clase) {
 //   echo $fichero = __DIR__ . DS."backend".DS.str_replace('/','\\', DS, $clase). '.php';
 echo  $fichero = __DIR__ . DS."backend".DS.str_replace('\\', DS, $clase). '.php';
     echo "<br>";
    if (file_exists($fichero)){
        include $fichero;
    }else{
        echo "<br><br>";
     echo $A= __DIR__ . DS."backend".DS."clases".DS.str_replace('\\', DS, $clase). '.php';
         include  __DIR__ . DS."backend".DS."clases".DS.str_replace('\\', DS, $clase). '.php';
}

    }
//autoloadClases("consultas");
spl_autoload_register("autoloadClases");
*/