<?php 
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Entities\VisitantesRegistro;
use App\Models\Entities\ConsultaRegistro;
use App\Models\Services\VisitanteService;


class VisitantesController extends BaseController {

    private VisitanteService $visitanteService;

    public function __construct(VisitanteService $visitanteService) {
        $this->visitanteService = $visitanteService;
        $this->authenticate();
        //$this->middlewareRol(['Director', 'Jefe de sala'], 'Visitantes');
    }

    public function index(): string {
        return $this->render('visitors/visitor-list', []);
    }

    public function create(): string {
        return $this->render('visitors/visitor', []);
    }

    public function store() {
        try {
            // Construir entidad VisitanteRegistro
            $visitante = new VisitantesRegistro(
                null,
                $this->input('idSala'),
                $this->input('fecha'),
                (int)$this->input('ninos_m', 0),
                (int)$this->input('ninos_f', 0),
                (int)$this->input('adol_m', 0),
                (int)$this->input('adol_f', 0),
                (int)$this->input('adultos_m', 0),
                (int)$this->input('adultos_f', 0),
                $this->input('idAdmin', null)
            );

            // Construir entidades ConsultaRegistro a partir de las categorías enviadas
            $consultas = [];
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'obra_') === 0) {
                    $categoria = substr($key, 5); // ej: "000", "100", "Biog"
                    $consultas[] = new ConsultaRegistro(
                        null,
                        $visitante->getIdSala(),
                        $categoria,
                        $visitante->getFecha(),
                        (int)$value,
                        $visitante->getIdAdmin()
                    );
                }
            }

            $idConteo = $this->visitanteService->registrar($visitante, $consultas);

            $_SESSION['success'] = "Registro guardado con éxito.";
            $this->redirect("/visitantes/show?id=" . $idConteo);

        } catch (\Exception $e) {
            $_SESSION['old'] = $_POST;
            $_SESSION['error'] = "Error al guardar: " . $e->getMessage();
            $this->redirect("/visitantes/create");
        }
    }

}