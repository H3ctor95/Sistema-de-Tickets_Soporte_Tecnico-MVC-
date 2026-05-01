<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['usuario'])) {
    require "controllers/AuthController.php";
    $auth = new AuthController();
    $auth->login();
    exit;
}

require_once "Router.php";