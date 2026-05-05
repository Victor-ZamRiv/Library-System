<?php

namespace App\Models\Services;

use App\Contracts\IPrestamoRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IAdministradorRepository;
use App\Contracts\IEjemplarPrestamoRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IAutorRepository;

class PrestamoDetailService
{
    private IPrestamoRepository $prestamoRepo;
    private ILectorRepository $lectorRepo;
    private IAdministradorRepository $adminRepo;
    private IEjemplarPrestamoRepository $ejemplarPrestamoRepo;
    private IEjemplarRepository $ejemplarRepo;
    private ILibroRepository $libroRepo;
    private IAutorRepository $autorRepo;

    public function __construct(
        IPrestamoRepository $prestamoRepo,
        ILectorRepository $lectorRepo,
        IAdministradorRepository $adminRepo,
        IEjemplarPrestamoRepository $ejemplarPrestamoRepo,
        IEjemplarRepository $ejemplarRepo,
        ILibroRepository $libroRepo,
        IAutorRepository $autorRepo
    ) {
        $this->prestamoRepo = $prestamoRepo;
        $this->lectorRepo = $lectorRepo;
        $this->adminRepo = $adminRepo;
        $this->ejemplarPrestamoRepo = $ejemplarPrestamoRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->libroRepo = $libroRepo;
        $this->autorRepo = $autorRepo;
    }

    /**
     * Obtiene todos los detalles de un préstamo.
     *
     * @param int $idPrestamo
     * @return array|null Devuelve un array con los datos o null si no existe
     */
    public function obtenerDetalles(int $idPrestamo): ?array
    {
        // 1. Obtener el préstamo
        $prestamo = $this->prestamoRepo->find($idPrestamo);
        if (!$prestamo) {
            return null;
        }

        // 2. Obtener el lector (con persona)
        $lector = $this->lectorRepo->find($prestamo->getIdLector());
        if (!$lector) {
            // Si no hay lector (no debería), lanzar excepción o manejarlo
            return null;
        }

        // 3. Obtener el administrador (con persona)
        $admin = $this->adminRepo->find($prestamo->getIdAdmin());

        // 4. Obtener los IDs de ejemplares asociados
        $idsEjemplares = $this->ejemplarPrestamoRepo->findByPrestamo($idPrestamo);
        
        // 5. Para cada ejemplar, cargar el libro y sus autores
        $ejemplaresDetalle = [];
        foreach ($idsEjemplares as $idEjemplar) {
            $ejemplar = $this->ejemplarRepo->find($idEjemplar);
            if (!$ejemplar) continue;

            $libro = $this->libroRepo->find($ejemplar->getLibroId());
            if (!$libro) continue;

            // Autores del libro
            $autores = $this->autorRepo->getAutoresLibro($libro->getIdLibro());
            
            $ejemplaresDetalle[] = [
                'ejemplar' => $ejemplar,
                'libro' => $libro,
                'autores' => $autores
            ];
        }

        // 6. Construir el array de salida
        return [
            'prestamo' => $prestamo,
            'lector' => $lector,
            'administrador' => $admin,
            'ejemplares' => $ejemplaresDetalle,
        ];
    }
}