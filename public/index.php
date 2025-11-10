<?php
require __DIR__ . '/../boots/init.php';

$router = require __DIR__ . '/../app/routes/web.php';

$container = [
    \PDO::class => $pdo
];

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $container);