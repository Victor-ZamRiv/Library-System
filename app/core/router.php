<?php
namespace App\Core;

class Router {
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function get(string $path, string $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, string $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, string $handler): void {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, string $handler): void {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method, array $dependencies = []): void {
        $uri = rtrim(parse_url($uri, PHP_URL_PATH), '/');

        // Simulación de PUT/DELETE desde formularios HTML
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        $handler = $this->routes[$method][$uri] ?? null; 

        if (!$handler) {
            http_response_code(404);
            echo "Ruta no encontrada: $method $uri";
            return;
        }

        [$controllerName, $methodName] = explode('@', $handler);
        $controllerClass = "App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controlador no encontrado: $controllerClass";
            return;
        }

        $controller = $this->instantiate($controllerClass, $dependencies);

        if (!method_exists($controller, $methodName)) {
            http_response_code(500);
            echo "Método no encontrado: $methodName";
            return;
        }

        echo call_user_func([$controller, $methodName]);
    }

    private function instantiate(string $class, array $dependencies): object {
        $ref = new \ReflectionClass($class);
        $ctor = $ref->getConstructor();

        if (!$ctor) return new $class();

        $args = [];
        foreach ($ctor->getParameters() as $param) {
            $type = $param->getType();
            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();
                $args[] = $dependencies[$typeName] ?? null;
            } else {
                $args[] = null;
            }
        }

        return $ref->newInstanceArgs($args);
    }
}