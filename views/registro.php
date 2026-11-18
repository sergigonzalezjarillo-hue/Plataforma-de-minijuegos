<h1>Registro de jugador</h1>

<form action="index.php?accion=registro" method="post">
    <div>
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($datos['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <?php if (isset($errores['username'])): ?>
            <p class="error"><?= htmlspecialchars($errores['username'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

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

    <div>
        <label for="password_confirm">Confirmar contraseña:</label>
        <input type="password" id="password_confirm" name="password_confirm">
        <?php if (isset($errores['password_confirm'])): ?>
            <p class="error"><?= htmlspecialchars($errores['password_confirm'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <button type="submit">Registrarse</button>
</form>

<p>¿Ya tienes cuenta? <a href="index.php?accion=login">Inicia sesión aquí</a></p>
