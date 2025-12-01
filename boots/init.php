<?php
require __DIR__ . '/autoload.php';
$config = require __DIR__ . '/../config/config.php';

define('BASE_PATH', dirname(__DIR__)); 


$cfg = $config['db'];
$dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset={$cfg['charset']}";
$pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

// $container['pdo'] = $pdo;