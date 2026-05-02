<?php
require_once "models/UsuarioModelo.php";

class AuthController {

    public function login() {

        $mensajeLogin = '';

        if ($_POST) {
            $modelo = new UsuarioModelo();

            $email = $_POST['email'];
            $pass = $_POST['contrasena'];

            $usuario = $modelo->login($email, $pass);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['agente_id'] = null;

                /* Roles: 1 = Administrador, 2 = Agente, 3 = Usuario */
                if ((int) $usuario->rol_id === 2) {
                    require_once "models/AgenteModelo.php";
                    $agenteMod = new AgenteModelo();
                    $_SESSION['agente_id'] = $agenteMod->obtenerIdPorUsuario((int) $usuario->id);

                    /* Agente mal dado de alta (rol 2 sin fila en agentes): no dejar sesión colgando */
                    if ((int) ($_SESSION['agente_id'] ?? 0) < 1) {
                        $_SESSION['usuario'] = null;
                        $_SESSION['agente_id'] = null;
                        unset($_SESSION['usuario'], $_SESSION['agente_id']);
                        $mensajeLogin = 'Este correo tiene rol Agente pero no tiene ficha de agente en la base de datos '
                            . '(seguramente se creó con “Crear usuario” eligiendo Agente). '
                            . 'Qué hacer: desde el administrador usá «Crear nuevo agente», o bien editá el usuario y poné rol Usuario.';
                    }
                }

                if (!empty($_SESSION['usuario'])) {
                    $rol = (int) $_SESSION['usuario']->rol_id;
                    if ($rol === 1) {
                        header("Location: index.php?controller=admin&action=dashboard");
                        exit;
                    }
                    if ($rol === 2) {
                        header("Location: index.php?controller=agente&action=tickets");
                        exit;
                    }
                    if ($rol === 3) {
                        header("Location: index.php?controller=ticket&action=index");
                        exit;
                    }
                }
            } else {
                $mensajeLogin = 'Credenciales incorrectas.';
            }
        }

        require "views/auth/login.php";
    }

    public function logout() {
        session_destroy();

        header("Location: index.php");
        exit;
    }
}