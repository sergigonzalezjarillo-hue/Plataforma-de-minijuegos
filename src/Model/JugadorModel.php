<?php
declare(strict_types=1);

class JugadorModel
{
    private string $rutaJson;

    public function __construct(string $rutaJson)
    {
        $this->rutaJson = $rutaJson;
    }

    /**
     * Lee el fichero JSON de jugadores y devuelve un array.
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
            throw new RuntimeException('Error al leer el fichero JSON de jugadores.');
        }

        return $datos;
    }

    /**
     * Comprueba si ya existe un usuario con ese nombre (sin distinguir mayúsculas).
     */
    public function existeUsername(string $username): bool
    {
        $buscado = mb_strtolower($username);

        foreach ($this->todos() as $jugador) {
            if (mb_strtolower($jugador['username']) === $buscado) {
                return true;
            }
        }

        return false;
    }

    /**
     * Comprueba si ya existe un usuario con ese correo (sin distinguir mayúsculas).
     */
    public function existeEmail(string $email): bool
    {
        $buscado = mb_strtolower($email);

        foreach ($this->todos() as $jugador) {
            if (mb_strtolower($jugador['email']) === $buscado) {
                return true;
            }
        }

        return false;
    }

    /**
     * Crea la carpeta data/ si no existe y guarda el nuevo jugador con contraseña cifrada.
     */
    public function crear(string $username, string $email, string $password): void
    {
        $carpeta = dirname($this->rutaJson);
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        $jugadores = $this->todos();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $nuevoJugador = [
            'username' => $username,
            'email'    => $email,
            'password' => $passwordHash,
        ];

        $jugadores[] = $nuevoJugador;

        $json = json_encode($jugadores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->rutaJson, $json, LOCK_EX);
    }
    public function verificarCredenciales(string $email, string $password): ?array
    {
        $buscado = mb_strtolower($email);

        foreach ($this->todos() as $jugador) {
            if (mb_strtolower($jugador['email']) === $buscado) {
                if (password_verify($password, $jugador['password'])) {
                    return $jugador;
                }
                return null;
            }
        }

        return null;
    }
}
