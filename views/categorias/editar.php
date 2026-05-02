<?php
$tituloPagina = 'Editar categoría';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=categoria&amp;action=index">← Categorías</a>
</nav>

<h1>Editar categoría</h1>

<form class="form-stack" method="POST">
<div class="field-block">
<label for="ecat-nombre">Nombre</label>
<input class="field-input" id="ecat-nombre" name="nombre" value="<?= htmlspecialchars($categoria->nombre) ?>">
</div>
<div class="form-actions">
<button type="submit">Actualizar</button>
<a class="button button-ghost" href="index.php?controller=categoria&amp;action=index">Cancelar</a>
</div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
