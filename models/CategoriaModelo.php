<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class CategoriaModelo {

    public function obtenerTodas() {
        $db = Conexion::conectar();
        $t = db_tbl('categorias');
        return $db->query("SELECT * FROM `$t` WHERE activo = 1 ORDER BY nombre");
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $t = db_tbl('categorias');
        return $db->query("SELECT * FROM `$t` WHERE id=$id AND activo = 1")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();
        $nombre = $datos['nombre'];
        $t = db_tbl('categorias');
        $sql = "INSERT INTO `$t` (nombre, activo) VALUES ('$nombre', 1)";
        return $db->query($sql);
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();
        $nombre = $datos['nombre'];
        $id = (int) $id;
        $t = db_tbl('categorias');
        $sql = "UPDATE `$t` SET nombre='$nombre' WHERE id=$id AND activo = 1";
        return $db->query($sql);
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $t = db_tbl('categorias');
        return $db->query("UPDATE `$t` SET activo = 0 WHERE id=$id");
    }
}
