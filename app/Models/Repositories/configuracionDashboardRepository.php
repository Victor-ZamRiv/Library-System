<?php
namespace App\Models\Repositories;

use App\Core\BaseRepository;
use App\Models\Entities\ConfiguracionDashboard;
use PDO;

class ConfiguracionDashboardRepository extends BaseRepository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'configuracion_dashboard', 'ID_Configuracion_Dashboard');
    }

    /**
     * Obtiene la configuración única (si no existe, crea una fila por defecto).
     */
    public function get(): ConfiguracionDashboard
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE ID_Configuracion_Dashboard = 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            // Crear fila por defecto
            return $this->createDefault();
        }
        return $this->mapToEntity($row);
    }

    /**
     * Guarda la configuración (actualiza la fila id=1).
     * @param ConfiguracionDashboard $config
     */
    public function save(ConfiguracionDashboard $config): bool
    {
        $sql = "INSERT INTO {$this->table} (
            ID_Configuracion_Dashboard,
            mostrar_cobertura,
            mostrar_referencia,
            mostrar_grafico_consultas,
            mostrar_cumplimiento,
            mostrar_ocupacion,
            mostrar_rotacion,
            mostrar_estado_fisico,
            mostrar_asistencia_estatal,
            mostrar_coleccion,
            mostrar_actividades,
            mostrar_iiur,
            mostrar_idcar,
            mostrar_ipe
        ) VALUES (
            1,
            :cobertura,
            :referencia,
            :grafico_consultas,
            :cumplimiento,
            :ocupacion,
            :rotacion,
            :estado_fisico,
            :asistencia_estatal,
            :coleccion,
            :actividades,
            :iiur,
            :idcar,
            :ipe
        ) ON DUPLICATE KEY UPDATE
            mostrar_cobertura = VALUES(mostrar_cobertura),
            mostrar_referencia = VALUES(mostrar_referencia),
            mostrar_grafico_consultas = VALUES(mostrar_grafico_consultas),
            mostrar_cumplimiento = VALUES(mostrar_cumplimiento),
            mostrar_ocupacion = VALUES(mostrar_ocupacion),
            mostrar_rotacion = VALUES(mostrar_rotacion),
            mostrar_estado_fisico = VALUES(mostrar_estado_fisico),
            mostrar_asistencia_estatal = VALUES(mostrar_asistencia_estatal),
            mostrar_coleccion = VALUES(mostrar_coleccion),
            mostrar_actividades = VALUES(mostrar_actividades),
            mostrar_iiur = VALUES(mostrar_iiur),
            mostrar_idcar = VALUES(mostrar_idcar),
            mostrar_ipe = VALUES(mostrar_ipe)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':cobertura' => $config->getMostrarCobertura() ? 1 : 0,
            ':referencia' => $config->getMostrarReferencia() ? 1 : 0,
            ':grafico_consultas' => $config->getMostrarGraficoConsultas() ? 1 : 0,
            ':cumplimiento' => $config->getMostrarCumplimiento() ? 1 : 0,
            ':ocupacion' => $config->getMostrarOcupacion() ? 1 : 0,
            ':rotacion' => $config->getMostrarRotacion() ? 1 : 0,
            ':estado_fisico' => $config->getMostrarEstadoFisico() ? 1 : 0,
            ':asistencia_estatal' => $config->getMostrarAsistenciaEstatal() ? 1 : 0,
            ':coleccion' => $config->getMostrarColeccion() ? 1 : 0,
            ':actividades' => $config->getMostrarActividades() ? 1 : 0,
            ':iiur' => $config->getMostrarIIUR() ? 1 : 0,
            ':idcar' => $config->getMostrarIDCAR() ? 1 : 0,
            ':ipe' => $config->getMostrarIPE() ? 1 : 0
        ]);
    }

    /**
     * Crea la fila por defecto (si no existe).
     */
    private function createDefault(): ConfiguracionDashboard
    {
        $sql = "INSERT INTO {$this->table} (id, mostrar_cobertura, mostrar_referencia, mostrar_grafico_consultas, 
                mostrar_cumplimiento, mostrar_ocupacion, mostrar_rotacion, mostrar_estado_fisico, 
                mostrar_asistencia_estatal, mostrar_coleccion, mostrar_actividades, mostrar_iiur, mostrar_idcar, mostrar_ipe)
                VALUES (1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)";
        $this->pdo->exec($sql);
        return new ConfiguracionDashboard(1, true, true, true, true, true, true, true, true, true, true, true, true, true);
    }

    protected function mapToEntity(array $row): object
    {
        return ConfiguracionDashboard::fromArray($row);
    }
}