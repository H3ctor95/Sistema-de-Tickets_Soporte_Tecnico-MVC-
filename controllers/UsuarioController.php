<?php
require_once "models/UsuarioModelo.php";
require_once "config/auth.php";

class UsuarioController {

    public function __construct() {
        verificarRol(1);
    }

    public function index() {
        $modelo = new UsuarioModelo();
        $usuarios = $modelo->obtenerTodos();

        require "views/usuarios/index.php";
    }

    public function crear() {

        if ($_POST) {
            $modelo = new UsuarioModelo();
            $modelo->crear($_POST);

            header("Location: index.php?controller=usuario&action=index");
            exit;
        }

        require "views/usuarios/crear.php";
    }

    public function editar() {
        $modelo = new UsuarioModelo();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($_POST) {
            $modelo->actualizar($id, $_POST);
            header("Location: index.php?controller=usuario&action=index");
            exit;
        }

        $usuario = $modelo->obtenerPorId($id);
        require "views/usuarios/editar.php";
    }

    public function eliminar() {
        $modelo = new UsuarioModelo();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo->eliminar($id);

        header("Location: index.php?controller=usuario&action=index");
        exit;
    }
}
