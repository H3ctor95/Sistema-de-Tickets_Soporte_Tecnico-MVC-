<?php
require_once "models/TicketModelo.php";
require_once "models/CategoriaModelo.php";
require_once "models/EstadoModelo.php";
require_once "models/PrioridadModelo.php";
require_once "models/ComentarioModelo.php";
require_once "config/auth.php";

class TicketController {

    public function __construct() {
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }
        if ((int) $_SESSION['usuario']->rol_id === 2) {
            header("Location: index.php?controller=agente&action=tickets");
            exit;
        }
    }

    public function index() {
        verificarAlgunRol([1, 3]);

        $modelo = new TicketModelo();
        if ((int) $_SESSION['usuario']->rol_id === 3) {
            $tickets = $modelo->obtenerPorUsuario($_SESSION['usuario']->id);
        } else {
            $tickets = $modelo->obtenerTodos();
        }

        require "views/tickets/index.php";
    }

    public function crear() {
        verificarAlgunRol([1, 3]);

        $catmodelo = new CategoriaModelo();
        $prioridadModelo = new PrioridadModelo();

        $categorias = $catmodelo->obtenerTodas();
        $prioridades = $prioridadModelo->obtenerTodas();

        if ($_POST) {
            $modelo = new TicketModelo();
            $modelo->crear($_POST, $_SESSION['usuario']->id);

            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        require "views/tickets/crear.php";
    }

    public function editar() {
        verificarAlgunRol([1, 3]);

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo = new TicketModelo();

        $ticket = $modelo->obtenerPorIdCompleto($id);
        if (!$ticket || !usuario_puede_ver_ticket($ticket)) {
            echo "Acceso denegado";
            exit;
        }
        if ((int) $_SESSION['usuario']->rol_id === 3
            && (int) $ticket->registrado_por_usuario_id !== (int) $_SESSION['usuario']->id) {
            echo "Acceso denegado";
            exit;
        }

        $catModelo = new CategoriaModelo();
        $estModelo = new EstadoModelo();

        $categorias = $catModelo->obtenerTodas();
        $estados = $estModelo->obtenerTodos();

        if ($_POST) {
            $modelo->actualizar($id, $_POST);
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        require "views/tickets/editar.php";
    }

    public function eliminar() {
        verificarAlgunRol([1, 3]);

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo = new TicketModelo();
        $ticket = $modelo->obtenerPorId($id);

        if (!$ticket) {
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }
        if ((int) $_SESSION['usuario']->rol_id === 3
            && (int) $ticket->registrado_por_usuario_id !== (int) $_SESSION['usuario']->id) {
            echo "Acceso denegado";
            exit;
        }

        $modelo->eliminar($id);

        header("Location: index.php?controller=ticket&action=index");
        exit;
    }

    public function ver() {
        verificarAlgunRol([1, 3]);

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo = new TicketModelo();
        $comentarioModelo = new ComentarioModelo();

        $ticket = $modelo->obtenerPorIdCompleto($id);
        if (!$ticket || !usuario_puede_ver_ticket($ticket)) {
            echo "Acceso denegado";
            exit;
        }

        $comentarios = $comentarioModelo->obtenerPorTicket($id);

        require "views/tickets/ver.php";
    }

    public function aprobar() {
        verificarAlgunRol([3]);

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo = new TicketModelo();
        $ticket = $modelo->obtenerPorId($id);

        if (!$ticket
            || (int) $ticket->registrado_por_usuario_id !== (int) $_SESSION['usuario']->id
            || (int) $ticket->estado_id !== 3) {
            echo "No se puede aprobar este ticket.";
            exit;
        }

        $modelo->cerrarYaprobar($id);

        header("Location: index.php?controller=ticket&action=index");
        exit;
    }

    public function rechazar() {
        verificarAlgunRol([3]);

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo = new TicketModelo();
        $ticket = $modelo->obtenerPorId($id);

        if (!$ticket
            || (int) $ticket->registrado_por_usuario_id !== (int) $_SESSION['usuario']->id
            || (int) $ticket->estado_id !== 3) {
            echo "No se puede rechazar este ticket.";
            exit;
        }

        $modelo->rechazarAprobacion($id);

        header("Location: index.php?controller=ticket&action=ver&id=$id");
        exit;
    }
}
