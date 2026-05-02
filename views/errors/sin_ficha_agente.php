<?php
$tituloPagina = 'Sin ficha de agente';
$bodyClass = 'login-page';
$mainContentClass = 'login-card';
include __DIR__ . '/../partials/head.php';
?>

<h1>Sin ficha de agente</h1>

<p class="msg msg-error">Tu cuenta tiene rol Agente pero no hay un registro activo en la tabla <strong>agentes</strong> vinculado a tu usuario. Suele pasar si alguien usó solo «Crear usuario» eligiendo rol Agente en lugar de «Crear nuevo agente».</p>

<ul class="task-list hint">
<li>Que un administrador te dé de alta desde <strong>Crear nuevo agente</strong> (recomendado), o bien</li>
<li>El administrador puede editar tu usuario y cambiar el rol a <strong>Usuario</strong> si esa persona no debe ser soporte.</li>
</ul>

<p class="actions-row form-actions footer-actions-large">
<a class="button" href="index.php?controller=auth&amp;action=logout">Salir / volver al login</a>
</p>

<?php include __DIR__ . '/../partials/footer.php'; ?>
