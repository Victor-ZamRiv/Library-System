<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Contracts\IPersonaRepository;
use App\Contracts\ILectorRepository;
use App\Models\Services\LectorRegistrationService;
use App\Models\Services\ListLectorService;
use App\Models\Services\AuditService;
use App\Models\Entities\Persona;
use App\Models\Entities\Lector;

class LectorController extends BaseController
{
    private IPersonaRepository $personaRepo;
    private ILectorRepository $lectorRepo;
    private LectorRegistrationService $lectorService;
    private ListLectorService $listLectorService;
    private AuditService $auditService;

    public function __construct(
        IPersonaRepository $personaRepo,
        ILectorRepository $lectorRepo,
        LectorRegistrationService $lectorService,
        ListLectorService $listLectorService,
        AuditService $auditService
    ) {
        $this->personaRepo = $personaRepo;
        $this->lectorRepo = $lectorRepo;
        $this->lectorService = $lectorService;
        $this->listLectorService = $listLectorService;
        $this->auditService = $auditService;
        $this->authenticate();
    }

    // ==================== MÉTODOS AUXILIARES ====================

    private function getIdAdmin(): int
    {
        return $_SESSION['administrador']['id'] ?? 0;
    }

    /**
     * Prepara un array plano con datos legibles para auditoría.
     * @param Lector $lector
     * @param Persona $persona
     * @return array
     */
    private function prepararDatosAuditoria(Lector $lector, Persona $persona): array
    {
        return [
            'ID Lector' => $lector->getIdLector(),
            'Carnet' => $lector->getCarnet(),
            'Cédula' => $persona->getCedula(),
            'Nombre Completo' => $persona->getNombre() . ' ' . $persona->getApellido(),
            'Teléfono' => $persona->getTelefono(),
            'Sexo' => $lector->getSexo(),
            'Dirección' => $lector->getDireccion(),
            'Profesión' => $lector->getProfesion(),
            'Teléfono Profesión' => $lector->getTelefonoProfesion(),
            'Dirección Profesión' => $lector->getDireccionProfesion(),
            'Referencia Personal' => $lector->getRefPersonal(),
            'Tel. Referencia Personal' => $lector->getRefPersonalTel(),
            'Referencia Legal' => $lector->getRefLegal(),
            'Tel. Referencia Legal' => $lector->getRefLegalTel(),
            'Fecha Vencimiento Carnet' => $lector->getVencimientoCarnet(),
            'Estado' => $lector->getEstado(),
            'Activo' => $lector->isActivo() ? 'Sí' : 'No',
        ];
    }

    // ==================== MÉTODOS CRUD ====================

    public function list(): string
    {
        $pagina = (int) $this->input('page', 1);
        $search = $this->input('buscar', '');
        $porPagina = 10;

        $resultado = $this->listLectorService->listarPaginado($pagina, $porPagina, $search);
        $inactivos = $this->lectorRepo->findInactivos($search);
        $totalInactivos = count($inactivos);
        foreach ($inactivos as $lector) {
            $lector->setPersona($this->personaRepo->find($lector->getIdPersona()));
        }

        return $this->render('reader/reader-list', [
            'lectores' => $resultado['datos'],
            'paginacion' => [
                'actual' => $resultado['pagina'],
                'porPagina' => $resultado['porPagina'],
                'total' => $resultado['total'],
                'ultima' => $resultado['ultimaPagina']
            ],
            'inactivos' => $inactivos,
            'totalInactivos' => $totalInactivos,
            'search' => $search
        ]);
    }

    public function show(): string
    {
        $id = (int) $this->input('id', 0);
        $lector = $this->lectorRepo->find($id);
        if (!$lector) {
            http_response_code(404);
            return "Lector no encontrado";
        }
        $persona = $this->personaRepo->find($lector->getIdPersona());
        $lector->setPersona($persona);
        return $this->render('reader/reader-info', ['lector' => $lector]);
    }

    public function create(): string
    {
        return $this->render('reader/reader', []);
    }

    public function store()
    {
        try {
            $persona = new Persona(
                null,
                $this->input('cedula'),
                $this->input('nombre-reg'),
                $this->input('apellido-reg'),
                $this->input('email'),
                $this->input('telefono-reg')
            );

            $lector = new Lector(
                null, 0,
                $this->input('carnet-reg'),
                $this->input('sexo-reg'),
                $this->input('direccion-reg'),
                $this->input('profesion-reg'),
                $this->input('telefono-profesion-reg'),
                $this->input('direccion-profesion-reg'),
                $this->input('ref-personal-reg'),
                $this->input('telefono-ref-personal-reg'),
                $this->input('ref-legal-reg'),
                $this->input('telefono-ref-legal-reg'),
                'Activo',
                $this->input('vencimientoCarnet')
            );

            $idLector = $this->lectorService->registrar($persona, $lector);

            // Auditoría: INSERT
            $lectorCreado = $this->lectorRepo->find($idLector);
            $personaCreada = $this->personaRepo->find($lectorCreado->getIdPersona());
            $newArray = $this->prepararDatosAuditoria($lectorCreado, $personaCreada);
            $this->auditService->registrarCambio(
                'historial_lector',
                $idLector,
                $this->getIdAdmin(),
                [],
                $newArray,
                'INSERT'
            );

            $_SESSION['success'] = "Lector registrado con éxito.";
            $this->redirect("/lectores/show?id=" . $idLector);
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al registrar lector: " . $e->getMessage();
            $_SESSION['old_data'] = $_POST;
            $this->redirect("/lectores/create");
        }
    }

