<?php
require_once "models/ComentarioModelo.php";
require_once "models/TicketModelo.php";
require_once "config/auth.php";

class ComentarioController {

    public function guardar() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        if ($_POST) {
            $ticket_id = isset($_POST['ticket_id']) ? (int) $_POST['ticket_id'] : 0;
            $texto = isset($_POST['texto']) ? trim($_POST['texto']) : '';

            $ticketModelo = new TicketModelo();
            $ticket = $ticketModelo->obtenerPorId($ticket_id);

            if (!$ticket || !usuario_puede_ver_ticket($ticket)) {
                echo "Acceso denegado";
                exit;
            }

            if ($texto === '') {
                header("Location: index.php?controller=ticket&action=ver&id=$ticket_id");
                exit;
            }

            $modelo = new ComentarioModelo();
            $modelo->crear($ticket_id, $_SESSION['usuario']->id, $texto);

            header("Location: index.php?controller=ticket&action=ver&id=$ticket_id");
            exit;
        }

        header("Location: index.php?controller=ticket&action=index");
        exit;
    }
}
