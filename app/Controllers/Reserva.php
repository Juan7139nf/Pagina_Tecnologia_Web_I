<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Reserva.php';
require_once __DIR__ . '/../Models/Servicio.php';

use MVC\Router;
use Models\Reserva;
use Models\Servicio;

class Controlador_Reserva
{
    public static function Listar(Router $router)
    {
        $Model = new Reserva();
        $cookie_valores = LeerCookie();
        $datos = [];
        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $id = $_SESSION['idf'];
            $estado = new Reserva();
            $resultado = $estado->estado($id);
            $datos['db'] = $resultado;
            unset($_SESSION['op']);
        }
        $reservas = $Model->obtenerreservas($cookie_valores['id']);
        $datos['reservas']=$reservas;
        $router->render("reserva/listar", $datos);
    }

    public static function Crear(Router $router)
    {
        $id = $_SESSION['id'] ?? null;
        $cookie_valores = LeerCookie();
        $datos=[
            'servicio'=> (new Servicio())->detalle($id),
            'reserva'=> (new Reserva()),
            'usuario'=> $cookie_valores
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reserva = new Reserva($_POST['dato']);
            $fecha_cita = $_POST['dato']['fecha_cita'] ?? null;
            $comentario = $_POST['dato']['comentario'] ?? null;

            if ($fecha_cita) {
                $model = new Reserva();
                $resultado = $model->insertar($cookie_valores['id'], $id, $fecha_cita, $comentario);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'fecha cita' es requerido.";
            }
            $datos['reserva'] = $reserva;
        }
        $router->render("reserva/crear", $datos);
    }
    
    public static function Actualizar(Router $router)
    {
        $servicioModel = new Reserva();
        $id = $_SESSION['idf'] ?? null;
        $datos = [
            'id' => $id
        ];

        if ($id && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
            $servicio = $servicioModel->detalle($id);
            $datos['reserva'] = $servicio;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $servicio = new Reserva($_POST['dato']);            
            $fecha_cita = $_POST['dato']['fecha_cita'] ?? null;
            $comentario = $_POST['dato']['comentario'] ?? null;

            if ($fecha_cita) {
                $model = new Reserva();
                $resultado = $model->editar($id, $fecha_cita, $comentario);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'fecha cita' es requerido.";
            }
            $datos['reserva'] = $servicio;
        }

        $router->render("reserva/editar", $datos);
    }
    
    public static function ListarTodo(Router $router)
    {
        $Model = new Reserva();
        $datos = [];
        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $id = $_SESSION['idf'];
            $estado = new Reserva();
            $resultado = $estado->confirmarReserva($id);
            $datos['db'] = $resultado;
            unset($_SESSION['op']);
        }
        $reservas = $Model->obtener();
        $datos['reservas']=$reservas;
        $router->render("reserva/listar_todo", $datos);
    }
}
