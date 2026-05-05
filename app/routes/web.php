<?php
use App\Core\Router;

$router = new Router();

//rutas generales
$router->get('/dashboard', 'DashboardController@index');
$router->get('/', 'DashboardController@index');

// Rutas para configuración
$router->get('/configuracion', 'ConfiguracionController@index');
$router->get('/configuracion/sala', 'ConfiguracionController@salaConfiguration');
$router->get('/configuracion/area', 'ConfiguracionController@areaConfiguration');
$router->get('/history', 'ConfiguracionController@historial');
$router->get('/configuracion/indicator', 'ConfiguracionController@indicatorConfiguration');
$router->get('/configuracion/prestamos', 'ConfiguracionController@prestamoConfiguration');
$router->post('/configuracion/prestamos/update', 'ConfiguracionController@prestamoUpdate');

// Rutas para libros
$router->get('/libros', 'LibroController@index');
$router->get('/libros/search', 'LibroController@search');
$router->get('/libros/opcion', 'LibroController@option');
$router->post('/libros/nueva-edicion', 'LibroController@newEdition');
$router->get('/libros/create', 'LibroController@create');
$router->post('/libros', 'LibroController@store');
$router->get('/libros/show', 'LibroController@show');
$router->get('/libros/edit', 'LibroController@edit');
$router->post('/libros/update', 'LibroController@update');

//rutas login/logout
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/password-recovery', 'AuthController@passwordRecoveryForm');

// Rutas para administradores
$router->get('/administradores', 'AdministradorController@list');
$router->get('/administradores/search', 'AdministradorController@search');
$router->get('/administradores/register', 'AdministradorController@create');
$router->post('/administradores/store', 'AdministradorController@store');
$router->get('/administradores/edit', 'AdministradorController@edit');
$router->post('/administradores/update', 'AdministradorController@update');
$router->get('/administradores/show', 'AdministradorController@show');

// Rutas para lectores
$router->get('/lectores', 'LectorController@list');
$router->get('/lectores/show', 'LectorController@show');
$router->get('/lectores/delete', 'LectorController@delete');
$router->get('/lectores/create', 'LectorController@create');
$router->post('/lectores/store', 'LectorController@store');
$router->get('/lectores/edit', 'LectorController@edit');
$router->post('/lectores/update', 'LectorController@update');
$router->get('/lectores/search', 'LectorController@search');

// Rutas actividades
$router->get('/eventos', 'ActividadController@list');
$router->get('/actividad/create', 'ActividadController@create');
$router->post('/actividad/store', 'ActividadController@store');

//Rutas logros
$router->get('/logro/create', 'LogroController@create');
$router->post('/logro/store', 'LogroController@store');

// Rutas visitantes y consultas
$router->get('/visitantes', 'VisitantesController@index');
$router->get('/visitantes/registro', 'VisitantesController@create');
$router->post('/visitantes/store', 'VisitantesController@store');

//Rutas para préstamos
$router->get('/prestamos', 'PrestamoController@index');
$router->get('/prestamos/create', 'PrestamoController@create');
$router->post('/prestamos/check-lector', 'PrestamoController@checkLector');
$router->post('/prestamos/check-libro', 'PrestamoController@checkLibro');
$router->post('/prestamos/store', 'PrestamoController@store');
$router->get('/prestamos/show', 'PrestamoController@show');
$router->get('/prestamos/previsualizar-devolucion', 'PrestamoController@previsualizarDevolucion');
$router->post('/prestamos/devolver', 'PrestamoController@devolver');
$router->post('/prestamos/renovar', 'PrestamoController@renovar');

//Rutas multas
$router->get('/multas', 'MultaController@index');

// Rutas configuracion prestamos






return $router;