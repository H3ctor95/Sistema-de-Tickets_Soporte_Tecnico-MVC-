<?php

function verificarRol($rol) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }

    if ($_SESSION['usuario']->rol_id != $rol) {
        echo "Acceso denegado";
        exit;
    }
}

function verificarAlgunRol(array $roles) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }

    if (!in_array((int) $_SESSION['usuario']->rol_id, $roles, true)) {
        echo "Acceso denegado";
        exit;
    }
}

/**
 * Acceso al detalle de ticket: administrador (rol 1) o dueño empresa (rol 3). Roles: 2 = agente → solo vistas agente.
 *
 * @param object|null $ticket Fila de tikets (registrado_por_usuario_id)
 */
function usuario_puede_ver_ticket($ticket) {
    if (!$ticket || !isset($_SESSION['usuario'])) {
        return false;
    }
    $u = $_SESSION['usuario'];
    if ((int) $u->rol_id === 1) {
        return true;
    }
    if ((int) $u->rol_id === 3 && (int) $ticket->registrado_por_usuario_id === (int) $u->id) {
        return true;
    }
    return false;
}