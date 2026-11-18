<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../autoloader.php';

try {
    $front = new FrontController();
    $front->despachar();
} catch (Throwable $e) {
    echo $e->getMessage();
    $error = new ErrorController();
    $error->error500();
}