<?php
require_once "models/UsuarioModelo.php";

class AuthController {

    public function login() {

        if ($_POST) {
            $modelo = new UsuarioModelo();

            $email = $_POST['email'];
            $pass = $_POST['contrasena'];

            $usuario = $modelo->login($email, $pass);

            if ($usuario) {
                session_start();

                $_SESSION['usuario'] = $usuario;

                 
                if ($usuario->rol_id == 1){
                    header("location: index.php?controller=admin&action=dashboard");
                } elseif ($usuario->rol_id == 2){
                    header("location: index.php?controller=ticket&action=index");
                } elseif ($usuario->rol_id == 3) {
                    header("location: index.php?controller=agente&action=index");
                }
            } else {
                echo "Credenciales incorrectas";
            }
        }

        require "views/auth/login.php";
    }

    public function logout() {
        session_start();
        session_destroy();

        header("Location: index.php");
    }
}