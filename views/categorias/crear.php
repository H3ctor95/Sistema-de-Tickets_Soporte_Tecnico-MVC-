<?php
$tituloPagina = 'Nueva categoría';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=categoria&amp;action=index">← Categorías</a>
</nav>

<h1>Crear categoría</h1>

<form class="form-stack" method="POST">
<div class="field-block">
<label for="cat-nombre">Nombre de la categoría</label>
<input class="field-input" id="cat-nombre" name="nombre" placeholder="Nombre">
</div>
<div class="form-actions">
<button type="submit">Guardar</button>
<a class="button button-ghost" href="index.php?controller=categoria&amp;action=index">Cancelar</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
