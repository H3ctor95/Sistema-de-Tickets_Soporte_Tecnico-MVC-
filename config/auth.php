<?php

function verificarRol($rol) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }

    if ($_SESSION['usuario']->rol_id != $rol) {
        echo "Acceso denegado";
        exit;
    }
}