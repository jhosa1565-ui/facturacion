<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Rutas Públicas (Login)
$routes->get('login', 'AuthController::index');
$routes->post('login/authenticate', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// Rutas Protegidas (Requieren autenticación)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Apuntamos tanto 'dashboard' como 'facturacion' a tu vista principal
    $routes->get('dashboard', 'Home::index');
    $routes->get('facturacion', 'Home::index');
    
    // Si creas más adelante un controlador específico para facturas, cámbialo aquí:
    // $routes->get('facturas', 'FacturaController::index');
});