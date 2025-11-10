<?php
spl_autoload_register(function($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    // quitar barra inicial si existe
    $class = ltrim($class, '\\');
    // sólo manejar clases del prefijo App\
    if (strncmp($prefix, $class, strlen($prefix)) === 0) {
        $relative = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) require $file;
    }
});