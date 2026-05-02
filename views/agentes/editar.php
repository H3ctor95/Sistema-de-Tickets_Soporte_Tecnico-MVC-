<?php
$tituloPagina = 'Editar agente';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav" aria-label="Panel admin">
<a href="index.php?controller=agente&amp;action=index">← Lista de agentes</a>
</nav>

<h1>Editar agente</h1>

<form class="form-stack" method="POST">

<div class="field-block">
<label for="eag-nombre">Nombre</label>
<input class="field-input" id="eag-nombre" name="nombre" value="<?= htmlspecialchars($agente->nombre) ?>" required>
</div>
<div class="field-block">
<label for="eag-email">Email</label>
<input class="field-input" id="eag-email" type="email" name="email" value="<?= htmlspecialchars($agente->email) ?>" required>
</div>
<div class="field-block">
<label for="eag-pass">Nueva contraseña</label>
<input class="field-input" id="eag-pass" type="password" name="contrasena" placeholder="Opcional: dejar en blanco para no cambiar">
</div>

<div class="form-actions">
<button type="submit">Actualizar</button>
<a class="button button-ghost" href="index.php?controller=agente&amp;action=index">Volver</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
