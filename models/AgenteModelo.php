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
}