<?php
require_once "config/conexion.php";

class CategoriaModelo {

    public function obtenerTodas() {
        $db = Conexion::conectar();
        return $db->query("SELECT * FROM ticket_categorias WHERE estado = 1");
    }
}