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

                header("Location: index.php");
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