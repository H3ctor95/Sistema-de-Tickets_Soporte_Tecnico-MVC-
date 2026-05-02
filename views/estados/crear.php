<?php
$tituloPagina = 'Nuevo estado';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=estado&amp;action=index">← Estados</a>
</nav>

<h1>Crear estado</h1>

<form class="form-stack" method="POST">
<div class="field-block">
<label for="est-nombre">Nombre del estado</label>
<input class="field-input" id="est-nombre" name="nombre" placeholder="Nombre">
</div>
<div class="form-actions">
<button type="submit">Guardar</button>
<a class="button button-ghost" href="index.php?controller=estado&amp;action=index">Cancelar</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
