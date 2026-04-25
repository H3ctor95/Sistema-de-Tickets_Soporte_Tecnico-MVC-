<?php
require_once "config/conexion.php";

class EstadoModelo {

    public function obtenerTodos() {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM ticket_estados WHERE estado = 1");
    }
}