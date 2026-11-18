<?php
declare(strict_types=1);

class JuegoModel
{
    private string $rutaJson;
    private string $rutaUploads;

    public function __construct(string $rutaJson, string $rutaUploads)
    {
        $this->rutaJson = $rutaJson;
        $this->rutaUploads = $rutaUploads;
    }

    /**
     * Devuelve la lista de juegos almacenados en juegos.json ([] si no existe o está vacío).
     */
    public function todos(): array
    {
        if (!file_exists($this->rutaJson)) {
            return [];
        }

        $contenido = file_get_contents($this->rutaJson);
        if ($contenido === false || trim($contenido) === '') {
            return [];
        }

        $datos = json_decode($contenido, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
            throw new RuntimeException('Error al leer el fichero JSON de juegos.');
        }

        return $datos;
    }

    /**
     * Mueve el ZIP subido con un nombre único y guarda los metadatos en juegos.json.
     */
    public function guardar(array $datos, string $rutaTemporal): void
    {
        // 1. Crear carpeta de subidas si no existe
        if (!is_dir($this->rutaUploads)) {
            mkdir($this->rutaUploads, 0755, true);
        }

        // 2. Generar un nombre único propio en disco
        $nombreUnico = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.zip';
        $rutaDestino = $this->rutaUploads . '/' . $nombreUnico;

        // 3. Mover el fichero temporal
        if (!move_uploaded_file($rutaTemporal, $rutaDestino)) {
            throw new RuntimeException('No se pudo guardar el archivo ZIP en el servidor.');
        }

        // 4. Crear carpeta data/ si no existe y guardar en juegos.json
        $carpetaData = dirname($this->rutaJson);
        if (!is_dir($carpetaData)) {
            mkdir($carpetaData, 0755, true);
        }

        $juegos = $this->todos();

        $nuevoJuego = [
            'titulo'          => $datos['titulo'],
            'descripcion'     => $datos['descripcion'],
            'autor'           => $datos['autor'],
            'categoria'       => $datos['categoria'],
            'archivo'         => 'uploads/juegos/' . $nombreUnico,
            'nombre_original' => $datos['nombre_original'],
        ];

        $juegos[] = $nuevoJuego;

        $json = json_encode($juegos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->rutaJson, $json, LOCK_EX);
    }
}
