<?php

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

function comprobar_sesionAdministrador() {

    session_start();
    if (!isset($_SESSION['administrador'])) {
        header("Location:/proyecto/backend/login/indexLogin.php");
    } else {
        return true;
    }
}

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

function comprobar_sesiones() {

    session_start();
    if (isset($_SESSION['usuario']) || isset($_SESSION['administrador'])) {
        header("Location:/proyecto/index.php");
    } else {
        return true;
    }
}

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
