<?php
require __DIR__ . "/router.php";
require_once __DIR__ . "/app/Controllers/Sesion.php";
require __DIR__ . "/app/Controllers/controller.php";
require __DIR__ . "/app/Controllers/Contacto.php";
require __DIR__ . "/app/Controllers/Fotos.php";
require __DIR__ . "/app/Controllers/Oferta.php";
require __DIR__ . "/app/Controllers/Reserva.php";
require __DIR__ . "/app/Controllers/Rol.php";
require __DIR__ . "/app/Controllers/Servicio.php";
require __DIR__ . "/app/Controllers/Usuario.php";

date_default_timezone_set('America/La_Paz');

use MVC\Router;
use Controllers\Controlador_Sesion;
use Controllers\Controlador;
use Controllers\Controlador_Contacto;
use Controllers\Controlador_Fotos;
use Controllers\Controlador_Oferta;
use Controllers\Controlador_Reserva;
use Controllers\Controlador_Rol;
use Controllers\Controlador_Servicio;
use Controllers\Controlador_Usuario;

$cookie_valores = LeerCookie();
session_start();

$router = new Router();
$router->get("/", [Controlador::class, "Inicio"]);
$router->get("/oferta", [Controlador::class, "Oferta"]);
$router->get("/servicio", [Controlador::class, "Servicio"]);

$router->get("/login", [Controlador_Sesion::class, "Iniciar"]);
$router->post("/login", [Controlador_Sesion::class, "Iniciar"]);

$router->get("/register", [Controlador_Sesion::class, "Registar"]);
$router->post("/register", [Controlador_Sesion::class, "Registar"]);

if ($cookie_valores == -1) {
    $router->get("/reserva", [Controlador_Sesion::class, "Iniciar"]);
    $router->get("/mis/reserva/crear", [Controlador_Sesion::class, "Iniciar"]);

    $router->get("/contacto", [Controlador_Sesion::class, "Iniciar"]);
}

if ($cookie_valores != -1) {
    $router->get("/informacion", [Controlador_Sesion::class, "Informacion"]);
    $router->get("/editar", [Controlador_Sesion::class, "Editar"]);
    $router->post("/editar", [Controlador_Sesion::class, "Editar"]);
    $router->get("/password", [Controlador_Sesion::class, "Password"]);
    $router->post("/password", [Controlador_Sesion::class, "Password"]);

    $router->get("/reserva", [Controlador_Reserva::class, "Listar"]);

    $router->get("/mis/reserva/crear", [Controlador_Reserva::class, "Crear"]);
    $router->post("/mis/reserva/crear", [Controlador_Reserva::class, "Crear"]);
    $router->get("/mis/reserva/actualizar", [Controlador_Reserva::class, "Actualizar"]);
    $router->post("/mis/reserva/actualizar", [Controlador_Reserva::class, "Actualizar"]);

    $router->get("/contacto", [Controlador_Contacto::class, "Crear"]);
    $router->post("/contacto", [Controlador_Contacto::class, "Crear"]);
}

if ($cookie_valores != -1 && $cookie_valores['rol_nombre'] != 'cliente') {
    $router->get("/admin/contacto", [Controlador_Contacto::class, "Listar"]);

    $router->get("/admin/oferta", [Controlador_Oferta::class, "Listar"]);
    $router->get("/admin/oferta/crear", [Controlador_Oferta::class, "Crear"]);
    $router->post("/admin/oferta/crear", [Controlador_Oferta::class, "Crear"]);
    $router->get("/admin/oferta/actualizar", [Controlador_Oferta::class, "Actualizar"]);
    $router->post("/admin/oferta/actualizar", [Controlador_Oferta::class, "Actualizar"]);

    $router->get("/admin/reserva", [Controlador_Reserva::class, "ListarTodo"]);

    $router->get("/admin/rol", [Controlador_Rol::class, "Listar"]);
    $router->get("/admin/rol/crear", [Controlador_Rol::class, "Crear"]);
    $router->post("/admin/rol/crear", [Controlador_Rol::class, "Crear"]);
    $router->get("/admin/rol/actualizar", [Controlador_Rol::class, "Actualizar"]);
    $router->post("/admin/rol/actualizar", [Controlador_Rol::class, "Actualizar"]);

    $router->get("/admin/servicio", [Controlador_Servicio::class, "Listar"]);
    $router->get("/admin/servicio/crear", [Controlador_Servicio::class, "Crear"]);
    $router->post("/admin/servicio/crear", [Controlador_Servicio::class, "Crear"]);
    $router->get("/admin/servicio/actualizar", [Controlador_Servicio::class, "Actualizar"]);
    $router->post("/admin/servicio/actualizar", [Controlador_Servicio::class, "Actualizar"]);

    $router->get("/admin/servicio/foto", [Controlador_Fotos::class, "Listar"]);
    $router->get("/admin/servicio/foto/crear", [Controlador_Fotos::class, "Crear"]);
    $router->post("/admin/servicio/foto/crear", [Controlador_Fotos::class, "Crear"]);
    $router->get("/admin/servicio/foto/actualizar", [Controlador_Fotos::class, "Actualizar"]);
    $router->post("/admin/servicio/foto/actualizar", [Controlador_Fotos::class, "Actualizar"]);

    $router->get("/admin/usuario", [Controlador_Usuario::class, "Listar"]);
    $router->get("/admin/usuario/asignar", [Controlador_Usuario::class, "Actualizar"]);
    $router->post("/admin/usuario/asignar", [Controlador_Usuario::class, "Actualizar"]);
}
$router->ComprobarRutas();


function LeerCookie()
{
    $nombre_cookie = "pelukeria_cookie";
    $cookie_valores = [];

    if (isset($_COOKIE[$nombre_cookie])) {
        $cookie_valores = json_decode($_COOKIE[$nombre_cookie], true);
    } else {
        $cookie_valores = -1;
    }

    return $cookie_valores;
}
/*
echo '<pre><code>';
print_r($cookie_valores);
echo '</code></pre>';
*/
//echo 'Hola';
