<?php
$tituloPagina = 'Crear ticket';
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_usuario.php';
?>

<h1>Crear nuevo ticket</h1>

<form class="form-stack" method="POST">

<div class="field-block">
<label for="tik-titulo">Título del problema</label>
<input class="field-input" id="tik-titulo" name="titulo" placeholder="Ej. PC no enciende" required>
</div>

<div class="field-block">
<label for="tik-desc">Descripción</label>
<textarea class="field-textarea field-textarea--narrow" id="tik-desc" name="descripcion" placeholder="Describe el problema con detalle" required rows="5"></textarea>
</div>

<div class="field-block">
<label for="tik-cat">Categoría</label>
<select class="field-input" id="tik-cat" name="categoria_id" required>
    <option value="">Seleccione…</option>
    <?php if ($categorias): while ($c = $categorias->fetch_object()): ?>
        <option value="<?= (int) $c->id ?>"><?= htmlspecialchars($c->nombre) ?></option>
    <?php endwhile; endif; ?>
</select>
</div>

<div class="field-block">
<label for="tik-pri">Prioridad</label>
<select class="field-input" id="tik-pri" name="prioridad_id" required>
    <?php if ($prioridades): while ($p = $prioridades->fetch_object()): ?>
        <option value="<?= (int) $p->id ?>"><?= htmlspecialchars($p->nombre) ?></option>
    <?php endwhile; endif; ?>
</select>
</div>

<p class="hint"><strong>Estado al crear:</strong> Abierto</p>

<div class="field-block">
<label for="tik-notas">Otros datos (teléfono, área, extensión, etc.)</label>
<textarea class="field-textarea field-textarea--narrow" id="tik-notas" name="notas_contacto" placeholder="Opcional: cómo localizarte en la empresa" rows="3"></textarea>
</div>

<div class="form-actions">
<button type="submit">Crear ticket</button>
</div>
</form>

<p class="hint">Después de crear volverás a <strong>Mis tickets</strong>.</p>

<?php include __DIR__ . '/../partials/footer.php'; ?>
