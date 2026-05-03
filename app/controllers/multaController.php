<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Contracts\IMultaRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IPrestamoRepository;

class MultaController extends BaseController
{
    private IMultaRepository $multaRepo;
    private ILectorRepository $lectorRepo;
    private IEjemplarRepository $ejemplarRepo;
    private ILibroRepository $libroRepo;
    private IPrestamoRepository $prestamoRepo;

    public function __construct(
        IMultaRepository $multaRepo,
        ILectorRepository $lectorRepo,
        IEjemplarRepository $ejemplarRepo,
        ILibroRepository $libroRepo,
        IPrestamoRepository $prestamoRepo
    ) {
        $this->multaRepo = $multaRepo;
        $this->lectorRepo = $lectorRepo;
        $this->ejemplarRepo = $ejemplarRepo;
        $this->libroRepo = $libroRepo;
        $this->prestamoRepo = $prestamoRepo;

        // Proteger todas las acciones (requiere autenticación)
        $this->authenticate();
        // Solo bibliotecarios y superiores pueden gestionar multas
        $this->middlewareRol(['Bibliotecario', 'Jefe_Sala', 'Director'], 'multas');
    }

    public function index(): string
    {
        $multas = $this->multaRepo->all();
        return $this->render('fine/fine-list', ['multas' => $multas]);
    }

        

}