<?php
namespace App\Models\Services;

use App\Models\Repositories\LibroRepository;
use App\Models\Repositories\AutorRepository;
use App\Models\Entities\Libro;

class LibroSearchService {
    private LibroRepository $libroRepo;
    private AutorRepository $autorRepo;

    public function __construct(LibroRepository $libroRepo, AutorRepository $autorRepo) {
        $this->libroRepo = $libroRepo;
        $this->autorRepo = $autorRepo;
    }

    public function buscar(array $filtros): array {
        $libros = $this->libroRepo->search($filtros);

        foreach ($libros as $libro) {
            if ($libro instanceof Libro) {
                $autores = $this->autorRepo->getAutoresLibro($libro->getIdLibro());
                $libro->setAutores($autores);
            }
        }

        return $libros;
    }
}