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

// Vista HTML de Proveedores
$routes->get('proveedores', 'ProveedorController::index');

// Grupo de acciones de Proveedores
$routes->group('proveedores', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'ProveedorController::guardar');
    $routes->get('eliminar/(:num)', 'ProveedorController::eliminar/$1');
});

// Vista HTML de Usuarios
$routes->get('usuarios', 'UsuarioController::index');

// Grupo de acciones de Usuarios
$routes->group('usuarios', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'UsuarioController::guardar');
    $routes->get('eliminar/(:num)', 'UsuarioController::eliminar/$1');
});

$routes->get('productos', 'ProductoController::index');
$routes->group('productos', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'ProductoController::guardar');
    $routes->get('eliminar/(:num)', 'ProductoController::eliminar/$1');
});

// En el grupo de vistas HTML protegidas:
$routes->get('facturas/nueva', 'VentaController::nueva');

// En el grupo exclusivo para AJAX/POST con filtros auth y ajax:
$routes->get('facturas/buscar-cliente', 'VentaController::buscarCliente');
$routes->get('facturas/buscar-producto', 'VentaController::buscarProducto');
$routes->post('facturas/guardar', 'VentaController::guardar');

$routes->get('facturas/nueva', 'VentaController::nueva');
$routes->get('facturas/buscar-cliente', 'VentaController::buscarCliente');
$routes->get('facturas/buscar-producto', 'VentaController::buscarProducto');
$routes->post('facturas/guardar', 'VentaController::guardar');

// Rutas exclusivas para Administradores (Categorías, Productos, Proveedores, Usuarios, etc.)
$routes->group('', ['filter' => 'role:administrador'], function($routes) {
    $routes->resource('categorias', ['controller' => 'CategoriaController']);
    $routes->resource('productos', ['controller' => 'ProductoController']);
    $routes->resource('proveedores', ['controller' => 'ProveedorController']);
    $routes->resource('usuarios', ['controller' => 'UsuarioController']);
    $routes->resource('marcas', ['controller' => 'MarcaController']);
});

// Rutas accesibles tanto para Administradores como para Encargados (Facturación / Ventas)
$routes->group('', ['filter' => 'role:administrador,encargado'], function($routes) {
    $routes->resource('facturacion', ['controller' => 'VentaController']); // o FacturacionController
});
