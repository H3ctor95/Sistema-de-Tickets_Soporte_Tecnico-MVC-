<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class PrioridadModelo {

    public function obtenerTodas() {
        $db = Conexion::conectar();
        $t = db_tbl('prioridades');
        return $db->query("SELECT * FROM `$t` WHERE activo = 1 ORDER BY orden ASC");
    }
}
