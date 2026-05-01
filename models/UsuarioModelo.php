<?php
require_once "config/conexion.php";

class UsuarioModelo {

    public funtion login($email, $password) {
        $db = Conexion::conectar();

        $sql = "select * from  usuarios where email='$enamil' and contrasena='$password'";

        return $db->query($sql)->fetch_object();
    }
}