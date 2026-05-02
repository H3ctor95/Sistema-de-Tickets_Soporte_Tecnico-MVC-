<?php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../config/tablas.php';

$db = Conexion::conectar();

$tik = db_tbl('tikets');
$tas = db_tbl('asignaciones');
$tu = db_tbl('usuarios');
$ta = db_tbl('agentes');

$tickets = $db->query("SELECT COUNT(*) AS total FROM `$tik` WHERE activo = 1")->fetch_object();

$pendientes = $db->query(
    "SELECT COUNT(*) AS total FROM `$tik` t
     WHERE t.activo = 1 AND t.estado_id = 1
       AND NOT EXISTS (
           SELECT 1 FROM `$tas` x WHERE x.tiket_id = t.id AND x.activo = 1
       )"
)->fetch_object();

$usuarios = $db->query("SELECT COUNT(*) AS total FROM `$tu` WHERE activo = 1")->fetch_object();
$agentes = $db->query("SELECT COUNT(*) AS total FROM `$ta` WHERE activo = 1")->fetch_object();

$tituloPagina = 'Panel administrador';
$mainContentClass = 'full-width';
include __DIR__ . '/../partials/head.php';
?>

<h1>Panel administrador</h1>
<p>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']->nombre) ?></p>

<h2>Resumen</h2>
<div class="dashboard-stats">
<div class="stat-card"><small>Tikets activos</small><strong><?= (int) $tickets->total ?></strong></div>
<div class="stat-card"><small>Abiertos sin asignar</small><strong><?= (int) $pendientes->total ?></strong></div>
<div class="stat-card"><small>Usuarios activos</small><strong><?= (int) $usuarios->total ?></strong></div>
<div class="stat-card"><small>Agentes activos</small><strong><?= (int) $agentes->total ?></strong></div>
</div>

<hr>

<h2>Tareas principales</h2>
<ul class="task-list">
<li><a href="index.php?controller=usuario&amp;action=crear"><strong>Crear nuevo usuario</strong></a> — credenciales para personal de la empresa</li>
<li><a href="index.php?controller=agente&amp;action=crear"><strong>Crear nuevo agente</strong></a> — soporte técnico</li>
<li><a href="index.php?controller=ticket&amp;action=index"><strong>Ver estado de todos los tikets</strong></a> — quién creó, quién atiende y comentarios en “Ver”</li>
</ul>

<h2>Otras opciones</h2>
<p class="actions-row admin-subnav">
    <a class="button button-ghost" href="index.php?controller=usuario&amp;action=index">Usuarios</a>
    <a class="button button-ghost" href="index.php?controller=agente&amp;action=index">Agentes</a>
    <a class="button button-ghost" href="index.php?controller=categoria&amp;action=index">Categorías</a>
    <a class="button button-ghost" href="index.php?controller=estado&amp;action=index">Estados</a>
</p>

<p class="footer-actions"><a href="index.php?controller=auth&amp;action=logout">Cerrar sesión</a></p>

<?php include __DIR__ . '/../partials/footer.php'; ?>
