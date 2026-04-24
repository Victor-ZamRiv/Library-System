<?php
namespace App\Core;

class BaseController {
    protected function render(string $viewPath, array $data = []): string {
        extract($data);
        ob_start();
        require VIEW_PATH . $viewPath . '.php';
        return ob_get_clean();
    }

    protected function middlewareRol(array $rolesPermitidos, string $modulo) {
        if (!isset($_SESSION['administrador']['rol']) || !in_array($_SESSION['administrador']['rol'], $rolesPermitidos)) {
            $_SESSION['error'] = "No tienes permisos para acceder al modulo $modulo.";
            $this->redirect("/dashboard");
        }
    }
    protected function authenticate() {
        if (!isset($_SESSION['administrador'])) {
            // Guardamos un mensaje para que el usuario sepa por qué fue rebotado
            $_SESSION['error'] = "Debes iniciar sesión para acceder a esta sección.";
            $this->redirect("/login");
            exit(); // Detenemos la ejecución
        }
    }

    protected function redirect(string $url): void {
        $path = (strpos($url, BASE_URL) === 0) ? $url : BASE_URL . $url;

        header("Location: " . $path);
        exit; 
    }

    protected function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}