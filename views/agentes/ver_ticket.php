<?php
$tituloPagina = 'Revisar ticket #' . (int) $ticket->id;
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_agente.php';
?>

<h1>Detalle del tiket (sin asignar)</h1>

<div class="detail-block">
<p><strong>Título:</strong> <?= htmlspecialchars($ticket->titulo) ?></p>
<p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($ticket->descripcion)) ?></p>
<p><strong>Prioridad:</strong> <?= htmlspecialchars($ticket->prioridad_nombre ?? '') ?></p>
<p><strong>Categoría:</strong> <?= htmlspecialchars($ticket->categoria_nombre ?? '') ?></p>
<p><strong>Estado:</strong> <?= htmlspecialchars($ticket->estado_nombre ?? '') ?> <em>(quedará “En proceso” al tomarlo)</em></p>
<p><strong>Solicitante:</strong> <?= htmlspecialchars($ticket->creador_nombre ?? '') ?></p>
<?php if (!empty($ticket->notas_contacto)): ?>
<p><strong>Otros datos / contacto:</strong><br><?= nl2br(htmlspecialchars($ticket->notas_contacto)) ?></p>
<?php endif; ?>
</div>

<p class="actions-row">
<a class="button" href="index.php?controller=agente&amp;action=tomar&amp;id=<?= (int) $ticket->id ?>">Tomar este ticket</a>
<a class="button button-ghost" href="index.php?controller=agente&amp;action=tickets">Volver a la lista</a>
</p>
<?php include __DIR__ . '/../partials/footer.php'; ?>
