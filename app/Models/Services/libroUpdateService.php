<?php
namespace App\Models\Services;

use App\Contracts\ILibroRepository;
use App\Contracts\IAutorRepository;
use App\Contracts\IEditorialRepository;
use App\Contracts\IEjemplarRepository;
use App\Models\Entities\Libro;
use App\Models\Entities\Autor;
use App\Models\Entities\Editorial;
use App\Models\Entities\Ejemplar;
use PDO;
use Exception;

class LibroUpdateService {

    private ILibroRepository $libroRepo;
    private IAutorRepository $autorRepo;
    private IEditorialRepository $editorialRepo;
    private IEjemplarRepository $ejemplarRepo;
    private PDO $pdo;

    public function __construct(
        ILibroRepository $libroRepo,
        IAutorRepository $autorRepo,
        IEditorialRepository $editorialRepo,
        IEjemplarRepository $ejemplarRepo,
        PDO $pdo
    ) {
        $this->libroRepo = $libroRepo;
        $this->autorRepo = $autorRepo;
        $this->editorialRepo = $editorialRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->pdo = $pdo;
    }

    /**
     * Actualiza los datos de un libro, incluyendo autores, editorial y ejemplares.
     */
    public function actualizar(
        Libro $libro,
        array $autores,
        string $editorialNombre,
        array $ejemplaresParaDescatalogar = [],
        int $nuevosEjemplares = 0
    ): ?Libro {
        try {
            $this->pdo->beginTransaction();
            // 1. Editorial
            $editorial = $this->editorialRepo->findByName($editorialNombre);
            if (!$editorial) {
                $editorial = new Editorial(null, $editorialNombre);
                $editorialId = $this->editorialRepo->insert($editorial);
                $editorial->setIDEditorial($editorialId);
            } else {
                $editorialId = $editorial->getId();
            }
            $libro->setIdEditorial($editorialId);

            // 2. Actualizar libro
            $this->libroRepo->update($libro);

            // 3. Autores
            // Primero eliminamos relaciones previas
            $this->autorRepo->deleteRelacionesPorLibro($libro->getIdLibro());

            // Luego vinculamos los nuevos autores
            foreach ($autores as $nombreAutor) {
                $autor = $this->autorRepo->findByName($nombreAutor);
                if (!$autor) {
                    $nuevoAutor = new Autor(null, $nombreAutor);
                    $autorId = $this->autorRepo->insert($nuevoAutor);
                } else {
                    $autorId = $autor->getId();
                }
                if ($autorId !== null) {
                    $this->libroRepo->associateAutor($libro->getIdLibro(), $autorId);
                }
            }

            // 4. Ejemplares
            // Descatalogar ejemplares seleccionados
            foreach ($ejemplaresParaDescatalogar as $ejemplarId) {
                $this->ejemplarRepo->deactivate($ejemplarId);
            }

            // Añadir nuevos ejemplares
            if ($nuevosEjemplares > 0) {
                $ejemplaresExistentes = $this->ejemplarRepo->findByLibro($libro->getIdLibro());
                $ultimoNumero = count($ejemplaresExistentes);

                for ($i = 1; $i <= $nuevosEjemplares; $i++) {
                    $this->ejemplarRepo->insert([
                        'ID_Libro' => $libro->getIdLibro(),
                        'Numero_Ejemplar' => $ultimoNumero + $i,
                        'Estado' => 'Disponible',
                        'Activo' => 1
                    ]);
                }
            }

            $this->pdo->commit();

            // 5. Retornar libro actualizado
            return $this->libroRepo->find($libro->getIdLibro());

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw new \RuntimeException("Error al actualizar libro: " . $e->getMessage(), 0, $e);
        }
    }
}