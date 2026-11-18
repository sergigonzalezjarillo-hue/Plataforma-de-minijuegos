<?php
declare(strict_types=1);

class JuegoController
{
    /**
     * Gestiona la subida de un minijuego en formato ZIP (GET muestra, POST procesa).
     */
    public function subir(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Pages::render('subir_juego', [
                'errores'    => [],
                'datos'      => [],
                'categorias' => CATEGORIAS,
            ]);
            return;
        }

        $request = new formSubirJuegoRequest($_POST, $_FILES);

        if (!$request->esValido()) {
            Pages::render('subir_juego', [
                'errores'    => $request->errores(),
                'datos'      => $request->datos(),
                'categorias' => CATEGORIAS,
            ]);
            return;
        }

        $modelo = new JuegoModel(RUTA_JUEGOS, RUTA_UPLOADS);
        $modelo->guardar([
            'titulo'          => $request->titulo(),
            'descripcion'     => $request->descripcion(),
            'autor'           => 'invitado',
            'categoria'       => $request->categoria(),
            'nombre_original' => $request->nombreOriginal(),
        ], $request->rutaTemporal());

        header('Location: index.php?accion=juegos');
        exit;
    }

    /**
     * Muestra el listado de juegos almacenados en data/juegos.json.
     */
    public function listar(): void
    {
        $modelo = new JuegoModel(RUTA_JUEGOS, RUTA_UPLOADS);
        $juegos = $modelo->todos();

        Pages::render('juegos', [
            'juegos' => $juegos,
        ]);
    }
}
