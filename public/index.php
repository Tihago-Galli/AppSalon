<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ApiControllers;
use Controllers\citaControllers;
use Controllers\LoginControllers;
use MVC\Router;

$router = new Router();

//iniciar sesion
$router->get('/',[LoginControllers::class, 'login']);
$router->post('/',[LoginControllers::class, 'login']);
$router->get('/logout',[LoginControllers::class, 'logout']);

//recuperar cuenta
$router->get('/olvide',[LoginControllers::class, 'olvide']);
$router->post('/olvide',[LoginControllers::class, 'olvide']);
$router->get('/restablecer-password',[LoginControllers::class, 'recuperar']);
$router->post('/restablecer-password',[LoginControllers::class, 'recuperar']);

//crear cuenta
$router->get('/crear-cuenta',[LoginControllers::class, 'crear']);
$router->post('/crear-cuenta',[LoginControllers::class, 'crear']);

//confirmar cuenta
$router->get('/confirmar-cuenta',[LoginControllers::class, 'confirmar']);
$router->get('/mensaje',[LoginControllers::class, 'mensaje']);

//crear cita
$router->get('/citas',[citaControllers::class, 'index']);

//API
$router->get('/api/servicios',[ApiControllers::class, 'index']);
$router->post('/api/citas',[ApiControllers::class, 'guardar']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();