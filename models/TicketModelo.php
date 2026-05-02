<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class TicketModelo {

    private function tabla() {
        return db_tbl('tikets');
    }

    /**
     * Listado con quien creó el tiket y qué agente lo tiene asignado (si hay).
     */
    public function obtenerTodos() {
        $db = Conexion::conectar();
        $tik = $this->tabla();
        $cat = db_tbl('categorias');
        $est = db_tbl('estados');
        $pri = db_tbl('prioridades');
        $eq = db_tbl('equipos');
        $tu = db_tbl('usuarios');
        $tas = db_tbl('asignaciones');
        $ta = db_tbl('agentes');

        $sql = "SELECT t.*, 
                       c.nombre AS categoria_nombre,
                       e.nombre AS estado_nombre,
                       p.nombre AS prioridad_nombre,
                       eq.nombre AS equipo_nombre,
                       uc.nombre AS creador_nombre,
                       ag.nombre AS agente_asignado
                FROM `$tik` t
                LEFT JOIN `$cat` c ON t.categoria_id = c.id
                LEFT JOIN `$eq` eq ON t.equipo_id = eq.id
                LEFT JOIN `$est` e ON t.estado_id = e.id
                LEFT JOIN `$pri` p ON t.prioridad_id = p.id
                LEFT JOIN `$tu` uc ON t.registrado_por_usuario_id = uc.id
                LEFT JOIN `$tas` tasig ON tasig.tiket_id = t.id AND tasig.activo = 1
                LEFT JOIN `$ta` ag ON tasig.agente_id = ag.id
                WHERE t.activo = 1
                ORDER BY t.id DESC";

        return $db->query($sql);
    }

    public function obtenerPorId($id) {
        return $this->obtenerPorIdCompleto($id);
    }

    public function obtenerPorIdCompleto($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $tik = $this->tabla();
        $cat = db_tbl('categorias');
        $est = db_tbl('estados');
        $pri = db_tbl('prioridades');
        $eq = db_tbl('equipos');
        $tu = db_tbl('usuarios');
        $tas = db_tbl('asignaciones');
        $ta = db_tbl('agentes');

        $sql = "SELECT t.*, 
                       c.nombre AS categoria_nombre,
                       e.nombre AS estado_nombre,
                       p.nombre AS prioridad_nombre,
                       eq.nombre AS equipo_nombre,
                       uc.nombre AS creador_nombre,
                       uc.email AS creador_email,
                       ag.nombre AS agente_asignado,
                       ag.email AS agente_email
                FROM `$tik` t
                LEFT JOIN `$cat` c ON t.categoria_id = c.id
                LEFT JOIN `$eq` eq ON t.equipo_id = eq.id
                LEFT JOIN `$est` e ON t.estado_id = e.id
                LEFT JOIN `$pri` p ON t.prioridad_id = p.id
                LEFT JOIN `$tu` uc ON t.registrado_por_usuario_id = uc.id
                LEFT JOIN `$tas` tasig ON tasig.tiket_id = t.id AND tasig.activo = 1
                LEFT JOIN `$ta` ag ON tasig.agente_id = ag.id
                WHERE t.id = $id AND t.activo = 1
                LIMIT 1";

        $res = $db->query($sql);
        if (!$res) {
            return null;
        }
        return $res->fetch_object();
    }

    public function crear($datos, $usuario_id) {
        $db = Conexion::conectar();
        $tik = $this->tabla();

        $titulo = $datos['titulo'];
        $descripcion = $datos['descripcion'];
        $notas = isset($datos['notas_contacto']) ? trim($datos['notas_contacto']) : '';
        $categoria_id = (int) $datos['categoria_id'];
        $prioridad_id = (int) $datos['prioridad_id'];
        $registrado_por = (int) $usuario_id;
        $estado_inicial = 1;

        $stmt = $db->prepare(
            "INSERT INTO `$tik` (titulo, descripcion, notas_contacto, categoria_id, estado_id, prioridad_id, registrado_por_usuario_id, aprobado, activo)
             VALUES (?, ?, ?, ?, ?, ?, ?, 0, 1)"
        );
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param(
            "sssiiii",
            $titulo,
            $descripcion,
            $notas,
            $categoria_id,
            $estado_inicial,
            $prioridad_id,
            $registrado_por
        );
        return $stmt->execute();
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $tik = $this->tabla();

        $titulo = $datos['titulo'];
        $descripcion = $datos['descripcion'];
        $categoria = (int) $datos['categoria_id'];
        $estado = (int) $datos['estado_id'];

        $stmt = $db->prepare(
            "UPDATE `$tik`
             SET titulo = ?, descripcion = ?, categoria_id = ?, estado_id = ?
             WHERE id = ? AND activo = 1"
        );
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssiii", $titulo, $descripcion, $categoria, $estado, $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $tik = $this->tabla();
        $tas = db_tbl('asignaciones');

        $db->begin_transaction();
        $db->query("UPDATE `$tas` SET activo = 0 WHERE tiket_id = $id");
        $ok = $db->query("UPDATE `$tik` SET activo = 0 WHERE id = $id");
        $db->commit();
        return $ok;
    }

    public function obtenerPorUsuario($usuario_id) {
        $db = Conexion::conectar();
        $usuario_id = (int) $usuario_id;
        $tik = $this->tabla();
        $cat = db_tbl('categorias');
        $est = db_tbl('estados');
        $pri = db_tbl('prioridades');
        $eq = db_tbl('equipos');
        $tu = db_tbl('usuarios');
        $tas = db_tbl('asignaciones');
        $ta = db_tbl('agentes');

        $sql = "SELECT t.*, 
                       c.nombre AS categoria_nombre,
                       e.nombre AS estado_nombre,
                       p.nombre AS prioridad_nombre,
                       eq.nombre AS equipo_nombre,
                       uc.nombre AS creador_nombre,
                       ag.nombre AS agente_asignado
                FROM `$tik` t
                LEFT JOIN `$cat` c ON t.categoria_id = c.id
                LEFT JOIN `$eq` eq ON t.equipo_id = eq.id
                LEFT JOIN `$est` e ON t.estado_id = e.id
                LEFT JOIN `$pri` p ON t.prioridad_id = p.id
                LEFT JOIN `$tu` uc ON t.registrado_por_usuario_id = uc.id
                LEFT JOIN `$tas` tasig ON tasig.tiket_id = t.id AND tasig.activo = 1
                LEFT JOIN `$ta` ag ON tasig.agente_id = ag.id
                WHERE t.registrado_por_usuario_id = $usuario_id AND t.activo = 1
                ORDER BY t.id DESC";

        return $db->query($sql);
    }

    public function cerrarYaprobar($ticket_id) {
        $db = Conexion::conectar();
        $ticket_id = (int) $ticket_id;
        $estado_cerrado = 4;
        $tik = $this->tabla();
        $stmt = $db->prepare("UPDATE `$tik` SET aprobado = 1, estado_id = ? WHERE id = ? AND activo = 1");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ii", $estado_cerrado, $ticket_id);
        return $stmt->execute();
    }

    public function rechazarAprobacion($ticket_id) {
        $db = Conexion::conectar();
        $ticket_id = (int) $ticket_id;
        $estado_proceso = 2;
        $tik = $this->tabla();
        $stmt = $db->prepare("UPDATE `$tik` SET estado_id = ? WHERE id = ? AND activo = 1");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ii", $estado_proceso, $ticket_id);
        return $stmt->execute();
    }

    public function actualizarEstadoPorId($tiket_id, $estado_id) {
        $db = Conexion::conectar();
        $tiket_id = (int) $tiket_id;
        $estado_id = (int) $estado_id;
        $tik = $this->tabla();
        $stmt = $db->prepare("UPDATE `$tik` SET estado_id = ? WHERE id = ? AND activo = 1");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ii", $estado_id, $tiket_id);
        return $stmt->execute();
    }

    /**
     * Tiket nuevo sin asignar (para vista previa del agente antes de tomarlo).
     */
    public function esTiketLibreParaTomar($tiket_id) {
        $t = $this->obtenerPorIdCompleto((int) $tiket_id);
        if (!$t || (int) $t->estado_id !== 1) {
            return false;
        }
        return empty($t->agente_asignado);
    }
}
