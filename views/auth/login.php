<?php
$tituloPagina = 'Iniciar sesión';
$bodyClass = 'login-page';
$mainContentClass = 'login-card';
include __DIR__ . '/../partials/head.php';
?>
<h1>Iniciar sesión</h1>
<p class="login-intro">Sistema de tickets de soporte técnico</p>

<?php if (!empty($mensajeLogin)): ?>
<p class="msg msg-error"><?= htmlspecialchars($mensajeLogin) ?></p>
<?php endif; ?>

<form class="form-stack" method="POST">
<div class="field-block">
<label for="login-email">Correo electrónico</label>
<input class="field-input" id="login-email" type="email" name="email" autocomplete="username" placeholder="usuario@ejemplo.org" required>
</div>
<div class="field-block">
<label for="login-pass">Contraseña</label>
<input class="field-input" id="login-pass" type="password" name="contrasena" autocomplete="current-password" placeholder="Contraseña" required>
</div>
<div class="form-actions">
<button type="submit">Ingresar</button>
</div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>
