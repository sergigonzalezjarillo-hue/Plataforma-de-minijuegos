<h1>Subir nuevo minijuego</h1>

<form action="index.php?accion=subir" method="post" enctype="multipart/form-data">
    <div>
        <label for="titulo">Título del juego:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($datos['titulo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <?php if (isset($errores['titulo'])): ?>
            <p class="error"><?= htmlspecialchars($errores['titulo'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($datos['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        <?php if (isset($errores['descripcion'])): ?>
            <p class="error"><?= htmlspecialchars($errores['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria">
            <option value="">-- Selecciona una categoría --</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>" <?= (($datos['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errores['categoria'])): ?>
            <p class="error"><?= htmlspecialchars($errores['categoria'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="archivo">Archivo ZIP (máx. 10 MB):</label>
        <input type="file" id="archivo" name="archivo" accept=".zip">
        <?php if (isset($errores['archivo'])): ?>
            <p class="error"><?= htmlspecialchars($errores['archivo'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <button type="submit">Subir juego</button>
</form>
