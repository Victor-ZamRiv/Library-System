<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Contracts\IMultaRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IPrestamoRepository;
use App\Models\Entities\Multa;
use App\Models\Services\MultaService;

class MultaController extends BaseController
{
    private IMultaRepository $multaRepo;
    private ILectorRepository $lectorRepo;
    private IEjemplarRepository $ejemplarRepo;
    private ILibroRepository $libroRepo;
    private IPrestamoRepository $prestamoRepo;
    private MultaService $multaService;
    public function __construct(
        IMultaRepository $multaRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        ILibroRepository $libroRepo,
        IPrestamoRepository $prestamoRepo,
        MultaService $multaService
    ) {
        $this->multaRepo = $multaRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->libroRepo = $libroRepo;
        $this->prestamoRepo = $prestamoRepo;
        $this->multaService = $multaService;

        // Proteger todas las acciones (requiere autenticación)
        $this->authenticate();
        // Solo bibliotecarios y superiores pueden gestionar multas
        $this->middlewareRol(['Bibliotecario', 'Jefe_Sala', 'Director'], 'multas');
    }

    public function index(): string{
        $multas = $this->multaRepo->all();
        return $this->render('fine/fine-list', ['multas' => $multas]);
    }

    public function pagar(): void{
        $idMulta = (int) $this->input('idMulta');
        $idAdmin = $_SESSION['administrador']['id'] ?? 0;

        $resultado = $this->multaService->pagarMulta($idMulta, $idAdmin);

        if ($resultado['success']) {
            $_SESSION['success'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        $this->redirect('/multas');
    }

    public function cancelar(): void{
        $idMulta = (int) $this->input('idMulta');
        $idAdmin = $_SESSION['administrador']['id'] ?? 0;

        $resultado = $this->multaService->cancelarMulta($idMulta, $idAdmin);

        if ($resultado['success']) {
            $_SESSION['success'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        $this->redirect('/multas');
    }    

}