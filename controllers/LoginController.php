<?php

namespace Controller;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    //Iniciar y cerrar sesión
    public static function login(Router $router)
    {
        $alertas = [];
        $auth = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    
                    //Revisar confirmacion y password
                    $confirmacion = $usuario->confirmadoAndPassword($auth->password);
                    if ($confirmacion) {
                        session_start();

                        //Establecer autenticación
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = "$usuario->nombre $usuario->apellido";
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redirección
                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = true;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }

            $alertas = Usuario::getAlertas();
        }
        $router->render("auth/login", [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout(Router $router)
    {
        session_start();
        $_SESSION = [];

        header('Location: /');
        
        $router->render("auth/logout", []);
    }

    //Crear cuenta
    public static function crear(Router $router)
    {
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarUsuario();

            if (empty($alertas)) {
                $resultado = $usuario->usuarioExiste();

                if ($resultado->num_rows) {
                    //Usuario registrado
                    $alertas = Usuario::getAlertas();
                } else {
                    //No registrado 
                    $usuario->hashPassword();
                    $usuario->crearToken();

                    $mail = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $mail->enviarConfirmacion();

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render("auth/crear-cuenta", [
            'usuario' => $usuario,
            'alertas' => $alertas ?? [],
        ]);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (!$usuario) {
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Tu cuenta ha sido confirmada');
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar-cuenta", [
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render("auth/mensaje", []);
    }

    //Recuperar contraseña
    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarDato('email');
            if (empty($alertas)) {
                $resultado = $usuario->where('email', $usuario->email);

                if ($resultado->confirmado === '1') {
                    if (!is_null($resultado)) {
                        //Si hay correo
                        $resultado->crearToken();
                        $resultado->guardar();

                        $mail = new Email($resultado->email, $resultado->nombre, $resultado->token);
                        $mail->enviarRecuperacion();

                        Usuario::setAlerta('exito', 'Te hemos enviado un correo con las instrucciones.');
                        $alertas = Usuario::getAlertas();
                    } else {
                        Usuario::setAlerta('error', 'El email no esta registrado.');
                        $alertas = Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'La cuenta no ha sido confirmada.');
                    $alertas = Usuario::getAlertas();
                }
            }
        }
        $router->render("auth/olvide", [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $validacion = false;

        $usuario = Usuario::where('token', $token);
        if (!is_null($usuario)) {
            $validacion = true;
        } else {
            Usuario::setAlerta('error', 'Token no válido.');
            $alertas = Usuario::getAlertas();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $password->validarPassword();

            $alertas = $password->getAlertas();

            if (empty($alertas)) {
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();

                if ($resultado) {
                    header('Location: /');
                }
            }
        }
        $router->render("auth/recuperar", [
            'alertas' => $alertas,
            'validacion' => $validacion
        ]);
    }
}
