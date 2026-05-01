<?php
require_once "models/ComentarioModelo.php";

class ComentarioController {

    public function guardar() {

        if ($_POST) {
            $modelo = new ComentarioModelo();
            $modelo->crear($_POST);

            header("Location: index.php?controller=ticket&action=ver&id=" . $_POST['ticket_id']);
        }
    }
}