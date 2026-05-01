<?php
require_once "config/conexion.php";

class UsuarioModelo {

    public function login($email, $contrasena) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM usuarios 
                WHERE email='$email' AND contrasena='$contrasena'";

        return $db->query($sql)->fetch_object();
    }
}