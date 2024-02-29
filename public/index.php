<?php 

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\ApiController;
use Controller\CitaController;
use Controller\LoginController;
use Controller\ServiciosController;
use MVC\Router;

$router = new Router();

//Iniciar Sesión
$router->get("/",[LoginController::class, "login"]);
$router->post("/",[LoginController::class, "login"]);
$router->get("/logout",[LoginController::class, "logout"]);

$router->get("/crear-cuenta",[LoginController::class, "crear"]);
$router->post("/crear-cuenta",[LoginController::class, "crear"]);
$router->get("/confirmar-cuenta",[LoginController::class, "confirmar"]);
$router->get("/mensaje",[LoginController::class, "mensaje"]);

$router->get("/olvide",[LoginController::class, "olvide"]);
$router->post("/olvide",[LoginController::class, "olvide"]);
$router->get("/recuperar",[LoginController::class, "recuperar"]);
$router->post("/recuperar",[LoginController::class, "recuperar"]);

//Sesión Iniciada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'admin']);
$router->get('/servicios', [ServiciosController::class, 'servicios']);
$router->get('/servicios/crear', [ServiciosController::class, 'crear']);
$router->post('/servicios/crear', [ServiciosController::class, 'crear']);
$router->get('/servicios/actualizar', [ServiciosController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServiciosController::class, 'actualizar']);

//Api´s
$router->get('/api/servicios', [ApiController::class, 'servicios']);
$router->post('/api/cita', [ApiController::class, 'guardar']);
$router->post('/api/eliminar-cita', [ApiController::class, 'eliminarCita']);
$router->post('/api/eliminar-servicio', [ApiController::class, 'eliminarServicio']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();