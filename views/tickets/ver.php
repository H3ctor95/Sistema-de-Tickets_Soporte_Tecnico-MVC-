<?php
$tituloPagina = 'Ticket #' . (int) $ticket->id;
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_usuario.php';
?>

<h1>Detalle del ticket</h1>

<div class="detail-block">
<p><strong>Título:</strong> <?= htmlspecialchars($ticket->titulo) ?></p>
<p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($ticket->descripcion)) ?></p>
<?php if (!empty($ticket->notas_contacto)): ?>
<p><strong>Otros datos / contacto:</strong><br><?= nl2br(htmlspecialchars($ticket->notas_contacto)) ?></p>
<?php endif; ?>
<p><strong>Prioridad:</strong> <?= htmlspecialchars($ticket->prioridad_nombre ?? '') ?></p>
<p><strong>Categoría:</strong> <?= htmlspecialchars($ticket->categoria_nombre ?? '') ?></p>
<p><strong>Estado:</strong> <?= htmlspecialchars($ticket->estado_nombre ?? '') ?></p>
<p><strong>Quién lo reportó:</strong> <?= htmlspecialchars($ticket->creador_nombre ?? '') ?>
    <?php if (!empty($ticket->creador_email)): ?>
        (<?= htmlspecialchars($ticket->creador_email) ?>)
    <?php endif; ?>
</p>
<p><strong>Agente que lo atiende:</strong>
    <?php if (!empty($ticket->agente_asignado)): ?>
        <?= htmlspecialchars($ticket->agente_asignado) ?>
        <?php if (!empty($ticket->agente_email)): ?>
            (<?= htmlspecialchars($ticket->agente_email) ?>)
        <?php endif; ?>
    <?php else: ?>
        <em>Aún sin asignar</em>
    <?php endif; ?>
</p>
</div>

<hr>

<h2>Comentarios</h2>

<?php if ($comentarios): while ($c = $comentarios->fetch_object()): ?>
    <div class="comment-block">
        <strong><?= htmlspecialchars($c->autor_nombre ?? 'Usuario') ?>:</strong>
        <?= nl2br(htmlspecialchars($c->texto)) ?>
    </div>
<?php endwhile; endif; ?>

<hr>

<h3>Agregar comentario</h3>
<p class="hint">Puedes dejar tu opinión sobre la resolución cuando el tiket esté en espera de aprobación.</p>

<form class="form-stack" method="POST" action="index.php?controller=comentario&amp;action=guardar">
<input type="hidden" name="ticket_id" value="<?= (int) $ticket->id ?>">
<div class="field-block">
<label for="com-texto">Comentario</label>
<textarea class="field-textarea field-textarea--narrow" id="com-texto" name="texto" placeholder="Escribe un comentario" rows="4"></textarea>
</div>
<div class="form-actions">
<button type="submit">Guardar comentario</button>
</div>
</form>

<p><a href="index.php?controller=ticket&amp;action=index">Volver</a></p>

<?php include __DIR__ . '/../partials/footer.php'; ?>
