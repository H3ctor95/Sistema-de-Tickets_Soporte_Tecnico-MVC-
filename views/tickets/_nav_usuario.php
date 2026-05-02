<nav class="nav-strip" aria-label="Navegación de usuario">
<span class="nav-strip-title"><?= (int) $_SESSION['usuario']->rol_id === 1 ? 'Administrador' : 'Usuario / empresa' ?></span>
<div class="nav-strip-links">
    <?php if ((int) $_SESSION['usuario']->rol_id === 1): ?>
        <a href="index.php?controller=admin&action=dashboard">← Panel administrador</a>
        <span class="nav-sep" aria-hidden="true">|</span>
    <?php endif; ?>
    <a href="index.php?controller=ticket&action=index"><?= (int) $_SESSION['usuario']->rol_id === 1 ? 'Todos los tikets' : 'Mis tickets' ?></a>
    <span class="nav-sep" aria-hidden="true">|</span>
    <a href="index.php?controller=ticket&action=crear">Crear nuevo ticket</a>
    <span class="nav-sep" aria-hidden="true">|</span>
    <a href="index.php?controller=auth&action=logout">Cerrar sesión</a>
</div>
</nav>
