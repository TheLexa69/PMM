<?php

/**
  Función que comprueba que sólo pueden acceder a la aplicación los usuarios que hayan hecho login.
  @return bool Devuelve true si el usuario ha iniciado sesión correctamente, o redirige al formulario de login si no.
 */
function comprobar_sesion() {
    /*
     * Para comprobar que sólo pueden acceder a la aplicación los usuarios que hayan hecho login.
     * Se une a la sesión existente y comprueba que la variable $_SESSION['usuario'] exista.
     * Si no es así, indica que el usuario no ha hecho login correctamente y por tanto
     * lo redirige al formulario del login
     */
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location:/proyecto/backend/login/indexLogin.php");
    } else {
        return true;
    }
}

/**
 * Función que comprueba que hayan iniciado sesión como administrador.
 * @return bool Devuelve true si el administrador ha iniciado sesión correctamente, 
 * o redirige al formulario de login si no.
 */
function comprobar_sesionAdministrador() {
    session_start();
    if (!isset($_SESSION['administrador'])) {
        header("Location:/proyecto/backend/login/indexLogin.php");
    } else {
        return true;
    }
}

/**
 *
 * Función que comprueba que el administrador ha iniciado sesión correctamente y que tiene el tipo de sesión adecuado.
 * @return bool Devuelve true si el administrador ha iniciado sesión correctamente y tiene el tipo de sesión adecuado, 
 * o redirige a la página de inicio de sesión si no.
 */
function sesionAdministrador() {
    session_start();
    if (!isset($_SESSION['administrador'])) {
        header("Location:/proyecto/backend/login/indexLogin.php");
    } else if ($_SESSION['administrador'][1] == 1) {
        return true;
    } else {
        header("Location:/proyecto/backend/administrador/indexAdministrador.php");
        return true;
    }
}

/**
  Función que comprueba que no haya sesiones iniciadas, para evitar que los usuarios inicien varias sesiones a la vez.
  @return bool Devuelve true si no hay sesiones iniciadas, o redirige a la página de inicio de la aplicación si hay alguna.
 */
function comprobar_sesiones() {
    session_start();
    if (isset($_SESSION['usuario']) || isset($_SESSION['administrador'])) {
        header("Location:/proyecto/index.php");
    } else {
        return true;
    }
}

/**
  Función que devuelve el tipo de sesión del administrador que ha iniciado sesión correctamente.
  @return int Devuelve el tipo de sesión del administrador (1, 2, 3 o 4), o redirige a la página de inicio de sesión si no ha iniciado sesión.
 */
function tipoDeSesionAdministrador() {
    session_start();
    if (!isset($_SESSION['administrador'])) {
        header("Location:/proyecto/backend/login/indexLogin.php");
    } else if ($_SESSION['administrador'][1] == 1) {
        return 1;
    } else if ($_SESSION['administrador'][1] == 2) {
        return 2;
    } else if ($_SESSION['administrador'][1] == 3) {
        return 3;
    } else {
        return 4;
    }
}
