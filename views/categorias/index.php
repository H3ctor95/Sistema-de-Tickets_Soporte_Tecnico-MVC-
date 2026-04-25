<h1>Categorías</h1>

<a href="index.php?controller=categoria&action=crear">Nueva Categoría</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>

<?php while($c = $categorias->fetch_object()): ?>
<tr>
    <td><?= $c->id ?></td>
    <td><?= $c->nombre ?></td>
    <td>
        <a href="index.php?controller=categoria&action=editar&id=<?= $c->id ?>">Editar</a>
        <a href="index.php?controller=categoria&action=eliminar&id=<?= $c->id ?>">Eliminar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>