<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Rutas Públicas (Login)
$routes->get('login', 'AuthController::index');
$routes->post('login/authenticate', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// Rutas Protegidas que cargan vistas HTML (Solo filtro 'auth')
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Home::index');
    $routes->get('facturacion', 'Home::index');
    
    // Vista principal de Categorías (Carga HTML normal)
    $routes->get('categorias', 'CategoriaController::index');
});

// Rutas Protegidas que requieren AJAX y Autenticación (Para DataTables y llamadas asíncronas)
$routes->group('categorias', ['filter' => ['auth', 'ajax']], function($routes) {
    $routes->get('listarAjax', 'CategoriaController::listarAjax');
});

// Rutas de acciones (Guardar, Actualizar, Eliminar) protegidas por auth (pueden ser peticiones normales por formulario o POST)
$routes->group('categorias', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'CategoriaController::store');
    $routes->post('actualizar/(:num)', 'CategoriaController::update/$1');
    $routes->get('eliminar/(:num)', 'CategoriaController::delete/$1');
});