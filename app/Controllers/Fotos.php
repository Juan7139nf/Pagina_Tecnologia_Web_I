<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Fotos.php';
require_once __DIR__ . '/../Models/Servicio.php';

use MVC\Router;
use Models\Foto;
use Models\Servicio;

class Controlador_Fotos
{
    public static function Listar(Router $router)
    {
        $fotoModel = new Foto();
        $id = $_SESSION['id'] ?? null;
        $datos = [];
        if (isset($_SESSION['op']) && $_SESSION['op'] == 'si') {
            $idf = $_SESSION['idf'];
            $estado = new Foto();
            $resultado = $estado->estado($idf);
            $datos['db'] = $resultado;
            unset($_SESSION['op']);
        }
        $servicio = (new Servicio())->detalle($id);
        $fotos = $fotoModel->obtenerPorServicio($id);
        $datos = [
            'fotos' => $fotos,
            'servicio' => $servicio
        ];
        $router->render("fotos/listar", $datos);
    }

    public static function Crear(Router $router)
    {
        $foto = new Foto();
        $datos = [
            'accion' => 'crear',
            'foto' => $foto
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $foto = new Foto($_POST['foto']);
            $urlFoto = $_POST['foto']['url'] ?? null;
            $servicioFoto = $_SESSION['id'] ?? null;

            $imagen = $_FILES['imagen'];

            if ($urlFoto && $servicioFoto) {
                $directorio_destino = 'public/uploads/';
                $nombre_archivo = basename($imagen['name']);
                $ruta_destino = $directorio_destino . $nombre_archivo;

                if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
                    $fotoModel = new Foto();
                    $resultado = $fotoModel->insertar($servicioFoto, $urlFoto);
                    $datos['db'] = $resultado;
                } else {
                    $datos['error'] = "Hubo un error al subir la imagen.";
                }
            } else {
                $datos['error'] = "El campo 'url' es obligatorio.";
            }
            $datos['foto'] = $foto;
        }
        $router->render("fotos/crear", $datos);
    }

    public static function Actualizar(Router $router)
    {
        $fotoModel = new Foto();
        $id = $_SESSION['idf']; // Supongo que el ID de la foto está en una sesión
        $foto = $fotoModel->detalle($id); // Obtener los detalles actuales de la foto
        $datos = [
            'accion' => 'editar',
            'foto' => $foto
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $urlFoto = $_POST['foto']['url'] ?? null;
            $imagen = $_FILES['imagen'];

            if (!empty($imagen['name'])) {
                $directorio_destino = 'public/uploads/';
                $nombre_archivo = basename($imagen['name']);
                $ruta_destino = $directorio_destino . $nombre_archivo;

                if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
                    $urlFoto = $nombre_archivo;
                } else {
                    $datos['error'] = "Error al subir la imagen.";
                    $router->render("fotos/editar", $datos);
                    return;
                }
            }

            if ($urlFoto) {
                $resultado = $fotoModel->editar($id, $urlFoto);
                $datos['db'] = $resultado;
            } else {
                $datos['error'] = "El campo 'url' es obligatorio.";
            }

            $datos['foto'] = $fotoModel->detalle($id);
        }

        $router->render("fotos/editar", $datos);
    }
}
