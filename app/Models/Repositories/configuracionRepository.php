<?php
namespace App\Models\Repositories;
use App\Core\baseRepository;
use App\Models\Entities\configuracion;
use App\Contracts\IConfiguracionRepository;
use PDO;

class configuracionRepository extends baseRepository implements IConfiguracionRepository {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'configuraciones_sistema', 'ID_Configuracion');
    }

    public function getConfiguracion(): ?configuracion {
        $result = $this->fetchById(1);
        return $result ? $this->mapToEntity($result) : null;
    }

    public function updateConfiguracion(configuracion $config): bool {
        $sql = "UPDATE {$this->table} SET 
                Dias_Prestamo = :diasPrestamo,
                Dias_Prestamo_Novelas = :diasPrestamoNovelas,
                Monto_Multa_Dia = :montoMultaDia,
                Limite_Prestamos_Simultaneos = :limitePrestamosSimultaneos,
                Max_Renovaciones = :maxRenovaciones
                WHERE ID_Configuracion = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':diasPrestamo' => $config->getDiasPrestamo(),
            ':diasPrestamoNovelas' => $config->getDiasPrestamoNovelas(),
            ':montoMultaDia' => $config->getMontoMultaDia(),
            ':limitePrestamosSimultaneos' => $config->getLimitePrestamosSimultaneos(),
            ':maxRenovaciones' => $config->getMaxRenovaciones(),
            ':id' => $config->getIdConfiguracion()
        ]);
    }

    protected function mapToEntity(array $row): configuracion {
        return configuracion::fromArray($row);
    }
}