<?php
use App\Core\Router;

$router = new Router();

// Rutas para libros
$router->get('/libros', 'LibroController@index');
$router->get('/libros/create', 'LibroController@create');
$router->post('/libros', 'LibroController@store');
$router->get('/libros/show', 'LibroController@show');

return $router;