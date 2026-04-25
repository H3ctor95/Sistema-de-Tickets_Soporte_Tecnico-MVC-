<?php
require_once "models/TicketModelo.php";
require_once "models/CategoriaModelo.php";
require_once "models/EstadoModelo.php";

class TicketController {

    public function index() {
        $modelo = new TicketModelo();
        $tickets = $modelo->obtenerTodos();

        require "views/tickets/index.php";
    }

    public function crear() {

        $catmodelo = new CategoriaModelo();
        $estModelo = new EstadoModelo();

        $categorias = $catmodelo->obtenerTodas();
        $estados = $estModelo->obtenerTodos();

        if ($_POST) {
            $modelo = new TicketModelo();
            $modelo->crear($_POST);

            header("Location: index.php");
        }

        require "views/tickets/crear.php";
    }

    public function editar() {
        $modelo = new TicketModelo();
        
        $catModelo = new CategoriaModelo();
        $estModelo = new EstadoModelo();

        $categorias = $catModelo->obtenerTodas();
        $estados = $estModelo->obtenerTodos();

        if ($_POST) {
            $modelo->actualizar($_GET['id'], $_POST);
            header("Location: index.php");
        }

        $ticket = $modelo->obtenerPorId($_GET['id']);
        require "views/tickets/editar.php";
    }

    public function eliminar() {
        $modelo = new TicketModelo();
        $modelo->eliminar($_GET['id']);

        header("Location: index.php");
    }
}