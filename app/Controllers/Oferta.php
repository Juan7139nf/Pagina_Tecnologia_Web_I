<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Oferta.php';
require_once __DIR__ . '/../Models/Servicio.php';

use MVC\Router;
use Models\Oferta;
use Models\Servicio;

class Controlador_Oferta
{
    public static function Listar(Router $router)
    {
        $ofertaModel = new Oferta();
        $datos=[];
        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $id = $_SESSION['id'];
            $estado = new Oferta();
            $resultado = $estado->estado($id);
            $datos['db'] = $resultado;
            unset($_SESSION['op']);
        }

        $ofertas = $ofertaModel->obtener();
        $datos['ofertas']=$ofertas;
        $router->render("oferta/listar", $datos);
    }

    public static function Crear(Router $router)
    {
        $oferta = new oferta();

        $datos = [
            'accion' => 'crear',
            'oferta' => $oferta,
            'servicio'=> (new Servicio())->obtener()
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oferta = new oferta($_POST['dato']);
            $servicio = $_POST['dato']['servicio_id'] ?? null;
            $descripcion = $_POST['dato']['descripcion'] ?? null;
            $descuento = $_POST['dato']['descuento'] ?? null;
            $fecha_inicio = $_POST['dato']['fecha_inicio'] ?? null;
            $fecha_fin = $_POST['dato']['fecha_fin'] ?? null;

            if ($servicio && $fecha_inicio && $fecha_fin !== null) {
                $ofertaModel = new oferta();
                $resultado = $ofertaModel->insertar($servicio, $descripcion, $descuento,$fecha_inicio, $fecha_fin);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "Los campos 'servicio', 'fecha inicio' y 'fecha fin' son requeridos.";
            }
            $datos['oferta'] = $oferta;
        }
        $router->render("oferta/crear", $datos);
    }

    public static function Actualizar(Router $router)
    {
        $ofertaModel = new oferta();
        $id = $_SESSION['id'] ?? null;
        $datos = [
            'accion' => 'editar',
            'id' => $id,
            'servicio'=> (new Servicio())->obtener()
        ];

        if ($id && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
            $oferta = $ofertaModel->detalle($id);
            $datos['oferta'] = $oferta;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oferta = new oferta($_POST['dato']);
            $servicio = $_POST['dato']['servicio_id'] ?? null;
            $descripcion = $_POST['dato']['descripcion'] ?? null;
            $descuento = $_POST['dato']['descuento'] ?? null;
            $fecha_inicio = $_POST['dato']['fecha_inicio'] ?? null;
            $fecha_fin = $_POST['dato']['fecha_fin'] ?? null;

            if ($servicio && $fecha_inicio && $fecha_fin !== null) {
                $resultado = $ofertaModel->editar($id, $servicio, $descripcion, $descuento, $fecha_inicio, $fecha_fin);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "Los campos 'servicio', 'fecha inicio' y 'fecha fin' son requeridos.";
            }
            $datos['oferta'] = $oferta;
        }

        $router->render("oferta/editar", $datos);
    }
}
