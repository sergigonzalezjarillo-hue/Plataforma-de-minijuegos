<?php
declare(strict_types=1);

class Pages
{
    /**
     * Carga la cabecera común, la vista solicitada con sus datos y el pie común.
     */
    public static function render(string $vista, array $datos = []): void
    {
        $rutaVista = RUTA_VIEWS . '/' . $vista . '.php';

        if (!file_exists($rutaVista)) {
            throw new RuntimeException("La vista '$vista' no existe.");
        }

        extract($datos);

        require RUTA_VIEWS . '/header.php';
        require $rutaVista;
        require RUTA_VIEWS . '/footer.php';
    }
}