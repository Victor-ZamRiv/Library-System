<?php
namespace App\Models\Repositories;
use App\Core\baseRepository;
use App\Models\Entities\configuracion;
use App\Contracts\IConfiguracionRepository;
use PDO;

class configuracionRepository extends baseRepository implements IConfiguracionRepository {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'configuraciones', 'ID_Configuracion');
    }

    public function getConfiguracion(): ?configuracion {
        $sql = "SELECT * FROM {$this->table} LIMIT 1";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new configuracion(
            $result['ID_Configuracion'],
            $result['Dias_Prestamo'],
            $result['Multa_Diaria'],
            $result['Maximo_Prestamos'],
            $result['Limite_Renovaciones']
        ) : null;
    }

    public function updateConfiguracion(configuracion $config): bool {
        $sql = "UPDATE {$this->table} SET Dias_Prestamo = :diasPrestamo, Multa_Diaria = :multaDiaria, Maximo_Prestamos = :maximoPrestamos, Limite_Renovaciones = :limiteRenovaciones WHERE ID_Configuracion = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':diasPrestamo' => $config->getDiasPrestamo(),
            ':multaDiaria' => $config->getMultaDiaria(),
            ':maximoPrestamos' => $config->getMaximoPrestamos(),
            ':limiteRenovaciones' => $config->getLimiteRenovaciones(),
            ':id' => $config->getIdConfiguracion()
        ]);
    }

    protected function mapToEntity(array $row): configuracion {
        return configuracion::fromArray($row);
    }
}