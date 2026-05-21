<?php

namespace App\Models\Services;

use App\Contracts\IAuditRepository;

class AuditService
{
    private IAuditRepository $auditRepo;

    public function __construct(IAuditRepository $auditRepo)
    {
        $this->auditRepo = $auditRepo;
    }

    /**
     * Registra un cambio en una tabla de historial.
     *
     * @param string $tablaHistorial   Nombre de la tabla de historial
     * @param int    $idRegistro       ID del registro afectado
     * @param int    $idAdmin          Administrador que realizó la acción
     * @param array  $oldValue         Estado anterior (array)
     * @param array  $newValue         Estado nuevo (array)
     * @param string $tipoCambio       INSERT | UPDATE | DELETE
     */
    public function registrarCambio(
        string $tablaHistorial,
        int $idRegistro,
        int $idAdmin,
        array $oldValue,
        array $newValue,
        string $tipoCambio
    ): bool {
        return $this->auditRepo->insert($tablaHistorial, [
            'ID_Admin'     => $idAdmin,
            'ID_' . $this->resolverNombreColumna($tablaHistorial) => $idRegistro,
            'Viejo_Valor'  => json_encode($oldValue, JSON_UNESCAPED_UNICODE),
            'Nuevo_Valor'  => json_encode($newValue, JSON_UNESCAPED_UNICODE),
            'Fecha_Cambio' => date('Y-m-d H:i:s'),
            'Tipo_Cambio'  => $tipoCambio
        ]);
    }

    /**
     * Determina el nombre de la columna ID según la tabla de historial.
     * Ejemplo: historial_prestamo → ID_Prestamo
     */
    private function resolverNombreColumna(string $tablaHistorial): string
    {
        // historial_prestamo → prestamo
        $base = str_replace('historial_', '', $tablaHistorial);

        // prestamo → Prestamo
        $base = ucfirst($base);

        return $base;
    }
}
