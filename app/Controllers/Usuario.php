<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Rol.php';

use MVC\Router;
use Models\Usuario;
use Models\Rol;

class Controlador_Usuario
{
    public static function Listar(Router $router)
    {
        $rolModel = new Usuario();
        $usuarios = $rolModel->obtenerUsuarios();
        $router->render("usuario/listar", ['usuarios' => $usuarios]);
    }

    public static function Actualizar(Router $router)
    {
        $id = $_SESSION['id'];
        $user = (new Usuario())->Detalle($id);
        $datos = [
            'usuario' => $user,
            'rol'=>$user['rol_id'],
            'roles' => (new Rol())->obtener()
        ];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rol=$_POST['rol'];
            $datos['rol']=$rol;
            $respuesta= (new Usuario())->actualizarRol($user['id'], $rol);
            $datos['bd']= $respuesta;
        }
        $router->render("usuario/asignar", $datos);
    }
}
