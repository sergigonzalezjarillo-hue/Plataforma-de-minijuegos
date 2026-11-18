<?php
declare(strict_types=1);

spl_autoload_register(function (string $clase): void {
    // 1. Si la clase usa namespace (ej: App\Controller\HomeController o Controller\HomeController)
    $claseLimpia = str_replace(['App\\', '\\'], ['', '/'], $clase);
    $rutaConNamespace = __DIR__ . '/src/' . $claseLimpia . '.php';

    if (file_exists($rutaConNamespace)) {
        require_once $rutaConNamespace;
        return;
    }

    // 2. Si la clase no usa namespace, la buscamos en las subcarpetas de src/
    $carpetas = ['Controller', 'Core', 'Model', 'Request'];
    foreach ($carpetas as $carpeta) {
        $rutaSinNamespace = __DIR__ . '/src/' . $carpeta . '/' . $clase . '.php';
        if (file_exists($rutaSinNamespace)) {
            require_once $rutaSinNamespace;
            return;
        }
    }
});
