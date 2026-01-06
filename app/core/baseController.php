<?php
namespace App\Core;

class BaseController {
    protected function render(string $viewPath, array $data = []): string {
        extract($data);
        ob_start();
        require VIEW_PATH . $viewPath . '.php';
        return ob_get_clean();
    }


    protected function redirect(string $url): void {
        // Si la URL que pasas ya tiene el nombre de la carpeta (ej: /Library_System/...)
        // o si es una URL externa, la dejamos tal cual.
        // De lo contrario, le pegamos el prefijo.
        $path = (strpos($url, BASE_URL) === 0) ? $url : BASE_URL . $url;

        header("Location: " . $path);
        exit; 
    }

    protected function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}