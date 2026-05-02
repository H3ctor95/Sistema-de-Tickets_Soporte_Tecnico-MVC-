<?php
$tituloPagina = 'Categorías';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=admin&amp;action=dashboard">← Panel administrador</a>
</nav>

<h1>Categorías</h1>

<p><a class="button" href="index.php?controller=categoria&amp;action=crear">Nueva categoría</a></p>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acciones</th>
</tr></thead>
<tbody>

<?php if ($categorias): while ($c = $categorias->fetch_object()): ?>
<tr>
    <td><?= (int) $c->id ?></td>
    <td><?= htmlspecialchars($c->nombre) ?></td>
    <td class="table-actions">
        <a href="index.php?controller=categoria&amp;action=editar&amp;id=<?= (int) $c->id ?>">Editar</a>
        <a href="index.php?controller=categoria&amp;action=eliminar&amp;id=<?= (int) $c->id ?>">Eliminar</a>
    </td>
</tr>
<?php endwhile; endif; ?>
</tbody>
</table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
