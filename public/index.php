<?php
require __DIR__ . '/../bootstrap/init.php';

$router = require __DIR__ . '/../routes/web.php';

$container = [
    \PDO::class => $pdo
];

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $container);