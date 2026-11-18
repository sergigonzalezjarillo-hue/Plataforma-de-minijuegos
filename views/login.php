<h1>Iniciar sesión</h1>

<?php if (!empty($mensajeExito)): ?>
    <p class="exito"><?= htmlspecialchars($mensajeExito, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<?php if (isset($errores['general'])): ?>
    <p class="error"><?= htmlspecialchars($errores['general'], ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form action="index.php?accion=login" method="post">
    <div>
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($datos['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <?php if (isset($errores['email'])): ?>
            <p class="error"><?= htmlspecialchars($errores['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <?php if (isset($errores['password'])): ?>
            <p class="error"><?= htmlspecialchars($errores['password'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <button type="submit">Entrar</button>
</form>

<p>¿Aún no tienes cuenta? <a href="index.php?accion=registro">Regístrate aquí</a></p>
