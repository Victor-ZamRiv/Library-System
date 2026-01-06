<?php
require __DIR__ . '/boots/init.php';

use App\Models\Repositories\LibroRepository;
use App\Models\Services\LibroSearchService;
use App\Models\Services\LibroRegistrationService;
use App\Models\Repositories\EjemplarRepository;
use App\Models\Repositories\AutorRepository;
use App\Models\Repositories\EditorialRepository;

$router = require __DIR__ . '/app/routes/web.php';

$container = [
    \PDO::class => $pdo,
    LibroRepository::class => new LibroRepository($pdo),
    LibroSearchService::class => new LibroSearchService(
        new LibroRepository($pdo), new AutorRepository($pdo)),
    LibroRegistrationService::class => new LibroRegistrationService(
        new LibroRepository($pdo),
        new AutorRepository($pdo),
        new EditorialRepository($pdo),
        new EjemplarRepository($pdo)
    )
];

$uri = str_ireplace(BASE_URL, '', $_SERVER['REQUEST_URI']);

$router->dispatch($uri, $_SERVER['REQUEST_METHOD'], $container);