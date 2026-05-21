<?php

namespace App\Models\Services;

use App\Models\Repositories\AuditRepository;
use App\Contracts\IAdministradorRepository;
use App\Contracts\IPersonaRepository;

class HistorialService
{
    private AuditRepository $auditRepo;
    private IAdministradorRepository $adminRepo;
    private IPersonaRepository $personaRepo;

    private array $modulos = [
        'lectores' => 'historial_lector',
        'libros' => 'historial_libro',
        'prestamos' => 'historial_prestamo',
        'actividades' => 'historial_actividad',
        'logros' => 'historial_logro',
        'multas' => 'historial_multa',
    ];

    public function __construct(
        AuditRepository $auditRepo,
        IAdministradorRepository $adminRepo,
        IPersonaRepository $personaRepo
    ) {
        $this->auditRepo = $auditRepo;
        $this->adminRepo = $adminRepo;
        $this->personaRepo = $personaRepo;
    }

    public function getModulos(): array
    {
        return $this->modulos;
    }

    /**
     * Detecta la PK real de la tabla.
     */
    private function getPrimaryKey(string $tabla): string
    {
        $base = str_replace('historial_', '', $tabla);
        return 'ID_Historial_' . ucfirst($base);
    }

    public function listar(
        ?string $modulo,
        ?int $idAdmin,
        ?string $accion,
        ?string $desde,
        ?string $hasta
    ): array {
        if (!$modulo || !isset($this->modulos[$modulo])) {
            return [];
        }

        $tabla = $this->modulos[$modulo];
        $rows = $this->auditRepo->getHistorial($tabla, $idAdmin, $accion, $desde, $hasta);

        $pk = $this->getPrimaryKey($tabla);

        return array_map(function ($r) use ($tabla, $pk) {

            $usuario = $this->adminRepo->find($r['ID_Admin']);
            if ($usuario) {
                $persona = $this->personaRepo->find($usuario->getIdPersona());
                if ($persona) {
                    $usuario->setPersona($persona);
                }
            }

            return [
                'usuario' => $usuario ? $usuario->getNombreUsuario() : 'Desconocido',
                'modulo' => ucfirst(str_replace('historial_', '', $tabla)),
                'fecha' => $r['Fecha_Cambio'],
                'accion' => $r['Tipo_Cambio'],
                'descripcion' => $this->descripcionAccion($r['Tipo_Cambio']),
                'id' => $r[$pk], // ← ID REAL DEL HISTORIAL
            ];
        }, $rows);
    }

    public function detalle(string $modulo, int $id): ?array
    {
        if (!isset($this->modulos[$modulo])) {
            return null;
        }

        $tabla = $this->modulos[$modulo];

        $registro = $this->auditRepo->getRegistro($tabla, $id);
        if (!$registro) {
            return null;
        }

        return [
            'registro' => $registro,
            'old_data' => json_decode($registro['Viejo_Valor'], true) ?? [],
            'new' => json_decode($registro['Nuevo_Valor'], true) ?? [],
            'modulo' => $modulo,
        ];
    }

    private function descripcionAccion(string $accion): string
    {
        return [
            'INSERT' => 'Registro creado',
            'UPDATE' => 'Registro actualizado',
            'DELETE' => 'Registro eliminado',
        ][$accion] ?? 'Acción realizada';
    }
}

