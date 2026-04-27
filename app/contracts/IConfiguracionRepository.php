<?php
namespace App\Contracts;
use App\Models\Entities\configuracion;
interface IConfiguracionRepository {
    public function getConfiguracion(): ?configuracion;
    public function updateConfiguracion(configuracion $config): bool;
}