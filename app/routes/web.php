<?php
use App\Core\Router;

$router = new Router();

//rutas generales
$router->get('/dashboard', 'DashboardController@index');

// Rutas para libros
$router->get('/libros', 'LibroController@index');
$router->get('/libros/create', 'LibroController@create');
$router->post('/libros', 'LibroController@store');
$router->get('/libros/show', 'LibroController@show');
$router->get('/libros/edit', 'LibroController@edit');
$router->post('/libros/update', 'LibroController@update');

//rutas login/logout
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Rutas para administradores
$router->get('/administradores', 'AdministradorController@list');
$router->get('/administradores/register', 'AdministradorController@create');
$router->post('/administradores/store', 'AdministradorController@store');



return $router;