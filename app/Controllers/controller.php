<?php

namespace Controllers;

require_once __DIR__ . '/../Models/model.php';

use MVC\Router;
use Models\Model;

class Controlador
{
    public static function Servicio(Router $router)
    {
        $servicio = (new Model())->listar();
        $datos = [
            'servicio' => $servicio
        ];
        $router->render("view/servicio", $datos);
    }

    public static function Oferta(Router $router)
    {
        $servicio = (new Model())->listarOferta();
        $datos = [
            'servicio' => $servicio
        ];
        $router->render("view/oferta", $datos);
    }

    public static function Inicio(Router $router)
    {
        $datos = [
        ];
        $router->render("view/index", $datos);
    }
}
