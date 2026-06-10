<?php

namespace App\Contracts;

interface IAuditRepository
{
    public function insert(string $tablaHistorial, array $data): bool;
    public function getPrimaryKey(string $tabla): string;
    public function getHistorialPaginado(
        string $tabla,
        int $pagina = 1,
        int $porPagina = 10,
        ?int $idAdmin = null,
        ?string $tipoCambio = null,
        ?string $desde = null,
        ?string $hasta = null
    ): array;
    public function getRegistro(string $tabla, int $id): ?array;
}
