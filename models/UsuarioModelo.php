<?php
require_once "config/conexion.php";
require_once "config/tablas.php";

class UsuarioModelo {

    public function login($email, $contrasena) {
        $db = Conexion::conectar();
        $tu = db_tbl('usuarios');

        $stmt = $db->prepare("SELECT * FROM `$tu` WHERE email = ? AND activo = 1 LIMIT 1");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_object();

        // Contraseña en texto plano (proyecto académico, sin producción)
        if ($usuario && (string) $usuario->contrasena === (string) $contrasena) {
            return $usuario;
        }

        return false;
    }

    public function obtenerTodos() {
        $db = Conexion::conectar();
        $tu = db_tbl('usuarios');
        $tr = db_tbl('roles');
        return $db->query(
            "SELECT u.*, r.nombre AS rol 
             FROM `$tu` u
             INNER JOIN `$tr` r ON u.rol_id = r.id
             WHERE u.activo = 1 AND r.activo = 1
             ORDER BY u.nombre"
        );
    }

    public function obtenerPorId($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $tu = db_tbl('usuarios');
        return $db->query("SELECT * FROM `$tu` WHERE id=$id AND activo = 1")->fetch_object();
    }

    public function crear($datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];
        $email = $datos['email'];
        $rol = (int) $datos['rol_id'];
        $contrasenaPlano = (string) $datos['contrasena'];

        $tu = db_tbl('usuarios');
        $stmt = $db->prepare(
            "INSERT INTO `$tu` (nombre, email, contrasena, rol_id, activo) VALUES (?, ?, ?, ?, 1)"
        );
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("sssi", $nombre, $email, $contrasenaPlano, $rol);
        return $stmt->execute();
    }

    public function actualizar($id, $datos) {
        $db = Conexion::conectar();

        $nombre = $datos['nombre'];
        $email = $datos['email'];
        $rol = (int) $datos['rol_id'];
        $id = (int) $id;

        $tu = db_tbl('usuarios');

        if (!empty($datos['contrasena'])) {
            $pass = (string) $datos['contrasena'];
            $stmt = $db->prepare(
                "UPDATE `$tu` SET nombre = ?, email = ?, rol_id = ?, contrasena = ? WHERE id = ? AND activo = 1"
            );
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("ssisi", $nombre, $email, $rol, $pass, $id);
            return $stmt->execute();
        }

        $stmt = $db->prepare(
            "UPDATE `$tu` SET nombre = ?, email = ?, rol_id = ? WHERE id = ? AND activo = 1"
        );
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssii", $nombre, $email, $rol, $id);
        return $stmt->execute();
    }

    /**
     * Baja lógica (no DELETE).
     */
    public function eliminar($id) {
        $db = Conexion::conectar();
        $id = (int) $id;
        $tu = db_tbl('usuarios');
        return $db->query("UPDATE `$tu` SET activo = 0 WHERE id=$id");
    }
}
