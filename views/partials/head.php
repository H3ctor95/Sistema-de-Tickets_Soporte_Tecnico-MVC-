<?php
$tituloPagina = isset($tituloPagina) ? (string) $tituloPagina : 'Soporte técnico';
$bodyClass = isset($bodyClass) ? trim((string) $bodyClass) : '';
$contentClass = isset($mainContentClass) ? trim((string) $mainContentClass) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="app-body<?= $bodyClass !== '' ? ' ' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') : '' ?>">
<div class="app-wrap">
<main class="main-content<?= $contentClass !== '' ? ' ' . htmlspecialchars($contentClass, ENT_QUOTES, 'UTF-8') : '' ?>">
