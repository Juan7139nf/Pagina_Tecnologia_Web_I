<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Servicio.php';

use MVC\Router;
use Models\Servicio;

class Controlador_Servicio
{
    public static function Listar(Router $router)
    {
        $servicioModel = new Servicio();
        $datos = [];

        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $id = $_SESSION['id'];
            $estado = new Servicio();
            $resultado = $estado->estado($id);
            $datos['db'] = $resultado;
            unset($_SESSION['op']);
        }

        $servicios = $servicioModel->obtener();
        $datos['servicios'] = $servicios;

        $router->render("servicio/listar", $datos);
    }

    public static function Crear(Router $router)
    {
        $servicio = new Servicio();
        $datos = [
            'accion' => 'crear',
            'servicio' => $servicio
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $servicio = new Servicio($_POST['dato']);
            $nombre = $_POST['dato']['nombre'] ?? null;
            $descripcion = $_POST['dato']['descripcion'] ?? null;
            $precio = $_POST['dato']['precio'] ?? null;

            if ($nombre && $precio !== null && $precio > 0) {
                $servicioModel = new Servicio();
                $resultado = $servicioModel->insertar($nombre, $descripcion, $precio);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "Los campos 'nombre' y 'precio' son requeridos.";
            }
            $datos['servicio'] = $servicio;
        }

        $router->render("servicio/crear", $datos);
    }

    public static function Actualizar(Router $router)
    {
        $servicioModel = new Servicio();
        $id = $_SESSION['id'] ?? null;
        $datos = [
            'accion' => 'editar',
            'id' => $id
        ];

        if ($id && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
            $servicio = $servicioModel->detalle($id);
            $datos['servicio'] = $servicio;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $servicio = new Servicio($_POST['dato']);
            $nombre = $_POST['dato']['nombre'] ?? null;
            $descripcion = $_POST['dato']['descripcion'] ?? null;
            $precio = $_POST['dato']['precio'] ?? null;

            if ($nombre && $precio !== null && $precio > 0) {
                $resultado = $servicioModel->editar($id, $nombre, $descripcion, $precio);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "Los campos 'nombre' y 'precio' son requeridos.";
            }
            $datos['servicio'] = $servicio;
        }

        $router->render("servicio/editar", $datos);
    }
}
