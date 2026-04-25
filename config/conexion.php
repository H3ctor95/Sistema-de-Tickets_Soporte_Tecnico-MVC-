<?php

class Conexion {

    public static function conectar() {

        $env = parse_ini_file(__DIR__ . '/../.env');

        $host = $env['DB_HOST'];
        $db = $env['DB_NOMBRE'];
        $user = $env['DB_USUARIO'];
        $pass = $env['DB_PASSWORD'];

        $conexion = new mysqli($host, $user, $pass, $db);

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        return $conexion;
    }
}
