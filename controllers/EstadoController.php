<?php
require_once "models/EstadoModelo.php";
require_once "config/auth.php";

class EstadoController {

    public function __construct() {
        verificarRol(1);
    }

    public function index() {
        $modelo = new EstadoModelo();
        $estados = $modelo->obtenerTodos();

        require "views/estados/index.php";
    }

    public function crear() {

        if ($_POST) {
            $modelo = new EstadoModelo();
            $modelo->crear($_POST);

            header("Location: index.php?controller=estado&action=index");
        }

        require "views/estados/crear.php";
    }

    public function editar() {
        $modelo = new EstadoModelo();

        if ($_POST) {
            $modelo->actualizar($_GET['id'], $_POST);
            header("Location: index.php?controller=estado&action=index");
        }

        $estado = $modelo->obtenerPorId($_GET['id']);
        require "views/estados/editar.php";
    }

    public function eliminar() {
        $modelo = new EstadoModelo();
        $modelo->eliminar($_GET['id']);

        header("Location: index.php?controller=estado&action=index");
    }
}