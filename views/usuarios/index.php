<?php
$tituloPagina = 'Usuarios';
include __DIR__ . '/../partials/head.php';
?>

<nav class="admin-subnav">
<a href="index.php?controller=admin&amp;action=dashboard">← Panel administrador</a>
</nav>

<h1>Usuarios</h1>

<p><a class="button" href="index.php?controller=usuario&amp;action=crear">Nuevo usuario</a></p>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Rol</th>
    <th>Acciones</th>
</tr></thead>
<tbody>

<?php if ($usuarios): while ($u = $usuarios->fetch_object()): ?>
<tr>
    <td><?= (int) $u->id ?></td>
    <td><?= htmlspecialchars($u->nombre) ?></td>
    <td><?= htmlspecialchars($u->email) ?></td>
    <td><?= htmlspecialchars($u->rol) ?></td>
    <td class="table-actions">
        <a href="index.php?controller=usuario&amp;action=editar&amp;id=<?= (int) $u->id ?>">Editar</a>
        <a href="index.php?controller=usuario&amp;action=eliminar&amp;id=<?= (int) $u->id ?>"
           onclick="return confirm('¿Eliminar?');">Eliminar</a>
    </td>
</tr>
<?php endwhile; endif; ?>
</tbody>
</table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
