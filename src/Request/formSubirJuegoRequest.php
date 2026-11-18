<?php
declare(strict_types=1);

class formSubirJuegoRequest
{
    private string $titulo;
    private string $descripcion;
    private string $categoria;
    private ?array $archivo;
    private string $nombreOriginal = '';
    private string $rutaTemporal = '';
    private array $errores = [];

    public function __construct(array $post, array $files = [])
    {
        $this->titulo = strip_tags(trim((string)($post['titulo'] ?? '')));
        $this->descripcion = strip_tags(trim((string)($post['descripcion'] ?? '')));
        $this->categoria = trim((string)($post['categoria'] ?? ''));
        $this->archivo = $files['archivo'] ?? null;

        if (is_array($this->archivo) && isset($this->archivo['name'], $this->archivo['tmp_name'])) {
            $base = basename((string)$this->archivo['name']);
            $limpio = preg_replace('/[^a-zA-Z0-9\-.]/', '_', $base);
            $this->nombreOriginal = $limpio !== null && $limpio !== '' ? $limpio : 'juego.zip';
            $this->rutaTemporal = (string)$this->archivo['tmp_name'];
        }
    }

    /**
     * Valida los textos, la categoría y el fichero ZIP en el orden establecido.
     */
    public function esValido(): bool
    {
        $this->errores = [];

        // 1. Validar título
        if ($this->titulo === '') {
            $this->agregarError('titulo', 'El título del juego es obligatorio.');
        } elseif (mb_strlen($this->titulo) < 3 || mb_strlen($this->titulo) > 80) {
            $this->agregarError('titulo', 'El título debe tener entre 3 y 80 caracteres.');
        }

        // 2. Validar descripción
        if ($this->descripcion === '') {
            $this->agregarError('descripcion', 'La descripción del juego es obligatoria.');
        } elseif (mb_strlen($this->descripcion) < 10 || mb_strlen($this->descripcion) > 500) {
            $this->agregarError('descripcion', 'La descripción debe tener entre 10 y 500 caracteres.');
        }

        // 3. Validar categoría contra lista blanca estricta
        if ($this->categoria === '' || !in_array($this->categoria, CATEGORIAS, true)) {
            $this->agregarError('categoria', 'Debes seleccionar una categoría válida.');
        }

        // 4. Validar archivo ZIP
        $this->validarArchivo();

        return empty($this->errores);
    }

    private function validarArchivo(): void
    {
        // Paso 1: Comprobar que se envió un fichero y sin errores de subida
        if (!is_array($this->archivo) || !isset($this->archivo['error']) || $this->archivo['error'] === UPLOAD_ERR_NO_FILE) {
            $this->agregarError('archivo', 'Debes seleccionar un archivo ZIP.');
            return;
        }

        if ($this->archivo['error'] !== UPLOAD_ERR_OK) {
            $this->agregarError('archivo', 'Error al subir el archivo (puede superar el límite permitido por el servidor).');
            return;
        }

        // Paso 2: Comprobar que proviene de una subida HTTP real
        if ($this->rutaTemporal === '' || !is_uploaded_file($this->rutaTemporal)) {
            $this->agregarError('archivo', 'El archivo subido no es válido.');
            return;
        }

        // Paso 3: Comprobar extensión .zip en minúsculas
        $extension = strtolower(pathinfo((string)$this->archivo['name'], PATHINFO_EXTENSION));
        if ($extension !== 'zip') {
            $this->agregarError('archivo', 'Solo se permiten archivos con extensión .zip.');
            return;
        }

        // Paso 4: Comprobar tipo MIME real con finfo (nunca $_FILES['archivo']['type'])
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo !== false ? finfo_file($finfo, $this->rutaTemporal) : false;
        if ($finfo !== false) {
            finfo_close($finfo);
        }

        $mimesPermitidos = ['application/zip', 'application/x-zip-compressed'];
        if ($mime === false || !in_array($mime, $mimesPermitidos, true)) {
            $this->agregarError('archivo', 'El contenido del archivo no corresponde a un ZIP válido.');
            return;
        }

        // Paso 5: Comprobar tamaño máximo de 10 MB (MAX_ZIP)
        $tamano = (int)($this->archivo['size'] ?? 0);
        if ($tamano <= 0 || $tamano > MAX_ZIP) {
            $this->agregarError('archivo', 'El archivo ZIP no puede superar los 10 MB.');
        }
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function agregarError(string $campo, string $mensaje): void
    {
        $this->errores[$campo] = $mensaje;
    }

    public function datos(): array
    {
        return [
            'titulo'      => $this->titulo,
            'descripcion' => $this->descripcion,
            'categoria'   => $this->categoria,
        ];
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function descripcion(): string
    {
        return $this->descripcion;
    }

    public function categoria(): string
    {
        return $this->categoria;
    }

    public function nombreOriginal(): string
    {
        return $this->nombreOriginal;
    }

    public function rutaTemporal(): string
    {
        return $this->rutaTemporal;
    }
}
