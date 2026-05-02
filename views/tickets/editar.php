<?php
$tituloPagina = 'Editar ticket';
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_usuario.php';
?>

<h1>Editar ticket</h1>

<form class="form-stack" method="POST">

<div class="field-block">
<label for="ed-titulo">Título</label>
<input class="field-input" id="ed-titulo" name="titulo" value="<?= htmlspecialchars($ticket->titulo) ?>" required>
</div>

<div class="field-block">
<label for="ed-desc">Descripción</label>
<textarea class="field-textarea field-textarea--narrow" id="ed-desc" name="descripcion"><?= htmlspecialchars($ticket->descripcion) ?></textarea>
</div>

<div class="field-block">
<label for="ed-cat">Categoría</label>
<select class="field-input" id="ed-cat" name="categoria_id">
    <?php if ($categorias): while ($c = $categorias->fetch_object()): ?>
        <option value="<?= $c->id ?>" <?= $ticket->categoria_id == $c->id ? 'selected' : '' ?>>
            <?= htmlspecialchars($c->nombre) ?>
        </option>
    <?php endwhile; endif; ?>
</select>
</div>

<div class="field-block">
<label for="ed-est">Estado</label>
<select class="field-input" id="ed-est" name="estado_id">
    <?php if ($estados): while ($e = $estados->fetch_object()): ?>
        <option value="<?= $e->id ?>" <?= $ticket->estado_id == $e->id ? 'selected' : '' ?>>
            <?= htmlspecialchars($e->nombre) ?>
        </option>
    <?php endwhile; endif; ?>
</select>
</div>

<div class="form-actions">
<button type="submit">Actualizar</button>
<a class="button button-ghost" href="index.php?controller=ticket&amp;action=index">Cancelar</a>
</div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>
