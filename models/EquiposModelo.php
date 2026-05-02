<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class EquiposModelo {

    public function obtenerActivos() {
        $db = Conexion::conectar();
        $t = db_tbl('equipos');
        return $db->query("SELECT * FROM `$t` WHERE activo = 1 ORDER BY nombre");
    }
}
