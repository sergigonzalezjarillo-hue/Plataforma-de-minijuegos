<h1>Catálogo de minijuegos</h1>

<?php if (empty($juegos)): ?>
    <p>Todavía no hay juegos subidos</p>
<?php else: ?>
    <?php foreach ($juegos as $juego): ?>
        <article class="tarjeta-juego">
            <p><strong>Título:</strong> <?= htmlspecialchars($juego['titulo'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Autor:</strong> <?= htmlspecialchars($juego['autor'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($juego['categoria'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($juego['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><a href="<?= htmlspecialchars($juego['archivo'], ENT_QUOTES, 'UTF-8') ?>" download>Descargar ZIP</a></p>
        </article>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>
