<?php
session_start();
require __DIR__ . '/boots/init.php';

use App\Models\Repositories\LibroRepository;
use App\Models\Repositories\EjemplarRepository;
use App\Models\Repositories\AutorRepository;
use App\Models\Repositories\EditorialRepository;
use App\Models\Repositories\PersonaRepository;
use App\Models\Repositories\AdministradorRepository;
use App\Models\Repositories\LectorRepository;
use App\Models\Repositories\ActividadRepository;
use App\Models\Repositories\LogroRepository;
use App\Models\Repositories\ConsultaRepository;
use App\Models\Repositories\VisitanteRepository;
use App\Models\Repositories\PreguntaRepository;
use App\Contracts\ILibroRepository;
use App\Contracts\IAutorRepository;
use App\Contracts\IEditorialRepository;
use App\Contracts\IEjemplarRepository;
use App\Contracts\IPersonaRepository;
use App\Contracts\IAdministradorRepository;
use App\Contracts\ILectorRepository;
use App\Contracts\IActividadRepository;
use App\Contracts\ILogroRepository;
use App\Contracts\IConsultaRepository;
use App\Contracts\IVisitanteRepository;
use App\Contracts\IPreguntaRepository;
use App\Models\Services\AuthService;
use App\Models\Services\LibroSearchService;
use App\Models\Services\LibroRegistrationService;
use App\Models\Services\libroDetailService;
use App\Models\Services\LibroUpdateService;
use App\Models\Services\AdministradorRegistrationService;
use App\Models\Services\LectorRegistrationService;
use App\Models\Services\ListAdministradorService;
use App\Models\Services\ListLectorService;
use App\Models\Services\VisitanteService;

$router = require __DIR__ . '/app/routes/web.php';

$libroRepo = new LibroRepository($pdo);
$autorRepo = new AutorRepository($pdo);
$editorialRepo = new EditorialRepository($pdo);
$ejemplarRepo = new EjemplarRepository($pdo);
$personaRepo = new PersonaRepository($pdo);
$administradorRepo = new AdministradorRepository($pdo);
$lectorRepo = new LectorRepository($pdo);
$actividadRepo = new ActividadRepository($pdo);
$logroRepo = new LogroRepository($pdo);
$consultaRepo = new ConsultaRepository($pdo);
$visitanteRepo = new VisitanteRepository($pdo);
$preguntaRepo = new PreguntaRepository($pdo);


$container = [
    \PDO::class => $pdo,
    ILibroRepository::class => $libroRepo,
    IAutorRepository::class => $autorRepo,
    IEditorialRepository::class => $editorialRepo,
    IEjemplarRepository::class => $ejemplarRepo,
    IPersonaRepository::class => $personaRepo,
    IAdministradorRepository::class => $administradorRepo,
    ILectorRepository::class => $lectorRepo,
    IActividadRepository::class => $actividadRepo,
    ILogroRepository::class => $logroRepo,
    IConsultaRepository::class => $consultaRepo,
    IVisitanteRepository::class => $visitanteRepo,
    IPreguntaRepository::class => $preguntaRepo,
    LibroSearchService::class => new LibroSearchService(
        $libroRepo, $autorRepo),
    LibroRegistrationService::class => new LibroRegistrationService(
        $libroRepo,
        $autorRepo,
        $editorialRepo,
        $ejemplarRepo
    ),
    libroDetailService::class => new libroDetailService(
        $libroRepo,
        $autorRepo,
        $editorialRepo,
        $ejemplarRepo
    ),
    LibroUpdateService::class => new LibroUpdateService(
        $libroRepo,
        $autorRepo,
        $editorialRepo,
        $ejemplarRepo,
        $pdo
    ),
    AuthService::class => new AuthService(
        $administradorRepo
    ),
    AdministradorRegistrationService::class => new AdministradorRegistrationService(
        $personaRepo,
        $administradorRepo,
        $pdo
    ),
    ListAdministradorService::class => new ListAdministradorService(
        $administradorRepo,
        $personaRepo
    ),
    LectorRegistrationService::class => new LectorRegistrationService(
        $personaRepo,
        $lectorRepo,
        $pdo
    ),
    ListLectorService::class => new ListLectorService(
        $lectorRepo,
        $personaRepo
    ),
    VisitanteService::class => new VisitanteService(
        $visitanteRepo,
        $consultaRepo,
        $pdo
    ),
];

$uri = str_ireplace(BASE_URL, '', $_SERVER['REQUEST_URI']);

$router->dispatch($uri, $_SERVER['REQUEST_METHOD'], $container);