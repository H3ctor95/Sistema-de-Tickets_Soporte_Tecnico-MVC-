<?php
$tituloPagina = 'Crear usuario';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=usuario&amp;action=index">← Usuarios</a>
</nav>

<h1>Crear usuario</h1>

<form class="form-stack" method="POST">

<div class="field-block">
<label for="u-nombre">Nombre</label>
<input class="field-input" id="u-nombre" name="nombre" placeholder="Nombre" required>
</div>
<div class="field-block">
<label for="u-email">Email</label>
<input class="field-input" id="u-email" type="email" name="email" placeholder="Email" required>
</div>
<div class="field-block">
<label for="u-pass">Contraseña</label>
<input class="field-input" id="u-pass" type="password" name="contrasena" placeholder="Contraseña" required>
</div>

<div class="field-block">
<label for="u-rol">Rol</label>
<select class="field-input" id="u-rol" name="rol_id" required>
    <option value="1">Administrador</option>
    <option value="2">Agente</option>
    <option value="3">Usuario</option>
</select>
<p class="hint">Para soporte técnico conviene crear el agente desde “Crear nuevo agente” en el panel admin.</p>
</div>

<div class="form-actions">
<button type="submit">Guardar</button>
<a class="button button-ghost" href="index.php?controller=usuario&amp;action=index">Cancelar</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
