<?php
$tituloPagina = 'Editar usuario';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=usuario&amp;action=index">← Usuarios</a>
</nav>

<h1>Editar usuario</h1>

<form class="form-stack" method="POST">

<div class="field-block">
<label for="eu-nombre">Nombre</label>
<input class="field-input" id="eu-nombre" name="nombre" value="<?= htmlspecialchars($usuario->nombre) ?>">
</div>
<div class="field-block">
<label for="eu-email">Email</label>
<input class="field-input" id="eu-email" type="email" name="email" value="<?= htmlspecialchars($usuario->email) ?>">
</div>
<div class="field-block">
<label for="eu-pass">Nueva contraseña</label>
<input class="field-input" id="eu-pass" type="password" name="contrasena" placeholder="Opcional">
</div>
<div class="field-block">
<label for="eu-rol">Rol</label>
<select class="field-input" id="eu-rol" name="rol_id">
    <option value="1" <?= $usuario->rol_id == 1 ? 'selected' : '' ?>>Administrador</option>
    <option value="2" <?= $usuario->rol_id == 2 ? 'selected' : '' ?>>Agente</option>
    <option value="3" <?= $usuario->rol_id == 3 ? 'selected' : '' ?>>Usuario</option>
</select>
</div>

<div class="form-actions">
<button type="submit">Guardar</button>
<a class="button button-ghost" href="index.php?controller=usuario&amp;action=index">Cancelar</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
