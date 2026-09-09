<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Rutas Públicas (Login)
$routes->get('login', 'AuthController::index');
$routes->post('login/authenticate', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// ==========================================
// RUTA DEL DASHBOARD (Corregido)
// ==========================================
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);

// ==========================================
// MÓDULO DE FACTURACIÓN / NUEVA FACTURA
// ==========================================
$routes->group('facturas', ['filter' => 'auth'], function($routes) {
    $routes->get('nueva', 'VentaController::nueva');
    $routes->get('buscar-cliente', 'VentaController::buscarCliente');
    $routes->get('buscar-producto', 'VentaController::buscarProducto');
    $routes->post('guardar', 'VentaController::guardar');
});

// ==========================================
// RUTAS DE MÓDULOS (Vistas HTML y Acciones)
// ==========================================

// Categorías
$routes->get('categorias', 'CategoriaController::index', ['filter' => 'auth']);
$routes->group('categorias', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'CategoriaController::store');
    $routes->post('actualizar/(:num)', 'CategoriaController::update/$1');
    $routes->get('eliminar/(:num)', 'CategoriaController::delete/$1');
});

// Marcas
$routes->get('marcas', 'MarcaController::index', ['filter' => 'auth']);
$routes->group('marcas', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'MarcaController::guardar');
    $routes->post('actualizar/(:num)', 'MarcaController::guardar/$1');
    $routes->get('eliminar/(:num)', 'MarcaController::eliminar/$1');
});

// Clientes
$routes->get('clientes', 'ClienteController::index', ['filter' => 'auth']);
$routes->group('clientes', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'ClienteController::guardar');
    $routes->get('eliminar/(:num)', 'ClienteController::eliminar/$1');
});

// Proveedores
$routes->get('proveedores', 'ProveedorController::index', ['filter' => 'auth']);
$routes->group('proveedores', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'ProveedorController::guardar');
    $routes->get('eliminar/(:num)', 'ProveedorController::eliminar/$1');
});

// Usuarios
$routes->get('usuarios', 'UsuarioController::index', ['filter' => 'auth']);
$routes->group('usuarios', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'UsuarioController::guardar');
    $routes->get('eliminar/(:num)', 'UsuarioController::eliminar/$1');
});

// Productos
$routes->get('productos', 'ProductoController::index', ['filter' => 'auth']);
$routes->group('productos', ['filter' => 'auth'], function($routes) {
    $routes->post('guardar', 'ProductoController::guardar');
    $routes->get('eliminar/(:num)', 'ProductoController::eliminar/$1');
});

// ==========================================
// FILTROS POR ROLES Y RECURSOS
// ==========================================

// Rutas exclusivas para Administradores
$routes->group('', ['filter' => 'role:administrador'], function($routes) {
    $routes->resource('categorias', ['controller' => 'CategoriaController']);
    $routes->resource('productos', ['controller' => 'ProductoController']);
    $routes->resource('proveedores', ['controller' => 'ProveedorController']);
    $routes->resource('usuarios', ['controller' => 'UsuarioController']);
    $routes->resource('marcas', ['controller' => 'MarcaController']);
});

// Rutas para Administradores y Encargados
$routes->group('', ['filter' => 'role:administrador,encargado'], function($routes) {
    $routes->resource('facturacion', ['controller' => 'VentaController']);
});

$routes->group('facturas', ['filter' => 'auth'], function($routes) {
    $routes->get('index', 'VentaController::index');
    $routes->get('', 'VentaController::index'); // Historial de facturas
    $routes->get('buscar-cliente', 'VentaController::buscarCliente');
    $routes->get('buscar-producto', 'VentaController::buscarProducto');
    $routes->post('guardar', 'VentaController::guardar');
});

// Módulo de Compras
$routes->group('compras', ['filter' => 'auth'], function($routes) {
    $routes->get('nueva', 'CompraController::nueva');
    $routes->get('', 'CompraController::index');
    $routes->get('buscar-proveedor', 'CompraController::buscarProveedor');
    $routes->get('buscar-producto', 'CompraController::buscarProducto');
    $routes->post('guardar', 'CompraController::guardar');
});