<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\IMultaRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IPrestamoRepository;
use App\Contracts\IPersonaRepository;
use App\Contracts\IAdministradorRepository;
use App\Models\Services\MultaService;
use App\Models\Services\AuditService;
use App\Models\Entities\Multa;

class MultaController extends BaseController
{
    private IMultaRepository $multaRepo;
    private ILectorRepository $lectorRepo;
    private IEjemplarRepository $ejemplarRepo;
    private ILibroRepository $libroRepo;
    private IPrestamoRepository $prestamoRepo;
    private IPersonaRepository $personaRepo;
    private IAdministradorRepository $adminRepo;
    private MultaService $multaService;
    private AuditService $auditService;

    public function __construct(
        IMultaRepository $multaRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        ILibroRepository $libroRepo,
        IPrestamoRepository $prestamoRepo,
        IPersonaRepository $personaRepo,
        IAdministradorRepository $adminRepo,
        MultaService $multaService,
        AuditService $auditService
    ) {
        $this->multaRepo = $multaRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->libroRepo = $libroRepo;
        $this->prestamoRepo = $prestamoRepo;
        $this->personaRepo = $personaRepo;
        $this->adminRepo = $adminRepo;
        $this->multaService = $multaService;
        $this->auditService = $auditService;

        $this->authenticate();
        $this->middlewareRol(['Bibliotecario', 'Jefe_Sala', 'Director'], 'multas');
    }

    // ==================== MÉTODOS AUXILIARES ====================

    private function getIdAdmin(): int
    {
        return $_SESSION['administrador']['id'] ?? 0;
    }

    /**
     * Prepara un array plano con datos legibles para auditoría.
     * @param Multa $multa
     * @return array
     */
    private function prepararDatosAuditoria(Multa $multa): array
    {
        $prestamo = $this->prestamoRepo->find($multa->getIdPrestamo());
        $lector = $prestamo ? $this->lectorRepo->find($prestamo->getIdLector()) : null;
        $personaLector = $lector ? $this->personaRepo->find($lector->getIdPersona()) : null; // Ajusta según tu repositorio

        return [
            'ID Multa' => $multa->getIdMulta(),
            'Monto' => $multa->getMonto(),
            'Estado' => $multa->getEstado(),
            'Fecha Generación' => $multa->getFechaGeneracion() ?? 'No registrada',
            'Fecha Cancelación' => $multa->getFechaCancelacion() ?? 'Pendiente',
            'Préstamo Asociado' => $prestamo ? $prestamo->getIdPrestamo() : 'N/A',
            'Lector' => $personaLector ? $personaLector->getNombre() . ' ' . $personaLector->getApellido() . ' (Carnet: ' . $lector->getCarnet() . ')' : 'N/A',
            'Admin que registró' => $multa->getIdAdmin() ? $this->obtenerNombreAdmin($multa->getIdAdmin()) : 'Desconocido',
        ];
    }

    private function obtenerNombreAdmin(int $idAdmin): string
    {
        $admin = $this->adminRepo->find($idAdmin);
        if ($admin && $admin->getPersona()) {
            return $admin->getPersona()->getNombre() . ' ' . $admin->getPersona()->getApellido();
        }
        return $admin ? $admin->getNombreUsuario() : 'Desconocido';
    }

    // ==================== MÉTODOS CRUD ====================

    public function index(): string
    {
        $multas = $this->multaRepo->all();
        return $this->render('fine/fine-list', ['multas' => $multas]);
    }

    /**
     * Registra una nueva multa (llamado desde DevolucionService).
     * @param int $idPrestamo
     * @param float $monto
     * @param int $idAdmin
     * @return int|null
     *//*
    public function store(int $idPrestamo, float $monto, int $idAdmin): ?int
    {
        $multa = new Multa(null, $idPrestamo, $idAdmin, $monto, null, 'Pendiente');
        $idMulta = $this->multaRepo->insert($multa);
        if ($idMulta) {
            $multaCreada = $this->multaRepo->find($idMulta);
            $newArray = $this->prepararDatosAuditoria($multaCreada);
            $this->auditService->registrarCambio(
                'historial_multa',
                $idMulta,
                $idAdmin,
                [],
                $newArray,
                'INSERT'
            );
        }
        return $idMulta;
    } */

    public function pagar(): void
    {
        $idMulta = (int) $this->input('idMulta');
        $idAdmin = $this->getIdAdmin();

        $multaAntes = $this->multaRepo->find($idMulta);
        $oldArray = $multaAntes ? $this->prepararDatosAuditoria($multaAntes) : [];

        $resultado = $this->multaService->pagarMulta($idMulta, $idAdmin);

        if ($resultado['success']) {
            $multaDespues = $this->multaRepo->find($idMulta);
            $newArray = $multaDespues ? $this->prepararDatosAuditoria($multaDespues) : [];
            $this->auditService->registrarCambio(
                'historial_multa',
                $idMulta,
                $idAdmin,
                $oldArray,
                $newArray,
                'UPDATE'
            );
            $_SESSION['success'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        $this->redirect('/multas');
    }

    public function cancelar(): void
    {
        $idMulta = (int) $this->input('idMulta');
        $idAdmin = $this->getIdAdmin();

        $multaAntes = $this->multaRepo->find($idMulta);
        $oldArray = $multaAntes ? $this->prepararDatosAuditoria($multaAntes) : [];

        $resultado = $this->multaService->cancelarMulta($idMulta, $idAdmin);

        if ($resultado['success']) {
            $multaDespues = $this->multaRepo->find($idMulta);
            $newArray = $multaDespues ? $this->prepararDatosAuditoria($multaDespues) : [];
            $this->auditService->registrarCambio(
                'historial_multa',
                $idMulta,
                $idAdmin,
                $oldArray,
                $newArray,
                'UPDATE'
            );
            $_SESSION['success'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        $this->redirect('/multas');
    }
/*
    public function delete(): void
    {
        $idMulta = (int) $this->input('id');
        $idAdmin = $this->getIdAdmin();
        try {
            $multaAntes = $this->multaRepo->find($idMulta);
            $oldArray = $multaAntes ? $this->prepararDatosAuditoria($multaAntes) : [];

            if ($this->multaRepo->deactivate($idMulta)) {
                $this->auditService->registrarCambio(
                    'historial_multa',
                    $idMulta,
                    $idAdmin,
                    $oldArray,
                    [],
                    'DELETE'
                );
                $_SESSION['success'] = "Multa desactivada con éxito.";
            } else {
                $_SESSION['error'] = "No se pudo desactivar la multa.";
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar multa: " . $e->getMessage();
        }
        $this->redirect('/multas');
    } */
}