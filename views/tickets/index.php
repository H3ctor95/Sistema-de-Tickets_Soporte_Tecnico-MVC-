<h1>Tickets</h1>

<a href="index.php?controller=ticket&action=crear">Nuevo Ticket</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Categoría</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

<?php while($t = $tickets->fetch_object()): ?>
<tr>
    <td><?= $t->id ?></td>
    <td><?= $t->titulo ?></td>
    <td><?= $t->categoria_nombre ?></td>
    <td><?= $t->estado_nombre ?></td>
    
    <td>
        <a href="index.php?controller=ticket&action=editar&id=<?= $t->id ?>">Editar</a>
        <a href="index.php?controller=ticket&action=eliminar&id=<?= $t->id ?>">Eliminar</a>
        <a href="index.php?controller=ticket&action=ver&id=<?= $t->id ?>">Ver</a>

        <?php if($t->estado_id == 3): ?> <!-- Espera aprobación -->
            <br>
            <a href="index.php?controller=ticket&action=aprobar&id=<?= $t->id ?>">
                Aprobar
            </a>

            <a href="index.php?controller=ticket&action=rechazar&id=<?= $t->id ?>">
                Rechazar
            </a>
        <?php endif; ?>
    </td>

</tr>
<?php endwhile; ?>

</table>

<a href="index.php?controller=auth&action=logout">Cerrar sesión</a>