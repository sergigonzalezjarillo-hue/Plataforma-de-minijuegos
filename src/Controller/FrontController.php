<?php
declare(strict_types=1);

class FrontController
{
    // Lista blanca de rutas permitidas: accion => [Controlador, metodo]
    private array $rutas = [
        'home'     => ['HomeController', 'index'],
        'registro' => ['AuthController', 'registro'],
        'login'    => ['AuthController', 'login'],
        'logout'   => ['AuthController', 'logout'],
        'subir'    => ['JuegoController', 'subir'],
        'juegos'   => ['JuegoController', 'listar'],
    ];

    /**
     * Lee la acción solicitada por GET, busca en la lista blanca y ejecuta el controlador.
     */
    public function despachar(): void
    {
        $accion = $_GET['accion'] ?? 'home';

        if (!isset($this->rutas[$accion])) {
            $error = new ErrorController();
            $error->error404();
            return;
        }

        [$nombreControlador, $metodo] = $this->rutas[$accion];

        $controlador = new $nombreControlador();
        $controlador->$metodo();
    }
}
