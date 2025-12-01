<?php
namespace App\Core;

class BaseController {
    protected function render(string $viewPath, array $data = []): string {
        extract($data);
        ob_start();
        require __DIR__ . '/../views/' . $viewPath . '.php';
        return ob_get_clean();
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    protected function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}