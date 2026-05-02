<?php
require_once "models/AgenteModelo.php";
require_once "models/TicketModelo.php";
require_once "models/ComentarioModelo.php";
require_once "models/EstadoModelo.php";
require_once "config/auth.php";

class AgenteController {

    public function __construct() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        if (!in_array((int) $_SESSION['usuario']->rol_id, [1, 2], true)) {
            echo "Acceso denegado";
            exit;
        }

        if ((int) $_SESSION['usuario']->rol_id === 2
            && (empty($_SESSION['agente_id']) || (int) $_SESSION['agente_id'] < 1)) {
            require "views/errors/sin_ficha_agente.php";
            exit;
        }
    }

    public function index() {

        if ((int) $_SESSION['usuario']->rol_id !== 1) {
            echo "Solo admin puede ver agentes";
            exit;
        }

        $modelo = new AgenteModelo();
        $agentes = $modelo->obtenerTodos();

        require "views/agentes/index.php";
    }

    public function crear() {

        if ((int) $_SESSION['usuario']->rol_id !== 1) {
            echo "Solo admin puede crear agentes";
            exit;
        }

        if ($_POST) {
            $modelo = new AgenteModelo();
            $modelo->crear($_POST);

            header("Location: index.php?controller=agente&action=index");
            exit;
        }

        require "views/agentes/crear.php";
    }

    public function editar() {

        if ((int) $_SESSION['usuario']->rol_id !== 1) {
            echo "Solo admin puede editar agentes";
            exit;
        }

        $modelo = new AgenteModelo();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($_POST) {
            $modelo->actualizar($id, $_POST);
            header("Location: index.php?controller=agente&action=index");
            exit;
        }

        $agente = $modelo->obtenerPorId($id);
        if (!$agente) {
            header("Location: index.php?controller=agente&action=index");
            exit;
        }
        require "views/agentes/editar.php";
    }

    public function eliminar() {

        if ((int) $_SESSION['usuario']->rol_id !== 1) {
            echo "Solo admin puede eliminar agentes";
            exit;
        }

        $modelo = new AgenteModelo();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $modelo->eliminar($id);

        header("Location: index.php?controller=agente&action=index");
        exit;
    }

    public function tickets() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes pueden ver tickets";
            exit;
        }

        $modelo = new AgenteModelo();
        $tickets = $modelo->ticketsDisponibles();

        require "views/agentes/tickets.php";
    }

    public function asignados() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes";
            exit;
        }

        $modelo = new AgenteModelo();
        $tickets = $modelo->ticketsAsignadosAlAgente((int) $_SESSION['agente_id']);

        require "views/agentes/asignados.php";
    }

    public function finalizados() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes";
            exit;
        }

        $modelo = new AgenteModelo();
        $tickets = $modelo->ticketsFinalizados((int) $_SESSION['agente_id']);

        require "views/agentes/finalizados.php";
    }

    public function verTicket() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes";
            exit;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $ticketModelo = new TicketModelo();
        $ticket = $ticketModelo->obtenerPorIdCompleto($id);

        if (!$ticket || !$ticketModelo->esTiketLibreParaTomar($id)) {
            echo "Este tiket no está disponible o ya fue tomado.";
            exit;
        }

        require "views/agentes/ver_ticket.php";
    }

    public function tomar() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes pueden tomar tickets";
            exit;
        }

        $modelo = new AgenteModelo();

        $ticket_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $agente_id = (int) $_SESSION['agente_id'];

        $ok = $modelo->tomarTicket($ticket_id, $agente_id);

        if (!$ok) {
            header("Location: index.php?controller=agente&action=tickets&msg=ocupado");
            exit;
        }

        header("Location: index.php?controller=agente&action=seguimiento&id=$ticket_id");
        exit;
    }

    public function seguimiento() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes pueden dar seguimiento";
            exit;
        }

        $ticketModelo = new TicketModelo();
        $agenteModelo = new AgenteModelo();
        $comentarioModelo = new ComentarioModelo();
        $estadoModelo = new EstadoModelo();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $aid = (int) $_SESSION['agente_id'];

        $ticket = $ticketModelo->obtenerPorIdCompleto($id);
        if (!$ticket || !$agenteModelo->tieneAsignacionActiva($id, $aid)) {
            echo "Ticket no asignado a usted.";
            exit;
        }

        $comentarios = $comentarioModelo->obtenerPorTicket($id);
        $estados = $estadoModelo->obtenerParaSeguimientoAgente();

        require "views/agentes/seguimiento.php";
    }

    public function actualizarEstado() {

        if ((int) $_SESSION['usuario']->rol_id !== 2) {
            echo "Solo agentes pueden actualizar";
            exit;
        }

        $ticket_id = isset($_POST['ticket_id']) ? (int) $_POST['ticket_id'] : 0;
        $estado_id = isset($_POST['estado_id']) ? (int) $_POST['estado_id'] : 0;
        $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';

        $ticketModelo = new TicketModelo();
        $agenteModelo = new AgenteModelo();
        $aid = (int) $_SESSION['agente_id'];

        $ticket = $ticketModelo->obtenerPorIdCompleto($ticket_id);
        if (!$ticket || !$agenteModelo->tieneAsignacionActiva($ticket_id, $aid)) {
            echo "Acceso denegado";
            exit;
        }

        if (!in_array($estado_id, [2, 3], true)) {
            echo "Estado no válido";
            exit;
        }

        if ($comentario === '') {
            header("Location: index.php?controller=agente&action=seguimiento&id=$ticket_id&msg=comentario");
            exit;
        }

        $ticketModelo->actualizarEstadoPorId($ticket_id, $estado_id);

        $cm = new ComentarioModelo();
        $cm->crear($ticket_id, $_SESSION['usuario']->id, $comentario);

        header("Location: index.php?controller=agente&action=seguimiento&id=$ticket_id");
        exit;
    }
}
