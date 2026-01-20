<?php 
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Services\AuthService;

class AuthController extends BaseController {

    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function loginForm(): string {
        return $this->render('login/login');
    }
    
    public function login(): void {
        $usuario = $this->input('username', '');
        $password = $this->input('password', '');

        if ($this->authService->login($usuario, $password)) {
            $_SESSION['success'] = "Bienvenido al sistema.";
            $this->redirect("/"); // redirige al home o dashboard
        } else {
            $_SESSION['error'] = "Credenciales inválidas.";
            $_SESSION['old_data'] = ['usuario' => $usuario];
            $this->redirect("/login/login");
        }
    }
    
    public function logout(): void {
        $this->authService->logout();
        $_SESSION['success'] = "Sesión cerrada correctamente.";
        $this->redirect("/auth/login");
    }
}