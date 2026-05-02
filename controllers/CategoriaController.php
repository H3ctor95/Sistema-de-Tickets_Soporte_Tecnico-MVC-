<?php
require_once "models/CategoriaModelo.php";
require_once "config/auth.php";

class CategoriaController {

    public function __construct() {
        verificarRol(1);
    }

    public function index() {
        $modelo = new CategoriaModelo();
        $categorias = $modelo->obtenerTodas();

        require "views/categorias/index.php";
    }

    public function crear() {

        if ($_POST) {
            $modelo = new CategoriaModelo();
            $modelo->crear($_POST);

            header("Location: index.php?controller=categoria&action=index");
        }

        require "views/categorias/crear.php";
    }

    public function editar() {
        $modelo = new CategoriaModelo();

        if ($_POST) {
            $modelo->actualizar($_GET['id'], $_POST);
            header("Location: index.php?controller=categoria&action=index");
        }

        $categoria = $modelo->obtenerPorId($_GET['id']);
        require "views/categorias/editar.php";
    }

    public function eliminar() {
        $modelo = new CategoriaModelo();
        $modelo->eliminar($_GET['id']);

        header("Location: index.php?controller=categoria&action=index");
    }
}