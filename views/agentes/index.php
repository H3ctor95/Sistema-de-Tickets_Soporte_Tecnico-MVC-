<h1>Agentes</h1>

<a href="index.php?controller=agente&action=crear">Nuevo Agente</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Acciones</th>
</tr>

<?php while($a = $agentes->fetch_object()): ?>
<tr>
    <td><?= $a->id ?></td>
    <td><?= $a->nombre ?></td>
    <td><?= $a->email ?></td>
    <td>
        <a href="index.php?controller=agente&action=editar&id=<?= $a->id ?>">Editar</a>
        <a href="index.php?controller=agente&action=eliminar&id=<?= $a->id ?>">Eliminar</a>
    </td>
</tr>
<?php endwhile; ?>

</table>