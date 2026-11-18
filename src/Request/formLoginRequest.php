<?php
declare(strict_types=1);

class formLoginRequest
{
    private string $email;
    private string $password;
    private array $errores = [];

    public function __construct(array $post, array$files = [])
    {
        $this->email = filter_var(trim((string)($post['email'] ?? '')), FILTER_SANITIZE_EMAIL);
        $this->password = (string)($post['password'] ?? '');
    }

    /**
     * Valida los datos del formulario de inicio de sesión.
     */
    public function esValido(): bool
    {
        $this->errores = [];

        if ($this->email === '') {$this->agregarError('email', 'El correo electrónico es obligatorio.');
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {$this->agregarError('email', 'El formato del correo electrónico no es válido.');
        }

        if (trim($this->password) === '') {$this->agregarError('password', 'La contraseña es obligatoria.');
        }

        return empty($this->errores);
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function agregarError(string $campo, string$mensaje): void
    {
        $this->errores[$campo] =$mensaje;
    }

    public function datos(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
