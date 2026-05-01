<?php
require_once "models/UsuarioMOdelo.php";

class AuthController {

    public function login() {
        if ($_post) {
            $modelo = new UsuarioModelo();

            $email = $_post['email'];
            $pass = $_post['contraseña'];

            $usuario = $modelo->login($email, $pass);

            if ($usuario) {
                session_start();

                $_session['usuario'] = $usuario;

                header("location: index.php");
            } else {
                echo "credenciales incorrectas";
            }
            require_once "views/auth/login.php";
        }


        public function logout() {
            session_start();
            session_destroy();

            header("location: index.php");
        }
    }
}