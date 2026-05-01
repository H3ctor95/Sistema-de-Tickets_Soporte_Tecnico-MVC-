<h1>Estados</h1>

<a href="index.php?controller=estado&action=crear">Nuevo Estado</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>

<?php while($e = $estados->fetch_object()): ?>
<tr>
    <td><?= $e->id ?></td>
    <td><?= $e->nombre ?></td>
    <td>
        <a href="index.php?controller=estado&action=editar&id=<?= $e->id ?>">Editar</a>
        <a href="index.php?controller=estado&action=eliminar&id=<?= $e->id ?>">Eliminar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>