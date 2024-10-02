<?php

namespace MVC;

class Router
{
    public function __construct()
    {
        //echo "Construyendo las rutas";
    }

    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function ComprobarRutas()
    {
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        if ($metodo == 'GET') {
            $fn = $this->getRoutes[$urlActual] ?? null;
        } 
        else if ($metodo == 'POST') {
            $fn = $this->postRoutes[$urlActual] ?? null;
        }
        if ($fn) {
            call_user_func($fn, $this);
        } else {
            ob_start();
            include __DIR__ . "/app/Views/view/error.php";
            $contenido = ob_get_clean();
            include_once __DIR__ . "/app/Views/layout.php";
        }
    }

    public function render($ubicacion, $datos = [])
    {
        ob_start();
        foreach ($datos as $key => $value) {
            $$key = $value;
        }
        include __DIR__ . "/app/Views/$ubicacion.php";
        $contenido = ob_get_clean();
        include_once __DIR__ . "/app/Views/layout.php";
    }
}
