<?php
$tituloPagina = 'Tickets nuevos';
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_agente.php';
?>

<h1>Tikets nuevos (sin asignar)</h1>
<p>Ordenados de mayor a menor prioridad. Pulsa <strong>Ver</strong> para revisar el caso y <strong>Tomar ticket</strong> dentro del detalle para iniciar.</p>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'ocupado'): ?>
<p class="msg msg-error">Ese tiket ya fue tomado por otro agente.</p>
<?php endif; ?>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Título</th>
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
    <td><?= htmlspecialchars($t->categoria_nombre ?? '') ?></td>
    <td><?= htmlspecialchars($t->prioridad_nombre ?? '') ?></td>
    <td><?= htmlspecialchars($t->estado_nombre ?? '') ?></td>
    <td class="table-actions">
        <a href="index.php?controller=agente&amp;action=verTicket&amp;id=<?= (int) $t->id ?>">Ver</a>
    </td>
</tr>
<?php endwhile; endif; ?>

</tbody>
</table>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
