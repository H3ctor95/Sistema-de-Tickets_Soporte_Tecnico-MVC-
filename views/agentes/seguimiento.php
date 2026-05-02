<?php
$tituloPagina = 'Seguimiento del ticket #' . (int) $ticket->id;
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_agente.php';
?>

<h1>Seguimiento del tiket</h1>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'comentario'): ?>
<p class="msg msg-error">Debes escribir un comentario al cambiar el estado.</p>
<?php endif; ?>

<p><strong>Título:</strong> <?= htmlspecialchars($ticket->titulo) ?></p>
<p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($ticket->descripcion)) ?></p>
<?php if (!empty($ticket->notas_contacto)): ?>
<p><strong>Datos de contacto del usuario:</strong><br><?= nl2br(htmlspecialchars($ticket->notas_contacto)) ?></p>
<?php endif; ?>

<h2>Historial de comentarios</h2>

<?php if ($comentarios): while ($c = $comentarios->fetch_object()): ?>
<div class="comment-block">
<strong><?= htmlspecialchars($c->autor_nombre ?? '') ?>:</strong>
<?= nl2br(htmlspecialchars($c->texto)) ?>
</div>
<?php endwhile; endif; ?>

<hr>

<form class="form-stack" method="POST" action="index.php?controller=agente&amp;action=actualizarEstado">
<input type="hidden" name="ticket_id" value="<?= (int) $ticket->id ?>">

<div class="field-block">
<label for="seg-com"><strong>Comentario</strong> (obligatorio al actualizar)</label>
<textarea class="field-textarea field-textarea--wide" id="seg-com" name="comentario" placeholder="Ej. Cambié la fuente, probamos el equipo…" required rows="4"></textarea>
</div>

<div class="field-block">
<label for="seg-est">Nuevo estado</label>
<select class="field-input" id="seg-est" name="estado_id" required>
    <?php if ($estados): while ($e = $estados->fetch_object()): ?>
        <option value="<?= (int) $e->id ?>" <?= (int) $ticket->estado_id === (int) $e->id ? 'selected' : '' ?>>
            <?= htmlspecialchars($e->nombre) ?>
        </option>
    <?php endwhile; endif; ?>
</select>
</div>

<div class="form-actions">
<button type="submit">Guardar estado y comentario</button>
</div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>
