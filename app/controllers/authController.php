<?php 
namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\IAdministradorRepository;
use App\Contracts\IPreguntaRepository;
use App\Models\Services\AuthService;

class AuthController extends BaseController {

    private AuthService $authService;
    private IAdministradorRepository $administradorRepo;
    private IPreguntaRepository $preguntaRepo;

    public function __construct(
        AuthService $authService, 
        IAdministradorRepository $administradorRepo, 
        IPreguntaRepository $preguntaRepo
        ) {
        $this->authService = $authService;
        $this->administradorRepo = $administradorRepo;
        $this->preguntaRepo = $preguntaRepo;
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


    public function recoveryVerify(): void
    {
        header('Content-Type: application/json');
        $username = trim($_POST['username'] ?? '');

        if (!$username) {
            echo json_encode(['success' => false, 'message' => 'Usuario requerido']);
            return;
        }

        // Buscar administrador por nombre de usuario
        $admin = $this->administradorRepo->findByUsername($username);
        if (!$admin || !$admin->isActivo()) {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado o inactivo']);
            return;
        }

        // Obtener la pregunta de seguridad
        $pregunta = $this->preguntaRepo->find($admin->getIdPregunta());
        if (!$pregunta) {
            echo json_encode(['success' => false, 'message' => 'No hay pregunta de seguridad asociada a este usuario']);
            return;
        }

        echo json_encode([
            'success' => true,
            'pregunta' => $pregunta->getPregunta(),
            'idUsuario' => $admin->getIdAdministrador()
        ]);
    }

    public function recoveryReset(): void
    {
        header('Content-Type: application/json');
        $username = trim($_POST['username'] ?? '');
        $respuesta = trim($_POST['respuesta'] ?? '');
        $nuevaPassword = trim($_POST['new_password'] ?? '');

        if (!$username || !$respuesta || !$nuevaPassword) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos']);
            return;
        }

        if (strlen($nuevaPassword) < 4) {
            echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 4 caracteres']);
            return;
        }

        // Buscar administrador
        $admin = $this->administradorRepo->findByUsername($username);
        if (!$admin || !$admin->isActivo()) {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            return;
        }

        // Verificar respuesta (hash)
        if (!password_verify($respuesta, $admin->getRespuestaHash())) {
            echo json_encode(['success' => false, 'message' => 'Respuesta incorrecta']);
            return;
        }

        // Actualizar contraseña
        $nuevoHash = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        $this->administradorRepo->updatePassword($admin->getIdAdministrador(), $nuevoHash);

        echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
    }
}