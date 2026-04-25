<?php

$controlador = $_GET['controller'] ?? 'ticket';
$accion = $_GET['action'] ?? 'index';

$nombreControlador = ucfirst($controlador) . "Controller";

require_once "controllers/$nombreControlador.php";

$controladorObj = new $nombreControlador();
$controladorObj->$accion();