<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\AuthController;
use Controllers\DashboardController;
use MVC\Router;

$router = new Router();


// // Auth
// Login
$router->get('/', [AuthController::class, 'login']);
$router->post('/', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Create Account
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);

// password recovery
$router->get('/forgot-password', [AuthController::class, 'forgot_password']);
$router->post('/forgot-password', [AuthController::class, 'forgot_password']);

// reset pass
$router->get('/reset-password', [AuthController::class, 'reset_password']);
$router->post('/reset-password', [AuthController::class, 'reset_password']);

// confirm account
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm-account', [AuthController::class, 'confirm_account']);



// // Private - Projects
$router->get('/dashboard', [DashboardController::class, 'index']);

$router->get('/crear-proyecto', [DashboardController::class, 'create_project']);
$router->post('/crear-proyecto', [DashboardController::class, 'create_project']);

$router->get('/proyecto', [DashboardController::class, 'project']);

$router->get('/perfil', [DashboardController::class, 'profile']);






// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
