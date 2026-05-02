<?php
$tituloPagina = 'Crear agente';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav" aria-label="Panel admin">
<a href="index.php?controller=agente&amp;action=index">← Lista de agentes</a>
</nav>

<h1>Crear agente</h1>
<p class="hint">Se creará un usuario con rol Agente (podrá iniciar sesión con este correo y contraseña).</p>

<form class="form-stack" method="POST">

<div class="field-block">
<label for="ag-nombre">Nombre</label>
<input class="field-input" id="ag-nombre" name="nombre" placeholder="Nombre" required>
</div>
<div class="field-block">
<label for="ag-email">Email</label>
<input class="field-input" id="ag-email" type="email" name="email" placeholder="Email" required>
</div>
<div class="field-block">
<label for="ag-pass">Contraseña</label>
<input class="field-input" id="ag-pass" type="password" name="contrasena" placeholder="Contraseña" required>
</div>

<div class="form-actions">
<button type="submit">Guardar</button>
<a class="button button-ghost" href="index.php?controller=agente&amp;action=index">Volver</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
