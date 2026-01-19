<?php
namespace App\Models\Services;

use App\Contracts\ILibroRepository;
use App\Contracts\IAutorRepository;
use App\Contracts\IEditorialRepository;
use App\Contracts\IEjemplarRepository;
use App\Models\Entities\Libro;

class libroDetailService {
    private ILibroRepository $libroRepo;
    private IAutorRepository $autorRepo;
    private IEditorialRepository $editorialRepo;
    private IEjemplarRepository $ejemplarRepo;

    public function __construct(
        ILibroRepository $libroRepo,
        IAutorRepository $autorRepo,
        IEditorialRepository $editorialRepo,
        IEjemplarRepository $ejemplarRepo
    ) {
        $this->libroRepo = $libroRepo;
        $this->autorRepo = $autorRepo;
        $this->editorialRepo = $editorialRepo;
        $this->ejemplarRepo = $ejemplarRepo;
    }

    public function obtenerDetallesLibro(int $idLibro): ?Libro {
        $libro = $this->libroRepo->find($idLibro);
        if (!$libro) {
            return null;
        }

        // 2. Cargar la Editorial
        if ($libro->getIdEditorial()) {
            $editorial = $this->editorialRepo->find($libro->getIdEditorial());
            $libro->setEditorial($editorial); 
        }

        // 3. Cargar los Autores (usando una consulta JOIN en el repo de autores)
        $autores = $this->autorRepo->getAutoresLibro($idLibro);
        $libro->setAutores($autores);

        // 4. Cargar los Ejemplares
        $ejemplares = $this->ejemplarRepo->findByLibro($idLibro);
        $libro->setEjemplares($ejemplares);

        return $libro;
    }
}