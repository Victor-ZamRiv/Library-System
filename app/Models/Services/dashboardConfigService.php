<?php
namespace App\Models\Services;

use App\Models\Repositories\ConfiguracionDashboardRepository;
use App\Models\Entities\ConfiguracionDashboard;

class DashboardConfigService
{
    private ConfiguracionDashboardRepository $repo;

    public function __construct(ConfiguracionDashboardRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Obtiene la configuración actual.
     */
    public function getConfig(): ConfiguracionDashboard
    {
        return $this->repo->get();
    }

    /**
     * Guarda la configuración a partir de un array de datos (ej. $_POST).
     * @param array $data Datos con las claves: mostrar_cobertura, mostrar_referencia, etc.
     */
    public function saveConfig(array $data): bool
    {
        $config = new ConfiguracionDashboard(
            1,
            isset($data['ind_cobertura']),
            isset($data['ind_referencia']),
            isset($data['ind_grafico_consultas']),
            isset($data['ind_cumplimiento']),
            isset($data['ind_ocupacion']),
            isset($data['ind_rotacion']),
            isset($data['ind_estado_fisico']),
            isset($data['ind_asistencia_estatal']),
            isset($data['ind_coleccion']),
            isset($data['ind_actividades']),
            isset($data['ind_iiur']),
            isset($data['ind_idcar']),
            isset($data['ind_ipe'])
        );
        return $this->repo->save($config);
    }
}