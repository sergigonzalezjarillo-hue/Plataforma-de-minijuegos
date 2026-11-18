<?php
declare(strict_types=1);

class formRegistroRequest
{
    private string $username;
    private string $email;
    private string $password;
    private string $passwordConfirm;
    private array $errores = [];

    public function __construct(array $post, array $files = [])
    {
        $this->username = strip_tags(trim((string)($post['username'] ?? '')));
        $this->email = filter_var(trim((string)($post['email'] ?? '')), FILTER_SANITIZE_EMAIL);
        $this->password = (string)($post['password'] ?? '');
        $this->passwordConfirm = (string)($post['password_confirm'] ?? '');
    }

    /**
     * Valida todos los campos del formulario de registro.
     */
    public function esValido(): bool
    {
        $this->errores = [];

        // Validar nombre de usuario
        if ($this->username === '') {
            $this->agregarError('username', 'El nombre de usuario es obligatorio.');
        } elseif (mb_strlen($this->username) < 3 || mb_strlen($this->username) > 20) {
            $this->agregarError('username', 'El usuario debe tener entre 3 y 20 caracteres.');
        }

        // Validar correo electrónico
        if ($this->email === '') {
            $this->agregarError('email', 'El correo electrónico es obligatorio.');
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->agregarError('email', 'El formato del correo electrónico no es válido.');
        }

        // Validar contraseña
        if (trim($this->password) === '') {
            $this->agregarError('password', 'La contraseña es obligatoria.');
        } elseif (mb_strlen($this->password) < 8) {
            $this->agregarError('password', 'La contraseña debe tener al menos 8 caracteres.');
        }

        // Validar confirmación de contraseña
        if (trim($this->passwordConfirm) === '') {
            $this->agregarError('password_confirm', 'Debes confirmar la contraseña.');
        } elseif ($this->password !== $this->passwordConfirm) {
            $this->agregarError('password_confirm', 'Las contraseñas no coinciden.');
        }

        return empty($this->errores);
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function agregarError(string $campo, string $mensaje): void
    {
        $this->errores[$campo] = $mensaje;
    }

    /**
     * Devuelve los datos saneados para rellenar el formulario (sin contraseñas).
     */
    public function datos(): array
    {
        return [
            'username' => $this->username,
            'email'    => $this->email,
        ];
    }

    public function username(): string
    {
        return $this->username;
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
