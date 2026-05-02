<h1>Seguimiento Ticket</h1>

<p><?= $ticket->titulo ?></p>
<p><?= $ticket->descripcion ?></p>

<h3>Comentarios</h3>

<?php while($c = $comentarios->fetch_object()): ?>
    <p><?= $c->texto ?></p>
<?php endwhile; ?>

<hr>

<form method="POST" action="index.php?controller=agente&action=actualizarEstado">
    <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">

    <textarea name="comentario"></textarea><br>

    <select name="estado_id">
        <option value="2">En proceso</option>
        <option value="3">Espera aprobación</option>
    </select>

    <button>Actualizar</button>
</form>