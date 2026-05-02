<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class ComentarioModelo {

    public function obtenerPorTicket($tiket_id) {
        $db = Conexion::conectar();
        $tiket_id = (int) $tiket_id;
        $tc = db_tbl('comentarios');
        $tu = db_tbl('usuarios');

        $sql = "SELECT c.*, u.nombre AS autor_nombre
                FROM `$tc` c
                INNER JOIN `$tu` u ON c.usuario_id = u.id
                WHERE c.tiket_id = $tiket_id AND c.activo = 1 AND u.activo = 1
                ORDER BY c.id ASC";

        return $db->query($sql);
    }

    public function crear($tiket_id, $usuario_id, $texto) {
        $db = Conexion::conectar();
        $tiket_id = (int) $tiket_id;
        $usuario_id = (int) $usuario_id;
        $tc = db_tbl('comentarios');

        $stmt = $db->prepare(
            "INSERT INTO `$tc` (tiket_id, usuario_id, texto, activo) VALUES (?, ?, ?, 1)"
        );
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("iis", $tiket_id, $usuario_id, $texto);
        return $stmt->execute();
    }

    /**
     * Baja lógica del comentario (no DELETE físico).
     */
    public function desactivar($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $tc = db_tbl('comentarios');
        return $db->query("UPDATE `$tc` SET activo = 0 WHERE id=$id");
    }
}
