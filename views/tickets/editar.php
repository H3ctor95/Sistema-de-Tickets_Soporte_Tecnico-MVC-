<h1>Editar Ticket</h1>

<form method="POST">

<input name="titulo" value="<?= $ticket->titulo ?>"><br>

<textarea name="descripcion"><?= $ticket->descripcion ?></textarea><br>

<select name="categoria_id">
    <?php while($c = $categorias->fetch_object()): ?>
        <option value="<?= $c->id ?>" <?= $ticket->categoria_id == $c->id ? 'selected' : '' ?>>
            <?= $c->nombre ?>
        </option>
    <?php endwhile; ?>
</select><br>

<select name="estado_id">
    <?php while($e = $estados->fetch_object()): ?>
        <option value="<?= $e->id ?>" <?= $ticket->estado_id == $e->id ? 'selected' : '' ?>>
            <?= $e->nombre ?>
        </option>
    <?php endwhile; ?>
</select><br>

<button>Actualizar</button>

</form>