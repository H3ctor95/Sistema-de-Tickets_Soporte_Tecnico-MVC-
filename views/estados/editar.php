<?php
$tituloPagina = 'Editar estado';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=estado&amp;action=index">← Estados</a>
</nav>

<h1>Editar estado</h1>

<form class="form-stack" method="POST">
<div class="field-block">
<label for="eest-nombre">Nombre</label>
<input class="field-input" id="eest-nombre" name="nombre" value="<?= htmlspecialchars($estado->nombre) ?>">
</div>
<div class="form-actions">
<button type="submit">Actualizar</button>
<a class="button button-ghost" href="index.php?controller=estado&amp;action=index">Cancelar</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
