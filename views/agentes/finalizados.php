<?php
$tituloPagina = 'Tickets finalizados';
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/_nav_agente.php';
?>

<h1>Finalizados</h1>
<p>Tikets cerrados en los que participaste.</p>

<div class="table-wrap">
<table class="table-data">
<thead><tr>
    <th>ID</th>
    <th>Título</th>
    <th>Categoría</th>
    <th>Prioridad</th>
    <th>Estado</th>
</tr></thead>
<tbody>

<?php if ($tickets): while ($t = $tickets->fetch_object()): ?>
<tr>
    <td><?= (int) $t->id ?></td>
    <td><?= htmlspecialchars($t->titulo) ?></td>
    <td><?= htmlspecialchars($t->categoria_nombre ?? '') ?></td>
    <td><?= htmlspecialchars($t->prioridad_nombre ?? '') ?></td>
    <td><?= htmlspecialchars($t->estado_nombre ?? '') ?></td>
</tr>
<?php endwhile; endif; ?>

</tbody>
</table>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
