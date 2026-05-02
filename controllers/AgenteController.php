<?php
require_once "models/AgenteModelo.php";
require_once "config/auth.php";

class AgenteController {

    public function index() {

        if ($_SESSION['usuario']->rol_id != 1) {
            echo "Solo admin puede ver agentes";
            exit;
        }
    
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
    
        if (!in_array($_SESSION['usuario']->rol_id, [1, 3])) {
            echo "Acceso denegado";
            exit;
        }
    }

    public function tomar() {
        $modelo = new AgenteModelo();
    
        $ticket_id = $_GET['id'];
        $agente_id = $_SESSION['usuario']->id;
    
        $modelo->tomarTicket($ticket_id, $agente_id);
    
        header("Location: index.php?controller=agente&action=seguimiento&id=$ticket_id");
    }

    public function seguimiento() {

        $ticketModelo = new TicketModelo();
        $comentarioModelo = new ComentarioModelo();
    
        $ticket = $ticketModelo->obtenerPorId($_GET['id']);
        $comentarios = $comentarioModelo->obtenerPorTicket($_GET['id']);
    
        require "views/agentes/seguimiento.php";
    }

    public function actualizarEstado() {

        $ticket_id = $_POST['ticket_id'];
        $estado_id = $_POST['estado_id'];
        $comentario = $_POST['comentario'];
    
        $db = Conexion::conectar();
    
        // actualizar estado
        $db->query("UPDATE tickets SET estado_id=$estado_id WHERE id=$ticket_id");
    
        // guardar comentario
        $db->query("INSERT INTO comentarios (ticket_id, texto) 
                    VALUES ($ticket_id, '$comentario')");
    
        header("Location: index.php?controller=agente&action=seguimiento&id=$ticket_id");
    }

}