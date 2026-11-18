<?php
declare(strict_types=1);

class HomeController
{
    /**
     * Muestra la página principal adaptada al estado del usuario.
     */
    public function index(): void
    {
        $bienvenido = isset($_GET['bienvenido']) ? trim((string)$_GET['bienvenido']) : '';
        $usuario = $bienvenido !== '' ? $bienvenido : null;

        Pages::render('home', [
            'usuario' => $usuario,
        ]);
    }
}
