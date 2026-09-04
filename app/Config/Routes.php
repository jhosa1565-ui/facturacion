<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Rutas Públicas (Login)
$routes->get('login', 'AuthController::index');
$routes->post('login/authenticate', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// 1. Rutas Protegidas que SÍ muestran vistas HTML (Solo filtro 'auth')
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Home::index');
    $routes->get('facturacion', 'Home::index');
    
    // Vistas principales
    $routes->get('categorias', 'CategoriaController::index');
    $routes->get('marcas', 'MarcaController::index'); // <--- Vista HTML de Marcas
});

// 2. Rutas de Categorías (Acciones)
$routes->group('categorias', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'CategoriaController::store');
    $routes->post('actualizar/(:num)', 'CategoriaController::update/$1');
    $routes->get('eliminar/(:num)', 'CategoriaController::delete/$1');
});

// 3. Rutas de Marcas (Acciones: Guardar, Actualizar, Eliminar)
$routes->group('marcas', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'MarcaController::guardar');
    $routes->post('actualizar/(:num)', 'MarcaController::guardar/$1');
    $routes->get('eliminar/(:num)', 'MarcaController::eliminar/$1');
});

// 1. Ruta Protegida de vista HTML para Clientes (dentro del grupo de vistas)
$routes->get('clientes', 'ClienteController::index');

// 2. Grupo de Rutas de acciones de Clientes (Guardar, Eliminar)
$routes->group('clientes', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'ClienteController::guardar');
    $routes->get('eliminar/(:num)', 'ClienteController::eliminar/$1');
});