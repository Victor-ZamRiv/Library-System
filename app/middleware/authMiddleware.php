<?php

namespace App\Middleware;

use App\Models\Services\AuthService;

class AuthMiddleware {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function handle(): void {
        if (!$this->authService->isAuthenticated()) {
            $_SESSION['error'] = "Debes iniciar sesión para continuar.";
            header("Location: /auth/login");
            exit;
        }
    }
}