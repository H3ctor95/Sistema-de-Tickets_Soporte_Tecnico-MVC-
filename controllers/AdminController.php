<?php

require_once "config/auth.php";


class AdminController {

    public function __construct() {
        session_start();

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        if ($_SESSION['usuario']->rol_id != 1) {
            echo "Acceso denegado";
            exit;
        }
    }

    public function dashboard() {
        require "views/admin/dashboard.php";
    }
}