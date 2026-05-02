<?php
$tituloPagina = 'Lista de agentes';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav" aria-label="Panel admin">
<a href="index.php?controller=admin&amp;action=dashboard">← Panel administrador</a>
</nav>

<h1>Agentes</h1>
<p><a class="button" href="index.php?controller=agente&amp;action=crear">Nuevo agente</a></p>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Acciones</th>
</tr></thead>
<tbody>

<?php if ($agentes): while ($a = $agentes->fetch_object()): ?>
<tr>
    <td><?= (int) $a->id ?></td>
    <td><?= htmlspecialchars($a->nombre) ?></td>
    <td><?= htmlspecialchars($a->email) ?></td>
    <td class="table-actions">
        <a href="index.php?controller=agente&amp;action=editar&amp;id=<?= (int) $a->id ?>">Editar</a>
        <a href="index.php?controller=agente&amp;action=eliminar&amp;id=<?= (int) $a->id ?>"
           onclick="return confirm('¿Eliminar este agente?');">Eliminar</a>
    </td>
</tr>
<?php endwhile; endif; ?>

</tbody>
</table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
