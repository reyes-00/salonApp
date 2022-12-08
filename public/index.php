<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\ApiController;
use Controllers\citaController;
use Controllers\LoginController;

$router = new Router();

// Iniciar sesion
$router->get('/',[LoginController::class,'index']);
$router->post('/',[LoginController::class,'index']);
$router->get('/logout',[LoginController::class,'logout']);

// Recuperar contraseña
$router->get('/olvide', [LoginController::class,'olvide']);
$router->post('/olvide', [LoginController::class,'olvide']);
$router->get('/recuperar', [LoginController::class,'recuperar']);
$router->post('/recuperar', [LoginController::class,'recuperar']);
$router->post('/olvide', [LoginController::class,'olvide']);


/* Crear cuenta */
$router->get('/crear-cuenta', [LoginController::class,'crearCuenta']);
$router->post('/crear-cuenta', [LoginController::class,'crearCuenta']);

// Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class,'confirmarCuenta']);
$router->get('/mensaje', [LoginController::class,'mensaje']);

/* Area privada */
$router->get('/cita',[citaController::class,'index']);

/* API de citas */
$router->get('/api/servicios',[ApiController::class,'index']);
$router->post('/api/citas',[ApiController::class,'guardar']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();