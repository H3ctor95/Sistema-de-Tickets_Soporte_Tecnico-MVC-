<?php
$tituloPagina = 'Estados';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=admin&amp;action=dashboard">← Panel administrador</a>
</nav>

<h1>Estados de ticket</h1>

<p><a class="button" href="index.php?controller=estado&amp;action=crear">Nuevo estado</a></p>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acciones</th>
</tr></thead>
<tbody>

<?php if ($estados): while ($e = $estados->fetch_object()): ?>
<tr>
    <td><?= (int) $e->id ?></td>
    <td><?= htmlspecialchars($e->nombre) ?></td>
    <td class="table-actions">
        <a href="index.php?controller=estado&amp;action=editar&amp;id=<?= (int) $e->id ?>">Editar</a>
        <a href="index.php?controller=estado&amp;action=eliminar&amp;id=<?= (int) $e->id ?>">Eliminar</a>
    </td>
</tr>
<?php endwhile; endif; ?>
</tbody>
</table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
