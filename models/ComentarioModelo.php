<?php
require_once "config/conexion.php";

class ComentarioModelo {

    public function obtenerPorTicket($ticket_id) {
        $db = Conexion::conectar();

        $sql = "SELECT c.*, a.nombre AS agente_nombre
                FROM comentarios c
                LEFT JOIN agentes a ON c.agente_id = a.id
                WHERE c.ticket_id = $ticket_id";

        return $db->query($sql);
    }

    public function crear($datos) {
        $db = Conexion::conectar();

        $ticket_id = $datos['ticket_id'];
        $texto = $datos['texto'];

        // por ahora dejamos agente_id en NULL o fijo
        $sql = "INSERT INTO comentarios (ticket_id, texto) 
                VALUES ($ticket_id, '$texto')";

        return $db->query($sql);
    }
}