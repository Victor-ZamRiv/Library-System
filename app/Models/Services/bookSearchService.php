<?php
namespace App\Services;

use App\Repositories\LibroRepository;
use App\Repositories\AutorRepository;
use App\Entities\Libro;

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
                $autores = $this->autorRepo->getAutoresLibro($libro->getId());
                $libro->setAutores($autores); // método opcional en la entidad
            }
        }

        return $libros;
    }
}