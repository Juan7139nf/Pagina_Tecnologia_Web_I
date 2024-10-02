<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Contacto.php';
require_once __DIR__ . '/../Models/Usuario.php';

use MVC\Router;
use Models\Contacto;
use Models\Usuario;

class Controlador_Contacto
{
    public static function Listar(Router $router)
    {
        $contactoModel = new Contacto();
        $datos=[];
        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $id = $_SESSION['id'];
            $estado = new Contacto();
            $resultado = $estado->estado($id);
            $datos['db'] = $resultado;
            unset($_SESSION['op']);
        }

        $contactos = $contactoModel->obtener();
        $datos['contactos']=$contactos;
        $router->render("contacto/listar", $datos);
    }

    public static function Crear(Router $router)
    {
        $asunto='';
        $cookie_valores = LeerCookie();

        $datos = [
            'accion' => 'crear'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario_id = $cookie_valores['id'] ?? null;
            $asunto = $_POST['asunto'] ?? null;
            $asunto = trim($asunto);
            if ($usuario_id && $asunto !== '') {
                $contactoModel = new Contacto();
                $resultado = $contactoModel->insertar($usuario_id, $asunto);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'asunto' es requerido.";
            }
            $datos['usuario']=$usuario_id;
        }
        $datos['asunto'] = $asunto;
        $router->render("contacto/crear", $datos);
    }

    public static function Actualizar(Router $router)
    {
        $contactoModel = new Contacto();
        $id = $_SESSION['id'] ?? null;
        $datos = [
            'accion' => 'editar',
            'id' => $id,
            'usuarios'=> (new Usuario())->obtenerUsuarios()
        ];

        if ($id && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
            $contacto = $contactoModel->detalle($id);
            $datos['contacto'] = $contacto;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $contacto = new Contacto($_POST['dato']);
            $usuario_id = $_POST['dato']['usuario_id'] ?? null;
            $asunto = $_POST['dato']['asunto'] ?? null;

            if ($usuario_id) {
                $resultado = $contactoModel->editar($id, $usuario_id, $asunto);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'usuario' es requerido.";
            }
            $datos['contacto'] = $contacto;
        }

        $router->render("contacto/editar", $datos);
    }
}
