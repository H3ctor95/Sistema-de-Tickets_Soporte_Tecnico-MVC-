<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class AgenteModelo {

    public function obtenerIdPorUsuario($usuario_id) {
        $db = Conexion::conectar();
        $usuario_id = (int) $usuario_id;
        $ta = db_tbl('agentes');
        $r = $db->query("SELECT id FROM `$ta` WHERE usuario_id = $usuario_id AND activo = 1 LIMIT 1");
        if (!$r) {
            return null;
        }
        $o = $r->fetch_object();
        return $o ? (int) $o->id : null;
    }

    public function obtenerTodos() {
        $db = Conexion::conectar();
        $ta = db_tbl('agentes');
        $tu = db_tbl('usuarios');
        $sql = "SELECT a.id, a.nombre, a.email, a.usuario_id
                FROM `$ta` a
                INNER JOIN `$tu` u ON a.usuario_id = u.id
                WHERE a.activo = 1 AND u.activo = 1
                ORDER BY a.nombre";
        return $db->query($sql);
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $ta = db_tbl('agentes');
        return $db->query("SELECT * FROM `$ta` WHERE id = $id AND activo = 1")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();
        $nombre = $datos['nombre'];
        $email = $datos['email'];
        $passPlano = (string) $datos['contrasena'];
        $rol = 2;

        $tu = db_tbl('usuarios');
        $ta = db_tbl('agentes');

        $db->begin_transaction();

        $stmt = $db->prepare(
            "INSERT INTO `$tu` (nombre, email, contrasena, rol_id, activo) VALUES (?, ?, ?, ?, 1)"
        );
        if (!$stmt || !$stmt->bind_param("sssi", $nombre, $email, $passPlano, $rol) || !$stmt->execute()) {
            $db->rollback();
            return false;
        }

        $uid = (int) $db->insert_id;

        $stmt2 = $db->prepare(
            "INSERT INTO `$ta` (usuario_id, nombre, email, activo) VALUES (?, ?, ?, 1)"
        );
        if (!$stmt2 || !$stmt2->bind_param("iss", $uid, $nombre, $email) || !$stmt2->execute()) {
            $db->rollback();
            return false;
        }

        $db->commit();
        return true;
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();
        $id = (int) $id;

        $agente = $this->obtenerPorId($id);
        if (!$agente) {
            return false;
        }

        $nombre = $datos['nombre'];
        $email = $datos['email'];
        $uid = (int) $agente->usuario_id;

        $tu = db_tbl('usuarios');
        $ta = db_tbl('agentes');

        if (!empty($datos['contrasena'])) {
            $passPlano = (string) $datos['contrasena'];
            $stmt = $db->prepare(
                "UPDATE `$tu` SET nombre = ?, email = ?, contrasena = ? WHERE id = ? AND activo = 1"
            );
            if (!$stmt || !$stmt->bind_param("sssi", $nombre, $email, $passPlano, $uid)) {
                return false;
            }
            $stmt->execute();
        } else {
            $stmt = $db->prepare(
                "UPDATE `$tu` SET nombre = ?, email = ? WHERE id = ? AND activo = 1"
            );
            if (!$stmt || !$stmt->bind_param("ssi", $nombre, $email, $uid)) {
                return false;
            }
            $stmt->execute();
        }

        $stmt2 = $db->prepare(
            "UPDATE `$ta` SET nombre = ?, email = ? WHERE id = ? AND activo = 1"
        );
        if (!$stmt2 || !$stmt2->bind_param("ssi", $nombre, $email, $id)) {
            return false;
        }
        return $stmt2->execute();
    }

    /**
     * Baja lógica: agente y usuario dejan de mostrarse / iniciar sesión.
     */
    public function eliminar($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $agente = $this->obtenerPorId($id);
        if (!$agente) {
            return false;
        }

        $uid = (int) $agente->usuario_id;
        $tu = db_tbl('usuarios');
        $ta = db_tbl('agentes');

        $db->begin_transaction();
        $db->query("UPDATE `$ta` SET activo = 0 WHERE id = $id");
        $db->query("UPDATE `$tu` SET activo = 0 WHERE id = $uid");
        $db->commit();
        return true;
    }

    public function ticketsDisponibles() {
        $db = Conexion::conectar();
        $tik = db_tbl('tikets');
        $cat = db_tbl('categorias');
        $est = db_tbl('estados');
        $pri = db_tbl('prioridades');
        $tas = db_tbl('asignaciones');
        $eq = db_tbl('equipos');

        $sql = "SELECT t.*, 
                       c.nombre AS categoria_nombre,
                       e.nombre AS estado_nombre,
                       p.nombre AS prioridad_nombre,
                       p.orden AS prioridad_orden,
                       eq.nombre AS equipo_nombre
                FROM `$tik` t
                LEFT JOIN `$cat` c ON t.categoria_id = c.id
                LEFT JOIN `$eq` eq ON t.equipo_id = eq.id
                LEFT JOIN `$est` e ON t.estado_id = e.id
                LEFT JOIN `$pri` p ON t.prioridad_id = p.id
                WHERE t.activo = 1
                  AND t.estado_id = 1
                  AND NOT EXISTS (
                      SELECT 1 FROM `$tas` ta 
                      WHERE ta.tiket_id = t.id AND ta.activo = 1
                  )
                ORDER BY p.orden DESC, t.id ASC";

        return $db->query($sql);
    }

    /**
     * Inserta asignación activa y pasa el tiket a "En proceso". Falla si ya hay asignación activa.
     */
    public function tomarTicket($tiket_id, $agente_id) {
        $db = Conexion::conectar();
        $tiket_id = (int) $tiket_id;
        $agente_id = (int) $agente_id;
        $estado_proceso = 2;

        $tik = db_tbl('tikets');
        $tas = db_tbl('asignaciones');

        $db->begin_transaction();

        $dup = $db->query(
            "SELECT id FROM `$tas` WHERE tiket_id = $tiket_id AND activo = 1 LIMIT 1 FOR UPDATE"
        );
        if ($dup && $dup->num_rows > 0) {
            $db->rollback();
            return false;
        }

        $tv = $db->query(
            "SELECT id FROM `$tik` WHERE id = $tiket_id AND activo = 1 AND estado_id = 1 LIMIT 1 FOR UPDATE"
        );
        if (!$tv || $tv->num_rows === 0) {
            $db->rollback();
            return false;
        }

        $stmt = $db->prepare(
            "INSERT INTO `$tas` (tiket_id, agente_id, activo) VALUES (?, ?, 1)"
        );
        if (!$stmt || !$stmt->bind_param("ii", $tiket_id, $agente_id) || !$stmt->execute()) {
            $db->rollback();
            return false;
        }

        $stmt2 = $db->prepare(
            "UPDATE `$tik` SET estado_id = ? WHERE id = ? AND activo = 1"
        );
        if (!$stmt2 || !$stmt2->bind_param("ii", $estado_proceso, $tiket_id) || !$stmt2->execute()) {
            $db->rollback();
            return false;
        }

        $db->commit();
        return true;
    }

    public function ticketsAsignadosAlAgente($agente_id) {
        $db = Conexion::conectar();
        $agente_id = (int) $agente_id;
        $tik = db_tbl('tikets');
        $cat = db_tbl('categorias');
        $est = db_tbl('estados');
        $pri = db_tbl('prioridades');
        $tas = db_tbl('asignaciones');
        $eq = db_tbl('equipos');

        $sql = "SELECT t.*, 
                       c.nombre AS categoria_nombre,
                       e.nombre AS estado_nombre,
                       p.nombre AS prioridad_nombre,
                       eq.nombre AS equipo_nombre
                FROM `$tik` t
                INNER JOIN `$tas` ta ON ta.tiket_id = t.id AND ta.agente_id = $agente_id AND ta.activo = 1
                LEFT JOIN `$cat` c ON t.categoria_id = c.id
                LEFT JOIN `$eq` eq ON t.equipo_id = eq.id
                LEFT JOIN `$est` e ON t.estado_id = e.id
                LEFT JOIN `$pri` p ON t.prioridad_id = p.id
                WHERE t.activo = 1
                ORDER BY t.id DESC";

        return $db->query($sql);
    }

    public function tieneAsignacionActiva($tiket_id, $agente_id) {
        $db = Conexion::conectar();
        $tiket_id = (int) $tiket_id;
        $agente_id = (int) $agente_id;
        $tas = db_tbl('asignaciones');
        $r = $db->query(
            "SELECT id FROM `$tas` WHERE tiket_id = $tiket_id AND agente_id = $agente_id AND activo = 1 LIMIT 1"
        );
        return $r && $r->num_rows > 0;
    }

    /**
     * Tikets cerrados en los que este agente participó (asignación registrada).
     */
    public function ticketsFinalizados($agente_id) {
        $db = Conexion::conectar();
        $agente_id = (int) $agente_id;
        $tik = db_tbl('tikets');
        $cat = db_tbl('categorias');
        $est = db_tbl('estados');
        $pri = db_tbl('prioridades');
        $tas = db_tbl('asignaciones');
        $eq = db_tbl('equipos');

        $sql = "SELECT DISTINCT t.*, 
                       c.nombre AS categoria_nombre,
                       e.nombre AS estado_nombre,
                       p.nombre AS prioridad_nombre,
                       eq.nombre AS equipo_nombre
                FROM `$tik` t
                INNER JOIN `$tas` ta ON ta.tiket_id = t.id AND ta.agente_id = $agente_id
                LEFT JOIN `$cat` c ON t.categoria_id = c.id
                LEFT JOIN `$eq` eq ON t.equipo_id = eq.id
                LEFT JOIN `$est` e ON t.estado_id = e.id
                LEFT JOIN `$pri` p ON t.prioridad_id = p.id
                WHERE t.activo = 1 AND t.estado_id = 4
                ORDER BY t.id DESC";

        return $db->query($sql);
    }
}
