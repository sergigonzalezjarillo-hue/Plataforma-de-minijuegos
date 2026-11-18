<?php
declare(strict_types=1);

class AuthController
{
    /**
     * Gestiona el formulario de registro de jugadores (GET muestra, POST procesa).
     */
    public function registro(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Pages::render('registro', [
                'errores' => [],
                'datos'   => [],
            ]);
            return;
        }

        $request = new formRegistroRequest($_POST);

        if ($request->esValido()) {
            $modelo = new JugadorModel(RUTA_JUGADORES);

            if ($modelo->existeUsername($request->username())) {
                $request->agregarError('username', 'Ese nombre de usuario ya está registrado.');
            }

            if ($modelo->existeEmail($request->email())) {
                $request->agregarError('email', 'Ese correo electrónico ya está registrado.');
            }
        }

        $errores = $request->errores();

        if (!empty($errores)) {
            Pages::render('registro', [
                'errores' => $errores,
                'datos'   => $request->datos(),
            ]);
            return;
        }

        $modelo = new JugadorModel(RUTA_JUGADORES);
        $modelo->crear($request->username(), $request->email(), $request->password());

        $query = http_build_query([
            'accion'     => 'login',
            'registrado' => 1,
        ]);
        header('Location: index.php?' . $query);
        exit;
    }
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $mensajeExito = isset($_GET['registrado']) && $_GET['registrado'] === '1'
                ? 'Registro correcto, ya puedes iniciar sesión.'
                : null;

            Pages::render('login', [
                'errores'      => [],
                'datos'        => [],
                'mensajeExito' => $mensajeExito,
            ]);
            return;
        }

        $request = new formLoginRequest($_POST);
        $jugador = null;

        if ($request->esValido()) {
            $modelo = new JugadorModel(RUTA_JUGADORES);
            $jugador = $modelo->verificarCredenciales($request->email(), $request->password());

            if ($jugador === null) {
                $request->agregarError('general', 'Email o contraseña incorrectos');
            }
        }

        $errores = $request->errores();

        if (!empty($errores)) {
            Pages::render('login', [
                'errores'      => $errores,
                'datos'        => $request->datos(),
                'mensajeExito' => null,
            ]);
            return;
        }

        $query = http_build_query([
            'accion'     => 'home',
            'bienvenido' => $jugador['username'],
        ]);
        header('Location: index.php?' . $query);
        exit;
    }
    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header('Location: index.php?accion=home');
        exit;
    }
}
