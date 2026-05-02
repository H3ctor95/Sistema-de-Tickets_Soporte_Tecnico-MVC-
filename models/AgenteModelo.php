<?php
require_once "config/conexion.php";

class AgenteModelo {

    public function obtenerTodos() {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM agentes");
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM agentes WHERE id = $id")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];
        $email = $datos['email'];

        $sql = "INSERT INTO agentes (nombre, email) 
                VALUES ('$nombre', '$email')";

        return $db->query($sql);
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];
        $email = $datos['email'];

        $sql = "UPDATE agentes 
                SET nombre='$nombre', email='$email' 
                WHERE id=$id";

        return $db->query($sql);
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        return $db->query("DELETE FROM agentes WHERE id=$id");
    }

    public function ticketsDisponibles(){
        $db = Conexion::conectar();
        
        return $db->query("SELECT * FROM tickets WHERE asignado = 0 ORDER BY prioridad_id DESC");
    }
    
    public function tomarTicket($ticket_id, $agente_id) {
        $db = Conexion::conectar();
    
        $sql = "UPDATE tickets 
                SET asignado = 1, agente_id = $agente_id, estado_id = 2 
                WHERE id = $ticket_id";
    
        return $db->query($sql);
    }
}