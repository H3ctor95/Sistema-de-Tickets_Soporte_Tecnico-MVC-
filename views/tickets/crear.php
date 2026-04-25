<h1>Crear Ticket</h1>

<form method="POST">

<input name="titulo" placeholder="Título"><br>

<textarea name="descripcion" placeholder="Descripción"></textarea><br>

<select name="categoria_id">
    <option>Seleccione categoría</option>
    <?php while($c = $categorias->fetch_object()): ?>
        <option value="<?= $c->id ?>"><?= $c->nombre ?></option>
    <?php endwhile; ?>
</select><br>

<select name="estado_id">
    <?php while($e = $estados->fetch_object()): ?>
        <option value="<?= $e->id ?>"><?= $e->nombre ?></option>
    <?php endwhile; ?>
</select><br>

<button>Guardar</button>

</form>