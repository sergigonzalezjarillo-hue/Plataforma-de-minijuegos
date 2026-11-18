<?php
declare(strict_types=1);

// Rutas principales del proyecto
define('RUTA_VIEWS', __DIR__ . '/views');
define('RUTA_JUGADORES', __DIR__ . '/data/jugadores.json');
define('RUTA_JUEGOS', __DIR__ . '/data/juegos.json');
define('RUTA_UPLOADS', __DIR__ . '/public/uploads/juegos');

// Configuración de subida de archivos y categorías permitidas
define('MAX_ZIP', 10 * 1024 * 1024); // 10 MB en bytes
define('CATEGORIAS', ['Aventura', 'Estrategia', 'Puzzle', 'Arcade']);
