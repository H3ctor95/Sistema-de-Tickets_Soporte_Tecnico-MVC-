<h1>Detalle del Ticket</h1>

<p><strong>Título:</strong> <?= $ticket->titulo ?></p>
<p><strong>Descripción:</strong> <?= $ticket->descripcion ?></p>

<hr>

<h2>Comentarios</h2>

<?php while($c = $comentarios->fetch_object()): ?>
    <p>
        <strong><?= $c->agente_nombre ?? 'Usuario' ?>:</strong>
        <?= $c->texto ?>
    </p>
<?php endwhile; ?>

<hr>

<h3>Agregar Comentario</h3>

<form method="POST" action="index.php?controller=comentario&action=guardar">
    <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
    <textarea name="texto" placeholder="Escribe un comentario"></textarea><br>
    <button>Guardar</button>
</form>