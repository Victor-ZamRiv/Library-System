<?php
namespace App\Models\Services;

use App\Models\Repositories\LibroRepository;
use App\Models\Repositories\AutorRepository;
use App\Models\Repositories\EditorialRepository;
use App\Models\Repositories\EjemplarRepository;
use App\Models\Entities\Libro;
use App\Models\Entities\Autor;
use App\Models\Entities\Editorial;

class LibroRegistrationService {
    private LibroRepository $libroRepo;
    private AutorRepository $autorRepo;
    private EditorialRepository $editorialRepo;
    private EjemplarRepository $ejemplarRepo;

    public function __construct(
        LibroRepository $libroRepo,
        AutorRepository $autorRepo,
        EditorialRepository $editorialRepo,
        EjemplarRepository $ejemplarRepo
    ) {
        $this->libroRepo = $libroRepo;
        $this->autorRepo = $autorRepo;
        $this->editorialRepo = $editorialRepo;
        $this->ejemplarRepo = $ejemplarRepo;
    }

    public function registrar(array $datosLibro, array $autores, string $editorialNombre, int $numEjemplares): ?Libro {
    try {
        // 1. Editorial
        $editorial = $this->editorialRepo->findByName($editorialNombre);
        if (!$editorial) {
            $editorial = new Editorial(null, $editorialNombre);
            $editorialId = $this->editorialRepo->insert($editorial);
            $editorial->setId($editorialId);
        } else {
            $editorialId = $editorial->getId();
        }

        // 2. Libro
        $areaParaConstructor = ($datosLibro['sala-reg'] === 'X') ? $datosLibro['id_area_color'] : null;
        $libro = new Libro(
            null,
            $datosLibro['titulo'],
            $editorialId,
            $datosLibro['sala-reg'],
            $areaParaConstructor,
            $datosLibro['cota'] ?? '',
            $datosLibro['ISBN'] ?? null,
            $datosLibro['paginas'] ?? null,
            $datosLibro['observaciones'] ?? null,
            $datosLibro['year'] ?? null,
            true,
            $datosLibro['Volume'] ?? null
        );
        $libroId = $this->libroRepo->insert($libro);

        // 3. Autores
        foreach ($autores as $nombreAutor) {
            $autor = $this->autorRepo->findByName($nombreAutor);
            
            if (!$autor) {
                $nuevoAutor = new Autor(null, $nombreAutor);
                $autorId = $this->autorRepo->insert($nuevoAutor);
            } else {
                $autorId = $autor->getId();
            }

            // Validación de seguridad antes de llamar a associateAutor
            if ($autorId !== null) {
                $this->libroRepo->associateAutor($libroId, $autorId);
            } else {
                throw new \Exception("No se pudo obtener el ID para el autor: " . $nombreAutor);
            }
        }

        // 4. Ejemplares
        for ($i = 1; $i <= $numEjemplares; $i++) {
            $this->ejemplarRepo->insert([
                'ID_Libro' => $libroId,
                'Numero_Ejemplar' => $i,
                'Estado' => 'Disponible',
                'Activo' => 1
            ]);
        }

        return $this->libroRepo->find($libroId);

    } catch (\RuntimeException $e) {
        // Error de repositorio (ej. fallo en insert)
        //error_log("Error al registrar libro: " . $e->getMessage());
        throw new \RuntimeException("error al registrar el libro" . $e->getMessage(), 0, $e);
        // return null;
    }
}
}