    public function edit(): string
    {
        $id = (int) $this->input('id', 0);
        $lector = $this->lectorRepo->find($id);
        if (!$lector) {
            http_response_code(404);
            return "Lector no encontrado";
        }
        $persona = $this->personaRepo->find($lector->getIdPersona());
        $lector->setPersona($persona);
        return $this->render('reader/reader-edit', ['lector' => $lector]);
    }

    public function update()
    {
        $id = (int) $this->input('id', 0);
        $lector = $this->lectorRepo->find($id);
        if (!$lector) {
            $_SESSION['error'] = "El lector no existe.";
            $this->redirect("/lectores");
            return;
        }

        // Obtener datos ANTES de modificar
        $personaAntes = $this->personaRepo->find($lector->getIdPersona());
        $lectorAntes = clone $lector; // clonar para no modificar el original aún
        $oldArray = $this->prepararDatosAuditoria($lectorAntes, $personaAntes);

        // Actualizar Persona
        $persona = $this->personaRepo->find($lector->getIdPersona());
        $persona->setCedula($this->input('cedula', $persona->getCedula()));
        $persona->setNombre($this->input('nombre-reg', $persona->getNombre()));
        $persona->setApellido($this->input('apellido-reg', $persona->getApellido()));
        $persona->setTelefono($this->input('telefono-reg', $persona->getTelefono()));

        // Actualizar Lector
        $lector->setCarnet($this->input('carnet', $lector->getCarnet()));
        $lector->setSexo($this->input('sexo', $lector->getSexo()));
        $lector->setDireccion($this->input('direccion', $lector->getDireccion()));
        $lector->setProfesion($this->input('profesion-reg', $lector->getProfesion()));
        $lector->setTelefonoProfesion($this->input('telefono-profesion-reg', $lector->getTelefonoProfesion()));
        $lector->setDireccionProfesion($this->input('direccion-profesion-reg', $lector->getDireccionProfesion()));
        $lector->setRefPersonal($this->input('refPersonal', $lector->getRefPersonal()));
        $lector->setRefPersonalTel($this->input('refPersonalTel', $lector->getRefPersonalTel()));
        $lector->setRefLegal($this->input('refLegal', $lector->getRefLegal()));
        $lector->setRefLegalTel($this->input('refLegalTel', $lector->getRefLegalTel()));
        $lector->setEstado($this->input('estado', $lector->getEstado()));
        $lector->setVencimientoCarnet($this->input('vencimientoCarnet', $lector->getVencimientoCarnet()));

        if ($this->lectorRepo->update($lector) && $this->personaRepo->update($persona)) {
            // Datos DESPUÉS de modificar
            $lectorDespues = $this->lectorRepo->find($id);
            $personaDespues = $this->personaRepo->find($lectorDespues->getIdPersona());
            $newArray = $this->prepararDatosAuditoria($lectorDespues, $personaDespues);

            $this->auditService->registrarCambio(
                'historial_lector',
                $id,
                $this->getIdAdmin(),
                $oldArray,
                $newArray,
                'UPDATE'
            );
            $_SESSION['success'] = "Lector actualizado correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar el lector.";
        }
        $this->redirect("/lectores/show?id=" . $id);
    }

    public function delete()
    {
        $id = (int) $this->input('id', 0);
        try {
            // Obtener datos ANTES de desactivar
            $lector = $this->lectorRepo->find($id);
            $persona = $this->personaRepo->find($lector->getIdPersona());
            $oldArray = $this->prepararDatosAuditoria($lector, $persona);

            if ($this->lectorRepo->deactivate($id)) {
                $this->auditService->registrarCambio(
                    'historial_lector',
                    $id,
                    $this->getIdAdmin(),
                    $oldArray,
                    [],
                    'DELETE'
                );
                $_SESSION['success'] = "Lector desactivado con éxito.";
            } else {
                $_SESSION['error'] = "No se pudo desactivar el lector.";
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al desactivar lector: " . $e->getMessage();
        }
        $this->redirect("/lectores");
    }

    public function reactivar(): void
    {
        $id = (int) $this->input('id');
        $search = $this->input('search', '');
        $page = $this->input('page', 1);
        try {
            // Obtener datos ANTES de reactivar (actualmente inactivo)
            $lector = $this->lectorRepo->find($id);
            $persona = $this->personaRepo->find($lector->getIdPersona());
            $oldArray = $this->prepararDatosAuditoria($lector, $persona);

            if ($this->lectorRepo->reactivar($id)) {
                // Datos DESPUÉS de reactivar
                $lectorDespues = $this->lectorRepo->find($id);
                $personaDespues = $this->personaRepo->find($lectorDespues->getIdPersona());
                $newArray = $this->prepararDatosAuditoria($lectorDespues, $personaDespues);

                $this->auditService->registrarCambio(
                    'historial_lector',
                    $id,
                    $this->getIdAdmin(),
                    $oldArray,
                    $newArray,
                    'UPDATE'
                );
                $_SESSION['success'] = 'Lector reactivado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo reactivar el lector.';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
        $this->redirect('/lectores?buscar=' . urlencode($search) . '&page=' . $page);
    }

    public function search(): string
    {
        $input = $this->input('buscar', '');
        $lectores = $this->listLectorService->search($input);
        return $this->render('reader/reader-list', ['lectores' => $lectores]);
    }
}
