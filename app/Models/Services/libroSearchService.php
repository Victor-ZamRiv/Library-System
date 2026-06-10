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

    public function buscar(int $pagina, int $porPagina, array $filtros): array
    {
        $resultado = $this->libroRepo->search($pagina, $porPagina, $filtros);
        
        // Cargar autores para cada libro en $resultado['datos']
        foreach ($resultado['datos'] as $libro) {
            $autores = $this->autorRepo->getAutoresLibro($libro->getIdLibro());
            $libro->setAutores($autores);
        }
        
        return $resultado;
    }
}