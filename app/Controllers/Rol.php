<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Rol.php';

use MVC\Router;
use Models\Rol;

class Controlador_Rol
{
    public static function Listar(Router $router)
    {
        $rolModel = new Rol();
        $datos=[];
        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $id = $_SESSION['id'];
            $estado = new Rol();
            $resultado = $estado->estado($id);
            $datos['rol_db'] = $resultado;
            unset($_SESSION['op']);
        }
        $roles = $rolModel->obtener();
        
        $datos['roles']=$roles;
        $router->render("rol/listar", $datos);
    }

    public static function Crear(Router $router)
    {
        $rol = new Rol();
        $datos = [
            'accion' => 'crear',
            'rol' => $rol
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rol = new Rol($_POST['rol']);
            $nombreRol = $_POST['rol']['nombre'] ?? null;
            if ($nombreRol) {
                $rolModel = new Rol();
                $resultado = $rolModel->insertar($nombreRol);
                $datos['rol_db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'nombre' es requerido.";
            }
            $datos['rol'] = $rol;
        }
        $router->render("rol/crear", $datos);
        /*var_dump($rol);
        echo 'crear';*/
    }

    public static function Actualizar(Router $router)
    {
        $rol = new Rol();
        $id = $_SESSION['id'];
        if ($id && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
            $rol = $rol->detalle($id);
        }
        $datos = [
            'accion' => 'editar',
            'rol' => $rol,
            'id' => $id
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rol = new Rol($_POST['rol']);
            $nombreRol = $_POST['rol']['nombre'] ?? null;
            $estado = $_POST['rol']['estado'] ?? 0;
            if ($nombreRol) {
                $rolModel = new Rol();
                $resultado = $rolModel->editar($id, $nombreRol, $estado);
                $datos['rol_db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'nombre' es requerido.";
            }
            $datos['rol'] = $rol;
        }
        $router->render("rol/editar", $datos);
        /*var_dump($rol);
        echo $id;
        echo "Actualizar";*/
    }
}
