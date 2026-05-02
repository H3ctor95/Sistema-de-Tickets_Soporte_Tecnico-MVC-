<?php
require_once "models/AgenteModelo.php";
require_once "config/auth.php";

class AgenteController {

    public function index() {
        $modelo = new AgenteModelo();
        $agentes = $modelo->obtenerTodos();

        require "views/agentes/index.php";
    }

    public function crear() {

        if ($_POST) {
            $modelo = new AgenteModelo();
            $modelo->crear($_POST);

            header("Location: index.php?controller=agente&action=index");
        }

        require "views/agentes/crear.php";
    }

    public function editar() {
        $modelo = new AgenteModelo();

        if ($_POST) {
            $modelo->actualizar($_GET['id'], $_POST);
            header("Location: index.php?controller=agente&action=index");
        }

        $agente = $modelo->obtenerPorId($_GET['id']);
        require "views/agentes/editar.php";
    }

    public function eliminar() {
        $modelo = new AgenteModelo();
        $modelo->eliminar($_GET['id']);

        header("Location: index.php?controller=agente&action=index");
    }

    public function __construct() {
        session_start();
    
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }
    
        if ($_SESSION['usuario']->rol_id != 3) {
            echo "Acceso solo para agentes";
            exit;
        }
    }

}