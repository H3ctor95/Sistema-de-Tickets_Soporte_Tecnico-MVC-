<h1>Panel Administrador</h1>

<p>Bienvenido <?= $_SESSION['usuario']->nombre ?></p>

<a href="index.php?controller=usuario&action=index">Usuarios</a><br>
<a href="index.php?controller=agente&action=index">Agentes</a><br>
<a href="index.php?controller=categoria&action=index">Categorías</a><br>
<a href="index.php?controller=estado&action=index">Estados</a><br>
<a href="index.php?controller=ticket&action=index">Tickets</a><br>

<a href="index.php?controller=auth&action=logout">Cerrar sesión</a>