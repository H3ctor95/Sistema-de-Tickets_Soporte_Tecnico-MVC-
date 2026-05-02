<?php

$rawCtrl = $_GET['controller'] ?? 'ticket';
$controlador = strtolower(preg_replace('/[^a-z]/i', '', $rawCtrl));
if ($controlador === '') {
    $controlador = 'ticket';
}

$accion = $_GET['action'] ?? 'index';
if (!is_string($accion) || !preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $accion)) {
    $accion = 'index';
}

$nombreControlador = ucfirst($controlador) . "Controller";
$ruta = __DIR__ . "/controllers/{$nombreControlador}.php";

if (!is_file($ruta)) {
    http_response_code(404);
    exit("Controlador no encontrado.");
}

require_once $ruta;

if (!class_exists($nombreControlador)) {
    http_response_code(500);
    exit("Error al cargar el controlador.");
}

$controladorObj = new $nombreControlador();

if (!method_exists($controladorObj, $accion)) {
    http_response_code(404);
    exit("Acción no encontrada.");
}

$controladorObj->$accion();
