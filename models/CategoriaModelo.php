<?php
require_once "config/conexion.php";

class CategoriaModelo {

    public function obtenerTodas() {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM ticket_categorias");
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM ticket_categorias WHERE id=$id")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];

        $sql = "INSERT INTO ticket_categorias (nombre) VALUES ('$nombre')";
        return $db->query($sql);
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];

        $sql = "UPDATE ticket_categorias SET nombre='$nombre' WHERE id=$id";
        return $db->query($sql);
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        return $db->query("DELETE FROM ticket_categorias WHERE id=$id");
    }
}