<?php
use App\Core\Router;

$router = new Router();

// Rutas para libros
$router->get('/libros', 'LibroController@index');
$router->get('/libros/create', 'LibroController@create');
$router->post('/libros', 'LibroController@store');
$router->get('/libros/show', 'LibroController@show');
$router->get('/libros/edit', 'LibroController@edit');
$router->post('/libros/update', 'LibroController@update');

return $router;