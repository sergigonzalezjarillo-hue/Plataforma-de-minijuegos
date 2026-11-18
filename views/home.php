<h1>Bienvenido a la Plataforma de Minijuegos</h1>

<?php if ($usuario === null): ?>
    <p>Explora los minijuegos de la comunidad o únete para compartir los tuyos.</p>
    <ul>
        <li><a href="index.php?accion=registro">Registrarse</a></li>
        <li><a href="index.php?accion=login">Iniciar sesión</a></li>
    </ul>
<?php else: ?>
    <p>¡Hola, <strong><?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?></strong>! Qué alegría verte por aquí.</p>
    <ul>
        <li><a href="index.php?accion=subir">Subir un nuevo juego</a></li>
        <li><a href="index.php?accion=juegos">Ver juegos subidos</a></li>
        <li><a href="index.php?accion=logout">Cerrar sesión</a></li>
    </ul>
<?php endif; ?>
