<?php
require_once "config/conexion.php";

class EstadoModelo {

    public function obtenerTodos() {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM ticket_estados");
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM ticket_estados WHERE id=$id")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];

        $sql = "INSERT INTO ticket_estados (nombre) VALUES ('$nombre')";
        return $db->query($sql);
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];

        $sql = "UPDATE ticket_estados SET nombre='$nombre' WHERE id=$id";
        return $db->query($sql);
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        return $db->query("DELETE FROM ticket_estados WHERE id=$id");
    }
}