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
    
    public function login() {
        try {
        $usuario = $this->input('username', '');
        $password = $this->input('password', '');

        if ($this->authService->login($usuario, $password)) {
            $_SESSION['success'] = "Bienvenido al sistema.";
            $this->redirect("/dashboard"); // redirige al home o dashboard
        } else {
            $_SESSION['error'] = "Credenciales inválidas.";
            $_SESSION['old_data'] = ['usuario' => $usuario];
            $this->redirect("/login");
        }
        } catch (\Exception $e) {
            http_response_code(500);
            return $this->render('errors/error', [
                'mensaje' => "Ocurrió un error inesperado al registrar el libro.",
                'detalle' => $e->getMessage()
            ]);
        }
    }
    
    public function logout(): void {
        $this->authService->logout();
        $_SESSION['success'] = "Sesión cerrada correctamente.";
        $this->redirect("/login");
    }
}