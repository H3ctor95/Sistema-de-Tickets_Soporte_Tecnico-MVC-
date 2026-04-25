<h1>Editar Ticket</h1>

<form method="POST">
    <input name="titulo" value="<?= $ticket->titulo ?>"><br>
    <textarea name="descripcion"><?= $ticket->descripcion ?></textarea><br>
    <button>Actualizar</button>
</form>