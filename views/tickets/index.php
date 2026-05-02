<?php
$tituloPagina = (int) $_SESSION['usuario']->rol_id === 1 ? 'Todos los tikets' : 'Mis tickets';
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_usuario.php';
?>

<h1><?= (int) $_SESSION['usuario']->rol_id === 1 ? 'Todos los tikets (administrador)' : 'Mis tickets' ?></h1>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Título</th>
    <?php if ((int) $_SESSION['usuario']->rol_id === 1): ?>
        <th>Creador</th>
    <?php endif; ?>
    <th>Agente</th>
    <th>Categoría</th>
    <th>Prioridad</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr></thead>
<tbody>
<?php if ($tickets): while ($t = $tickets->fetch_object()): ?>
<tr>
    <td><?= (int) $t->id ?></td>
    <td><?= htmlspecialchars($t->titulo) ?></td>
    <?php if ((int) $_SESSION['usuario']->rol_id === 1): ?>
        <td><?= htmlspecialchars($t->creador_nombre ?? '—') ?></td>
    <?php endif; ?>
    <td><?= htmlspecialchars($t->agente_asignado ?? '—') ?></td>
    <td><?= htmlspecialchars($t->categoria_nombre ?? '') ?></td>
    <td><?= htmlspecialchars($t->prioridad_nombre ?? '') ?></td>
    <td><?= htmlspecialchars($t->estado_nombre ?? '') ?></td>

    <td class="table-actions">
        <a href="index.php?controller=ticket&amp;action=ver&amp;id=<?= (int) $t->id ?>">Ver</a>

        <?php if ((int) $_SESSION['usuario']->rol_id === 1 || (int) $t->registrado_por_usuario_id === (int) $_SESSION['usuario']->id): ?>
            <a href="index.php?controller=ticket&amp;action=editar&amp;id=<?= (int) $t->id ?>">Editar</a>
            <a href="index.php?controller=ticket&amp;action=eliminar&amp;id=<?= (int) $t->id ?>"
               onclick="return confirm('¿Dar de baja este ticket?');">Eliminar</a>
        <?php endif; ?>

        <?php
        $es_dueno = isset($t->registrado_por_usuario_id)
            && (int) $t->registrado_por_usuario_id === (int) $_SESSION['usuario']->id;
        if ($es_dueno && (int) $t->estado_id === 3):
        ?>
            <span class="approve-links">
            <a href="index.php?controller=ticket&amp;action=aprobar&amp;id=<?= (int) $t->id ?>">Aprobar resolución</a>
            <a href="index.php?controller=ticket&amp;action=rechazar&amp;id=<?= (int) $t->id ?>"
               onclick="return confirm('¿Volver con el agente a revisar?');">Rechazar / pedir corrección</a>
            </span>
        <?php endif; ?>
    </td>

</tr>
<?php endwhile; endif; ?>
</tbody>
</table>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
