<?php

namespace App\Models\Repositories;

use App\Contracts\IVisitanteRepository;
use App\Core\BaseRepository;
use App\Models\Entities\VisitantesRegistro;
use PDO;

class VisitanteRepository extends BaseRepository implements IVisitanteRepository{

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'conteo_diario_visitantes', 'ID_Conteo');
    }

    public function find(int $id): ?VisitantesRegistro {
        $row = $this->fetchById($id);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function insert(VisitantesRegistro $registro): int {
        if ($registro->getIdConteo() !== null) {
            throw new \InvalidArgumentException("El registro ya tiene ID, no puede insertarse");
        }

        $sql = "INSERT INTO conteo_diario_visitantes 
            (ID_Sala, Fecha, Niños_Hombres, Niños_Mujeres, Adolescentes_Hombres, Adolescentes_Mujeres, Adultos_Hombres, Adultos_Mujeres, ID_Admin)
            VALUES (:idSala, :fecha, :ninosH, :ninosM, :adolH, :adolM, :adultH, :adultM, :idAdmin)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idSala' => $registro->getIdSala(),
            ':fecha' => $registro->getFecha(),
            ':ninosH' => $registro->getNinosHombres(),
            ':ninosM' => $registro->getNinosMujeres(),
            ':adolH' => $registro->getAdolescentesHombres(),
            ':adolM' => $registro->getAdolescentesMujeres(),
            ':adultH' => $registro->getAdultosHombres(),
            ':adultM' => $registro->getAdultosMujeres(),
            ':idAdmin' => $registro->getIdAdmin()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(VisitantesRegistro $registro): bool {
        if ($registro->getIdConteo() === null) {
            throw new \InvalidArgumentException("El registro no tiene ID, no puede actualizarse");
        }

        $sql = "UPDATE conteo_diario_visitantes SET
            ID_Sala = :idSala,
            Fecha = :fecha,
            Niños_Hombres = :ninosH,
            Niños_Mujeres = :ninosM,
            Adolescentes_Hombres = :adolH,
            Adolescentes_Mujeres = :adolM,
            Adultos_Hombres = :adultH,
            Adultos_Mujeres = :adultM,
            ID_Admin = :idAdmin
            WHERE ID_Conteo = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idSala' => $registro->getIdSala(),
            ':fecha' => $registro->getFecha(),
            ':ninosH' => $registro->getNinosHombres(),
            ':ninosM' => $registro->getNinosMujeres(),
            ':adolH' => $registro->getAdolescentesHombres(),
            ':adolM' => $registro->getAdolescentesMujeres(),
            ':adultH' => $registro->getAdultosHombres(),
            ':adultM' => $registro->getAdultosMujeres(),
            ':idAdmin' => $registro->getIdAdmin(),
            ':id' => $registro->getIdConteo()
        ]);
    }

    public function existsBySalaFechaTurno(string $idSala, string $fecha, string $turno): bool {
        $sql = "SELECT COUNT(*) FROM conteo_diario_visitantes 
                WHERE ID_Sala = :idSala AND Fecha = :fecha AND Turno = :turno";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idSala' => $idSala, ':fecha' => $fecha, ':turno' => $turno]);
        return $stmt->fetchColumn() > 0;
    }


    protected function mapToEntity(array $row): VisitantesRegistro {
        return VisitantesRegistro::fromArray($row);
    }
}
