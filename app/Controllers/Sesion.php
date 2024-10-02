<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Sesion.php';

use MVC\Router;
use Models\Sesion;

class Controlador_Sesion
{
    public static function Iniciar(Router $router)
    {
        $sesion = new Sesion();
        $datos = [
            'user' => $sesion
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sesion = new Sesion($_POST['user']);
            $email = $_POST['user']['email'] ?? null;
            $password = $_POST['user']['password'] ?? null;
            if ($email) {
                $sesionModel = new Sesion();
                $resultado = $sesionModel->Login($email, $password);
                $datos['usuario'] = $resultado;
            } else {
                $datos['error'] = "El campo 'email' es requerido.";
            }
            $datos['user'] = $sesion;
        }
        $router->render("sesion/login", $datos);
        /*var_dump($sesion);
        echo 'login';*/
    }

    public static function Registar(Router $router)
    {
        $sesion = new Sesion();
        $datos = [
            'user' => $sesion
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sesion = new Sesion($_POST['user']);
            $nombre = $_POST['user']['nombre'] ?? null;
            $apellido_paterno = $_POST['user']['apellido_paterno'] ?? null;
            $apellido_materno = $_POST['user']['apellido_materno'] ?? null;
            $email = $_POST['user']['email'] ?? null;
            $password = $_POST['user']['password'] ?? null;
            if ($nombre && $apellido_materno && $email && $password) {
                $sesionModel = new Sesion();
                $resultado = $sesionModel->RegistrarUsuario($nombre, $apellido_paterno, $apellido_materno, $email, $password);
                $datos['usuario'] = $resultado;
            } else {
                $datos['error'] = "Los campos 'nombre', 'apellido_materno', 'email' y 'password' son requeridos.";
            }
            $datos['user'] = $sesion;
        }
        $router->render("sesion/register", $datos);
        /*var_dump($sesion);
        echo 'login';*/
    }

    public static function Informacion(Router $router)
    {
        $sesion = new Sesion();
        $cookie_valores = LeerCookie();
        $datos = [
            'user' => $sesion,
            'cookie_valores' => $cookie_valores
        ];
        $router->render("sesion/informacion", $datos);
        /*var_dump($sesion);
        echo 'login';*/
    }

    public static function Editar(Router $router)
    {
        $sesion = new Sesion();
        $cookie_valores = LeerCookie();
        $user_id = $cookie_valores['id'] ?? null;
        if ($user_id && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
            $sesion = $sesion->obtenerUsuario($user_id);
        }
        $datos = [
            'user' => $sesion,
            'cookie_valores' => $cookie_valores
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sesion = new Sesion($_POST['user']);
            $nombre = $_POST['user']['nombre'] ?? null;
            $apellido_paterno = $_POST['user']['apellido_paterno'] ?? null;
            $apellido_materno = $_POST['user']['apellido_materno'] ?? null;
            $email = $_POST['user']['email'] ?? null;
            $estado = $_POST['user']['estado'] ?? null;

            if ($nombre && $apellido_materno && $email) {
                $v = false;
                if ($cookie_valores['email'] != $email)
                    $v = true;
                $sesionModel = new Sesion();
                $resultado = $sesionModel->EditarUsuario($cookie_valores['id'], $nombre, $apellido_paterno, $apellido_materno, $email, $estado, $v);
                $datos['usuario'] = $resultado;
            } else {
                $datos['error'] = "Los campos 'nombre', 'apellido_materno' y 'email' son requeridos.";
            }
            $datos['user'] = $sesion;
        }
        $router->render("sesion/editar", $datos);
        /*var_dump($sesion);
        echo 'login';*/
    }


    public static function Password(Router $router)
    {
        $sesion = new Sesion();
        $datos = [
            'user' => $sesion
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cookie_valores = LeerCookie();
            $sesion = new Sesion($_POST['user']);
            $password = $_POST['user']['nombre'] ?? null;
            $password1 = $_POST['user']['apellido_paterno'] ?? null;
            $password2 = $_POST['user']['apellido_materno'] ?? null;
            $email = $cookie_valores['email'];

            if ($password1 == $password2) {
                $sesionModel = new Sesion();
                $resultado = $sesionModel->Password($email, $password, $password1);
                $datos['usuario'] = $resultado;
            } else {
                $datos['error'] = "Las nueva contraseñas no coinciden.";
            }
            $datos['user'] = $sesion;
        }
        $router->render("sesion/password", $datos);
        /*var_dump($sesion);
        echo 'login';*/
    }
}
