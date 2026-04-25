<?php
require_once "config/conexion.php";

class TicketModelo {

    public function obtenerTodos() {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM tickets");
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM tickets WHERE id = $id")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();

        $titulo = $datos['titulo'];
        $descripcion = $datos['descripcion'];

        $sql = "INSERT INTO tickets (titulo, descripcion, estado_id) 
                VALUES ('$titulo', '$descripcion', 1)";

        return $db->query($sql);
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();

        $titulo = $datos['titulo'];
        $descripcion = $datos['descripcion'];

        $sql = "UPDATE tickets 
                SET titulo='$titulo', descripcion='$descripcion' 
                WHERE id=$id";

        return $db->query($sql);
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        return $db->query("DELETE FROM tickets WHERE id=$id");
    }
}