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
        $categoria_id = $datos['categoria_id'];
        $estado =$datos['estado_id'];

        $sql = "INSERT INTO tickets (titulo, descripcion, categoria_id, estado_id) 
                VALUES ('$titulo', '$descripcion', '$categoria_id', '$estado')";

        return $db->query($sql);
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();

        $titulo = $datos['titulo'];
        $descripcion = $datos['descripcion'];
        $categoria_id = $datos['categoria_id'];
        $estado =$datos['estado_id'];

        $sql = "UPDATE tickets 
        SET titulo='$titulo', 
            descripcion='$descripcion',
            categoria_id=$categoria,
            estado_id=$estado
        WHERE id=$id";

        return $db->query($sql);
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        return $db->query("DELETE FROM tickets WHERE id=$id");
    }
}